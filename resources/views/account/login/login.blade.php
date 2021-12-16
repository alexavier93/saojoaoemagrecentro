@extends('layouts.app')

@section('title', '- Login')

@section('content')

    <div id="login">


        <div class="container">

            <div class="content">

                <div class="row">

                    <div class="col-lg-4 offset-lg-4">

                        <div class="form-login">

                            <div class="text-center mb-5">
                                <h4>JÁ POSSUI UMA CONTA?</h4>
                                <h5>Se você já possui uma conta, informe os dados de acesso.</h5>
                            </div>

                            @include('flash::message')
                            
                            <form action="{{ route('account.doLogin') }}" method="post">

                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Senha</label>
                                    <input type="password" class="form-control" name="password">
                                </div>

                                <div class="mb-3">
                                    <a href="" class="forgot-password">Esqueceu sua senha?</a>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Entrar</button>
                                </div>

                            </form>

                            <div class="cadastre text-center my-5">
                                <h5>Ainda não é cadastrado? <a href="{{ route('account.create') }}">Clique aqui!</a></h5>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
