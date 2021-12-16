@extends('layouts.app')
@extends('account.nav')

@section('title', '- Pedidos')

@section('content')

    <div id="orders_dash">

        <div class="container">

            <div class="content">

                <div class="row">

                    <div class="col-lg-3">
                    @section('nav_content')
                    </div>

                    <div class="col-lg-9">

                        <h1 class="mb-3 display-6">Pedidos</h1>

                        <div class="accordion accordion-flush" id="accordionFlushExample">

                            @foreach ($orders as $order)

                                <div class="accordion-item">

                                    <h2 class="accordion-header" id="{{ $order->code }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $order->code }}" aria-expanded="false"
                                            aria-controls="collapse-{{ $order->code }}">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <b>Número do pedido:</b> {{ $order->code }}
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Data da compra:</b> 20/03/2021
                                                </div>
                                                <div class="col-md-4">
                                                    <b>Valor total:</b> R$ {{ number_format($order->total, 2, ',', '') }}
                                                </div>
                                            </div>

                                        </button>
                                    </h2>

                                    <div id="collapse-{{ $order->code }}" class="accordion-collapse collapse" aria-labelledby="{{ $order->code }}" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Produtos</th>
                                                        <th scope="col">Preço</th>
                                                        <th scope="col">Quantidade</th>
                                                        <th scope="col">Sub-total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order_product as $item)
                                                        @if ($order->id == $item->order_id)
                                                            <tr>
                                                                <td>
                                                                    <h6 class="product-name">{{ $item->title }}</h6>
                                                                    <em><small><b>Sessões</b>:
                                                                            {{ $item->option }}</small></em>
                                                                </td>
                                                                <td>R$ {{ number_format($item->price, 2, ',', '') }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>R$ {{ number_format($item->subtotal, 2, ',', '') }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                                <tfoot>

                                                    <tr class="total">
                                                        <td colspan="3"></td>
                                                        <td>
                                                            <b>Total</b>: R$ {{ number_format($order->total, 2, ',', '') }}
                                                        </td>

                                                    </tr>

                                                </tfoot>
                                            </table>

                                            <div class="product-details d-none">

                                                <a href="#" class="btn btn-secondary btn-sm">Cancelar compra</a>

                                                <a href="#" class="btn btn-secondary btn-sm">Nota fiscal</a>

                                                <a href="#" class="btn btn-secondary btn-sm">Avaliar produto</a>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
