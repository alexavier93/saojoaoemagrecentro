@extends('layouts.app')

@section('title', '- Pagamento')

@section('content')

    <div id="payment">

        <div class="container">

            <div class="mercadopago">

                <div class="row">

                    <div class="col-md-12">
                        @include('flash::message')
                    </div>

                    <div class="col-md-7 col-sm-12">

                        <div class="card">

                            <div class="card-header">Dados do Pagamento</div>

                            <div class="card-body">

                                <form action="{{ route('payment.createOrder') }}" method="post" id="paymentForm">
                                    @csrf

                                    <div class="row">

                                        <div class="col-md-7 mb-3">
                                            <label for="cardNumber">Número do cartão</label>
                                            <input class="form-control" type="text" id="cardNumber"
                                                data-checkout="cardNumber" onselectstart="return false"
                                                onpaste="return false" oncopy="return false" oncut="return false"
                                                ondrag="return false" ondrop="return false" autocomplete=off>
                                        </div>

                                        <div class="col-md-5 mb-3">

                                            <div class="row">

                                                <label>Data de vencimento</label>
                                                <div class="col-lg-6 col-sm-6">
                                                    <input class="form-control" type="text" placeholder="01"
                                                        id="cardExpirationMonth" maxlength="2"
                                                        data-checkout="cardExpirationMonth" onselectstart="return false"
                                                        onpaste="return false" oncopy="return false" oncut="return false"
                                                        ondrag="return false" ondrop="return false" autocomplete=off>
                                                </div>
                                                <div class="col-lg-6 col-sm-6">
                                                    <input class="form-control" type="text" placeholder="20"
                                                        id="cardExpirationYear" maxlength="2"
                                                        data-checkout="cardExpirationYear" onselectstart="return false"
                                                        onpaste="return false" oncopy="return false" oncut="return false"
                                                        ondrag="return false" ondrop="return false" autocomplete=off>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7 mb-3">
                                            <label for="cardholderName">Titular do cartão</label>
                                            <input id="cardholderName" class="form-control" data-checkout="cardholderName"
                                                type="text">
                                        </div>

                                        <div class="col-md-5 mb-3">
                                            <label for="securityCode">Código de segurança</label>
                                            <input class="form-control" id="securityCode" data-checkout="securityCode"
                                                type="text" onselectstart="return false" onpaste="return false"
                                                oncopy="return false" oncut="return false" ondrag="return false"
                                                ondrop="return false" autocomplete=off>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="docType">Tipo de documento</label>
                                            <select id="docType" class="form-control" name="docType" data-checkout="docType"
                                                type="text"></select>
                                        </div>

                                        <div class="col-md-5 mb-3">
                                            <label for="docNumber">Número do documento</label>
                                            <input id="docNumber" class="form-control" name="docNumber"
                                                data-checkout="docNumber" type="text" />
                                        </div>

                                        <div id="issuerInput" class="col-md-4 mb-3 d-none">
                                            <label for="issuer">Banco emissor</label>
                                            <select class="form-control" id="issuer" name="issuer"
                                                data-checkout="issuer"></select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="installments">Parcelas</label>
                                            <select class="form-control" type="text" id="installments"
                                                name="installments"></select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <input type="hidden" name="transactionAmount" id="transactionAmount"
                                                value="pedido_total" />
                                            <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
                                            <input type="hidden" name="description" id="description" />
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary float-right">Confirmar a compra</button>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-5 col-sm-12 mt-4 mt-md-0">

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
