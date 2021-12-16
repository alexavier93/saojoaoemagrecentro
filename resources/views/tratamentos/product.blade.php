@extends('layouts.app')

@section('title', '- Tratamento Info')

@section('content')

    <div id="tratamento-info">

        <div class="header" style="background: url('{{ asset('storage/'.$product->banner) }}')">

            <div class="container">

                <div class="product-details">

                    <form action="{{ route('cart.create') }}" method="POST">

                        @csrf
                        <input type="hidden" name="id_product" value="{{ $product->id }}">
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" class="urlPrice" name="url" value="{{ route('tratamentos.getPrice') }}">

                        <div class="product-shop">

                            @if($product->discount != '')
                                <div class="discount-product">{{ $product->discount }}%<span> OFF</span></div>
                            @endif

                            <div class="product-name">
                                <h1>{{ $product->title }}</h1>
                            </div>

                            <div class="short-description">
                                <div class="std">{{ $product->short_description }}</div>
                            </div>

                            @if (!$product->sections->isEmpty())
                            <div class="product-options">
                                <div class="sessoes">
                                    <select data-product-id="{{ $product->id }}" name="section">
                                        @foreach ($sections as $section)
                                            @foreach ($productSection as $prodSection)
                                                @if ($section->id == $prodSection->section_id)
                                                    <option value="{{ $prodSection->id }}">{{ $section->title }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="price-box">

                                @if($product->available)
                                    <h5>Disponível para Avaliação</h5>
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

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="container">

            <div class="content">

                <div class="product-info">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details" aria-selected="true">Detalhes</button>
                        </li>
                        <!--<li class="nav-item" role="presentation">
                            <button class="nav-link" id="howtouse-tab" data-bs-toggle="tab" data-bs-target="#howtouse"
                                type="button" role="tab" aria-controls="howtouse" aria-selected="false">Indicações de
                                uso</button>
                        </li>-->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="text">

                                {!! $product->description !!}
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="howtouse" role="tabpanel" aria-labelledby="howtouse-tab">

                            <div class="row">

                                @foreach ($indications as $indication)
                                @foreach ($productIndication as $prodIndication)
                                @if ($indication->id == $prodIndication->indication_id)

                                <div class="col-md-4">
                                    <h5>{{ $indication->title }}</h5>
                                    <p>{!! $prodIndication->description !!}</p>
                                </div>

                                @endif
                                @endforeach
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
