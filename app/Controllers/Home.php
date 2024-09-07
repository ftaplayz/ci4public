<?php

namespace App\Controllers;
class Home extends BaseController{
    public function index(): string{
        return $this->loadDefaultView(['page' => 'home'], ['title' => 'Home', 'styles' => [base_url('css/menu.css'), base_url('css/home.css')]]);
    }
}
