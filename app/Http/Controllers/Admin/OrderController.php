<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $orders = $this->order->orderBy('id', 'DESC')->paginate(10);
        $orders = $orders->load('customer');
        

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($order)
    {

        $order = $this->order->findOrFail($order);

        $order_product = DB::table('order_products')
        ->leftJoin('products', 'products.id', '=', 'order_products.product_id')
        ->leftJoin('order_product_options', 'order_product_options.order_product_id', '=', 'order_products.id')
        ->select('order_products.*', 'order_product_options.option', 'products.title', 'products.image', 'products.short_description')
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
     
        $customer = Customer::find($order->customer_id);
        $address = $customer->address()->first();

        return view('admin.orders.show', compact('order', 'customer', 'address', 'order_product'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request)
    {

        $id = $request->id;

        $order = $this->order->find($id);

        if ($order->delete() == TRUE) {

            /*
            if (Storage::exists($modelo->image)) {
                Storage::delete($modelo->image);
            }
            */

            flash('Modelo removido com sucesso!')->success();
            return redirect()->route('admin.orders.index');
        }

    }


    public function orderby(Request $request)
    {

        $sort = request()->sort;
        $order = request()->order;

        if($order == 'desc'){
            $orders = $this->order::orderBy($sort, 'desc')->paginate(10);
            $orders = $orders->load('customer');
        }else{
            $orders = $this->order::orderBy($sort, 'asc')->paginate(10);
            $orders = $orders->load('customer');
        }

        return view('admin.orders.index', compact('orders'));
    }

}
