<?php

/**
 * @author Sueliton
 */

namespace App\Controllers;

use \Core\BaseController;
use \Core\Container;
use \Core\Redirect;

class PostsController extends BaseController {

    private $post;

    public function __construct() {
        //mantendo o construtor da classe pai.
        parent::__construct();
        $this->post = $model = Container::getModel('Post');
    }

    public function index() {
        //setando o titulo da página.
        $this->setPageTitle('Posts');
        //pegando todos os posts.
        $this->view->posts = $this->post->all();
        //renderizando a view post/index junto com o layout.
        $this->renderView('posts/index', 'layout');
    }

    public function show($id) {
        /**
         * O $this->view que é um obj vazio até então, agora recebe uma variável ->post que
         * recebe a resultado vindo do método find() em forma de um array de obj podendo 
         * assim ser acessado com o '->' como sendo um atributo do obj.  
         */
        $this->view->post = $this->post->find($id);
        //setando o título da página dinamicamente com o título guardado no banco.
        $this->setPageTitle("{$this->view->post->title}");
        //renderizando a view com o layout solicitado.
        $this->renderView('posts/show', 'layout');
    }

    public function create() {
        $this->setPageTitle('New post');
        $this->renderView('posts/create', 'layout');
    }

    //recebe o parametro request passado pela classe Router onde esse controller é efetivamente instanciado.
    //injetando aqui todos os parametros.
    public function store($request) {
        $data = [
            'title' => $request->post->title,
            'content' => $request->post->content
        ];

        if ($this->post->create($data)) {
            Redirect::route("/posts");
        } else {
            echo 'não pode ser salvo no momento';
        }
    }

    public function edit($id) {
        $this->view->post = $this->post->find($id);
        $this->setPageTitle('Edit Post' . $this->view->post->title);
        $this->renderView('posts/edit', 'layout');
    }

    public function update($id, $request) {   
        $data = [
            'title' => $request->post->title,
            'content' => $request->post->content
        ];

        if ($this->post->update($data, $id)) {
            Redirect::route("/posts");
        } else {
            echo 'Erro ao atualizar';
        }    
    }
    
    public function delete($id) {
        if ($this->post->delete($id)) {
            Redirect::route("/posts");
        } else {
            echo 'Erro ao excluir';
        }
    }

}
