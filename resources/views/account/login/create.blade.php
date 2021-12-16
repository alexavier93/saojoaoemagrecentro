@extends('layouts.app')

@section('title', '- Login')

@section('content')

    <div id="login">


        <div class="container">

            <div class="content">

                <div class="row">

                    <div class="col-lg-6 offset-lg-3">

                        <div class="form-login">

                            <div class="text-center mb-3">
                                <h4>CRIE UMA CONTA</h4>
                            </div>
                            
                            <form action="{{ route('account.createCustomer') }}" method="POST">

                                @csrf

                                <div class="row">

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">Nome</label>
                                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" name="firstname">
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" name="lastname">
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">Data de Nascimento</label>
                                            <input type="text" class="form-control data @error('birthdate') is-invalid @enderror" value="{{ old('birthdate') }}" name="birthdate">
                                            @error('birthdate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control number_cpf @error('cpf') is-invalid @enderror" value="{{ old('cpf') }}" name="cpf">
                                            @error('cpf')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">Telefone</label>
                                            <input type="text" class="form-control telefone @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"  name="email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">Senha</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"  name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="mb-3">
                                            <label class="form-label">Confirmar Senha</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}"  name="password_confirmation">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-12 col-lg-6">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="news">
                                            <label class="form-check-label" for="news">Desejo receber novidades por e-mail</label>
                                        </div>

                                    </div>


                                    

                                </div>

                                <div class="my-3">
                                    <button type="submit" class="btn btn-primary">Criar Conta</button>
                                </div>

                            </form>

                            <div class="cadastre text-center my-4">
                                <h5>Já tem cadastro? <a href="{{ route('account.login') }}">Clique aqui!</a></h5>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
