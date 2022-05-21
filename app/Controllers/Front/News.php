<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\Back\NewsModel;
use App\Models\Back\SiteModel;

class News extends BaseController {

    protected $news;

    public function __construct() {
        $this->news = new NewsModel();
    }

    public function save() {
        $validation = $this->validate([
            'nome' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nome obrigatorio',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[newsletter.email, newsletter.site_id, {id}]',
                'errors' => [
                    'required' => 'Email obrigatorio',
                    'valid_email' => 'Email Inválido',
                    'is_unique' => 'repetido'
                ],
            ],
        ]);
        if (!$validation) {
            echo json_encode($this->validator->getErrors());
        } else {
            $values = [
                'site_id' => $this->request->getPost('site_id'),
                'nome' => $this->request->getPost('nome'),
                'email' => $this->request->getPost('email'),
            ];
            $this->news->save($values);
            echo json_encode(['email' => 'cadastrado']);
        }
    }

}
