@extends('layouts.app')

@section('title', '- Carrinho')

@section('content')

    <div id="cart">


        <div class="container">

            <div class="content">

                <div class="mb-5">

                    <div class="row">

                        <div class="col-lg-9 mb-5">

                            @include('flash::message')

                            <div class="table-responsive table-resume-cart">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Sub-total</th>
                                            <th scope="col">Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Product-->
                                        @if ($cart)
                                            @foreach ($cart['products'] as $item)

                                                <tr class="align-items-center text-center">

                                                    <td class="column-product">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                                class="cart-item-img">
                                                            <div class="cart-title text-start">
                                                                <a href="" class="text-uppercase text-dark">
                                                                    <strong>{{ $item['name'] }}</strong>
                                                                </a>
                                                                <div class="text-muted text-sm">
                                                                    {{ $item['attributes']['section'] }}</div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="column-qtd">
                                                        <div class="d-flex align-items-center">
                                                            <div class="quantity d-flex align-items-center">

                                                                <a href="{{ route('cart.decrementProduct', ['id' => $item['id']]) }}"
                                                                    class="btn btn-items btn-items-decrease">-</a>

                                                                <input type="text" name="" value="{{ $item['qty'] }}"
                                                                    class="form-control text-center input-items disabled"
                                                                    disabled>

                                                                <a href="{{ route('cart.incrementProduct', ['id' => $item['id']]) }}"
                                                                    class="btn btn-items btn-items-increase">+</a>

                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="column-price text-center">
                                                        R$ <span class="money">{{ $item['sub_total'] }}</span>
                                                    </td>

                                                    <td class="column-delete text-center">
                                                        <a href="{{ route('cart.deleteProduct', ['id' => $item['id']]) }}"
                                                            class="cart-remove btn btn-light">
                                                            <i class="delete fa fa-times"></i>
                                                        </a>
                                                    </td>

                                                </tr>

                                            @endforeach

                                        @else
                                            <tr class="align-items-center text-center">

                                                <td colspan="4" class="column-delete text-center">
                                                    <p>Carrinho vazio</p>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                    <tfoot>

                                        @if ($cart)
                                        @isset ($cart['discountCupon'])
                                        <tr class="cart__table__row">
                                            @php
                                                $total = 0;
                                                foreach ($cart['products'] as $key => $value) {
                                                    $total += $value['sub_total'];
                                                }
                                                $discount = $cart['total'] - $total
                                            @endphp

                                            <td colspan="4" class="text-end">
                                                <b>Cupom de Desconto</b>: R$ <span>{{ number_format($discount, 2, ',', ' ') }}</span>
                                            </td>
                                        </tr>
                                        @endisset
                                        
                                        @isset ($cart['giftCupon'])
                                        <tr class="cart__table__row">
                                            @php
                                                $total = 0;
                                                foreach ($cart['products'] as $key => $value) {
                                                    $total += $value['sub_total'];
                                                }
                                                $discount = $cart['total'] - $total
                                            @endphp

                                            <td colspan="4" class="text-end">
                                                <b>Cupom de Presente</b>: R$ <span>{{ number_format($discount, 2, ',', ' ') }}</span>
                                            </td>
                                        </tr>
                                        @endisset

                                        @endif

                                        <tr class="total cart__table__row">

                                            <td colspan="4" class="text-end">
                                                <b>Total</b>:
                                                @if ($cart)
                                                    @if ($cart['total'] == '')
                                                        R$ 0
                                                    @else
                                                        R$ <span class="money">{{ number_format($cart['total'], 2, ',', ' ') }}</span>
                                                    @endif
                                                @else
                                                    R$ 0
                                                @endif
                                            </td>

                                        </tr>

                                    </tfoot>

                                </table>

                            </div>

                            <ul class="list-group mt-4 w-100 list-products d-none">

                                <!-- Product-->

                                <li class="list-group-item justify-content-between lh-condensed">

                                    <div class="row">

                                        <div class="col-4">

                                            <div>
                                                <h6 class="my-0">NICEBOX <span
                                                        class="badge badge-secondary badge-pill">1</span>
                                                </h6>
                                                <small class="text-muted">Cor: Dourado</small>
                                                <br>
                                                <small class="text-muted">R$ 12,00</small>
                                            </div>

                                        </div>

                                        <div class="col-4">

                                            <div class="quantity d-flex align-items-center">

                                                <a href="" class="btn btn-items btn-items-decrease">-</a>

                                                <input type="text" name="1[qty]" value="1"
                                                    class="form-control text-center input-items">

                                                <a href="" class="btn btn-items btn-items-increase">+</a>

                                            </div>

                                        </div>

                                        <div class="col-4 text-center"><span class="text-muted">R$ 12,00</span></div>


                                    </div>



                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total</span>
                                    <strong>R$ 12,00</strong>
                                    <input id="valorTotal" type="hidden" name="valorTotal" value="12.00">
                                </li>

                            </ul>

                            <div class="my-3 d-flex justify-content-between flex-column flex-lg-row">

                                <a href="" onclick="window.history.go(-1); return false;" class="btn btn-link text-muted"><i class="fa fa-chevron-left"></i> Continue Comprando</a>

                                <a href="{{ route('checkout.auth') }}" class="btn btn-success">Finalizar Pedido <i class="fa fa-chevron-right"></i></a>

                            </div>


                        </div>

                        <div class="col-lg-3">

                            <div class="card p-2 mb-3">

                                <h6>CUPOM DE DESCONTO</h6>

                                <form action="{{ route('cart.discountCupon') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Informe aqui seu cupom promocional</label>
                                        <div class="input-group">
                                            <input type="text" name="code" class="form-control">
                                            <button type="submit" class="btn btn-secondary">Aplicar</button>
                                        </div>
                                    </div>

                                </form>

                            </div>

                            <div class="card p-2 mb-3">

                                <h6>CUPOM DE PRESENTE</h6>

                                <form action="{{ route('cart.giftCupon') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Insira aqui o código do seu Gift Card</label>
                                    <div class="input-group">
                                        <input type="text" name="code" class="form-control">
                                        <button type="submit" class="btn btn-secondary">Aplicar</button>
                                    </div>
                                </div>

                                </form>

                            </div>


                        </div>





                    </div>


                </div>

            </div>

        </div>

    </div>

@endsection
