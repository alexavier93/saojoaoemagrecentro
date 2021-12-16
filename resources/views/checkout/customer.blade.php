@extends('layouts.app')

@section('title', '- Dados do Comprador')

@section('content')

    <div id="checkout">

        <div class="container">

            <div class="customer">

                <div class="row">

                    <div class="col-md-4 col-sm-12">

                        <div class="card costumer">

                            <div class="card-header">Dados Pessoais</div>

                            <div class="card-body">

                                <p class="card-text">Solicitamos apenas as informações essenciais para a realização da compra.</p>

                                @include('flash::message')

                                <form action="{{ route('checkout.createCustomer') }}" method="POST">
                                    @csrf

                                    <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" @if (session()->get('email')) value="{{ $email }}" @endif >
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nome</label>
                                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}">
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}">
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control number_cpf @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}">
                                            @error('cpf')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Data de Nascimento</label>
                                            <input type="text" class="form-control data @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}">
                                            @error('birthdate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Telefone</label>
                                            <input type="text" class="form-control telefone @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Senha</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirma senha</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-secondary">Salvar Informações</button>

                                </form>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">Endereço</div>
                            <div class="card-body">
                                <p>Aguardando o preenchimento dos dados pessoais</p>
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
