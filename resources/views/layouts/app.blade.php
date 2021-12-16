<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('/assets/images/favicon.ico') }} ">

    <title>Emagrecentro São João @yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Header -->
    <header id="header">

        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 text-center text-md-start">
                        <p>bem-vindos ao emagrecentro são joão</p>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 text-center text-md-end">
                        <ul class="nav-top">
                            @if (session()->get('customer'))<li><a href="{{ route('account.register') }}">Bem-vindo {{ $CUSTOMER_SESSION->firstname }}</a></li>@endif
                            <li><a href="{{ route('contato.index') }}">Contato</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-nav">

            <div class="container">

                <div class="wrap">

                    <div class="logo">
                        @if (route('home'))
                            <a href="{{ route('home') }}" class="logo-main"><img
                                    src="{{ asset('assets/images/logo-emagrecentro-sao-joao.png') }}" alt=""></a>
                        @else
                            <a href="{{ route('home') }}" class="logo-main"><img class="img-fluid"
                                    src="{{ asset('assets/images/logo-emagrecentro-sao-joao.png') }}" alt=""></a>
                        @endif
                        <a href="{{ route('home') }}" class="logo-fix"><img class="img-fluid"
                                src="{{ asset('assets/images/logo-emagrecentro-sao-joao.png') }}" alt=""></a>
                    </div>

                    <div class="menu">

                        <nav class="nav">
                            <ul>
                                <li class="nav-item">
                                    <a class="nav-link @if (\Route::current()->getName() == 'home') active @endif" href="{{ route('home') }}">Home</a>
                                </li>

                                @foreach ($menuTreatments as $treatment)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="{{ route('tratamentos.treatment', ['treatment' => $treatment->slug]) }}">{{ $treatment->title }}</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($menuCategories as $category)
                                        @if ($treatment->id == $category->treatment_id)
                                            <li><a class="dropdown-item" href="{{ route('tratamentos.category', ['treatment' => $treatment->slug, 'category' => $category->slug]) }}">{{ $category->title }}</a></li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach

                                <li class="nav-item">
                                    <a class="nav-link @if (\Route::current()->getName() == 'blog.index') active @endif" href="{{ route('blog.index') }}">Blog</a>
                                </li>

                            </ul>
                        </nav>

                    </div>

                    <div class="loja">

                        <ul class="links">
                            @if (session()->get('customer'))
                                <li><a href="{{ route('account.logout') }}">Sair</a></li>
                            @else
                                <li><a href="{{ route('account.login') }}" class="login">Login</a></li>
                            @endif
                            <li><a href="{{ route('cart.index') }}">Carrinho</a></li>
                            <li>
                                <a href="{{ route('cart.index') }}" class="bag">
                                    @if (session()->has('cart'))
                                        {{ $cartSum }}
                                    @else
                                        0
                                    @endif
                                </a>
                                
                            </li>
                        </ul>

                    </div>

                    <a href="javascript:void(0)" class="sidemenu_btn d-lg-none" id="sidemenu_toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>

                </div>

            </div>



        </div>

        <!--Side Nav-->
        <div class="side-menu hidden">
            <div class="inner-wrapper">
                <span class="btn-close" id="btn_sideNavClose"><i></i></span>
                <nav class="side-nav w-100">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        @foreach ($menuTreatments as $treatment)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tratamentos.treatment', ['treatment' => $treatment->slug]) }}">{{ $treatment->title }}</a>
                        </li>
                        @endforeach

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                        </li>
                        
                        <li class="nav-item">
                            @if (session()->get('customer'))
                                <a class="nav-link" href="{{ route('account.logout') }}">Sair</a>
                            @else
                                <a class="nav-link" href="{{ route('account.login') }}" class="login">Login</a>
                            @endif
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link">
                                <i class="fas fa-shopping-cart"></i>
                                @if (session()->has('cart'))
                                    {{ $cartSum }}
                                @else
                                    0
                                @endif
                            </a>
                        </li>

                        

                        
                    </ul>
                </nav>

            </div>

        </div>

        <a id="close_side_menu" href="javascript:void(0);"></a>

    </header>
    <!-- Header -->

    <main role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer">

        <div class="footer-top">

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-md-12 logo text-center">
                        <div class="img">
                            <img class="mx-auto center-block" src="{{ asset('assets/images/logo-emagrecentro-sao-joao-branco.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-4 info">

                        <h4>Entre em contato</h4>

                        <ul>
                            <li>
                                <p>Tel: <span>(19) 3635-2128</span></p>
                            </li>
                            <li>
                                <p>E-mail: <span>saojoaoboavista@emagrecentro.net</span></p>
                            </li>
                            <li>
                                <p>Endereço: <span>Rua Floriano Peixoto, 342 - São João da Boa Vista / SP</span></p>
                            </li>
                        </ul>

                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-4 newsletter text-md-center">

                        <h4>Fique por dentro das promoções</h4>
                        <p>Cadastre-se e recaba nossas novidades e promoções exclusivas</p>

                        <div class="msg-sucesso"></div>
                        <div class="msg-erro"></div>

                        <div class="form-newsletter">

                            <div class="alert" style="display: none;"></div>

                            <form id="form-newsletter" method="post" class="row g-3">

                                @csrf

                                <input type="hidden" name="url" value="{{ route('home.insertNews') }}">

                                <div class="col-xs-12 col-md-9">
                                    <input type="text" class="form-control" name="email" placeholder="Seu e-mail" required>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <button type="submit" class="btn btn-primary mb-3">Enviar</button>
                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-4 instagram">

                        <h4>Horário de Atendimento</h4>

                        <p>Seg - Sex: 8h às 18h </p>
                        <p>Sáb: 8h às 14h</p>

                    </div>

                    <hr class="my-3">

                    <div class="col-md-6 col-lg-5">
                        <div class="text-center text-md-start text-lg-start my-3">
                            <img class="w-50" src="{{ asset('assets/images/credit-cards.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-7">

                        <ul class="social list-inline text-center text-md-end text-lg-end my-3">
                            <li>
                                <a href="https://www.facebook.com/emagrecentrosaojoao" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>

                            <li>
                                <a href="https://www.instagram.com/emagrecentrosaojoao" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="bottom-footer">

            <div class="container">

                <div class="clearfix">

                    <p class="col-sm-12 col-md-6 col-lg-6 copy">© {{ now()->year }} Emagrecentro São João - Todos os
                        direitos reservados</p>

                    <p class="col-sm-12 col-md-6 col-lg-6 dev">
                        Desenvolvido por <a href="https://www.agenciaaffinity.com.br"><img width="90"
                                src="https://agenciaaffinity.com.br/assinatura/affinity-logo-branco.svg"></a>
                    </p>

                </div>

            </div>

        </div>

    </footer>
    <!-- End Footer -->

    <a href="https://api.whatsapp.com/send?phone=5519983409401" class="float" target="_blank"><i class="fab fa-whatsapp"></i></a>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script src="{{ asset('/assets/js/app.js') }} "></script>

</body>

</html>
