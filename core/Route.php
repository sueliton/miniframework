<?php
/**
 * @author Sueliton
 */

namespace Core;

class Route {

    private $routes;

    //conseguimos trazer pra classe o array das rotas configuradas.
    public function __construct(array $routes) {
        $this->setRoutes($routes);
        $this->run();
    }

    //recebe as rotas e set ela para o objeto poder utilizalas.
    //@return array com todas as urls da chamada, controller e metodo/acao.
    private function setRoutes($routes) {
        foreach ($routes as $route) {
            $expplode = explode('@', $route[1]);
            $r = [$route[0], $expplode[0], $expplode[1]];
            $newRoutes[] = $r;
        }
        $this->routes = $newRoutes;
    }

    //trata as requisiçõe do tipo get ou post.
    //essa classe router for solicitada o método quer dizer que houve uma requisição.
    //essa requisição será pega e devolvida em forma de um objeto para o ocntrole fazendo
    // com que ele possa acessar os dados da requisição em qualquer controller, já que 
    //o controller é instanciado nessa classe.
    private function getRequest() {
        //classe  vazia, para que possamos iniciar um objeto vazio.
        $obj = new \stdClass;
        foreach ($_GET as $key => $value){
            @$obj->get->$key = $value;
        }
        foreach ($_POST as $key => $value){
            @$obj->post->$key = $value;
        }
        return $obj;
    }


    private function getURL() {
        //parse_url() retorna uma matriz com vários componentes que estão na URL.
        //$_SERVER['REQUEST_URI'] captura oque o usuário digitou
        //PHP_URL_PATH seta o indice que deseja pegar no array.
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    //responsável por chama tudo na classe.
    private function run() {
        $url = $this->getURL();
        $urlArray = explode('/', $url);

        foreach ($this->routes as $route) {
            //pegat apenas o indices 0 do array de rotas, explode o valor contido nele.
            $routeArray = explode('/', $route[0]);
            $param = [];
            for ($i = 0; $i < count($routeArray); $i++) {
                //se o existir '{' na posição atual do array e os arrays forem do mesmo tamanho.
                if ((strpos($routeArray[$i], "{") !== false) && (count($urlArray)) == count($routeArray)) {
                    $routeArray[$i] = $urlArray[$i];
                    $param[] = $urlArray[$i];
                }
                //as rotas tem um array de 2 posições pscão[0] contem a rota e psção[1] contém o o nome do controller e nome da ação.
                $route[0] = implode($routeArray, '/');
            }
            
            //se a rota existir found recebe TRUE e poderá mais a frente ser redirecionada.
            if ($url == $route[0]) {
                $found = true;
                $controller = $route[1];
                $action = $route[2];
                break;
            }
        }
        
        //se $found foi setada e recebeu trueinstancia o controller e redireciona, caso ontrário página não encontrada.
        if (isset($found)) {
            $controller = Container::newController($controller);
            switch (count($param)) {
                case 1:
                    //$action é substituida pelo nome que virá da rota quebrada $controller->$action = $controller->show
                    $controller->$action($param[0], $this->getRequest());
                    break;
                case 2:
                    $controller->$action($param[0], $param[1], $this->getRequest());
                    break;
                case 3:
                    $controller->$action($param[0], $param[1], $param[2], $this->getRequest());
                    break;
                default:
                    $controller->$action($this->getRequest());
                    break;
            }
        } else {
            Container::pageNotFound();
        }
    }

}
