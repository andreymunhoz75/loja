<?php
Class Funcionario{
    public $id;
    public $nome_fun;
    public $cpf;
    public $endereco;
    public $telefone;
    public $funcao;
    public $login_fun;
    public $senha_fun;
    public $imagem_fun;
    public $bd;

    public function __construct($bd){
        $this->bd = $bd;
    }

    public function lerTodos(){
        $sql = "SELECT id, nome_fun, cpf, endereco, telefone, funcao, login_fun, imagem_fun FROM funcionario";
        $resultado = $this->bd->query($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastrarFuncionario(){
        $sql = "INSERT INTO funcionario (nome_fun, cpf, endereco, telefone, funcao, login_fun, senha_fun, imagem_fun) 
                VALUES (:nome_fun, :cpf, :endereco, :telefone, :funcao, :login_fun, :senha_fun, :imagem_fun)";
        $stmt = $this->bd->prepare($sql);

        $stmt->bindParam(":nome_fun", $this->nome_fun, PDO::PARAM_STR);
        $stmt->bindParam(":cpf", $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(":funcao", $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(":login_fun", $this->login_fun, PDO::PARAM_STR);
        $stmt->bindParam(":senha_fun", $this->senha_fun, PDO::PARAM_STR);
        $stmt->bindParam(":imagem_fun", $this->imagem_fun, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function excluirFuncionario(){
        $sql = "DELETE FROM funcionario WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function atualizarFuncionario(){
        if(empty($this->senha_fun)) {
            $sql = "UPDATE funcionario SET nome_fun = :nome_fun, cpf = :cpf, endereco = :endereco, telefone = :telefone, funcao = :funcao, login_fun = :login_fun, imagem_fun = :imagem_fun WHERE id = :id";
        } else {
            $sql = "UPDATE funcionario SET nome_fun = :nome_fun, cpf = :cpf, endereco = :endereco, telefone = :telefone, funcao = :funcao, login_fun = :login_fun, senha_fun = :senha_fun, imagem_fun = :imagem_fun WHERE id = :id";
        }
        
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":nome_fun", $this->nome_fun, PDO::PARAM_STR);
        $stmt->bindParam(":cpf", $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(":funcao", $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(":login_fun", $this->login_fun, PDO::PARAM_STR);
        $stmt->bindParam(":imagem_fun", $this->imagem_fun, PDO::PARAM_STR);
        
        if(!empty($this->senha_fun)){
            $stmt->bindParam(":senha_fun", $this->senha_fun, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function busca($id){
        $sql = "SELECT id, nome_fun, cpf, endereco, telefone, funcao, login_fun, imagem_fun FROM funcionario WHERE id = :id";
        $resultado = $this->bd->prepare($sql);
        $resultado->bindParam(":id", $id, PDO::PARAM_INT);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_OBJ);
    }

    public function autenticar($login, $senha) {
        $sql = "SELECT id, nome_fun, funcao, senha_fun FROM funcionario WHERE login_fun = :login";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user && password_verify($senha, $user->senha_fun)) {
            return $user;
        }
        return false;
    }
}
?>
