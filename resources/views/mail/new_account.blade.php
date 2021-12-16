@component('mail::layout')

{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => route('home')])
    Seja Bem-vindo a Emagrecentro São João
@endcomponent
@endslot


Olá, <b>{{ $customer->firstname }}</b>

Obrigado por criar uma conta em Emagrecentro São João. O seu nome de usuário é {{ $customer->email }}. Para acessar sua conta para ver pedidos, alterar sua senha e muito mais, clique no botão abaixo.

Estamos ansiosos para atende-lo(a) em breve.


@component('mail::button', ['url' => route('account.login'), 'color' => 'blue'])
    Minha Conta
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
    © 2021 Emagrecentro São João. Todos os direitos reservados.
@endcomponent
@endslot

@endcomponent

