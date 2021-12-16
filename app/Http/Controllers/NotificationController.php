<?php

namespace App\Http\Controllers;

use App\Mail\PaymentPendingMail;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentSuccessMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\MerchantOrder;

class NotificationController extends Controller
{


    public function notification ()
    {

        SDK::setAccessToken("TEST-8654173215685261-041313-0ede25869a8d4a6a4300e2e2970c601c-715836394");
		
		//
		$payment = Payment::find_by_id($_GET["id"]);

        $order_payments = OrderPayment::where('payment_id', $_GET["id"])->first();

        switch ($order_payments->payment_type){

            case "credit_card":
                $metodo_pagamento = 'Cartão de Crédito';
                break;
            case "ticket":
                $metodo_pagamento = 'Boleto';
                break;
            case "bank_transfer":
                $metodo_pagamento = 'Pix';
                break;
            default:
                echo "None";

        }
		
        $order = Order::where('id', $order_payments->order_id)->first();

        $customer = Customer::where('id', $order->customer_id)->first();

        $orderStatus = array(
            "order_id" => $order->id,
            "status" => $payment->status,
            "status_detail" => $payment->status_detail,
        );

        $productsOrder = DB::table('order_products')
        ->leftJoin('products', 'products.id', '=', 'order_products.product_id')
        ->leftJoin('order_product_options', 'order_product_options.order_product_id', '=', 'order_products.id')
        ->select('order_products.*', 'order_product_options.option', 'products.title', 'products.image', 'products.short_description')
        ->where('order_products.order_id', $order->id)
        ->orderBy('id', 'desc')
        ->get();

        $data = array (
            "customer"          => $customer,
            "order"             => $order,
            "order_product"     => $productsOrder,
            "address"           => $customer->address()->first(),
            "metodo_pagamento"  => $metodo_pagamento,
        );
		
        //Enviar E-mail do Pedido
        if($payment->status == 'approved'){

            Mail::to($customer->email)->send(new PaymentSuccessMail($data));

        }elseif($payment->status == 'rejected'){

            Mail::to($customer->email)->send(new PaymentRejectedMail($data));

        }elseif($payment->status == 'pending' || $payment->status == 'in_process'){
			
            Mail::to($customer->email)->send(new PaymentPendingMail($data));
			
        }elseif($payment->status == 'cancelled'){
			
			
		}
		
		$result = OrderStatus::create($orderStatus);
        
    }


}
