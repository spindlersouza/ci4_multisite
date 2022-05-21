<?php

namespace Config;

$routes = Services::routes();
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers\Front');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

//API 
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->get('consultaCep/(:num)', 'Frenet::consultaCep/$1');
    $routes->get('getFreteProduto/(:num)/(:num)', 'Frenet::getFreteProduto/$1/$2');
    $routes->get('getFreteCarrinho/(:num)', 'Frenet::getFreteCarrinho/$1');
    $routes->get('getPedidos', 'Pedidos::exportaPedidos');

    $routes->group('produtos', function ($routes) {
        $routes->post('categorias', 'Produtos::categorias');
        $routes->post('produtos', 'Produtos::produto');
        $routes->post('variacoes', 'Produtos::atributos');
        $routes->post('imagens', 'Produtos::imagens');
        $routes->post('delimg', 'Produtos::deleteImagens');
    });
    $routes->group('cadastros', function ($routes) {
        $routes->post('cadVendedor', 'Cadastros::cadVendedores');
    });
    $routes->group('mp', function ($routes) {
        $routes->get('meios', 'MercadoPg::MeiosPagamento');
        $routes->post('pagamentocc', 'MercadoPg::pagamentocc');
        $routes->get('pagamentoboleto', 'MercadoPg::pagamentoboleto');
        $routes->get('testeemail', 'MercadoPg::testeemail');
    });
});
//------------------------------------------------------------------------------------------------------------------------------------------------------//
//BACK
//Bloqueio de páginas exigindo login
$routes->group('admin', ['namespace' => 'App\Controllers\Back', 'filter' => 'AdminAuthCheck'], function ($routes) {
    $routes->group('', function ($routes) {
        $routes->get('', 'Dashboard::index');
        $routes->get('dashboard', 'Dashboard::index');
        $routes->get('logout', 'Auth::logout');
        $routes->get('news', 'News::index');
        $routes->get('clientes', 'Clientes::index');
    });
    $routes->group('auth', function ($routes) {
        $routes->get('list', 'Auth::list');
        $routes->get('cadastro', 'Auth::cadastro');
        $routes->get('cadastro/(:num)', 'Auth::cadastro/$1');
        $routes->post('save', 'Auth::save');
    });
    $routes->group('aux', function ($routes) {
        $routes->get('estado', 'Estado::listEstados');
        $routes->get('cidade/(:num)', 'Cidade::listCidades/$1');
        $routes->post('uploadimg', 'AuxUpload::uploadSummer');
    });
    $routes->group('banner', function ($routes) {
        $routes->get('', 'Banner::index');
        $routes->get('cadastro', 'Banner::cadastro');
        $routes->get('cadastro/(:num)', 'Banner::cadastro/$1');
        $routes->get('indexTipos/(:num)', 'Banner::indexTipos/$1');
        $routes->get('cadastroTipos/(:num)', 'Banner::cadastroTipos/$1');
        $routes->get('cadastroTipos/(:num)/(:num)', 'Banner::cadastroTipos/$1/$2');
        $routes->post('saveTipos', 'Banner::saveTipos');
        $routes->post('editAtivo', 'Banner::editAtivo');
        $routes->get('delete/(:num)/(:num)', 'Banner::delete/$1/$2');
        $routes->post('save', 'Banner::save');
    });
    $routes->group('config', function ($routes) {
        $routes->get('', 'Configuracao::index');
        $routes->get('cadastro/(:num)', 'Configuracao::cadastro/$1');
        $routes->post('save', 'Configuracao::save');
    });
    $routes->group('cupom', function ($routes) {
        $routes->get('', 'Cupom::index');
        $routes->get('cadastro', 'Cupom::cadastro');
        $routes->get('cadastro/(:num)', 'Cupom::cadastro/$1');
        $routes->post('editAtivo', 'Cupom::editAtivo');
        $routes->post('save', 'Cupom::save');
    });
    $routes->group('duvidas', function ($routes) {
        $routes->get('', 'Duvidas::index');
        $routes->get('cadastro', 'Duvidas::cadastro');
        $routes->get('cadastro/(:num)', 'Duvidas::cadastro/$1');
        $routes->post('save', 'Duvidas::save');
    });
    $routes->group('fretegratis', function ($routes) {
        $routes->get('', 'FreteGratis::index');
        $routes->post('save', 'FreteGratis::save');
    });

    $routes->group('infosite', function ($routes) {
        $routes->get('', 'InfoSite::index');
        $routes->get('cadastro/(:num)', 'InfoSite::cadastro/$1');
        $routes->post('save', 'InfoSite::save');
    });
    $routes->group('lojas', function ($routes) {
        $routes->get('', 'Lojas::index');
        $routes->get('cadastro', 'Lojas::cadastro');
        $routes->get('cadastro/(:num)', 'Lojas::cadastro/$1');
        $routes->post('save', 'Lojas::save');
    });
    $routes->group('paginas', function ($routes) {
        $routes->get('cadastro/(:any)/(:num)', 'Paginas::cadastro/$1/$2');
        $routes->get('(:any)', 'Paginas::index/$1');
        $routes->post('save', 'Paginas::save');
    });
    $routes->group('topicos', function ($routes) {
        $routes->get('', 'Topicos::index');
        $routes->get('cadastro', 'Topicos::cadastro');
        $routes->get('cadastro/(:num)', 'Topicos::cadastro/$1');
        $routes->post('save', 'Topicos::save');
    });
    $routes->group('pedidos', function ($routes) {
        $routes->get('', 'Pedidos::index');
        $routes->get('(:num)', 'Pedidos::detalhes/$1');
    });
});

//Bloqueio de páginas usadas para acesso
$routes->group('admin', ['namespace' => 'App\Controllers\Back', 'filter' => 'AdminAuthChecked'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');
});
//------------------------------------------------------------------------------------------------------------------------------------------------------//
//FRONT
if (URLRESTRIC) {
    $routes->group('', ['namespace' => 'App\Controllers\Front'], function ($routes) {
        $routes->get('/', 'Home::index');
        $routes->get('/home', 'Home::index');
        $routes->get('cidade/(:num)', 'Cidade::listCidades/$1');
        $routes->get('catalogo/(:any)', 'Catalogo::index/$1');
        $routes->get('(duvidasfrequentes|duvidas-frequentes|faq)', 'DuvidasFrequentes::index');
        $routes->post('news', 'News::save');
        $routes->post('busca', 'Busca::index');
        $routes->get('(politicatrocas|politica-trocas)', 'PoliticaTrocas::index');
        $routes->get('(termosdeuso|termos-de-uso)', 'TermosDeUso::index');
        $routes->get('(politicaprivacidade|politica-privacidade)', 'PoliticaPrivacidade::index');
        $routes->get('lojas', 'NossasLojas::index');
        $routes->get('trabalhe-conosco', 'TrabalheConosco::index');
        $routes->get('carrinho', 'Carrinho::index');
        $routes->get('delCarrinho/(:num)', 'Carrinho::delProduto/$1');
        $routes->post('addCarrinho', 'Carrinho::addProduto');
        $routes->post('addCupom', 'Carrinho::addCupom');
        $routes->post('alteraquantidade', 'Carrinho::addQuantidade');
        $routes->post('addfavorito', 'Produto::addFavorito');
        $routes->post('delfavorito', 'Produto::delFavorito');
        $routes->post('avaliacao', 'Produto::avaliacao');
        $routes->post('atualizafrete', 'Carrinho::atualizaCep');
        $routes->post('freteselect', 'Carrinho::freteselect');
        $routes->get('pagamento', 'Pagamento::index');
        $routes->get('login', 'Login::index');
        $routes->get('logout', 'Login::logout');
        $routes->post('login', 'Login::login');
        $routes->post('cadlog', 'Login::save');
        $routes->post('upcc', 'Login::upconta');
        $routes->post('savecadastro', 'Login::save');
        $routes->get('(meuspedidos|meus-pedidos)', 'MeusPedidos::index');
        $routes->get('(minha-conta|minhaconta)', 'MinhaConta::index');
        $routes->get('(:segment)/(:segment)/(:segment)', 'Produto::index/$1/$2/$3');
        $routes->get('(:segment)/(:segment)', 'Categoria::subcategoria/$1/$2');
        $routes->get('(:segment)', 'Categoria::categoria/$1');
    });
}
//------------------------------------------------------------------------------------------------------------------------------------------------------//
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}


