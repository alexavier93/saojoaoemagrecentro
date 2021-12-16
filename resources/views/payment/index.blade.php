@extends('layouts.app')

@section('title', '- Pagamento')

@section('content')

    <div id="payment">

        <div class="container">

            <div class="payment">

                <div class="row">

                    <div class="col-md-12">
                        @include('flash::message')
                    </div>

                    <div class="col-md-7 col-sm-12">

                        <div class="card">



                        </div>

                        <button type="submit" form="formFrete" class="btn btn-primary float-right mt-3">Fazer
                            Pagamento</button>

                    </div>

                    <div class="col-md-5 col-sm-12 mt-4 mt-md-0">

                        <div class="card">

                            <div class="card-header">Resumo Do Pedido</div>

                            <div class="card-body">

                                <div class="d-flex justify-content-between my-3">
                                    <div>
                                        <h6 class="my-0">Produto Teste</h6>
                                        <small class="text-muted">Lorem Ipsum dolor</small>
                                    </div>
                                    <span class="text-muted">R$ 100,00</span>
                                </div>

                                <hr class="my-3">

                                <div class="d-flex justify-content-between">
                                    <span>Total</span>
                                    <strong>R$ <span class="">100,00</span></strong>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>


        </div>

    </div>

@endsection
