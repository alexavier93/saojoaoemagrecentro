@component('mail::layout')

{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
Aguardando o pagamento
@endcomponent
@endslot

Olá, <b>{{ $data['customer']['firstname'] }}</b>

Estamos aguardando o pagamento do seu pedido #{{ $data['order']['code'] }}, caso tenha realizado o pagamento, por favor aguarde o processo que pode demorar até 2 dias para se confirmar.

<h1>Pedido #{{ $data['order']['code'] }}</h1>

@component('mail::table') 
| Produto   | Preço   | Quantidade  | Sub-total  |
| :-------- | :------ | :---------- |:---------- |
@foreach ($data['order_product'] as $produto)
| {{ $produto->title }} <br> <em><small><b>Sessões</b>: {{ $produto->option }}</small></em> | R$ {{ number_format($produto->price, 2, ',', '') }} | {{ $produto->quantity }} | R$ {{ number_format($produto->subtotal, 2, ',', '') }} |
@endforeach
| <b>Método de pagamento</b> |  |  | {{ $data['metodo_pagamento'] }} |
| <b>Total</b> |  |  |  R$ {{ number_format( $data['order']['total'], 2, ',', '') }} | 
@endcomponent



@component('mail::button', ['url' => route('account.orders'), 'color' => 'blue'])
Ver Pedido
@endcomponent

<b>Dados Pessoais</b>

@component('mail::card')
{{ $data['customer']['firstname'] .' '. $data['customer']['lastname'] }}

{{ $data['customer']['email'] }}

{{ $data['customer']['cpf'] }}

{{ $data['customer']['phone'] }}
@endcomponent

<b>Endereço de faturamento</b>
@component('mail::card')
{{ $data['customer']['firstname'] .' '. $data['customer']['lastname'] }}

{{ $data['address']['logradouro'] .', '. $data['address']['numero'] }}

{{ $data['address']['bairro'] . ' - '. $data['address']['cidade'] .' - '. $data['address']['uf'] }}
@endcomponent

Qualquer dúvida, basta entrar em contato com a nossa equipe através do telefone 19 983 409 401 ou envie um e-mail para saojoaoboavista@emagrecentro.net.

WhatsApp 19 983 409 401


{{-- Footer --}}
@slot('footer')
@component('mail::footer')
    © 2021 Emagrecentro São João. Todos os direitos reservados.
@endcomponent
@endslot

@endcomponent