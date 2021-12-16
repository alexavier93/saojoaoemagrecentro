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
                                        <a href="{{ route('payment.mercadopago') }}" class="list-group-item list-group-item-action active" aria-current="true">
                                            Cartão de Crédito
                                        </a>
                                        <a href="{{ route('payment.otherpayments') }}" class="list-group-item list-group-item-action">Boleto / Pix</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">

                            <div class="card-header">Dados do Pagamento</div>

                            <div class="card-body">

                                <div class="payments-form">

                                    <form id="form-checkout" action="{{ route('payment.createOrder') }}" method="post">
                                        @csrf
                                    
                                        <div class="row">
                                            
                                            <div class="col-md-7 mb-3">
                                                <label for="cardNumber">Número do cartão</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control number" name="cardNumber" id="form-checkout__cardNumber" maxlength="16"/>
                                                    <span class="input-group-text issuer_card">
                                                        <img src="{{ asset('assets/images/credit-card.svg') }}" style="width: 32px;">
                                                    </span>
                                                </div>
                                                  
                                            </div>
                                    
                                            <div class="col-md-5 mb-3">
                                                <label>Data de vencimento</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control number" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" maxlength="2">
                                                    <input type="text" class="form-control number" name="cardExpirationYear" id="form-checkout__cardExpirationYear" maxlength="2">
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-7 mb-3">
                                                <label for="cardholderName">Titular do cartão</label>
                                                <input class="form-control" type="text" name="cardholderName" id="form-checkout__cardholderName" />
                                            </div>
                                    
                                            <div class="col-md-5 mb-3">
                                                <label for="securityCode">Código de segurança</label>
                                                <input class="form-control number" type="text" name="securityCode" id="form-checkout__securityCode" maxlength="3"/>
                                            </div>
                                    
                                            <div class="col-md-3 mb-3">
                                                <label for="form-checkout__identificationType">Tipo de documento</label>
                                                <select class="form-control" name="identificationType" id="form-checkout__identificationType"></select>
                                            </div>
                                    
                                            <div class="col-md-4 mb-3">
                                                <label>Número do documento</label>
                                                <input class="form-control" type="text" name="identificationNumber" id="form-checkout__identificationNumber" />
                                            </div>
                                    
                                            <div class="col-md-5 mb-3">
                                                <label for="installments">Parcelas</label>
                                                <select class="form-control" name="installments" id="form-checkout__installments"></select>
                                            </div>
                                    
                                            <select class="d-none" name="issuer" id="form-checkout__issuer"></select>
                                    
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" id="form-checkout__submit" class="btn btn-primary">Confirmar a compra</button>
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
