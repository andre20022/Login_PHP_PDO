<?php
include_once "Operacoes.php";

class Processa
{

    private $html;

    public function __construct(){

      $this->html = file_get_contents("formulario.html");

      if(isset($_REQUEST["enviar"])){
      
         $this->validacao();

      }else{

         $this->html = str_replace("{mensagem}"," ",$this->html);
         print $this->html;

      }
     
    }
     public function validacao()
    {
      
            if($_REQUEST["codigo"] == "0"){

            if(empty($_REQUEST["nome"]) || strlen($_REQUEST["nome"]) < 5){

               $this->html = str_replace("{mensagem}","Preencha o campo Nome",$this->html);
               print $this->html;

            }elseif(empty($_REQUEST["email"]) || strlen($_REQUEST["email"]) < 10){

               $this->html = str_replace("{mensagem}","Preencha o campo E-mail",$this->html);
               print $this->html;

            }elseif(empty($_REQUEST["cpf"]) || strlen($_REQUEST["cpf"]) < 10){

               $this->html = str_replace("{mensagem}","Preencha o campo CPF",$this->html);
               print $this->html;

            }elseif(empty($_REQUEST["senha"]) || strlen($_REQUEST["senha"]) < 3){

               $this->html = str_replace("{mensagem}","Preencha o campo Senha",$this->html);
               print $this->html;

            }elseif(empty($_REQUEST["confirmaSenha"]) || strlen($_REQUEST["confirmaSenha"]) < 3){

               $this->html = str_replace("{mensagem}","Confirme sua Senha",$this->html);
               print $this->html;

            }elseif($_REQUEST["senha"] != $_REQUEST["confirmaSenha"]){

               $this->html = str_replace("{mensagem}","Digite as DUAS senhas iguais",$this->html);
               print $this->html;

            }else{

               $class = new Operacoes($_REQUEST);
               try{
                    $result = $class->existente();

                     if($result == true){

                        $result = $class->insert();

                           if($result == true){

                              $this->html = str_replace("{mensagem}","Usuario foi cadastrado com sucesso!",$this->html);
                              print $this->html;

                           }
                     }

                  }catch(Exception $e){

                        //EXEBI A EXCEÇÃO NA TELA DE LOGIN
                        $this->html = str_replace("{mensagem}", $e->getMessage(),$this->html);
                        print $this->html;   

                  }
            }

         }else{
            
            if(empty($_REQUEST["login"]) || strlen($_REQUEST["login"]) < 10){

               $this->html = str_replace("{mensagem}","Digite o login",$this->html);
               print $this->html;

            }elseif(empty($_REQUEST["senha"]) || strlen($_REQUEST["login"]) < 3){

               $this->html = str_replace("{mensagem}","Digite a senha do login",$this->html);
               print $this->html;

            }else{

                  try{
         
                  $class = new Operacoes($_REQUEST);
                  // RECEBE A EXCEÇÃO 
                  $class->select();

                  if($class->select() == true){

                     $class->logar();

                        if(isset($_SESSION["user"]) AND !empty($_SESSION["user"])){

                           $this->html = file_get_contents("logado.html");
                           $this->html = str_replace("{session}",$_SESSION["user"],$this->html);
                           print $this->html;

                        }

                  }

                  }catch(Exception $e){

                     //EXEBI A EXCEÇÃO NA TELA DE LOGIN
                     $this->html = str_replace("{mensagem}", $e->getMessage(),$this->html);
                     print $this->html;

                  }


            }

         }

    }
  

}

?>