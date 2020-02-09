<?php

class Operacoes{

    private $nome;
    private $email;
    private $login;
    private $password;
    private $conn;
    private $cpf;

    
    public function __construct($dados){

        if(isset($_REQUEST["codigo"]) AND $_REQUEST["codigo"]== "1"){
        
        $this->setLogin($dados["login"]);
        $this->setPassword($dados["senha"]);

        }elseif(isset($_REQUEST["codigo"]) AND $_REQUEST["codigo"]== "0"){

        $this->setNome($dados["nome"]);
        $this->setEmail($dados["email"]);
        $this->setPassword($dados["senha"]);
        $this->setCpf($dados["cpf"]);

        }else{
            
            $this->logout();

        }

    }
    public function setNome($propriedade){

        $validacao = addslashes($propriedade);
        $validacao = trim($propriedade);
        $this->nome = $propriedade;
        
    }
    public function getNome(){

        return $this->nome;

    }
    public function setEmail($propriedade){

       $validacao = addslashes($propriedade);
       $validacao = trim($propriedade);
       $this->email = $propriedade;

    }
    public function getEmail(){

      return $this->email;  

    }
    public function setPassword($propriedade){

       //validação basica
        $validacao = addslashes($propriedade);  
        $validacao = trim($propriedade);
        $validacao = sha1($validacao);
        $this->password = $validacao;
 
     }
     public function getPassword(){
      
            return sha1($this->password);    
 
     }
     public function setCpf($propriedade){

        $validacao = addslashes($propriedade);
        $validacao = trim($propriedade);
        $this->cpf = $propriedade;

     }
     public function getCpf(){

        return $this->cpf;

     }
     public function setLogin($propriedade){

      //validação basica
      $validacao = addslashes($propriedade);
      $validacao = trim($propriedade);
      $this->login = $validacao;

   }
   public function getLogin(){

      return $this->login;

   }

   public function conexao(){

    try{

    $this->conn = new PDO('mysql:host=localhost;dbname=basilides','root','1234');
    $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){

        print "Erro encontrado ". $e->getMessage();

    }

    return $this->conn;

   }

   public function insert(){

    try{

        $insert = "INSERT INTO usuarios(nome,cpf,email,senha)VALUES(:nome,:cpf,:email,:senha);";
        $prepara = $this->conexao()->prepare($insert); 
        $prepara->BindValue(":nome",$this->getNome());
        $prepara->BindValue(":cpf",$this->getCpf());
        $prepara->BindValue(":email",$this->getEmail());
        $prepara->BindValue(":senha",$this->getPassword());
        $executa = $prepara->execute();

        return true;


    }catch(PDOException $e){

        print "Erro encontrado ". $e->getMessage();

    }

        
   }
   // METODO PARA VERIFICAR SE JA EXISTE O CADASTRO NO BANCO DO CADASTRO
   public function existente(){

    $select = "SELECT cpf,email FROM usuarios;";
    $prepara = $this->conexao()->prepare($select);
    $executa = $prepara->execute();
    $prepara = $prepara->fetch(PDO::FETCH_ASSOC);
    if($prepara["cpf"] == $this->getCpf() || $prepara["email"] == $this->getEmail()){

        // FAZ UMA EXÇÃO COM O RESULTADO RECEBIDO
        throw new Exception("Esses dados digitados no campo CPF ou E-MAIL já foram cadastrados");

     }else{

       return true;

     }


   }
   // METODO DE SELEÇÃO DO FORMULARIO DE LOGIN
   public function select(){    

    $select =  "SELECT DISTINCT * FROM usuarios WHERE :email IN(email,cpf) AND senha = :senha";
    $prepara = $this->conexao()->prepare($select); 
    $prepara->BindValue(":email",$this->getLogin());
    $prepara->BindValue(":senha",$this->getPassword());
    $executa = $prepara->execute();
    $prepara = $prepara->fetch(PDO::FETCH_ASSOC);

         if($prepara == null){

            // FAZ UMA EXÇÃO COM O RESULTADO RECEBIDO
            throw new Exception("Não foi possivel localizar seus dados {$this->getLogin()} seus dados digite novamente");

         }else{
             
           $this->setNome($prepara["nome"]);
           return true;

         }
    
    }
    public function logar(){

        session_start();
        $_SESSION["user"] = $this->getNome();

    }
    public function logout()
    {
        session_start();
        session_destroy();
        header("location:processa_classe.php?class=Processa");

    }


}
?>