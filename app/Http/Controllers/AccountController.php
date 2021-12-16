<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Mail\NewAccountMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{

    public function index()
    {
    }

    public function login()
    {

        return view('account.login.login');
    }

    public function doLogin(Request $request)
    {

        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        $customer = Customer::where('email', '=', $request->email)->first();

        if (!$customer) {

            flash('Usuário não encontrado!')->warning();
            return redirect()->route('account.login');
        } elseif (!Hash::check($request->password, $customer->password)) {

            flash('Email e senha incorretos!')->warning();
            return redirect()->route('account.login');
        } else {

            if ($customer->status == 0) {

                flash('Olá, seu acesso está bloqueado, por favor entrar em contato conosco!')->warning();
                return redirect()->route('account.login');
            } else {

                session()->put('customer', $customer);
                return redirect()->route('account.orders')->withErrors('ERROS');
            }
        }
    }

    public function create()
    {

        return view('account.login.create');
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

            flash('Conta criada com sucesso!')->success();
            return redirect()->route('account.login');
        }
    }

    public function orders()
    {
        if (session()->has('customer')) {

            $customer = session()->get('customer');

            $orders = Order::where('customer_id', $customer->id)->paginate(10);

            $order_product = DB::table('order_products')
            ->leftJoin('products', 'products.id', '=', 'order_products.product_id')
            ->leftJoin('order_product_options', 'order_product_options.order_product_id', '=', 'order_products.id')
            ->select('order_products.*', 'order_product_options.option', 'products.title', 'products.image', 'products.short_description')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

            return view('account.orders', compact('orders', 'order_product'));

        } else {
            return redirect()->route('account.login');
        }
    }

    public function register()
    {

        if (session()->has('customer')) {

            $customer = session()->get('customer');
            $customer = Customer::findOrFail($customer->id);

            return view('account.register', compact('customer'));
        } else {
            return redirect()->route('account.login');
        }
    }

    public function updateCustomer(UpdateCustomerRequest $request, $customer)
    {

        $data = $request->all();
        $data['cpf'] = limpaCPF_CNPJ($request->cpf);
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
        
        $customer = Customer::findOrFail($customer);
        $customer->update($data);
        
        flash('Informações atualizadas com sucesso!')->success();
        return redirect()->route('account.register');
    }

    public function address()
    {

        if (session()->has('customer')) {

            $customer = session()->get('customer');
            $customer = Customer::findOrFail($customer->id);
            $address = $customer->address()->first();

            return view('account.address', compact('address'));

        } else {
            return redirect()->route('account.login');
        }

        
    }


    public function logout()
    {
        session()->forget('customer');
        return redirect()->route('account.login');
    }
}
