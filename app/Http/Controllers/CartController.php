<?php

namespace App\Http\Controllers;

use App\Models\DiscountCupon;
use App\Models\GiftCupon;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\Section;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
 
        session()->forget('email');

        $cart = $request->session()->get('cart');

        if (isset($cart)) {
            if ($cart['products'] == false) {
                session()->forget('cart');
            }
        }

        return view('cart.index', compact('cart'));
    }

    public function create(Request $request)
    {

        $Product = Product::find($request->id_product);

        if($request->section){
            $productSection = ProductSection::where('id', $request->section)->first();
            $section = Section::find($productSection->section_id);
        }else{
            $section = false;
        }

        if ($section == false) {
            $section = '';
        } else {
            $section = $section->title;
        }

        $data = array(
            'id'            => rand(1000, 9999),
            'name'          => $Product->title,
            'image'         => $Product->image,
            'qty'           => $request->qty,
            'price'         => $request->price,
            'sub_total'     => $request->price,
            'attributes'    => array(
                'section'   => $section,
            ),
            'associatedProduct'    => $Product,
        );

        // Se existir sessão carrinho
        if (session()->has('cart')) {

            // Inserindo produto no carrinho e salvando
            session()->push('cart.products', $data);
            //session()->save();

            // Resgatando a sessão carrinho
            $cart = $request->session()->get('cart');

            // Pegando o ultimo produto adicionado
            $product = end($cart['products']);

            // Verifica se o cupom foi adicionado
            if (isset($cart['discountCupon'])) {

                // Pega o valor total do carrinho Ex. 90
                $total_cart = session()->get('cart.total');
                
                // valor com desconto R$ 90 ( 10% desconto / R$ 100)
                $cupon = $cart['discountCupon']['value'];
                $priceDiscount = $this->percentageValue($cupon, $product['price']);  

                //90 + 90 = 180
                $total = $total_cart + $priceDiscount;

                $total = str_replace(' ', '', number_format($total, 2, '.', ' '));

            }elseif(isset($cart['giftCupon'])){

                // Pega o valor total do carrinho Ex. 90
                $total_cart = session()->get('cart.total');
                $total = $total_cart + $product['price'];
                $total = str_replace(' ', '', number_format($total, 2, '.', ' '));

            }else{

                $total = 0;
                foreach ($cart['products'] as $key => $value) {
                    $total += $value['sub_total'];
                    $total = str_replace(' ', '', number_format($total, 2, '.', ' '));
                }

            }
        
            session()->put('cart.total', $total);
            session()->save();

        } else {

            session()->put('cart');
            session()->push('cart.products', $data);
            session()->put('cart.total', $request->price);
        }

        return redirect()->route('cart.index');
    }

    public function deleteProduct(Request $request, $id)
    {

        $cart = $request->session()->get('cart');

        foreach ($cart['products'] as $key => $value) {

            if ($value['id'] == $id) {
                // Excluindo a chave e salvando em seguida
                session()->forget('cart.products.' . $key);

                // Tem 180
                $total_cart = session()->get('cart.total');

                // 180 - 100(produto) = 80
                $total_cart = $total_cart - $value['sub_total'];

                if (isset($cart['discountCupon'])) {

                    $cupon = $cart['discountCupon']['value'];

                    // Cupom 10% com 100 = 10
                    $discount = $this->percentageDiscount($cupon, $value['sub_total']);

                    // 80 + 10 = 90
                    $total_cart = $total_cart + $discount;

                }

                session()->put('cart.total', $total_cart);
                session()->save();

            }
        }

        if ($cart['products'] == false) {
            session()->forget('cart');
        }

        flash('Item removido com sucesso!')->success();
        return redirect()->route('cart.index');
    }

    public function incrementProduct(Request $request, $id)
    {

        $cart = $request->session()->get('cart');

        foreach ($cart['products'] as $key => $value) {

            if ($value['id'] == $id) {

                $total = $value['sub_total'] + $value['price'];
                $subtotal = str_replace(' ', '', number_format($total, 2, '.', ' '));

                session()->increment('cart.products.' . $key . '.qty', 1);
                session()->put('cart.products.' . $key . '.sub_total', $subtotal);

                $total_cart = session()->get('cart.total');
                $total_cart = $total_cart + $value['price'];

                if (isset($cart['discountCupon'])) {

                    $cupon = $cart['discountCupon']['value'];
                    $discount = $this->percentageDiscount($cupon, $value['price']);

                    $total = $total_cart - $discount;
                    $total_cart = str_replace(' ', '', number_format($total, 2, '.', ' '));

                }elseif(isset($cart['giftCupon'])){

                    // Pega o valor total do carrinho Ex. 90
                    $total_cart = session()->get('cart.total');
                    $total = $total_cart + $value['price'];
                    $total_cart = str_replace(' ', '', number_format($total, 2, '.', ' '));
    
                }

                session()->put('cart.total', $total_cart);
            }
        }

        return redirect()->route('cart.index');
    }

    public function decrementProduct(Request $request, $id)
    {

        $cart = $request->session()->get('cart');

        foreach ($cart['products'] as $key => $value) {
            if ($value['id'] == $id) {

                $total = $value['sub_total'] - $value['price'];
                $subtotal = str_replace(' ', '', number_format($total, 2, '.', ' '));

                session()->decrement('cart.products.' . $key . '.qty', 1);
                session()->put('cart.products.' . $key . '.sub_total', $subtotal);

                $total_cart = session()->get('cart.total');
                $total_cart = $total_cart - $value['price'];

                if (isset($cart['discountCupon'])) {

                    $cupon = $cart['discountCupon']['value'];
                    $discount = $this->percentageDiscount($cupon, $value['price']);

                    $total_cart = $total_cart + $discount;

                }

                session()->put('cart.total', $total_cart);

                if ($value['qty'] == 1) {
                    session()->forget('cart.products.' . $key);

                    if ($cart['products'] == false) {
                        session()->forget('cart');
                    }
                }
            }
        }

        if ($cart['products'] == false) {
            session()->forget('cart');
        }

        return redirect()->route('cart.index');
    }

    public function discountCupon(Request $request)
    {

        $cart = session()->get('cart');

        if (isset($cart['products'])) {

            if ($cart['products']) {

                $cupon = DiscountCupon::where('code', '=', $request->code)->first();

                if ($cupon) {

                    if ($cupon->quantity > 0) {

                        if (isset($cart['discountCupon'])) {

                            if ($cart['discountCupon']['exists'] == true) {
                                flash('Você já tem um cupom de presente aplicado!')->warning();
                            }
                        } else {

                            $data = array(
                                'exists'    => true,
                                'cupon'     => $cupon->code,
                                'value'     => $cupon->value,
                                'discount'  => '',
                            );

                            session()->put('cart.discountCupon', $data);

                            $total_cart = session()->get('cart.total');

                            $discountTotal = $this->percentageValue($cupon->value, $total_cart);

                            $total_cart = str_replace(' ', '', number_format($discountTotal, 2, '.', ' '));

                            session()->put('cart.total', $total_cart);
                            session()->put('cart.discountCupon.discount', $cupon->value);

                            flash('Cupom adicionado com sucesso!')->success();
                        }

                    } else {
                        flash('O cupom não é válido!')->warning();
                    }

                } else {
                    flash('O cupom não é válido!')->warning();
                }

            } else {
                flash('Você não tem produtos no carrinho!')->warning();
            }
        } else {
            flash('Você não tem produtos no carrinho!')->warning();
        }

        return redirect()->route('cart.index');
    }

    public function giftCupon(Request $request)
    {

        $cart = session()->get('cart');

        if (isset($cart['products'])) {

            if ($cart['products']) {
                $cupon = GiftCupon::where('code', '=', $request->code)->first();

                if ($cupon) {

                    if ($cupon->quantity > 0) {

                        if (isset($cart['giftCupon'])) {
                            if ($cart['giftCupon']['exists'] == true) {
                                flash('Você já tem um cupom de presente aplicado!')->warning();
                            }
                        } else {
                            $data = array(
                                'exists'    => true,
                                'cupon'     => $cupon->code,
                                'value'     => $cupon->value,
                                'discount'  => '',
                            );
            
                            session()->put('cart.giftCupon', $data);
            
                            $total_cart = session()->get('cart.total');
                            $total_cart = $total_cart - $cupon->value;
                            session()->put('cart.total', $total_cart);
                            session()->put('cart.giftCupon.discount', $cupon->value);
            
                            flash('Cupom adicionado com sucesso!')->success();
                        }

                    } else {
                        flash('O cupom não é válido!')->warning();
                    }

                } else {
                    flash('O cupom não é válido!')->warning();
                }
            } else {
                flash('Você não tem produtos no carrinho!')->warning();
            }
        } else {
            flash('Você não tem produtos no carrinho!')->warning();
        }

        return redirect()->route('cart.index');
    }

    public function percentageValue($cupom, $valor)
    {
        $percentual = $cupom / 100;
        $valor_final = $valor - ($percentual * $valor);
        return $valor_final;
    }

    public function percentageDiscount($cupom, $valor)
    {
        $percentual = $cupom / 100;
        $valor_final = $percentual * $valor;
        return $valor_final;
    }

}
