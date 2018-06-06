<?php

/**
 * @author Sueliton
 */

namespace App\Models;
use Core\BaseModel;

class Post extends BaseModel{
    /*
     * passa o nome da tabela. Esse nome já vai está setado quando for instanciado na classe Container
     * restando apenas passar o objeto PDO com a conexão. 
     */
    protected $table = "posts";
}
