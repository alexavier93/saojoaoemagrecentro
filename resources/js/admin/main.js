(function ($) {
    "use strict";


    $(document).on('click', '.delete', function () {
        var id = $(this).attr('data-id');
        $('#id').val(id);
    });

    // Jquery Mask
    $('.cpf').mask('000.000.000-00', { reverse: true });
    $('.money').mask("#.##0,00", { reverse: true });
    $('.mes_ano').mask('00/0000');
    $('.numero').mask('0#');

    $('.summernote').summernote({
        lang: 'pt-BR',
        height: 200,
        fontNames: ['Noto Sans JP','Signika','Open Sans','Arial'],
        fontNamesIgnoreCheck: ['Nunito','Segoe UI'],
        fontSizeUnits: ['px', 'pt'],
        styleTags: [
            'p',
                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
        toolbar: [
            ['style'],
            ['font', ['bold', 'underline', 'clear', 'font']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table'],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });


    $('.select').select2({
        placeholder: "Selecione uma opção",
    });


})(jQuery, window, document);