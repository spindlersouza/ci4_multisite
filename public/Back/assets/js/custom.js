function uploadImage(file) {
    var data = new FormData();
    data.append("file", file);
    $.ajax({
        url: "/admin/aux/uploadimg",
        type: "POST",
        cache: false,
        data: data,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (url) {
            var image = $('<img>').attr('src', '/public/upload/editores/' + url);
            $('.summernote').summernote("insertNode", image[0]);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

$(document).ready(function () {
    //NOVAS
    $('.fancybox').fancybox();
    $('.summernote').summernote({
        callbacks: {
            onImageUpload: function (files) {
                uploadImage(files[0]);
            }
//            onMediaDelete: function (target) {
//                console.log(target[0].src);
//                deleteFile(target[0].src);
//            }
        }
    });
    $('.editAtivoAdmin').click(function () {
        var v;
        var col = $(this).data('col');
        var tb = $(this).data('tb');
        if ($(this).hasClass('fa-flip-horizontal')) {
            $(this).removeClass('fa-flip-horizontal');
            $(this).css('color', '#9d4444');
            v = 0;
        } else {
            $(this).addClass('fa-flip-horizontal');
            $(this).css('color', '#508b47');
            v = 1;
        }
        $.post(tb + '/editAtivo', {ativo: v, col: col}, function () {
            return false;
        });
    });
    $('#estado_id').change(function () {
        if ($(this).val() != '') {
            $.ajax({
                url: "/admin/aux/cidade/" + $(this).val(),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    var citys = '<option value=""> Selecione uma cidade </option>';
                    for (var i = 0; i < data.length; i++) {
                        citys += '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                    }
                    $('#cidade_id').html(citys);
                }
            });
        } else {
            $('#cidade_id').html('<option value=""> Selecione um estado </option>');
        }
    });

    $('.alteraFrete').click(function () {
        console.log();
        var id = $(this).data('id');
        var site_id = $(this).data('site');
        var valor = $('#valor_frete_' + id).val();
        $.post('fretegratis/save', {id: id, valor: valor, site_id: site_id}, function (data) {
            var rt = $.parseJSON(data);
            if (rt.erro == 'true') {
                alert(rt.msg);
            } else {
                alert(rt.msg);
            }
        });
    });

});