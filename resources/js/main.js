;(function ($) {
    'use strict'

    /* ===================================
        Side Menu
    ====================================== */
    if ($('#sidemenu_toggle').length) {
        $('#sidemenu_toggle').on('click', function () {
            $('.pushwrap').toggleClass('active')
            $('.side-menu').addClass('side-menu-active'),
                $('#close_side_menu').fadeIn(700)
        }),
            $('#close_side_menu').on('click', function () {
                $('.side-menu').removeClass('side-menu-active'),
                    $(this).fadeOut(200),
                    $('.pushwrap').removeClass('active')
            }),
            $('.side-nav .navbar-nav').on('click', function () {
                $('.side-menu').removeClass('side-menu-active'),
                    $('#close_side_menu').fadeOut(200),
                    $('.pushwrap').removeClass('active')
            }),
            $('#btn_sideNavClose').on('click', function () {
                $('.side-menu').removeClass('side-menu-active'),
                    $('#close_side_menu').fadeOut(200),
                    $('.pushwrap').removeClass('active')
            })
    }

    // Navbar Scroll Function
    var $window = $(window)
    $window.scroll(function () {
        var $scroll = $window.scrollTop()
        var $navbar = $('.header-nav')
        if (!$navbar.hasClass('sticky-bottom')) {
            if ($scroll > 250) {
                $navbar.addClass('fixed-menu')
            } else {
                $navbar.removeClass('fixed-menu')
            }
        }
    })

    // Função para habilitar a troca de senha no painel do cliente
    $('.change_password').on('click', function () {
        $('.password').attr('type', 'password')
        $('.password').attr('name', 'password')
        $('.password_confirmation').attr('type', 'password')
        $('.password_confirmation').attr('name', 'password_confirmation')
        $('.passwordCustomer').show()
    })

    // Verificando se o e-mail está cadastrado
    $('.verify_email').on('focusout', function (e) {
        e.preventDefault()

        var url = $(this).attr('data-url')
        var email = $(this).val()

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {
                email: email
            },
            dataType: 'json',
            success: function (response) {
                if (response.exists == true) {
                    $('#formLogin').attr('action', response.action)
                    $('.password').attr('type', 'password')
                    $('.password').attr('name', 'password')
                    $('.passwordLogin').show()
                    $('.btnLogin').removeClass('disabled')
                } else {
                    $('#formLogin').attr('action', response.action)
                    $('.btnLogin').removeClass('disabled')
                }
            }
        })
    })

    $('.sessoes select').on('change', function (e) {
        e.preventDefault()

        var url = $('.urlPrice').val()
        var productId = $(this).data('product-id')
        var id = $(this).val()
        var regularPrice = $('#product-price-' + productId).find(
            'input[name=price]'
        )
        var regularPriceView = $('#product-price-' + productId).find('.view')
        var specialPrice = $('#product-price-' + productId).find(
            '.special-price .price input[name=price]'
        )
        var specialPriceView = $('#product-price-' + productId).find(
            '.special-price .price .money.view'
        )

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {
                product_id: productId,
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if (response.exists == true) {
                    regularPrice.val(response.price)
                    regularPriceView.html(response.priceView)
                    specialPrice.val(response.price)
                    specialPriceView.html(response.priceView)
                }
            }
        })
    })

    $('#cepConsulta').blur(function () {
        var cep = $(this).val()
        var url = $(this).attr('data-url')
        consultaCep(cep, url)
    })

    function consultaCep (cep, url) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: {
                cep: cep
            },
            dataType: 'json',
            success: function (response) {
                $('input[name=logradouro]').val(response.logradouro)
                $('input[name=bairro]').val(response.bairro)
                $('input[name=cidade]').val(response.cidade)
                $('input[name=uf]').val(response.uf)
                $('input[name=numero]').focus()
            }
        })

        return false
    }

    // Form de Contato
    $('#form-newsletter').submit(function (e) {
        e.preventDefault()

        var dados = $(this).serialize()

        var url = this.url.value

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: url,
            data: dados,
            dataType: 'json',
            success: function (response) {
                $('.form-newsletter .alert').html(response.success)
                $('.form-newsletter .alert')
                    .addClass('alert-success')
                    .fadeIn('slow')

                setTimeout(function () {
                    $('#form-newsletter').each(function () {
                        this.reset()
                    })
                }, 500)
            },
            error: function (response) {
                $('.form-newsletter .alert').html(response.erro)
                $('.form-newsletter .alert')
                    .addClass('alert-danger')
                    .fadeOut('slow')
            }
        })

        return false
    })

    // Banner Carousel / Owl Carousel
    $('.banner-carousel').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        loop: true,
        margin: 0,
        nav: true,
        dots: false,
        smartSpeed: 500,
        autoHeight: true,
        autoplay: true,
        autoplayTimeout: 5000,
        navText: [
            '<span class="fa fa-angle-left">',
            '<span class="fa fa-angle-right">'
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1024: {
                items: 1
            }
        }
    })

    // owlCarousel Blog
    $('.blog-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3,

                loop: false
            }
        }
    })

    // Mask
    $('.cep').mask('00000-000')
    $('.number_cpf').mask('000.000.000-00', { reverse: true })
    $('.data').mask('00/00/0000')
    $('.money').mask('#.##0,00', { reverse: true })
    $('.creditcard').mask('0000 0000 0000 0000')
    $('.number').mask('0#')

    $('.telefone')
        .focusout(function () {
            var phone, element
            element = $(this)
            element.unmask()
            phone = element.val().replace(/\D/g, '')
            if (phone.length > 10) {
                element.mask('(99) 99999-9999')
            } else {
                element.mask('(99) 9999-99999')
            }
        })
        .trigger('focusout')
})(jQuery, window, document)
