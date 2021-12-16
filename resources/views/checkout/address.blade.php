@extends('layouts.app')

@section('title', '- Dados do Comprador')

@section('content')

    <div id="checkout">

        <div class="container">

            <div class="customer">

                @include('flash::message')

                <div class="row">

                    <div class="col-md-4 col-sm-12">

                        <div class="card">

                            <div class="card-header">Dados Pessoais</div>

                            <div class="card-body">

                                <p class="card-text">{{ $customer->email }}</p>

                                <p class="card-text">{{ $customer->firstname.' '.$customer->lastname }}</p>

                                <p class="card-text">{{ $customer->phone }}</p>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-12">

                        <div class="card">

                            <div class="card-header">Endereço</div>

                            <div class="card-body">

                                @include('flash::message')

                                <form action="{{ route('checkout.createAddress') }}" method="POST">

                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">CEP</label>
                                            <input type="text" name="cep" id="cepConsulta" class="form-control cep @error('cep') is-invalid @enderror" data-url="{{ route('checkout.consultaCep') }}" "
                                                placeholder="Digite um CEP">
                                            @error('cep')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Rua / Avenida</label>
                                            <input type="text" name="logradouro" class="form-control @error('logradouro') is-invalid @enderror" value="{{ old('logradouro') }}">
                                            @error('logradouro')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Número</label>
                                            <input type="text" class="form-control" name="numero" class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}">
                                            @error('numero')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label">Complemento</label>
                                            <input type="text" class="form-control" name="complemento">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Bairro</label>
                                            <input type="text" class="form-control" name="bairro" class="form-control @error('bairro') is-invalid @enderror" value="{{ old('bairro') }}">
                                            @error('bairro')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label">Cidade</label>
                                            <input type="text" class="form-control" name="cidade" class="form-control @error('cidade') is-invalid @enderror" value="{{ old('cidade') }}">
                                            @error('cidade')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">UF</label>
                                            <input type="text" class="form-control" name="uf" class="form-control @error('uf') is-invalid @enderror" value="{{ old('uf') }}">
                                            @error('uf')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-secondary">Ir para o pagamento</button>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-12 mt-4 mt-md-0">
                        
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
                                    <span class="text-muted">R$ {{ number_format($item['sub_total'], 2, ',', ' ') }}</span>
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
