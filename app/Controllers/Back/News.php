<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;
use App\Models\Back\SiteModel;
use App\Models\Back\NewsModel;

class News extends BaseController {

    protected $news;
    protected $sites;

    public function __construct() {
        helper(['url', 'form']);
        $this->news = new NewsModel();
        $this->sites = new SiteModel();
    }

    public function index() {

        $data['news'] = $this->news->select('newsletter.id, newsletter.nome, newsletter.email, site.slug AS site')->
                        join('site', 'site.id = newsletter.site_id')->
                        get()->getResult('array');
        echo view('Back/News/index', $data);
    }

}
