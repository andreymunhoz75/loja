<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "configs/database.php";
include_once "Funcionario.php";

Class FuncionarioController{
    private $bd;
    private $funcionario;
    private $img_name;

    public function __construct(){
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->funcionario = new Funcionario($this->bd);
    }
    
    public function index(){
        return $this->funcionario->lerTodos();
    }
    
    public function CadastrarFuncionario($dados, $arquivo){
        if(!$this->upload($arquivo)){
            $this->img_name = null;
        }

        $this->funcionario->nome_fun = $dados["nome_fun"];
        $this->funcionario->cpf = $dados["cpf"];
        $this->funcionario->endereco = $dados["endereco"];
        $this->funcionario->telefone = $dados["telefone"];
        $this->funcionario->funcao = $dados["funcao"];
        $this->funcionario->login_fun = $dados["login_fun"];
        $this->funcionario->senha_fun = password_hash($dados["senha_fun"], PASSWORD_DEFAULT);
        $this->funcionario->imagem_fun = $this->img_name;

        if($this->funcionario->cadastrarFuncionario()){
            header("location:painel_funcionario.php");
            exit();
        }
    }

    public function RegistrarExterno($dados, $arquivo){
        if(!$this->upload($arquivo)){
            $this->img_name = null;
        }

        $this->funcionario->nome_fun = $dados["nome_fun"];
        $this->funcionario->cpf = $dados["cpf"];
        $this->funcionario->endereco = $dados["endereco"];
        $this->funcionario->telefone = $dados["telefone"];
        $this->funcionario->funcao = $dados["funcao"];
        $this->funcionario->login_fun = $dados["login_fun"];
        $this->funcionario->senha_fun = password_hash($dados["senha_fun"], PASSWORD_DEFAULT);
        $this->funcionario->imagem_fun = $this->img_name;

        if($this->funcionario->cadastrarFuncionario()){
            header("location:login.php?sucesso=1");
            exit();
        }
    }
    
    public function ExcluirFuncionario($id){
        $this->funcionario->id = $id;

        if($this->funcionario->excluirFuncionario()){
            header("location:painel_funcionario.php");
            exit();
        }
    }

    public function AtualizarFuncionario($dados, $arquivo){
        if(!$this->upload($arquivo)){
            $this->img_name = $this->localizarFuncionario($dados["id"])->imagem_fun; // Mantém a imagem atual se ñ fizer upload de nova
        }

        $this->funcionario->id = $dados["id"];
        $this->funcionario->nome_fun = $dados["nome_fun"];
        $this->funcionario->cpf = $dados["cpf"];
        $this->funcionario->endereco = $dados["endereco"];
        $this->funcionario->telefone = $dados["telefone"];
        $this->funcionario->funcao = $dados["funcao"];
        $this->funcionario->login_fun = $dados["login_fun"];
        $this->funcionario->imagem_fun = $this->img_name;
        
        if(!empty($dados["senha_fun"])){
            $this->funcionario->senha_fun = password_hash($dados["senha_fun"], PASSWORD_DEFAULT);
        } else {
            $this->funcionario->senha_fun = "";
        }

        if($this->funcionario->atualizarFuncionario()){
            header("location:painel_funcionario.php");
            exit();
        }
    }

    public function localizarFuncionario($id){
        return $this->funcionario->busca($id);
    }

    public function login($login, $senha) {
        $user = $this->funcionario->autenticar($login, $senha);
        
        if ($user) {
            $_SESSION["funcionario_logado"] = true;
            $_SESSION["funcionario_id"] = $user->id;
            $_SESSION["funcionario_nome"] = $user->nome_fun;
            $_SESSION["funcionario_nivel"] = $user->funcao;
            return true;
        }
        return false;
    }

    public function logout() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function verificarAutenticacao() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["funcionario_logado"]) || $_SESSION["funcionario_logado"] !== true) {
            header("Location: login.php");
            exit();
        }
    }

    public function verificarAdmin() {
        $this->verificarAutenticacao();
        if ($_SESSION["funcionario_nivel"] !== 'admin') {
            die("Acesso negado. Apenas administradores podem acessar esta página.");
        }
    }

    public function verificarFuncionario() {
        $this->verificarAutenticacao();
        if ($_SESSION["funcionario_nivel"] === 'cliente') {
            die("Acesso negado. Clientes não podem gerenciar produtos.");
        }
    }

    public function upload($arquivo)
    {
        if (!isset($arquivo["name"]['fileToUpload']) || $arquivo["error"]['fileToUpload'] != UPLOAD_ERR_OK) {
            return false;
        }

        $target_dir = "uploads/";
        $uploadOk = 1;
        $target_file = $target_dir . $arquivo["name"]['fileToUpload'];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $random_name = uniqid('fun_', true) . '.' . $imageFileType;
        $this->img_name = $random_name;
        $upload_file = $target_dir . $random_name;

        $check = getimagesize($arquivo['tmp_name']['fileToUpload']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if (file_exists($upload_file)) {
            $uploadOk = 0;
        }

        if ($arquivo['size']['fileToUpload'] > 5000000) {
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($arquivo['tmp_name']['fileToUpload'], $upload_file)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>
