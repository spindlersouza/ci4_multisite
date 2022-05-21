$(document).ready(function () {
    //ANTIGAS
    $('.bg-cover img, .bg-contain img').each(function () {

        var src = $(this).attr('src');

        $(this).hide();
        $(this).parent().css({'background-image': 'url(' + src + ')'});
    });
    $('.input-upper').on('focusout keyup', function () {
        var dado = $(this).val();
        dado = dado.toUpperCase();
        $(this).val(dado);
    });
    $('[data-toggle="tooltip"]').tooltip({
        delay: {show: 200, hide: 200}
    });
    $('.imagem-interativa img').click(function (e) {
        var element = $(this);
        var parent = $(this).parent('figure');
        var posX = parent.offset().left;
        var posY = parent.offset().top;
        var posLeft = e.pageX - posX;
        var posTop = e.pageY - posY;
        var percentX = posLeft / element.width() * 100;
        var percentY = posTop / element.height() * 100;
        $('.pontos').append('<span class="ponto" style="left: ' + percentX + '%; top: ' + percentY + '%;"></span>');
        $('[name="pontos"]').html($('.pontos').html());
    });
    $('.chosen-select').chosen();
    $('[data-video]').click(function () {
        var dado = $(this).attr('data-video');
        $('.area-video').html('<iframe src="' + dado + '" frameborder="0" allowfullscreen class="video-embed"></iframe>');
    });
    $('.btn-preview').click(function () {
        $.ajax({
            type: "POST",
            url: urlC + 'session_ajax',
            data: $('.form-session').serialize(),
            success: function (data) {

            }
        });
    });
    $('.datatable').each(function () {
        $(this).on('page.dt', function () {
            setTimeout(function () {
                $('[data-toggle="confirmation"]').confirmation({
                    title: 'Tem certeza?',
                    singleton: true,
                    popout: true,
                    btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
                    btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
                    btnOkClass: 'btn-primary',
                    btnCancelClass: 'btn-danger',
                    placement: 'left',
                    onConfirm: function () {
                        $(this).closest('form').submit();
                    }
                });
                $('.btn-file-gallery :file').filestyle({
                    buttonText: ''
                });
                $('.btn-file-lg :file').filestyle({
                    buttonText: ' Arquivo...'
                });
                $('.btn-file-sm :file').filestyle({
                    buttonText: '&nbsp;Arquivo...',
                    size: 'sm'
                });
                $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
                    console.log(numFiles);
                    console.log(label);
                });
            }, 500);
        }).DataTable({
            ordering: false,
            'pageLength': (typeof $(this).data('rows') !== 'undefined') ? ($(this).data('rows')) : (10),
            'sDom': '<"col-xs-12"f><"col-xs-12"p>t<"col-xs-12"l><"col-xs-12"i><"col-xs-12"p>'
        });
    });
    $('.datatable-ordering').each(function () {
        $(this).on('page.dt', function () {
            setTimeout(function () {
                $('[data-toggle="confirmation"]').confirmation({
                    title: 'Tem certeza?',
                    singleton: true,
                    popout: true,
                    btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
                    btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
                    btnOkClass: 'btn-primary',
                    btnCancelClass: 'btn-danger',
                    placement: 'left',
                    onConfirm: function () {
                        $(this).closest('form').submit();
                    }
                });

                $('.btn-file-gallery :file').filestyle({
                    buttonText: ''
                });

                $('.btn-file-lg :file').filestyle({
                    buttonText: ' Arquivo...'
                });

                $('.btn-file-sm :file').filestyle({
                    buttonText: '&nbsp;Arquivo...',
                    size: 'sm'
                });

                $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
                    console.log(numFiles);
                    console.log(label);
                });
            }, 500);
        }).DataTable({
            'sDom': '<"col-xs-12"f><"col-xs-12"p>t<"col-xs-12"l><"col-xs-12"i><"col-xs-12"p>'
        });
    });
    $('span[data-active]').each(function () {
        var dado = $(this).attr('data-active');
        $('li[data-active="' + dado + '"]').addClass('active');
    });
    $('.datatable-reorder').each(function () {
        $(this).on('page.dt', function () {
            setTimeout(function () {
                $('[data-toggle="confirmation"]').confirmation({
                    title: 'Tem certeza?',
                    singleton: true,
                    popout: true,
                    btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
                    btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
                    btnOkClass: 'btn-primary',
                    btnCancelClass: 'btn-danger',
                    placement: 'left',
                    onConfirm: function () {
                        $(this).closest('form').submit();
                    }
                });

                $('.btn-file-gallery :file').filestyle({
                    buttonText: ''
                });

                $('.btn-file-lg :file').filestyle({
                    buttonText: ' Arquivo...'
                });

                $('.btn-file-sm :file').filestyle({
                    buttonText: '&nbsp;Arquivo...',
                    size: 'sm'
                });

                $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
                    console.log(numFiles);
                    console.log(label);
                });
            }, 500);
        }).DataTable({
            rowReorder: true,
            'sDom': '<"col-xs-12"f><"col-xs-12"p>t<"col-xs-12"l><"col-xs-12"i><"col-xs-12"p>',
            'order': [[0, 'desc']],
            'pageLength': (typeof $(this).data('rows') !== 'undefined') ? ($(this).data('rows')) : (10),
            columnDefs: [
                {orderable: true, className: 'reorder', targets: 0},
                {orderable: false, targets: '_all'}
            ]
        });
    });
    $('.reorder').click(function (e) {
        e.preventDefault();
    });
    $('.btn-reorder').click(function () {
        var element = $(this);
        var this_html = element.html();
        var table = element.attr('data-table');
        var array_id = [];
        var array_ordem = [];
        var count = 0;
        element.html('Salvando...').removeClass('btn-warning').addClass('btn-default').attr('disabled', 'disabled');
        $('.datatable-reorder tr td[data-reorder-id]').each(function () {
            array_id[count] = $(this).attr('data-reorder-id');
            array_ordem[count] = $(this).html();
            count++;
        });
        $.ajax({
            type: "POST",
            url: urlC + 'reorder_ajax',
            data: {
                table: table,
                array_id: array_id,
                array_ordem: array_ordem
            },
            success: function (data) {
                setTimeout(function () {
                    element.html(this_html).removeClass('btn-default').addClass('btn-warning').removeAttr('disabled');
                }, 2000);
            }
        });
    });
    $('[data-toggle="confirmation"]').confirmation({
        title: 'Tem certeza?',
        singleton: true,
        popout: true,
        btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
        btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
        btnOkClass: 'btn-primary',
        btnCancelClass: 'btn-danger',
        placement: 'left',
        onConfirm: function () {
            $(this).closest('form').submit();
        }
    });
    $('.btn-file-gallery :file').filestyle({
        buttonText: ''
    });
    $('.btn-file-lg :file').filestyle({
        buttonText: ' Arquivo...'
    });
    $('.btn-file-sm :file').filestyle({
        buttonText: '&nbsp;Arquivo...',
        size: 'sm'
    });
    $('.btn-files :file').filestyle({
        buttonText: '&nbsp;Arquivos...',
        size: 'sm'
    });
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        console.log(numFiles);
        console.log(label);
    });
    $('[role="iconpicker"]').iconpicker({
        align: 'center',
        cols: 5,
        rows: 5,
        labelHeader: '&nbsp;Selecione um ícone!&nbsp;',
        placement: 'bottom',
        hideOnSelect: true,
        search: false,
        iconset: 'fontawesome',
        selectedClass: 'btn-success'
    }).on('change', function (e) {
        $(this).closest('.form-group').find('[data-target-icp]').val(e.icon);
    });
    $('.lista-item a img').each(function () {
        var src = $(this).attr('src');
        $(this).closest('a').css({
            'background-image': 'url(' + src + ')',
            'background-repeat': 'no-repeat',
            'background-position': 'center center',
            'background-size': 'contain',
            'background-color': '#ffffff'
        });
    });
});


$(document).on('click', '.ponto', function () {
    $(this).remove();
    $('[name="pontos"]').html($('.pontos').html());
});
$(document).on('click', '.confirm', function (e) {
    e.preventDefault();
    var elemento = $(this);
    $.confirm({
        title: '',
        content: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<b>' + elemento.attr('data-title') + '</b>',
        buttons: {
            confirm: {
                btnClass: 'btn-primary btn-sm',
                text: 'Sim',
                action: function () {
                    elemento.closest('form').submit();
                }
            },
            cancel: {
                btnClass: 'btn-danger btn-sm',
                text: 'Não',
                action: function () {

                }
            }
        }
    });
});
$(document).on('click', '.confirmar', function (e) {
    e.preventDefault();
    var elemento = $(this);
    $.confirm({
        title: '',
        content: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<b>' + elemento.attr('data-title') + '</b>',
        buttons: {
            confirm: {
                btnClass: 'btn-primary btn-sm',
                text: 'Sim',
                action: function () {
                    window.location.href = elemento.attr('data-href');
                }
            },
            cancel: {
                btnClass: 'btn-danger btn-sm',
                text: 'Não',
                action: function () {

                }
            }
        }
    });
});
