@extends('layouts.app')

@section('title', '- Pedido Finalizado')

@section('content')

    <div id="order-confirmation">

        <div class="container">

            <div class="content">

                <div class="row">

                    <div class="col-md-12 text-center mb-4">
                        <h2>Pedido finalizado</h2>
                        <h3>SEU PEDIDO FOI REALIZADO COM SUCESSO</h3>
                        <p>Seu pedido é: <b class="h4">{{ $order->code }}</b></p>


                        <div class="info-payment">

                            @isset($paymentCreditCard)
                            <p>Forma de Pagamento: <br>Cartão de Crédito</p>
                            <p>Valor: {{ $paymentCreditCard->installments }}x R$ {{ number_format($paymentCreditCard->installment_amount, 2, ',', '') }}</p>

                            @endisset

                            @isset($paymentBoleto)

                            <p>Forma de Pagamento: Boleto</p>
                            <p>Valor: R$ {{ number_format($paymentBoleto->total_paid_amount, 2, ',', '') }}</p>
                            <p><b><a href="{{ $paymentBoleto->external_resource_url }}" target="_blank" download>Clique aqui para baixar o PDF</a></b></p>

                            @endisset

                            @isset($paymentPix)

                                <div class="row">
                                    <div class="col-md-6 offset-md-3">
                                        <p>Forma de Pagamento: Pix</p>
                                        <p>Valor: R$ {{ number_format($paymentPix->total_paid_amount, 2, ',', '') }}</p>
                                        <p>
                                            Para fazer o pagamento basta escanear o QR Code, o código é válido por apenas por 24h. Para fazer o download do QR Code é só clicar na imagem.<br>
                                            <a href="data:image/jpeg;base64,{{ $paymentPix->qr_code_base64 }}" download="Pix_Pedido_{{ $order->code }}"><img style="width: 200px" src="data:image/jpeg;base64,{{ $paymentPix->qr_code_base64 }}" /></a>
                                        </p>
                                    </div>
                                </div>
                                    
                            @endisset

                        </div>


                        <p>Você receberá uma cópia com detalhes do seu pedido por e-mail e também pode acompanhar pelo o painel do cliente, <a href="{{ route('account.orders') }}">clicando aqui.</a></p>
                    </div>

                    <div class="col-md-12">
                        @include('flash::message')
                    </div>

                    <div class="col-md-5 col-sm-12">
    
                        <div class="card">

                            <div class="card-header">Dados Pessoais</div>

                            <div class="card-body">
    
                                <p class="text-muted">
                                    <b>{{ $customer->firstname.' '.$customer->lastname }}</b><br>
                                    <span class="cpf">{{ $customer->email }}</span><br>
                                    {{ $customer->phone }}
                                </p>

                            </div>
    
                        </div>

                        <div class="card mt-3">

                            <div class="card-header">Endereço de Cobrança</div>

                            <div class="card-body">
                                
                                <p class="text-muted">{{ $customer->firstname.' '.$customer->lastname }}</p>

                                <p class="text-muted">{{ $address->logradouro.', '.$address->numero }} @if ($address->complemento) {{ '- '.$address->complemento }} @endif<br>

                                {{ $address->bairro.' - '. $address->cidade .' - '. $address->uf }}</p>

                            </div>

                        </div>
    
    
                    </div>
                
                    <div class="col-md-7 col-sm-12 mt-4 mt-md-0">

                        <div class="card">
                            
                            <div class="card-header">Resumo Do Pedido - <small class="text-muted">{{ $order->created_at->format('d/m/Y') }}</small></div>

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
    

            </div>


        </div>

    </div>

@endsection
