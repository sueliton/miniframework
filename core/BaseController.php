<?php

namespace Core;

/**
 * @author Sueliton
 */
//calse pai de todos so controllers com metodos para renderizar views e etc..
abstract class BaseController {

    //vai virar um objeto para poder set manipulado posteriormente
    protected $view;
    private $viewPath;
    private $layoutPath;
    private $pageTitle = NULL;

    //pega uma classe vazia para que $view seja um objeto.
    public function __construct() {
        $this->view = new \stdClass;
    }

    /**
     * @param string $viewPath Caminho da view. 
     * @param string $layoutPath Caminho da layout.
     * @return View view referente ao caminho informado se passado apenas o viewPeth
     * se passado também o lyout será retornado o layout.
     */
    protected function renderView($viewPath, $layoutPath = null) {
        $this->viewPath = $viewPath;
        $this->layoutPath = $layoutPath;
        if ($layoutPath) {
            $this->layout();
        } else {
            $this->content();
        }
    }

    /**
     * Quem efetivamente vai ser chamado para renderizar a view no metódo renderView.
     */
    protected function content() {
        //verifica se o arquivo existe.
        if (file_exists(__DIR__ . "/../app/Views/" . $this->viewPath . ".phtml")) {
            require_once __DIR__ . "/../app/Views/" . $this->viewPath . ".phtml";
        } else {
            echo "Error: view not found";
        }
    }

    /**
     * Quem efetivamente vai ser chamado para renderizar o layout no metódo renderView.
     */
    protected function layout() {
        //verifica se o arquivo existe.
        if (file_exists(__DIR__ . "/../app/Views/" . $this->layoutPath . ".phtml")) {
            require_once __DIR__ . "/../app/Views/" . $this->layoutPath . ".phtml";
        } else {
            echo "Error: Layout path not found";
        }
    }
    
    /**
     * seta o titulo da página, esse titulo deve ser passado no controller que herdar essa classe.
     */
    protected function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
    }

    /**
     * seta o titulo da página, esse titulo deve ser passado na view que será chamado pelo controller.
     */
    protected function getPageTitle($separator =NULL) {
        if($separator){
            echo $this->pageTitle. " ". $separator. " ";
        }else{
            echo $this->pageTitle." ";
        }
    }
}
