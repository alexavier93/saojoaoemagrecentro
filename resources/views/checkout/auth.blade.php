@extends('layouts.app')

@section('title', '- Dados do Comprador')

@section('content')

    <div id="checkout">

        <div class="container">

            <div class="customer">

                <div class="row">

                    <div class="col-md-12 col-lg-6 offset-lg-3">
    
                        <div class="card">
    
                            <div class="card-body">

                                @include('flash::message')
    
                                <h5 class="card-title text-center mb-3">Em apenas um passo, conclua sua compra em nossa loja.<br>É RÁPIDO E SEGURO.</h5>
    
                                <form id="formLogin" method="POST">
                                    
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <input type="email" class="form-control verify_email" name="email" data-url="{{ route('checkout.checkEmail') }}" placeholder="Digite seu e-mail">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 passwordLogin">
                                        <input type="hidden" class="form-control password" name="" placeholder="Insira sua senha">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                           
                                    <button type="submit" class="btn btn-primary btnLogin disabled">Continuar</button>
    
                                </form>
    
                            </div>
    
                        </div>
    
                    </div>
    
     
                </div>
    

            </div>


        </div>

    </div>

@endsection
