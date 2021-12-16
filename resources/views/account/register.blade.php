@extends('layouts.app')
@extends('account.nav')

@section('title', '- Login')

@section('content')

    <div id="login">


        <div class="container">

            <div class="content">

                @include('flash::message')

                <div class="row">

                    <div class="col-lg-3">
                        @section('nav_content')
                    </div>

                    <div class="col-lg-7">

                        <h1 class="mb-3 display-6">Dados Pessoais</h1>

                        <form action="{{ route('account.updateCustomer', ['customer' => $customer->id]) }}" method="POST">

                            @csrf
                            @method("PUT")

                            <div class="row">

                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" value="{{ $customer->firstname }}" name="firstname">
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Sobrenome</label>
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" value="{{ $customer->lastname }}" name="lastname">
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Data de Nascimento</label>
                                    <input type="text" class="form-control data @error('birthdate') is-invalid @enderror" value="{{ $customer->birthdate }}" name="birthdate">
                                    @error('birthdate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                            </div>
    
                            <div class="row">
                                <div class="col-md-7 mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control number_cpf @error('cpf') is-invalid @enderror" value="{{ $customer->cpf }}" name="cpf">
                                    @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $customer->email }}"  name="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" class="form-control telefone @error('phone') is-invalid @enderror" value="{{ $customer->phone }}" name="phone">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-7 mb-3">
                                    <a href="javascript:void(0)" class="btn btn-secondary btn-sm change_password">Trocar Senha</a>
                                </div>

                                <div class="passwordCustomer" style="display: none">

                                    <div class="col-md-7 mb-3">
                                        <label class="form-label">Senha</label>
                                        <input type="hidden" class="form-control password @error('password') is-invalid @enderror" value="{{ old('password') }}" name="">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-7 mb-3">
                                        <label class="form-label">Confirmar Senha</label>
                                        <input type="hidden" class="form-control password_confirmation @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" name="">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                
                            </div>
    
                            <button type="submit" class="btn btn-secondary">Salvar Informações</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
