<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

class Home extends BaseController {

    public function index() {
        return view('welcome_message');
    }

}
