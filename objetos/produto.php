<?php
Class Produto{
    public $id;
    public $nomeProduto;
    public $precoProduto;
    public $descricaoProduto;
    public $quantidadeProduto;
    public $img;
    public $bd;

    public function __construct($bd){
        $this->bd = $bd;

    }
    public function lerTodos(){
        $sql = "SELECT * FROM produtos";
        $resultado = $this->bd->query($sql);
        $resultado->execute();

        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }
    public function pesquisarProduto($tipo, $valor) {
        if ($tipo == 'id') {
            $sql = "SELECT * FROM produtos WHERE id = :busca";
        } else if ($tipo == 'nome') {
            $sql = "SELECT * FROM produtos WHERE nome LIKE :busca";
            $valor = "%$valor%";
        } else {
            return null;
        }

        $resultado = $this->bd->prepare($sql);
        $resultado->bindParam(':busca', $valor);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastrarProduto(){
        $sql = "INSERT INTO produtos (nome, descricao, quantidade, preco) VALUES (:nome, :descricao, :quantidade, :preco)";
        $stmt = $this->bd->prepare($sql);

        $stmt->bindParam(":nome", $this->nomeProduto, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $this->descricaoProduto, PDO::PARAM_STR);
        $stmt->bindParam(":quantidade", $this->quantidadeProduto, PDO::PARAM_INT);
        $stmt->bindParam(":preco", $this->precoProduto);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function excluirProduto(){
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }


    }

    public function atualizarProduto(){
        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":nome", $this->idProduto, PDO::PARAM_STR);
        $stmt->bindParam(":nome", $this->nomeProduto, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $this->descricaoProduto, PDO::PARAM_STR);
        $stmt->bindParam(":preco", $this->precoProduto);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

        public function busca($id){
            $sql = "SELECT * FROM produtos WHERE id = :id";
            $resultado = $this->bd->prepare($sql);
            $resultado->bindParam(":id", $id);
            $resultado->execute();
            return $resultado->fetch(PDO::FETCH_OBJ);
        }

}