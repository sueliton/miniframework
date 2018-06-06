<?php
/**
 * @author Sueliton
 */

namespace Core;

class Container {

    /**
     * @param type $controller
     * @return \Core\objController retorna um objeto do controller
     * esse metodo é chamado em classes dentro do diretório 'core' para gerenciar dependencias.
     */
    public static function newController($controller) {
        $objController = "App\\Controllers\\".$controller;
        return new $objController;
    }
    
    /**
     * @param String nome do model
     * @return Retorna um objeto model já configurado com o obj de conexão do PDO que todo Model precisa passar assim que é instanciado..
     * esse metodo é chamado em classes dentro do diretório 'core' para gerenciar dependencias.
     */
    public static function getModel($model) {
        $objModel = "\\App\\Models\\".$model;
        // a classe Database não p´recisa ser importada pois está no mesmo namespace que a classe Container
        return new $objModel(DataBase::getDatabase());
    }
    
    /**
     * @return Retorna a view 404.phtml
     * esse metodo é chamado na classe Router caso a rota informada não seja encontrada
     */
    public static function pageNotFound() {
        if(file_exists(__DIR__."/../App/Views/404.phtml")){
            require_once __DIR__."/../App/Views/404.phtml";   
        }else{
            echo 'Erro: 404 page not found';
        }
    }

}
