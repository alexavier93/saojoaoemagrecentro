@extends('admin.layouts.app')

@section('title', '- Pedidos')

@section('content')

    <!-- Page Heading -->
    <div class="page-header-content py-3">

        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Pedido #{{ $order->code }}</h1>
        </div>

        <ol class="breadcrumb mb-0 mt-4">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pedidos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pedido #{{ $order->code }}</li>
        </ol>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-sm-12 col-lg-4 col-xl-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <span class="m-0 font-weight-bold text-primary">Detalhe do Cliente</span>
                </div>
                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fas fa-user"></i>
                            {{ $customer->firstname . ' ' . $customer->lastname }}
                        </li>
                        <li class="list-group-item"><i class="fas fa-id-card"></i> <span
                                class="cpf">{{ $customer->cpf }}</span></li>
                        <li class="list-group-item"><i class="fas fa-phone-alt"></i> {{ $customer->phone }}</li>
                        <li class="list-group-item"><i class="fas fa-envelope"></i> {{ $customer->email }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Column -->
        <div class="col-sm-12 col-lg-4 col-xl-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <span class="m-0 font-weight-bold text-primary">Endereço</span>
                </div>
                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fas fa-map-marker-alt"></i>
                            {{ $customer->firstname . ' ' . $customer->lastname }}
                        </li>
                        <li class="list-group-item">
                            <p class="text-muted">{{ $address->logradouro . ', ' . $address->numero }}
                                @if ($address->complemento)
                                    {{ '- ' . $address->complemento }} @endif<br>
                                {{ $address->bairro . ' - ' . $address->cidade . ' - ' . $address->uf }}
                            </p>
                        </li>
                    </ul>


                </div>
            </div>
        </div>

        <!-- Content Column -->
        <div class="col-sm-12 col-lg-4 col-xl-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <span class="m-0 font-weight-bold text-primary">Detalhe do Pedido</span>
                </div>
                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="fas fa-calendar"></i>
                            {{ $order->created_at->format('d/m/Y') }}
                        </li>
                        <li class="list-group-item"><i class="fas fa-credit-card"></i> Método do pagamento</li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- Content Column -->
        <div class="col-sm-12 col-lg-12 col-xl-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <span class="m-0 font-weight-bold text-primary">Resumo Do Pedido</span>
                </div>
                <div class="card-body">

                    <table class="table">
                        <thead class="table-light">
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

                            @isset($order->discount)
                                <tr class="total">
                                    <td colspan="3"></td>
                                    <td>
                                        <b>Desconto</b>: R$ {{ number_format($order->discount, 2, ',', '') }}
                                    </td>
                                </tr>
                            @endisset

                            <tr class="total">
                                <td colspan="3"></td>
                                <td>
                                    <b>Total</b>: R$ {{ number_format($order->total, 2, ',', '') }}
                                </td>
                            </tr>

                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="py-3 m-0">Tem certeza que deseja excluir este registro?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    <form action="{{ route('admin.orders.delete') }}" method="post" class="float-right">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $order->id }}">
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
