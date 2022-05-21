<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Back\ConfiguracaoModel;
use App\Models\Back\ProdutosModel;
use App\Models\Back\SiteModel;
use App\Models\Front\CarrinhoModel;
use App\Models\Front\CarrinhoItensModel;

class Frenet extends BaseController {

    protected $configs;
    protected $sites;
    protected $produtos;
    protected $carrinho;
    protected $carrinhoItens;
    protected $data;

    public function __construct() {
        $this->configs = new ConfiguracaoModel();
        $this->sites = new SiteModel();
        $this->produtos = new ProdutosModel();
        $this->carrinho = new CarrinhoModel();
        $this->carrinhoItens = new CarrinhoItensModel();
        $this->data = [
            'slug' => SITESLUG,
            'site_id' => SITEENABLED,
            'configs' => $this->configs->select('cep_remetente, frenet_token')->where('site_id', SITEENABLED)->first(),
        ];
    }

    public function consultaCep($cep) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.frenet.com.br/CEP/Address/" . $cep);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "token: " . $this->data['configs']['frenet_token']
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function getFreteProduto($id, $cep) {
        $ret = [];
        $produto = $this->produtos->where('id', $id)->first();
        $dtrq['SellerCEP'] = $this->data['configs']['cep_remetente'];
        $dtrq['RecipientCEP'] = $cep;
        $dtrq['ShipmentInvoiceValue'] = $produto['preco'] ?? 0;
        $dtrq['ShippingItemArray'][] = [
            'Height' => $produto['altura'] ?? 1,
            'Length' => $produto['comprimento'] ?? 1,
            'Quantity' => 1,
            'Weight' => $produto['peso'] ?? 1,
            'Width' => $produto['largura'] ?? 1,
            'SKU' => $produto['cod_sinc'] ?? 0,
            'Category' => '',
        ];
        $dtrq['RecipientCountry'] = 'BR';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.frenet.com.br/shipping/quote");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dtrq));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Content-Type: application/json",
            "token: " . $this->data['configs']['frenet_token']
        ));

        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        foreach ($response['ShippingSevicesArray'] as $frete) {
            if (!$frete['Error']) {
                $ret[] = [
                    'cod' => $frete['ServiceCode'],
                    'tipo' => $frete['ServiceDescription'],
                    'transportadora' => $frete['Carrier'],
                    'preco' => number_format($frete['ShippingPrice'], 2, ',', '.'),
                    'dias' => $frete['DeliveryTime']
                ];
            }
        }
        session()->set('cep', $cep);
        if (!isset($_COOKIE['cep'])) {
            setcookie("cep", $cep, time() + 3600 * 24 * 7, "/");
        } else {
            $_COOKIE['cep'] = $cep;
        }
        return json_encode($ret);
    }

    public function getFreteCarrinho($cep = null) {
        $ShipmentInvoiceValue = 0;
        $carrinho = $this->carrinho->where('id', $_COOKIE['cart'])->first();
        foreach ($this->carrinhoItens->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
            $rsProd = $this->produtos->select('nome, referencia, imagem, altura, largura, comprimento, peso')->where('id', $item['produtos_id'])->first();
            $dtrq['ShippingItemArray'][] = [
                'Height' => ($rsProd['altura'] == 0.000) ? 1 : $rsProd['altura'],
                'Length' => ($rsProd['comprimento'] == 0.000) ? 1 : $rsProd['comprimento'],
                'Quantity' => $item['quantidade'],
                'Weight' => ($rsProd['peso'] < 0.300) ? 0.300 : ($rsProd['peso']),
                'Width' => ($rsProd['largura'] == 0.000) ? 1 : $rsProd['largura'],
                'SKU' => $rsProd['referencia'],
                'Category' => '',
            ];
            $ShipmentInvoiceValue += $item['total'];
        }

        $dtrq['SellerCEP'] = $this->data['configs']['cep_remetente'];
        $dtrq['RecipientCEP'] = $cep ;
        $dtrq['ShipmentInvoiceValue'] = $ShipmentInvoiceValue;
        $dtrq['RecipientCountry'] = 'BR';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.frenet.com.br/shipping/quote");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dtrq));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Content-Type: application/json",
            "token: " . $this->data['configs']['frenet_token']
        ));

        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        $ret = [];
        if (isset($response['ShippingSevicesArray'])) {
            foreach ($response['ShippingSevicesArray'] as $frete) {
                if (!$frete['Error']) {
                    $ret[] = [
                        'cod' => $frete['ServiceCode'],
                        'tipo' => $frete['ServiceDescription'],
                        'transportadora' => $frete['Carrier'],
                        'preco' => number_format($frete['ShippingPrice'], 2, ',', '.'),
                        'dias' => $frete['DeliveryTime']
                    ];
                }
            }
        }
        return json_encode($ret);
    }

    public function calcFreteCarrinho($itens, $cep, $tipoFrete) {

        $ShipmentInvoiceValue = 0;
        foreach ($itens as $k => $item) {
            $dtrq['ShippingItemArray'][] = [
                'Height' => ($item['item']['altura'] == 0.000) ? 1 : $item['item']['altura'],
                'Length' => ($item['item']['comprimento'] == 0.000) ? 1 : $item['item']['comprimento'],
                'Quantity' => $item['qtd'],
                'Weight' => (($item['item']['peso'] / 1000) == 0) ? 1 : ($item['item']['peso'] / 1000),
                'Width' => ($item['item']['largura'] == 0.000) ? 1 : $item['item']['larguras'],
                'SKU' => $item['item']['referencia'],
                'Category' => '',
            ];
            $ShipmentInvoiceValue += $item['subtotal'];
        }

        $dtrq['SellerCEP'] = $this->data['configs']['cep_remetente'];
        $dtrq['RecipientCEP'] = $cep;
        $dtrq['ShipmentInvoiceValue'] = $ShipmentInvoiceValue;
        $dtrq['RecipientCountry'] = 'BR';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.frenet.com.br/shipping/quote");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dtrq));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Content-Type: application/json",
            "token: " . $this->data['configs']['frenet_token']
        ));

        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        foreach ($response['ShippingSevicesArray'] as $k => $frete) {
            if (!$frete['Error'] && $frete['ServiceDescription'] == $tipoFrete) {
                $ret = $frete['ShippingPrice'];
            }
        }


        return $ret;
    }

    public function reCalcFreteCarrinho($cep, $tipoFrete) {
        
        $ShipmentInvoiceValue = 0;
        $carrinho = $this->carrinho->where('id', $_COOKIE['cart'])->first();
        foreach ($this->carrinhoItens->where('carrinho_id', $carrinho['id'])->get()->getResult('array') as $k => $item) {
            $rsProd = $this->produtos->select('nome, referencia, imagem, altura, largura, comprimento, peso')->where('id', $item['produtos_id'])->first();
            $dtrq['ShippingItemArray'][] = [
                'Height' => ($rsProd['altura'] == 0.000) ? 1 : $rsProd['altura'],
                'Length' => ($rsProd['comprimento'] == 0.000) ? 1 : $rsProd['comprimento'],
                'Quantity' => $item['quantidade'],
                'Weight' => ($rsProd['peso'] < 0.300) ? 0.300 : ($rsProd['peso']),
                'Width' => ($rsProd['largura'] == 0.000) ? 1 : $rsProd['largura'],
                'SKU' => $rsProd['referencia'],
                'Category' => '',
            ];
            $ShipmentInvoiceValue += $item['total'];
        }

        $dtrq['SellerCEP'] = $this->data['configs']['cep_remetente'];
        $dtrq['RecipientCEP'] = $carrinho['cep'];
        $dtrq['ShipmentInvoiceValue'] = $ShipmentInvoiceValue;
        $dtrq['RecipientCountry'] = 'BR';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://api.frenet.com.br/shipping/quote");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dtrq));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json",
            "Content-Type: application/json",
            "token: " . $this->data['configs']['frenet_token']
        ));

        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);
        foreach ($response['ShippingSevicesArray'] as $k => $frete) {
            if (!$frete['Error'] && $frete['ServiceDescription'] == $tipoFrete) {
                $carrinho['frete'] = $frete['ShippingPrice'];
            }
        }
        $this->carrinho->save($carrinho);

        return $carrinho['frete'];
    }

}
