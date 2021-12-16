@extends('layouts.app')

@section('content')

    <!-- Home -->
    <div id="home">

        <!-- Banner Section -->
        <section class="banner-section">

            <div class="banner-carousel owl-carousel owl-theme">
                @foreach ($banners as $banner)
                    @if ($banner->status == 1)
                        <a @if ($banner->link != '')href="{{ $banner->link }}"@endif><div class="slide-item" style="background-image: url('{{ asset('storage/' . $banner->image) }}');"></div></a>
                    @endif
                @endforeach
            </div>

        </section>

        <section class="servicos">

            <div class="container">

                <div class="row">

                    <div class="col-md-4">
                        <div class="item">
                            <div class="item-icon">
                                <img src="{{ asset('assets/images/icons/icon-calendar.png') }}" alt="">
                            </div>
                            <div class="item-title">
                                <h4>AGENDE AVALIAÇÃO ESTÉTICA</h4>
                                <small>totalmente gratuita</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="item">
                            <div class="item-icon">
                                <img src="{{ asset('assets/images/icons/icon-money-hand.png') }}" alt="">
                            </div>
                            <div class="item-title">
                                <h4>PARCELE SEUS TRATAMENTOS</h4>
                                <small>em até 12x no cartão</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="item">
                            <div class="item-icon">
                                <img src="{{ asset('assets/images/icons/icon-security.png') }}" alt="">
                            </div>
                            <div class="item-title">
                                <h4>AMBIENTE 100% SEGURO</h4>
                                <small>certificado de segurança</small>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section class="objetivos">

            <div class="container">

                <div class="titulo">
                    <span class="overtitulo">Qual o seu</span>
                    <h2 class="titulo_principal">Objetivo?</h2>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <a href="{{ url('tratamentos/tratamentos-corporais/emagrecimento') }}"><img class="img-fluid mx-auto d-block my-3" src="{{ asset('assets/images/01.jpg') }}" alt="Emagrecimento"></a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ url('tratamentos/tratamentos-faciais/rejuvenescimento') }}"><img class="img-fluid mx-auto d-block my-3" src="{{ asset('assets/images/02.jpg') }}" alt=""></a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ url('tratamentos/tratamentos-corporais/celulite') }}"><img class="img-fluid mx-auto d-block my-3" src="{{ asset('assets/images/03.jpg') }}" alt=""></a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ url('tratamentos/tratamentos-corporais/gordura-localizada') }}"><img class="img-fluid mx-auto d-block my-3" src="{{ asset('assets/images/04.jpg') }}" alt=""></a>
                    </div>

                </div>

            </div>


        </section>

        <section class="categorias">

            <div class="container">

                <div class="titulo">
                    <span class="overtitulo">Escolha por</span>
                    <h2 class="titulo_principal">Categoria</h2>
                </div>
                
                <div class="row">

                    <div class="col-md-4">
                        <a class="item my-3" href="{{ url('tratamentos/tratamentos-faciais') }}">
                            <img class="img-fluid mx-auto d-block" src="{{ asset('assets/images/categoria-01.jpg') }}"
                                alt="">
                            <div class="title">
                                <h2>Tratamentos Faciais</h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a class="item my-3" href="">
                            <img class="img-fluid mx-auto d-block" src="{{ asset('assets/images/categoria-02.jpg') }}"
                                alt="">
                            <div class="title">
                                <h2>Massagem</h2>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a class="item my-3" href="{{ url('tratamentos/tratamentos-corporais') }}">
                            <img class="img-fluid mx-auto d-block" src="{{ asset('assets/images/categoria-03.jpg') }}"
                                alt="">
                            <div class="title">
                                <h2>Tratamentos Corporais</h2>
                            </div>
                        </a>
                    </div>

                </div>

            </div>


        </section>

        <section class="procurados">

            <div class="container">

                <div class="titulo">
                    <span class="overtitulo">Os mais</span>
                    <h2 class="titulo_principal">Vendidos</h2>
                </div>

                <div class="row">

                    @foreach ($products as $product)
                        @foreach ($categories as $category)
                            @if ($product->category_id == $category->id)
                                @foreach ($treatments as $treatment)
                                    @if ($category->treatment_id == $treatment->id)

                                        <div class="col-md-6 col-lg-3">

                                            <div class="item">

                                                <a href="{{ route('tratamentos.product', ['treatment' => $treatment->slug, 'category' => $category->slug, 'product' => $product->slug]) }}"
                                                    class="product-image">
                                                    <div class="img">
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="">
                                                    </div>
                                                </a>

                                                <div class="product-info">
                                                    <h2 class="product-name">
                                                        <a
                                                            href="{{ route('tratamentos.product', ['treatment' => $treatment->slug, 'category' => $category->slug, 'product' => $product->slug]) }}">{{ $product->title }}</a>
                                                    </h2>
                                                    <div class="short-desc">{{ $product->short_description }}</div>
                                                </div>

                                                @if($product->available)
                                                    <form>
                                                @else 
                                                    <form action="{{ route('cart.create') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_product" value="{{ $product->id }}">
                                                    <input type="hidden" name="qty" value="1">
                                                    <input type="hidden" class="urlPrice" name="url" value="{{ route('tratamentos.getPrice') }}">
                                                @endif
                                              
                                                    

                                                    <div class="options">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="publico">
                                                                    @if ($product->female != '')
                                                                        <span class="female">
                                                                            <i></i>
                                                                            <label>Disponível para o Público
                                                                                Feminino</label>
                                                                        </span>
                                                                    @endif

                                                                    @if ($product->male != '')
                                                                        <span class="male">
                                                                            <i></i>
                                                                            <label>Disponível para o Público
                                                                                Masculino</label>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-md-end">

                                                                @if (!$product->sections->isEmpty())
                                                                    
                                                                <div class="sessoes">
                                                                    <select data-product-id="{{ $product->id }}" name="section">
                                                                        @foreach ($sections as $section)
                                                                            @foreach ($productSection as $prodSection)
                                                                                @if ($product->id == $prodSection->product_id)  
                                                                                    @if ($section->id == $prodSection->section_id)
                                                                                        <option value="{{ $prodSection->id }}">{{ $section->title }}</option>
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @else
                                                                <br>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="price-box">

                                                        @if($product->available)

                                                            <h4>Disponível para Avaliação</h4>

                                                        @else

                                                            @if($product->new_price == '')
                                                                <span class="regular-price">
                                                                    <span class="price" id="product-price-{{ $product->id }}">
                                                                        <span class="simbolo">R$</span>
                                                                        <span class="money view">{{ $product->price }}</span>
                                                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                                                    </span>
                                                                </span>
                                                            @endif
                            
                                                            @if($product->new_price != '')
                                                                <p class="old-price">
                                                                    <span class="price">
                                                                        <span class="price">
                                                                            <span class="simbolo">R$</span>
                                                                            <span class="money">{{ $product->old_price }}</span>
                                                                        </span>
                                                                    </span>
                                                                </p>
                                                                <p class="special-price">
                                                                    <span class="price" id="product-price-{{ $product->id }}">
                                                                        <span class="price">
                                                                            <span class="simbolo">R$</span>
                                                                            <span class="money view">{{ $product->new_price }}</span>
                                                                            <input type="hidden" name="price" value="{{ $product->new_price }}">
                                                                        </span>
                                                                    </span>
                                                                </p>
                                                            @endif

                                                        @endif

                                                    </div>

                                                    <div class="actions">

                                                        <a href="https://api.whatsapp.com/send?phone=55199834094018&text=Ol%C3%A1%2C%20gostaria%20de%20agendar%20uma%20avali%C3%A7%C3%A3o%20do%20tratamento%20{{ $product->title }}" target="_blank" class="avaliacao">
                                                            <small>Agendar agora avaliação ONLINE</small>
                                                            <span>Estética gratuita</span>
                                                        </a>

                                                        @if($product->available)
                                                            <button type="button" onclick='window.location.href="{{ route("contato.index") }}"'><span>ENTRE EM CONTATO</span></button>
                                                        @else
                                                            <button type="submit"><span>COMPRAR</span></button>
                                                        @endif

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach

                </div>

            </div>

        </section>


        <section class="oferta">
            <a href="https://api.whatsapp.com/send?phone=5519983409401" target="_blank"><img class="img-fluid mx-auto d-block" src="{{ asset('assets/images/banner-oferta.jpg') }}" alt=""></a>
        </section>

        <section class="blog">

            <div class="container">

                <div class="titulo">
                    <span class="overtitulo">Nosso</span>
                    <h2 class="titulo_principal">Blog</h2>
                </div>

                <div class="row">

                    <div class="blog-carousel owl-carousel owl-theme">

                        @foreach ($posts as $post)

                        <a class="item" href="{{ route('blog.posts', ['post' => $post->slug]) }}">
                            <div class="blog-image">
                                <img class="img-fluid mx-auto d-block my-3" src="{{ asset('storage/' . $post->image) }}"
                                    alt="">
                            </div>

                            <div class="blog-content">
                                <h2 class="title">{{ $post->title }}</h2>
                            </div>

                            <button type="button" class="btn btn-blog">Saiba Mais</button>
                        </a>

                        @endforeach

                    </div>

                </div>
            </div>
        </section>

    </div>
    <!-- End Home -->



@endsection
