<?php

spl_autoload_register(function($class){

    if(file_exists("classes/{$class}.php")){require_once "classes/{$class}.php";}

});

$classe = $_REQUEST["class"];
$metodo = isset($_REQUEST["metodo"])?$_REQUEST["metodo"]:null;

if(class_exists($classe)){

     $pagina = new $classe($_REQUEST); 
  
  if(!empty($metodo) AND method_exists($pagina,$metodo)){

     $pagina->$metodo($_POST);

  }

}



?>