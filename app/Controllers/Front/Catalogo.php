<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\InfoSiteModel;

class Catalogo extends BaseController {

    public function index($fn) {
        
        $file =  'public/upload/catalogos/' . $fn;
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader('Content-Disposition: inline;', 'filename="' . $fn . '"');
        $this->response->setHeader('Content-Transfer-Encoding', 'binary');
        $this->response->setHeader('Content-Length: ' . filesize($file), '');
        $this->response->setHeader('Accept-Ranges:', 'bytes');
        readfile($file);
    }

}
