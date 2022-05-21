<?php
 
namespace App\Controllers\Front;
 
use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
 
class TrabalheConosco extends BaseController {
 
    public function index() {
 
        $sites = New SiteModel();
 
        foreach ($sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }
 
        $data = [
            'site' => SITESLUG, //Utilizado para identificar o css
            SITESLUG => 'active', //Utilizado para ativar a aba da marca no topo
            'linksite' => $rsSites, //Link do site, ver no _header o exemplo pra quando precisar direcionar para a outra marca
        ];
       
        return view('Front/TrabalheConosco/index', $data);
    }
 
}
