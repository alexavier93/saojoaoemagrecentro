@extends('layouts.app')

@section('title', '- Pagamento')

@section('content')

    <div id="payment">

        <div class="container">

            <div class="mercadopago">

                <div class="row">

                    <div class="col-md-12">
                        @include('flash::message')

                        <div class="alert alert-warning" role="alert" style="display: none;"></div>
                    </div>

                    <div class="col-md-6 col-sm-12">

                        <div class="card mb-3">
                            <div class="card-header">Selecione uma forma de pagamento</div>

                            <div class="card-body">
                                <div class="payments-type">
                                    <div class="list-group">
                                        <a href="{{ route('payment.mercadopago') }}" class="list-group-item list-group-item-action" aria-current="true">
                                            Cartão de Crédito
                                        </a>
                                        <a href="{{ route('payment.otherpayments') }}" class="list-group-item list-group-item-action active">Boleto / Pix</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">

                            <div class="card-header">Dados do Pagamento</div>

                            <div class="card-body">

                                <div class="payments-form">

                                    <form action="{{ route('payment.createOrder') }}" method="post" id="boletoPayment">
                                        @csrf
                                    
                                        <div class="row">

                                            <div class="col-md-12 mb-3">
                                                <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                                                    <option value="">Selecione uma forma de pagamento</option>
                                                    <option value="bolbradesco">Boleto</option>
                                                    <option value="pix">Pix</option>
                                                </select>
                                            </div>
                                    
                                            <div class="col-lg-4 mb-3">
                                                <label for="docType">Tipo de documento</label>
                                                <select class="form-control" name="identificationType" id="docType"></select>
                                            </div>
                                    
                                            <div class="col-lg-8 mb-3">
                                                <label>Número do documento</label>
                                                <input class="form-control" type="text" name="identificationNumber" id="identificationNumber" />
                                            </div>
                                    
                                        </div>
                                    
                                        <input type="hidden" name="MPHiddenInputAmount" id="transactionAmount" value="{{ $cart['total'] }}" />
                                    
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Confirmar a compra</button>
                                        </div>
                                        
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-sm-12 mt-4 mt-md-0">

                        <div class="card">

                            <div class="card-header">Resumo Do Pedido</div>

                            <div class="card-body">

                                @if ($cart)
                                    @foreach ($cart['products'] as $item)

                                        <div class="d-flex justify-content-between my-3">
                                            <div>
                                                <h6 class="my-0">{{ $item['name'] }}</h6>
                                                <small class="text-muted">{{ $item['attributes']['section'] }}</small><br>
                                                <small class="text-muted">Quantidade: {{ $item['qty'] }}</small>

                                            </div>
                                            <span class="text-muted">R$
                                                {{ number_format($item['sub_total'], 2, ',', ' ') }}</span>
                                        </div>

                                    @endforeach
                                @endif

                                <hr class="my-3">
                                
                                @isset ($cart['discountCupon'])
                                <div class="d-flex justify-content-between">
                                    <span>Desconto</span>

                                    @php
                                        $total = 0;
                                        foreach ($cart['products'] as $key => $value) {
                                            $total += $value['sub_total'];
                                        }
                                        $desconto = $cart['total'] - $total
                                    @endphp

                                    <strong>R$ <span>{{ number_format($desconto, 2, ',', ' ') }}</span></strong>
                                </div>
                                @endisset

                                @isset ($cart['giftCupon'])
                                <div class="d-flex justify-content-between">
                                    <span>Desconto</span>

                                    @php
                                        $total = 0;
                                        foreach ($cart['products'] as $key => $value) {
                                            $total += $value['sub_total'];
                                        }
                                        $desconto = $cart['total'] - $total
                                    @endphp

                                    <strong>R$ <span>{{ number_format($desconto, 2, ',', ' ') }}</span></strong>
                                </div>
                                @endisset

                                <div class="d-flex justify-content-between">
                                    <span>Total</span>
                        
                                    @if ($cart['total'] == '')
                                        R$ 0
                                    @else
                                        <strong>R$ <span class="money">{{ number_format($cart['total'], 2, ',', ' ') }}</span></strong>
                                        <input type="hidden" id="valorTotal" value="{{ $cart['total'] }}">
                                    @endif
                               
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>


        </div>

    </div>

@endsection
