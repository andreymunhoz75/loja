<?php
include_once "configs/database.php";
include_once "produto.php";
Class ProdutoController{
    private $bd;
    private $produto;

    public function __construct(){
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->produto = new Produto($this->bd);
    }
    public function index(){
        return $this->produto->lerTodos();
    }
    public function pesquisarProduto($tipo, $valor){
        return $this->produto->pesquisarProduto($tipo, $valor);
    }
    public function CadastrarProduto($dados){
        $this->produto->nomeProduto = $dados["nome"];
        $this->produto->precoProduto = $dados["preco"];
        $this->produto->descricaoProduto = $dados["descricao"];
        $this->produto->quantidadeProduto = $dados["quantidade"];

        if($this->produto->cadastrarProduto()){
            header("location:index.php");
            exit();
        }
    }
    public function ExcluirProduto($id){
        $this->produto->id = $id;

        if($this->produto->excluirProduto()){
            header("location:index.php");
        }
    }

    public function AtualizarProduto($dados){
        $this->produto->id = $dados["id"];
        $this->produto->nomeProduto = $dados["nome"];
        $this->produto->precoProduto = $dados["preco"];
        $this->produto->descricaoProduto = $dados["descricao"];
        $this->produto->quantidadeProduto = $dados["quantidade"];

        if($this->produto->atualizarProduto()){
            header("location:index.php");
        }
    }

    public function localizarProduto($id){
        return $this->produto->busca($id);
    }
}