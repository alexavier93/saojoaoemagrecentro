@extends('layouts.app')

@section('title', '- Sobre Nós')

@section('content')

    <div id="categories">

        <div class="header">

            <div class="container">
                <h1>{{ $category->title }}</h1>
                <div class="category-description">
                    {!! $category->description !!}
                </div>

            </div>

        </div>

        <div class="container">

            <div class="content">

                <div class="produtos">

                    <div class="row">

                        @foreach ($products as $product)

                            <div class="col-md-6 col-lg-3">

                                <div class="item">

                                    <a href="{{ route('tratamentos.product', ['treatment' => $treatment->slug, 'category' => $category->slug, 'product' => $product->slug]) }}" class="product-image">
                                        <div class="img">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="">
                                        </div>
                                    </a>

                                    <div class="product-info">
                                        <h2 class="product-name">
                                            <a href="{{ route('tratamentos.product', ['treatment' => $treatment->slug, 'category' => $category->slug, 'product' => $product->slug]) }}">{{ $product->title }}</a>
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
                                                                <label>Disponível para o Público Feminino</label>
                                                            </span>
                                                        @endif

                                                        @if ($product->male != '')
                                                            <span class="male">
                                                                <i></i>
                                                                <label>Disponível para o Público Masculino</label>
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

                        @endforeach

                        {{ $products->links() }}

                    </div>

                </div>



            </div>

        </div>

    </div>

@endsection
