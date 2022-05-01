<?php
// abrir a sessao

use core\classes\Database;
//Inicia uma sessão
session_start();
//Carregar o config
require_once('../config.php');
//Carrega todas as classes do projeto
require_once('../vendor/autoload.php');

?>