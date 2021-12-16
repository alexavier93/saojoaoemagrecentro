<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Customer;
use App\Models\DiscountCupon;
use App\Models\GiftCupon;
use App\Models\Order;
use App\Models\PaymentBoleto;
use App\Models\PaymentCreditcard;
use App\Models\PaymentPix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use MercadoPago\Payment;
use MercadoPago\SDK;

class PaymentController extends Controller
{
    public function index()
    {

        return view('payment.index');
    }

    public function mercadopago(Request $request)
    {

        if (session()->has('cart')) {

            if (session()->has('customer')) {

                $cart = session()->get('cart');

                $customer = $request->session()->get('customer');
                $customer = Customer::find($customer->id);
                $address = $customer->address()->first();

                if($address){
                    return view('payment.mpcreditcard', compact('cart'));
                }else{
                    return redirect()->route('checkout.address');
                }

            } else {
                return redirect()->route('account.login');
            }
        } else {
            return redirect()->route('cart.index');
        }
    }

    public function otherpayments()
    {

        if (session()->has('cart')) {

            if (session()->has('customer')) {

                $cart = session()->get('cart');

                return view('payment.mpotherpayment', compact('cart'));
            } else {
                return redirect()->route('account.login');
            }
        } else {
            return redirect()->route('cart.index');
        }
    }


    public function createOrder(Request $request)
    {

        $customer = $request->session()->get('customer');
        $customer = Customer::find($customer->id);

        $cart = $request->session()->get('cart');

        // Gera numero do Pedido
        $codigo_pedido = rand(100000000, 999999999);

        // Verificando se código já existe
        if (Order::where('code', '=', $codigo_pedido)->exists()) {
            $codigo_pedido = rand(100000000, 999999999);
        }

        // Verificando se algum cupom de desconto foi inserido, se foi inserido, fazer o calculo para saber o desconto dado na compra
        if (isset($cart['discountCupon'])) {
            $total = 0;
            foreach ($cart['products'] as $key => $value) {
                $total += $value['sub_total'];
            }
            $discount = $cart['total'] - $total;
            $discount = str_replace(' ', '', number_format(abs($discount), 2, '.', ' '));
        } elseif (isset($cart['giftCupon'])) {
            $total = 0;
            foreach ($cart['products'] as $key => $value) {
                $total += $value['sub_total'];
            }
            $discount = $cart['total'] - $total;
            $discount = str_replace(' ', '', number_format(abs($discount), 2, '.', ' '));
        } else {
            $discount = null;
        }

        // Verificando se o método é cartão de crédito ou boleto/pix
        if(isset($request->MPHiddenInputPaymentMethod)){
            $PaymentMethod = $request->MPHiddenInputPaymentMethod;
        }elseif(isset($request->paymentMethod)){
            $PaymentMethod = $request->paymentMethod;
        }

        // Passando os dados necessários para o pagamento
        $mpData = array(
            'transactionAmount' => $request->MPHiddenInputAmount,
            'token' => $request->MPHiddenInputToken,
            'installments' => $request->installments,
            'paymentMethod' => $PaymentMethod,
            'customer' => $customer,
            'identificationType' => $request->identificationType,
            'identificationNumber' => $request->identificationNumber,
        );

        // Chamando a função de pagamento
        $payment = $this->makePayment($mpData);
		

        if($payment->error == ""){

            // Recebendo o status 
            $status_detail = $payment->status_detail;

            // Recebendo os dados do pagamento
            $transaction_details = $payment->transaction_details;

            // Verificando se o status for o certo para dar a continuidade com o pedido
            if($payment->status_detail == 'accredited' || $payment->status_detail == 'pending_waiting_payment' || $payment->status_detail == 'pending_waiting_transfer'){ 

                // Dados para inserção do pedido 
                $dataOrder = array(
                    'customer_id'   => $customer->id,
                    'code'          => $codigo_pedido,
                    'total'         => $transaction_details->total_paid_amount,
                    'discount'      => $discount,
                    'status'        => 0,
                );

                //Inserindo Pedido
                $order = $customer->orders()->create($dataOrder);

                // Fazendo looping nos produtos e inserindo no BD
                foreach ($cart['products'] as $key => $value) {

                    $product = $value['associatedProduct'];

                    $order_product  = array(
                        'order_id'      => $order->id,
                        'product_id'    => $product->id,
                        'quantity'      => $value['qty'],
                        'price'         => $value['price'],
                        'subtotal'      => $value['sub_total'],
                    );

                    $order_product = $order->order_product()->create($order_product);


                    $section = $value['attributes']['section'];
                    $product_option  = array(
                        'order_product_id'  => $order_product->id,
                        'option'            => $section,
                    );

                    $order_product->product_option()->create($product_option);
                }

                // Inserindo o método de pagamento
                $paymentMethod = array (
                    'payment_id'        => $payment->id,
                    'payment_type'      => $payment->payment_type_id,
                    'payment_method'    => $payment->payment_method_id,
                );

                $order_payment = $order->order_payment()->create($paymentMethod);
                
                // Pegando o método de pagamento e adicionando os detalhes do pagamento
                if($payment->payment_type_id == 'credit_card'){

                    $metodo_pagamento = "Cartão de Crédito";
    
                    $paymentCreditCard = array (
                        'installments'          => $payment->installments,
                        'installment_amount'    => $transaction_details->installment_amount,
                        'total_paid_amount'     => $transaction_details->total_paid_amount 
                    );

                    $order_payment->payment_creditcard()->create($paymentCreditCard);
    
                }elseif($payment->payment_type_id == 'ticket'){

                    $metodo_pagamento = "Boleto";
    
                    $paymentBoleto = array (
                        'payment_method_reference_id'   => $transaction_details->payment_method_reference_id,
                        'verification_code'             => $transaction_details->verification_code,
                        'total_paid_amount'             => $transaction_details->total_paid_amount, 
                        'external_resource_url'         => $transaction_details->external_resource_url,
                    );

                    $order_payment->payment_boleto()->create($paymentBoleto);
    
                }elseif($payment->payment_type_id == 'bank_transfer'){

                    $metodo_pagamento = "Pix";
    
                    $point_of_interaction = $payment->point_of_interaction;
                    $transaction_data = $point_of_interaction->transaction_data;
    
                    $paymentPix = array (
                        'total_paid_amount'     => $transaction_details->total_paid_amount, 
                        'qr_code'               => $transaction_data->qr_code,
                        'qr_code_base64'        => $transaction_data->qr_code_base64,
                    );

                    $order_payment->payment_pix()->create($paymentPix);
    
                }


                if (isset($cart['discountCupon'])) {

                    $code = $cart['discountCupon']['cupon'];

                    $cupon = DiscountCupon::where('code', '=', $code)->first();

                    if ($cupon->quantity > 0) {

                        $qty = $cupon->quantity - 1;

                        $cupon->where('id', $cupon->id)->update(['quantity' => $qty]);
                    } else {

                        flash('O cupom está expirado!')->success();
                        return redirect()->route('payment.mercadopago');
                    }
                } elseif (isset($cart['giftCupon'])) {

                    $code = $cart['giftCupon']['cupon'];

                    $cupon = GiftCupon::where('code', '=', $code)->first();

                    if ($cupon->quantity > 0) {

                        $qty = $cupon->quantity - 1;

                        $cupon->where('id', $cupon->id)->update(['quantity' => $qty]);
                    } else {

                        flash('O cupom está expirado!')->success();
                        return redirect()->route('payment.mercadopago');
                    }
                }


                //Enviar E-mail do Pedido

                $productsOrder = DB::table('order_products')
                ->leftJoin('products', 'products.id', '=', 'order_products.product_id')
                ->leftJoin('order_product_options', 'order_product_options.order_product_id', '=', 'order_products.id')
                ->select('order_products.*', 'order_product_options.option', 'products.title', 'products.image', 'products.short_description')
                ->where('order_products.order_id', $order->id)
                ->orderBy('id', 'desc')
                ->get();

                $data = array (
                    "customer"      => $customer,
                    "order"         => $order,
                    "order_product" => $productsOrder,
                    "address"       => $customer->address()->first(),
                    "metodo_pagamento"        => $metodo_pagamento,
                );

                Mail::to($customer->email)->send(new NewOrderMail($data));

                // Mata a sessão
                $request->session()->forget('cart');

                if($payment->status_detail == 'pending_waiting_payment' || $payment->status_detail == 'pending_waiting_transfer'){
                    flash('Estamos processando o pagamento. Em até 2 dias úteis informaremos por e-mail se foi aprovado ou se precisamos de mais informações.')->warning();
                }

                return redirect()->route('payment.order', ['code' => $codigo_pedido]);

            }else{
				
				$status = $this->getStatus($status_detail, null);
				flash($status)->warning();
                return redirect()->route('payment.mercadopago');

            }

        }else{

            $errors = $payment->error->causes[0]->code;
            $errors = $this->getErrors($errors);

            flash($errors)->warning();
            return redirect()->route('payment.mercadopago');

        }

    }


    public function makePayment($mpData)
    {

        //SDK::setAccessToken("APP_USR-8654173215685261-041313-3777abb559046027561ac667049fd276-715836394");
		SDK::setAccessToken("TEST-8654173215685261-041313-0ede25869a8d4a6a4300e2e2970c601c-715836394");

        $customer = $mpData['customer'];
        $address = $customer->address()->first();

        $payment = new Payment();

        $payment->transaction_amount = (float)$mpData['transactionAmount'];
        $payment->token = $mpData['token'];
        $payment->installments = (int)$mpData['installments'];
        $payment->payment_method_id = $mpData['paymentMethod'];
        $payment->payer = array(
            "email" => $customer->email,
            "first_name" => $customer->firstname,
            "last_name" => $customer->lastname,
            "identification" => array(
                "type" => $mpData['identificationType'],
                "number" => $mpData['identificationNumber']
            ),
            "address"=>  array(
                "zip_code" => $address->cep,
                "street_name" => $address->logradouro,
                "street_number" => $address->numero,
                "neighborhood" => $address->bairro,
                "city" => $address->cidade,
                "federal_unit" => $address->uf
            )
        );

        $payment->save();

        return $payment;

    }


    public function order($code)
    {

        $order = Order::where('code', $code)->firstOrFail();

        $order_product = DB::table('order_products')
            ->leftJoin('products', 'products.id', '=', 'order_products.product_id')
            ->leftJoin('order_product_options', 'order_product_options.order_product_id', '=', 'order_products.id')
            ->select('order_products.*', 'order_product_options.option', 'products.title', 'products.image', 'products.short_description')
            ->orderBy('id', 'desc')
            ->get();

        $customer = Customer::find($order->customer_id);
        $address = $customer->address()->first();

        $orderPayment = $order->order_payment()->first();
        $paymentCreditCard = PaymentCreditcard::where('order_payment_id', $orderPayment->id)->first();
        $paymentBoleto = PaymentBoleto::where('order_payment_id', $orderPayment->id)->first();
        $paymentPix = PaymentPix::where('order_payment_id', $orderPayment->id)->first();

        return view('payment.order', compact('order', 'customer', 'address', 'order_product', 'orderPayment', 'paymentCreditCard', 'paymentBoleto', 'paymentPix'));
    }

    #Get Status
    public function getStatus($status_detail, $statement_descriptor)
    {
        $status = [
            'accredited' => 'Pronto, seu pagamento foi aprovado! Você verá o nome ' . $statement_descriptor . ' na sua fatura de cartão de crédito. Entraremos em contato com você!',
            'pending_contingency' => 'Estamos processando o pagamento. Em até 2 dias úteis informaremos por e-mail o resultado.',
            'pending_review_manual' => 'Estamos processando o pagamento. Em até 2 dias úteis informaremos por e-mail se foi aprovado ou se precisamos de mais informações.',
            'cc_rejected_bad_filled_card_number' => 'Confira o número do cartão.',
            'cc_rejected_bad_filled_date' => 'Confira a data de validade.',
            'cc_rejected_bad_filled_other' => 'Confira os dados.',
            'cc_rejected_bad_filled_security_code' => 'Confira o código de segurança.',
            'cc_rejected_blacklist' => 'Não conseguimos processar seu pagamento.',
            'cc_rejected_call_for_authorize' => 'Você deve autorizar o pagamento do valor ao Mercado Pago.',
            'cc_rejected_card_error' => 'Não conseguimos processar seu pagamento.',
            'cc_rejected_duplicated_payment' => 'Você já efetuou um pagamento com esse valor. Caso precise pagar novamente, utilize outro cartão ou outra forma de pagamento.',
            'cc_rejected_high_risk' => 'Seu pagamento foi recusado. Escolha outra forma de pagamento. Recomendamos meios de pagamento em dinheiro.',
            'cc_rejected_insufficient_amount' => 'O cartão possui saldo insuficiente.',
            'cc_rejected_invalid_installments' => 'O cartão não processa pagamentos parcelados.',
            'cc_rejected_max_attempts' => 'Você atingiu o limite de tentativas permitido. Escolha outro cartão ou outra forma de pagamento.',
            'cc_rejected_other_reason' => 'O cartão não processou seu pagamento'
        ];

        if (array_key_exists($status_detail, $status)) {
            return $status[$status_detail];
        } else {
            return "Houve um problema na sua requisição. Tente novamente!";
        }
    }

    #Get Error
    public function getErrors($errors)
    {
        $error = [
            '205' => 'Digite o número do seu cartão.',
            '208' => 'Escolha um mês.',
            '209' => 'Escolha um ano.',
            '212' => 'Informe seu documento.',
            '213' => 'Informe seu documento.',
            '214' => 'Informe seu documento.',
            '220' => 'Informe seu banco emissor.',
            '221' => 'Informe seu sobrenome.',
            '224' => 'Digite o código de segurança.',
            'E301' => 'Há algo de errado com esse número. Digite novamente.',
            'E302' => 'Confira o código de segurança.',
            '316' => 'Por favor, digite um nome válido.',
            '322' => 'Confira seu documento.',
            '323' => 'Confira seu documento.',
            '324' => 'Confira seu documento.',
            '325' => 'Confira a data.',
            '326' => 'Confira a data.',
            '2067' => 'O CPF não é válido.'

            
        ];

        if (array_key_exists($errors, $error)) {
            return $error[$errors];
        } else {
            return "Houve um problema na sua requisição. Tente novamente!";
        }
    }
}
