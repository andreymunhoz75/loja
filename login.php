<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION["funcionario_logado"]) && $_SESSION["funcionario_logado"] === true) {
    header("Location: index.php");
    exit();
}

include_once "objetos/FuncionarioController.php";

$erro = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new FuncionarioController();
    $sucesso = $controller->login($_POST['login_fun'], $_POST['senha_fun']);
    if ($sucesso) {
        header("Location: index.php");
        exit();
    } else {
        $erro = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login do Sistema</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Login do Sistema</h1>
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <p style="color: green;">Conta criada com sucesso! Faça login abaixo.</p>
    <?php endif; ?>
    <?php if ($erro): ?>
        <p style="color: red;">Login ou senha inválidos.</p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label>Login:</label>
        <input type="text" name="login_fun" required><br><br>
        
        <label>Senha:</label>
        <input type="password" name="senha_fun" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>
    <br>
    <p>Não tem uma conta? <a href="registrar.php">Registre-se aqui</a></p>
</body>
</html>
