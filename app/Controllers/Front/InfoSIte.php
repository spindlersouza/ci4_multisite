<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\InfoSiteModel;

class InfoSite extends BaseController {

    protected $sites;
    protected $infoSite;

    public function __construct() {
        $this->infoSite = new InfoSiteModel();
        $this->sites = new SiteModel();
    }

    public function index($politica) {

        foreach ($this->sites->select('site, slug')->get()->getResult('array') as $row) {
            $rsSites[$row['slug']] = 'http://' . $row['site'];
        }

        $data = [
            'site' => SITESLUG,
            SITESLUG => 'active',
            'linksite' => $rsSites,
        ];

        return view('Front/InfoSite/index', $data);
    }

}
