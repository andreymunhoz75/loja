<?php
Class Produto{
    public $id_produto;
    public $nomeProduto;
    public $precoProduto;
    public $descricaoProduto;
    public $quantidadeProduto;
    public $imagem;
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

        $sql = "INSERT INTO produtos (nome, descricao, quantidade, preco, imagem) VALUES (:nome, :descricao, :quantidade, :preco, :imagens)";
        $stmt = $this->bd->prepare($sql);

        $stmt->bindParam(":nome", $this->nomeProduto, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $this->descricaoProduto, PDO::PARAM_STR);
        $stmt->bindParam(":quantidade", $this->quantidadeProduto, PDO::PARAM_INT);
        $stmt->bindParam(":preco", $this->precoProduto);
        $stmt->bindParam(":imagens", $this->imagem, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function excluirProduto(){
        $sql = "DELETE FROM produtos WHERE id_produto = :id_produto";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":id_produto", $this->id_produto, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }


    }

    public function atualizarProduto(){
        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco , imagem = :imagem WHERE id_produto = :id_produto";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(":nome", $this->nomeProduto, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $this->descricaoProduto, PDO::PARAM_STR);
        $stmt->bindParam(":preco", $this->precoProduto);
        $stmt->bindParam(":id_produto", $this->id_produto);
        $stmt->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

        public function busca($id_produto){
            $sql = "SELECT * FROM produtos WHERE id_produto = :id_produto";
            $resultado = $this->bd->prepare($sql);
            $resultado->bindParam(":id_produto", $id_produto);
            $resultado->execute();
            return $resultado->fetch(PDO::FETCH_OBJ);
        }

}