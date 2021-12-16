<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAddressRequest;
use App\Http\Requests\CreateCustomerRequest;
use App\Mail\NewAccountMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    public function index()
    {

        return view('checkout.index');
    }

    public function auth()
    {

        session()->forget('email');

        if (session()->has('customer')) {
            return redirect()->route('payment.mercadopago');
        }else{
            return view('checkout.auth');
        }

        
    }

    public function doAuth(Request $request)
    {

        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $customer = Customer::where('email', '=', $request->email)->first();

        if (!Hash::check($request->password, $customer->password)) {

            flash('Email e senha incorretos!')->warning();
            return redirect()->route('checkout.auth')->withErrors('ERROS');

        } else {

            if ($customer->status == 0) {

                flash('Olá, seu acesso está bloqueado, por favor entrar em contato conosco!')->warning();
                return redirect()->route('checkout.auth');

            } else {

                session()->put('customer', $customer);
                return redirect()->route('payment.mercadopago')->withErrors('ERROS');

            }
        }

        return redirect()->route('checkout.customer');
    }

    public function newCustomer(Request $request)
    {

        $email = $request->email;

        session()->put('email', $email);

        return redirect()->route('checkout.customer');
    }

    public function customer()
    {

        if (session()->has('email')) {

            $email = session()->get('email');
            $cart = session()->get('cart');

            return view('checkout.customer', compact('email', 'cart'));
        } else {

            return redirect()->route('checkout.auth');
        }
    }

    public function createCustomer(CreateCustomerRequest $request)
    {

        $data = $request->all();

        $data['cpf'] = limpaCPF_CNPJ($request->cpf);
        $data['password'] = Hash::make($request->password);
        $data['type'] = 1;
        $data['status'] = 1;

        $customer = Customer::create($data);

        if ($customer) {
			
			Mail::to($customer->email)->send(new NewAccountMail($customer));

            session()->put('customer', $customer);
            session()->forget('email');

            flash('Conta criada com sucesso! Agora preencha os dados do seu endereço.')->success();
            return redirect()->route('checkout.address');

        }
    }


    public function address()
    {

        if (session()->has('customer')) {

            $customer = session()->get('customer');
            $cart = session()->get('cart');

            return view('checkout.address', compact('customer', 'cart'));
        } else {
            return redirect()->route('checkout.customer');
        }
    }

    public function createAddress(CreateAddressRequest $request)
    {

        $data = $request->all();

        $customer = session()->get('customer');
        $customer = Customer::where('id', $customer->id)->first();

        $address = $customer->address()->create($data);

        if ($address) {
            flash('Endereço adicionado com sucesso! Para finalizar, preencha os dados para realizar o pagamento.')->success();
            return redirect()->route('payment.mercadopago');
        }

    }

    /**
     * 
     * Função para checar se o usuário já tem cadastro e redirecionar para tal função
     * 
     */
    public function checkEmail(Request $request)
    {

        $customer = Customer::where('email', '=', $request->email)->first();

        if ($customer) {

            $response = array(
                'exists'    => true,
                'action'    => route('checkout.doAuth')
            );
        } else {

            $response = array(
                'exists'    => false,
                'action'    => route('checkout.newCustomer')
            );
        }

        return response()->json($response);
    }

    /**
     * 
     * Função para consultar o CEP
     * 
     */
    function consultaCep(Request $request)
    {

        $cep = $request->cep;

        $consulta = str_replace("-", "", $cep);

        $result = simplexml_load_file("http://viacep.com.br/ws/" . $consulta . "/xml/");

        $dados = array(
            'logradouro' => (string) $result->logradouro,
            'bairro' => (string) $result->bairro,
            'cidade' => (string) $result->localidade,
            'uf' => (string) $result->uf
        );

        echo json_encode($dados);
    }
}
