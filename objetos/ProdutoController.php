<?php
include_once "configs/database.php";
include_once "produto.php";

Class ProdutoController{
    private $bd;
    private $produto;
    private $img_name;

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
    public function CadastrarProduto($dados, $arquivo){

//        $temArquivo = isset($arquivo["name"]["fileToUpload"])
//            && $arquivo["name"]["fileToUpload"] !== ""
//            && isset($arquivo["erro"]["fileToUpload"])
//            && $arquivo["erro"]["fileToUpload"] === UPLOAD_ERR_OK;
//
//
//         if($temArquivo && !$this->upload($arquivo)){
//             return false;
//         }


         if(!$this->upload($arquivo)){
             return false;
         }

//         if(!$temArquivo){
//             $this->img_name = null;
//         }

        $this->produto->nomeProduto = $dados["nome"];
        $this->produto->precoProduto = $dados["preco"];
        $this->produto->descricaoProduto = $dados["descricao"];
        $this->produto->quantidadeProduto = $dados["quantidade"];
        $this->produto->imagem = $this->img_name;

        if($this->produto->cadastrarProduto()){
            header("location:index.php");
            exit();
        }
    }
    public function ExcluirProduto($id_produto){
        $this->produto->id_produto = $id_produto;

        if($this->produto->excluirProduto()){
            header("location:index.php");
            exit();
        }
    }

    public function AtualizarProduto($dados, $arquivo){

         if(!$this->upload($arquivo)){
             return false;
         }

        $this->produto->id_produto = $dados["id_produto"];
        $this->produto->nomeProduto = $dados["nome"];
        $this->produto->precoProduto = $dados["preco"];
        $this->produto->descricaoProduto = $dados["descricao"];
        $this->produto->quantidadeProduto = $dados["quantidade"];
        $this->produto->imagem = $this->img_name;

        if($this->produto->atualizarProduto()){
            header("location:index.php");
            exit();
        }

    }

    public function localizarProduto($id_produto){
        return $this->produto->busca($id_produto);
    }

    public function upload($arquivo)
    {
        if (!isset($arquivo['name']['fileToUpload']) || $arquivo['error']['fileToUpload'] === UPLOAD_ERR_NO_FILE) {
            $this->img_name = null;
            return true;
        }

        if ($arquivo['error']['fileToUpload'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $target_dir = "uploads/";
        $uploadOk = 1;
        $target_file = $target_dir . $arquivo["name"]['fileToUpload'];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $random_name = uniqid('img_', true) . '.' . pathinfo($arquivo['name']['fileToUpload'], PATHINFO_EXTENSION);
        $this->img_name = $random_name;
        $upload_file = $target_dir . $random_name;

        $check = getimagesize($arquivo['tmp_name']['fileToUpload']);

        if ($check !== false) {
            //echo "Imagem selecionada - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            // echo "O arquivo selecionado não é uma imagem.<br>";
            $uploadOk = 0;
        }

        // Verifica se o arquivo já existe na pasta
        if (file_exists($upload_file)) {
            // echo "O arquivo já existe no servidor.<br>";
            $uploadOk = 0;
        }

        // Verifica o tamanho do arquivo - Limite de 5MB
        if ($arquivo['size']['fileToUpload'] > 5000000) {
            //echo "Arquivo muito grande!<br>";

            $uploadOk = 0;
        }
        // Permite apenas determinados tipos de arquivo - jpg, png, jpeg e gif
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            //echo "São aceitas somente imagens JPG, JPEG, PNG e GIF.";

            $uploadOk = 0;
        }

        // Verificação de erros. Se $uploadOk=0 ocorreu algum erro
        if ($uploadOk == 0) {
          //  echo "Erro: não foi possível fazer upload.";

            return false;
            // Se não ocorreu problemas, tenta fazer upload
        } else {
            if (move_uploaded_file($arquivo['tmp_name']['fileToUpload'], $upload_file)) {
//              echo "Arquivo ". basename( $arquivo['full_path']['fileToUpload']) . " enviado.";
//              die();
                return true;
            } else {
//               echo "Erro ao enviar a imagem.";
//               die();
                return false;
            }
        }

        return false;
    }

    public function login($login, $senha){
        $this->aluno->login = $login;
        $this->aluno->senha = $senha;
        $this->aluno->login();
    }

}