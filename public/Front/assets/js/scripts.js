//NÂO ALTERAR
function removeprodutocarrinhotopo(id) {
    $.get("/delCarrinho/" + id, function () {
        $('#produtocarrinhotopo' + id).remove();
    });
}
function removeprodutocarrinho(id) {
    $.get("/delCarrinho/" + id, function () {
        $('#produtocarrinho' + id).remove();
    });
}
function removeprodutocarrinhotopo(id) {
    $.get("/delCarrinho/" + id, function () {
        $('#produtocarrinhotopo' + id).remove();
    });
}
function alteraquantidade(qtd, id) {
    $.post('/alteraquantidade', {id: id, quantidade: qtd}, function (data) {
        var obj = $.parseJSON(data);
        $('#subtotal_item_carrinho' + id).html('R$ ' + obj.item_subtotal.toFixed(2).replace('.', ','));
        $('#total_carrinho').val(obj.total_produtos.toFixed(2).replace('.', ','));
        $('#total_carrinho_s').html('R$ ' + obj.total_produtos.toFixed(2).replace('.', ','));

        var cep = $('#cepFreteCarrinho').val();
        if (cep != '') {
            buscaFreteCarrinho();
            $('#totalefrete').html('SELECIONE O FRETE');
        }
        $('#qtdCarrinhoProds' + id).fadeIn();
        if ($('#codigo_cupom').val() != '') {
            addCupom();
        }
        console.log(data);
    });
}
function addCupom() {
    $('#erro_cupom').hide();
    var codigo = $('#codigo_cupom').val();
    if (codigo != '') {
        $.post('/addCupom', {codigo: codigo}, function (data) {
            var obj = $.parseJSON(data);
            $('#total_carrinho').val(obj.total_produtos.toFixed(2).replace('.', ','));
            $('#total_carrinho_s').html('R$ ' + obj.total_produtos.toFixed(2).replace('.', ','));
            $('#desconto_carrinho').html('R$ ' + obj.desconto.toFixed(2).replace('.', ','));
            $('#total_desconto').val(obj.desconto.toFixed(2).replace('.', ','));
            $('#totalefrete').html('SELECIONE O FRETE');
        });
    } else {
        $('#erro_cupom').show();
    }
}
function buscaFreteCarrinho() {
    var cep = $('#cepFreteCarrinho').val().replace('-', '');
    var htmlH = '';
    var html = '';
    if ($('#ftc').val() == '1') {
        $.get("/api/getFreteCarrinho/" + cep, function (data) {
            console.log(data);
            var cep = $.parseJSON(data);
            $(cep).each(function () {
                html += '<div class="radio">';
                if (this.transportadora == 'Correios') {
                    html += '   <input type="radio" name="rdfrete" id="frete-' + this.tipo + '" value="' + this.tipo + '" data-valor="' + this.preco + '" class="radio-frete" onclick="selectFreteCarrinho(this)">';
                    html += '   <label for="frete-' + this.tipo + '">' + this.tipo + ' = <b> R$ ' + this.preco + '</b></label>';
                } else {
                    html += '   <input type="radio" name="rdfrete" id="frete-' + this.transportadora + '" value="' + this.preco + '" data-valor="' + this.preco + '" class="radio-frete" onclick="selectFreteCarrinho(this)">';
                    html += '   <label for="frete-' + this.tipo + '">' + this.transportadora + ' = <b> R$ ' + this.preco + '</b></label>';
                }
                html += '</div>';
            });
            if (html != '') {
                htmlH += '<p class="text-uppercase">Selecione a forma de entrega:</p>';
            } else {
                htmlH += '<p class="text-uppercase">Região não atendida</p>';
            }
        });
    } else {
        htmlH += '<p class="text-uppercase">Selecione a forma de entrega:</p>';
        html += '<div class="radio">';
        html += '   <input type="radio" name="rdfrete" id="frete-gratis" value="gratis" data-valor="0,00" class="radio-frete" onclick="selectFreteCarrinho(this)">';
        html += '   <label for="frete-gratis"> Frete Grátis = <b> R$ 0,00</b></label>';
        html += '</div>';
    }
    $('#totalefrete').html('SELECIONE O FRETE');
    $('#lista_fretes_carrinho').html(htmlH + html);
}
function selectFreteCarrinho(obj) {
    var vlfrete = parseFloat($(obj).data('valor').replace('.', '').replace(',', '.'));
    var vldesconto = parseFloat($('#total_desconto').val().replace('.', '').replace(',', '.'));
    var vlcarrinho = parseFloat($('#total_carrinho').val().replace('.', '').replace(',', '.'));
    var total = (vlcarrinho - vldesconto + vlfrete).toFixed(2).replace('.', ',');
    $.post('/freteselect', {tipo: $(obj).val(), valor: vlfrete}, function () {
        $('#totalefrete').html(' R$ ' + total + '');
        $('#validacarrinhopagamento').hide();
        $('#link_pagamento').fadeIn();
        $('#lista_fretes_carrinho').removeClass('border');
        $('#lista_fretes_carrinho').removeClass('border-danger');

    });
}
var tsClickController = 0;
$(document).ready(function () {

    $('.galeria_produto').izoomify();
    $(".periodo").mask("99? 99 99 99 99 99 99 99 99 99 99 99");
    $(".card").mask("9999999999999999");
    $(".numero").mask("9?999999");
    $(".data_completa").mask("99/99/9999");
    $(".data_hora_mask").mask("99/99/9999 99:99");
    $(".data-mask").mask("99/99/9999");
    $(".peso").maskMoney({showSymbol: true, symbol: "", decimal: ".", thousands: "", precision: 3});
    $(".taxa").maskMoney({showSymbol: true, symbol: "", decimal: ".", thousands: "", precision: 5});
    $(".moeda_real").maskMoney({showSymbol: true, symbol: "", decimal: ".", thousands: ""});
    $(".moeda_real").focusout(function () {
        if ($(this).val() == '') {
            $(this).val(0);
        }
    });
    $(".cpf-mask").focusin(function () {
        $(this).mask("999.999.999-99");
    });
    $(".rg-mask").focusin(function () {
        $(this).mask("99999999?99");
    });
    $(".cnpj-mask").focusin(function () {
        $(this).mask("99.999.999/9999-99");
    });
    $(".cep-mask").focusin(function () {
        $(this).mask("99999-999");
    });
    $('.fone-mask').focusin(function () {
        $(this).mask("(99) 9999-9999?9");
    });
    $('#cadNews').click(function () {
        $.post(
                '/news',
                $('#subscribe-form').serialize(),
                function (data) {
                    var valid = $.parseJSON(data);
                    if ((valid.nome || valid.email) && valid.email != 'repetido' && valid.email != 'cadastrado') {
                        $('#avisoNewsModal').modal('show');
                    } else {
                        $('#sucessoNewsModal').modal('show');
                        $('#subscribe-form')[0].reset();

                    }
                    return false;
                });
    });

    $('#addProduto').click(function () {
        console.log(this);
        $('#produto_cor_valida').fadeOut();
        $('#produto_tamanho_valida').fadeOut();
        var id = $(this).data('idproduto');
        var qtd = $('#produto_quantidade').val();
        var cor = $('#cor_selecionada').val();
        var tamanho = $('#tamanho_selecionado').val();
        var html = '';
        var totalCarrinho = 0;
        if (cor == '') {
            $('#produto_cor_valida').fadeIn();
            return false;
        }
        if (tamanho == '') {
            $('#produto_tamanho_valida').fadeIn();
            return false;
        }
        $.post(
                '/addCarrinho',
                {produtos_id: id, qtd: qtd, cor: cor, tamanho: tamanho},
                function (data) {
                    var itens = $.parseJSON(data);
                    $(itens).each(function () {
                        html += '<div class="row border-all" id="produtocarrinhotopo' + this.id + '">';
                        html += '    <div class="col-4">';
                        if (this.imagem != null) {
                            html += '        <img class="img-fit-cart" src="/public/upload/produtos/thumb_200/' + this.imagem + '" />';
                        }
                        html += '    </div>';
                        html += '    <div class="col-6">';
                        html += '        <b class="text-uppercase">' + this.nome + '</b>';
                        html += '        <p>Quantidade:<b class="text-uppercase">' + this.quantidade + '</b></p>';
                        html += '        <p>Valor: <b> R$ ' + this.valor.toLocaleString("pt-BR", {style: "currency", currency: "BRL"}) + '</b></p>';
                        html += '    </div>';
                        html += '    <div class="col-2 px-1">';
                        html += '        <div class="form-remove-carrinho text-center my-2">';
                        html += '            <button class="remover-produto btn btn-gray btn-xs" onclick="removeprodutocarrinhotopo(' + this.id + ')" ><i class="fa fa-trash"></i></button>';
                        html += '        </div>';
                        html += '    </div>';
                        html += '</div>';
                        totalCarrinho = totalCarrinho + this.total;
                    });
                    $('#lista_itens_carrinho_topo').html(html);
                    $('#quantidade_carrinho_itens').html(itens.length);
                    $('#carrinho_topo_total').html('R$ ' + totalCarrinho.toLocaleString("pt-BR", {style: "currency", currency: "BRL"}));
                    $('#AddCarrinho').fadeIn();
                    return false;
                });
    });
    $('#calcularFreteProduto').click(function () {
        var produto = $(this).data('produto');
        var cep = $('#cepProduto').val().replace('-', '');
        $.get("/api/getFreteProduto/" + produto + "/" + cep, function (data) {

            var cep = $.parseJSON(data);
            var htmlH = '';
            var html = '';
            $(cep).each(function () {
                html += '<div class="col-8 border-bottom border-gray" style="height: 60px;">';
                if (this.transportadora == 'Correios') {
                    html += '   <p><i class="fa fa-archive"></i>&nbsp;' + this.tipo + '</p>';
                } else {
                    html += '   <p><i class="fa fa-truck"></i>&nbsp;' + this.transportadora + '<br></p>';
                }
                html += '</div>';
                html += '<div class="col-4 border-bottom border-gray" style="height: 60px;">';
                html += '   <b>R$ ' + this.preco + '</b><br>';
                html += '   <small style="font-size:11px;">' + this.dias + ' dia(s) úteis</small>';
                html += '</div>';
            });
            if (html != '') {
                htmlH += '<div class="col-12 my-2">';
                htmlH += '   <p class="text-uppercase"><b>Opções de frete para sua região:</b></p>';
                htmlH += '</div>';
            } else {
                htmlH += '<div class="col-12 my-2">';
                htmlH += '   <p class="text-uppercase"><b>Região não atendida</b></p>';
                htmlH += '</div>';
            }
            $('#valorCepProduto').html(htmlH + html);
        });
    });
    $('.clickcor').click(function () {
        var cor_unica = $('#cor_unica_selecionada').val();
        if (cor_unica == '') {
            var cor_select = $(this).data('corvl');
            $('#cor_selecionada').val($(this).data('cor'));
            $('.clickcor > a > img').removeClass('cor_active');
            $(this).find('a > img').addClass('cor_active');
            $('.owl-produtos').html('');
            $('#aux_slider > .galeria_produto').each(function () {
                if ($(this).data('cor') == cor_select) {
                    console.log($(this));
                    $(this).clone().appendTo('.owl-produtos');
                }
            });
            $(".owl-produtos").owlCarousel('destroy');
            $('.owl-produtos').owlCarousel({
                margin: 0,
                autoplay: false,
                autoplayTimeout: 5000,
                nav: false,
                dots: true,
                loop: true,
                items: 1,
            });
            $('.galeria_produto').izoomify();
        }
    });
    $('.clicktamanho').click(function () {
        var tamanho_unico = $('#tamanho_unico_selecionado').val();
        if (tamanho_unico == '') {
            $('#tamanho_selecionado').val($(this).data('tamanho'));
            $('.clicktamanho > a').removeClass('tamanho_active');
            $(this).find('a').addClass('tamanho_active');
        }
    });
    $('#minus_produto').click(function () {
        var qtd = parseInt($('#produto_quantidade').val());
        if (qtd > 1) {
            $('#produto_quantidade').val(qtd - 1);
        }
    });
    $('#plus_produto').click(function () {
        var qtd = parseInt($('#produto_quantidade').val());
        $('#produto_quantidade').val(qtd + 1);

    });
    $('.addfavorito').click(function () {
        var el = $(this);
        $.post('/addfavorito', {id: $(this).data('id')}, function () {
            $(el).css('color', 'red');
            $(el).removeClass('addfavorito');
            $(el).addClass('delfavorito');
        });
    });
    $('.delfavorito').click(function () {
        var el = $(this);
        $.post('/delfavorito', {id: $(this).data('id')}, function () {
            $(el).css('color', '');
            $(el).addClass('addfavorito');
            $(el).removeClass('delfavorito');
        });
    });

    $('.starAval').mouseover(function () {
        var v = $(this).data('v');

        $(this).removeClass('fa-star-o');
        $(this).addClass('fa-star');

        $(this).siblings('i').each(function () {
            if ($(this).data('v') < v) {
                $(this).addClass('fa-star');
                $(this).removeClass('fa-star-o');
            } else {
                $(this).addClass('fa-star-o');
            }
        });
    }).mouseleave(function () {
        var v = $(this).data('v');
        var vs = $('#nota').val();

        $(this).addClass('fa-star-o');
        $(this).removeClass('fa-star');

        $(this).siblings('i').each(function () {
            $(this).removeClass('fa-star');
            $(this).removeClass('fa-star-o');
            if ($(this).data('v') == vs) {
                $(this).addClass('fa-star');
            } else if ($(this).data('v') < vs) {
                $(this).addClass('fa-star');
            } else {
                $(this).addClass('fa-star-o');
            }
        });

    }).click(function () {
        var v = $(this).data('v');
        $('#nota').val(v);
        $(this).siblings('i').each(function () {
            $(this).removeClass('fa-star');
            $(this).removeClass('fa-star-o');
            if ($(this).data('v') == v) {
                $(this).addClass('fa-star');
            } else if ($(this).data('v') < v) {
                $(this).addClass('fa-star');
            } else {
                $(this).addClass('fa-star-o');
            }
        });
    });
    $('#btnAval').click(function () {
        var nota = $('#nota').val();
        var desc = $('#comentAval').val();
        var produto = $('#produtoAval').val();
        $.post('/avaliacao', {nota: nota, descricao: desc, produto: produto}, function () {
            location.reload();
        });
    });

    $('#cadastro_estado_id').change(function () {
        if ($(this).val() != '') {
            $.ajax({
                url: "/cidade/" + $(this).val(),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    var citys = '<option value=""> Selecione uma cidade </option>';
                    for (var i = 0; i < data.length; i++) {
                        citys += '<option value="' + data[i].id + '" data-ct="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#cadastro_cidade_id').html(citys);
                }
            });
        } else {
            $('#cadastro_cidade_id').html('<option value=""> Selecione um estado </option>');
        }
    });
    $('#buscacep_cadastro').click(function () {
        var cep = $('#cadastro_cep').val().replace('-', '');
        $.getJSON('/api/consultaCep/' + cep, function (dataCep) {
            $('#cadastro_estado_id option[data-uf=' + dataCep.UF + ']').prop('selected', true);
            $.ajax({
                url: "/cidade/" + $('#cadastro_estado_id').val(),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    var citys = '<option value=""> Selecione uma cidade </option>';
                    for (var i = 0; i < data.length; i++) {
                        citys += '<option value="' + data[i].id + '"';
                        if (dataCep.City == data[i].nome) {
                            citys += 'selected';
                        }
                        citys += '>' + data[i].nome + '</option>';
                    }
                    $('#cadastro_cidade_id').html(citys);
                }
            });
            $('#cadastro_endereco').val(dataCep.Street);
            $('#cadastro_bairro').val(dataCep.District);


        });
    });
    $('#validaCadastro').click(function () {
        var idForm = '#formCadastro';
        var error = 0;
        $('#formCadastro').find('.error-input').removeClass('error-input').siblings('span').fadeOut();
        $('.g-recaptcha').find('iframe[title="reCAPTCHA"]').removeClass('error-input');
        $('.g-recaptcha-response').siblings('span').fadeOut();
        $('#formCadastro').find('[required]').each(function () {
            if ($(this).val().trim() == '') {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
                error++;
            } else if ($(this).val().trim() != '' && $(this).data('required') == 'email' && !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/).test($(this).val())) {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
            } else if ($(this).val().trim() != '' && $(this).data('required') == 'passwd' && $(this).val() != $('#cadastro_senha').val()) {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
            }
        });
        if ($('.g-recaptcha-response').val().trim() == '') {
            $('.g-recaptcha').siblings('span').fadeIn();
            $('.g-recaptcha').find('iframe[title="reCAPTCHA"]').addClass('error-input');
            error++;
        }

        if (error == 0) {
            $.post('/cadlog', $('#formCadastro').serialize(),
                    function (data) {
                        var ret = $.parseJSON(data);
                        if (data.error == 'true') {
                            alert('Ocorreu um problema, tente novamente mais tarde');
                            return false;
                        } else {
                            window.location.href = '/';
                        }
                    });
        } else {
            window.location.href = '/carriho';
        }

    });

    $('.minus_produto_carrinho').click(function (event) {
        if ((event.timeStamp - tsClickController) > 150) {
            tsClickController = event.timeStamp;
            var idProd = $(this).data('id');
            var idProd = $(this).data('id');
            $('#qtdCarrinhoProds' + idProd).hide();
            var qtd = parseInt($('#produto_quantidade' + idProd).val()) - 1;
            if (qtd > 0) {
                $('#qtdCarrinhoProds' + idProd).fadeOut();
                $('#produto_quantidade' + idProd).val(qtd);
                alteraquantidade(qtd, idProd);
            } else {
                $('#qtdCarrinhoProds' + idProd).show();
            }
        }
    });
    $('.plus_produto_carrinho').click(function () {
        if ((event.timeStamp - tsClickController) > 150) {
            tsClickController = event.timeStamp;
            var idProd = $(this).data('id');
            $('#qtdCarrinhoProds' + idProd).hide();
            var qtd = parseInt($('#produto_quantidade' + idProd).val()) + 1;
            $('#produto_quantidade' + idProd).val(qtd);
            alteraquantidade(qtd, idProd);
        }
    });

    $('#busca_frete_carrinho').click(function () {
        buscaFreteCarrinho();
    });

    $('#cupomCarrinho').click(function () {
        addCupom();

    });

    $('#buscacep_minhaconta').click(function () {
        var cep = $('#conta_cep').val().replace('-', '');
        $.getJSON('/api/consultaCep/' + cep, function (dataCep) {
            $('#conta_estado_id option[data-uf=' + dataCep.UF + ']').prop('selected', true);
            $.ajax({
                url: "/cidade/" + $('#conta_estado_id').val(),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    var citys = '<option value=""> Selecione uma cidade </option>';
                    for (var i = 0; i < data.length; i++) {
                        citys += '<option value="' + data[i].id + '"';
                        if (dataCep.City == data[i].nome) {
                            citys += 'selected';
                        }
                        citys += '>' + data[i].nome + '</option>';
                    }
                    $('#conta_cidade_id').html(citys);
                }
            });
            $('#conta_endereco').val(dataCep.Street);
            $('#conta_bairro').val(dataCep.District);


        });
    });
    $('#validaConta').click(function () {
        var idForm = '#formConta';
        var error = 0;
        $('#formConta').find('.error-input').removeClass('error-input').siblings('span').fadeOut();
        $('.g-recaptcha').find('iframe[title="reCAPTCHA"]').removeClass('error-input');
        $('.g-recaptcha-response').siblings('span').fadeOut();
        $('#formConta').find('[required]').each(function () {
            if ($(this).val().trim() == '') {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
                error++;
            } else if ($(this).val().trim() != '' && $(this).data('required') == 'email' && !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/).test($(this).val())) {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
            } else if ($(this).val().trim() != '' && $(this).data('required') == 'passwd' && $(this).val() != $('#conta_senha').val()) {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
            }
        });
        if ($('.g-recaptcha-response').val().trim() == '') {
            $('.g-recaptcha').siblings('span').fadeIn();
            $('.g-recaptcha').find('iframe[title="reCAPTCHA"]').addClass('error-input');
            error++;
        }

        if (error == 0) {
            $.post('/upcc', $('#formConta').serialize(),
                    function (data) {
                        var ret = $.parseJSON(data);
                        if (data.error == 'true') {
                            alert('Ocorreu um problema, tente novamente mais tarde');
                            return false;
                        } else {
                            location.reload();
                        }
                    });
        }
    });

    $('#carrinho_estado_id').change(function () {
        if ($(this).val() != '') {
            $.ajax({
                url: "/cidade/" + $(this).val(),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    var citys = '<option value=""> Selecione uma cidade </option>';
                    for (var i = 0; i < data.length; i++) {
                        citys += '<option value="' + data[i].id + '">' + data[i].nome + '</option>';
                    }
                    $('#carrinho_cidade_id').html(citys);
                }
            });
        } else {
            $('#carrinho_cidade_id').html('<option value=""> Selecione um estado </option>');
        }
    });
    $('#buscacep_carrinho').click(function () {
        var cep = $('#carrinho_cep').val().replace('-', '');
        $.getJSON('/api/consultaCep/' + cep, function (dataCep) {
            $('#carrinho_estado_id option[data-uf=' + dataCep.UF + ']').prop('selected', true);
            $.ajax({
                url: "/cidade/" + $('#carrinho_estado_id').val(),
                method: "GET",
                dataType: "JSON",
                success: function (data) {
                    var citys = '<option value=""> Selecione uma cidade </option>';
                    for (var i = 0; i < data.length; i++) {
                        citys += '<option value="' + data[i].id + '"';
                        if (dataCep.City == data[i].nome) {
                            citys += 'selected';
                        }
                        citys += '>' + data[i].nome + '</option>';
                    }
                    $('#carrinho_cidade_id').html(citys);
                }
            });
            $('#carrinho_endereco').val(dataCep.Street);
            $('#carrinho_bairro').val(dataCep.District);
        });
    });
    $('#validaCarrinho').click(function () {
        var idForm = '#formFreteCarrinho';
        var error = 0;
        $('#formFreteCarrinho').find('.error-input').removeClass('error-input').siblings('span').fadeOut();
        $('.g-recaptcha').find('iframe[title="reCAPTCHA"]').removeClass('error-input');
        $('.g-recaptcha-response').siblings('span').fadeOut();
        $('#formFreteCarrinho').find('[required]').each(function () {
            if ($(this).val().trim() == '') {
                $(this).siblings('span').fadeIn();
                $(this).addClass('error-input');
                error++;
            }
        });
        if ($('.g-recaptcha-response').val().trim() == '') {
            $('.g-recaptcha').siblings('span').fadeIn();
            $('.g-recaptcha').find('iframe[title="reCAPTCHA"]').addClass('error-input');
            error++;
        }

        if (error == 0) {
            $('#formFreteCarrinho').submit();
        }
    });
    $('#validacarrinhopagamento').click(function () {
        if (typeof $('input[name=rdfrete]:checked').val() == "undefined") {
            $('#lista_fretes_carrinho').addClass('border');
            $('#lista_fretes_carrinho').addClass('border-danger');
        } else {
            $(this).hide();
            $('#link_pagamento').show();

        }
    });
});