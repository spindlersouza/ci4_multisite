<?php

namespace App\Controllers\Back;

use App\Controllers\BaseController;

class AuxUpload extends BaseController {

    public function uploadSummer() {
        helper(['form', 'url', 'filesystem']);
        $file = $this->request->getFile('file');
        $nName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/upload/editores', $nName);
        echo json_encode($nName);
        die();
    }

    public function deleteSummer() {
        
    }

}
