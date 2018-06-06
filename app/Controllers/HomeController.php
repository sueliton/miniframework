<?php

namespace App\Controllers;
use \Core\BaseController;
/**
 * @author Sueliton
 */
class HomeController extends BaseController{
    
    public function index() {
        $this->setPageTitle("Home");
        $this->view->nome = "Sueliton miguel";
        $this->renderView('home/index', 'layout');
    }

}
