@extends('layouts.app')

@section('title', '- Contato')

@section('content')

    <div id="contato">

        <div class="container">

            <div class="content">

                <div class="row">

                    <div class="col-xl-6 col-md-12 col-sm-12 mb-4 form">

                        <h3>Inicie um atendimento agora mesmo</h3>
    
                        @include('flash::message')
    
                        <form action="{{ route('contato.enviaEmail') }}" method="POST" class="my-4">

                            @csrf

                            <div class="form-group my-3">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nome" required>
                            </div>

                
                            <div class="form-group my-3">
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail" required>
                            </div>

                
                            <div class="form-group my-3">
                                <input type="text" name="phone" class="form-control telefone" value="{{ old('phone') }}" placeholder="Telefone" required>
                            </div>

                            <div class="form-group my-3">
                                <textarea name="description" class="form-control" rows="5" placeholder="Mensagem" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="text-left">
                                <button type="submit" class="btn btn-primary text-right">Enviar Mensagem</button>
                            </div>

                        </form>
    
                    </div>
    
                    <div class="col-xl-6 col-md-12 col-sm-12 map">

                        <h3>Localização</h3>

                        <iframe class="mt-3" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3700.024955138956!2d-46.796510785051176!3d-21.972005285495076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c9cb7070302137%3A0xf1e962b4f6d2ff60!2sR.%20Floriano%20Peixoto%2C%20342%20-%20Centro%2C%20S%C3%A3o%20Jo%C3%A3o%20da%20Boa%20Vista%20-%20SP%2C%2013870-060!5e0!3m2!1spt-BR!2sbr!4v1625775768970!5m2!1spt-BR!2sbr" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                        <div class="infos">
                            <div class="icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="info">(19) 3635-2128</div>
                        </div>

                        <div class="infos">
                            <div class="icon"><i class="far fa-envelope"></i></div>
                            <div class="info">saojoaoboavista@emagrecentro.net</div>
                        </div>

                        <div class="infos">
                            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info">R. Floriano Peixoto, 342 - Centro, São João da Boa Vista - SP, 13870-060</div>
                        </div>
                    
                    </div>
    
                </div>

            </div>

        </div>

    </div>

@endsection
