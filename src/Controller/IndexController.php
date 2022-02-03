<?php

namespace App\Controller;

class IndexController extends Controller{
    public function show() {
        $this->render('index.twig');
    }
}