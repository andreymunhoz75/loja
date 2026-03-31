<?php
include_once "objetos/FuncionarioController.php";

$controller = new FuncionarioController();
$controller->verificarAdmin(); // Apenas administradores podem cadastrar

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $controller->CadastrarFuncionario($_POST['funcionario'], $_FILES['funcionario']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastrar Novo Funcionário</h1>
    <a href="painel_funcionario.php">Voltar ao Painel</a><br><br>
    
    <form action="cadastro_funcionario.php" method="POST" enctype="multipart/form-data">
        <label>Nome:</label><br>
        <input type="text" name="funcionario[nome_fun]" required><br><br>

        <label>CPF:</label><br>
        <input type="text" name="funcionario[cpf]" maxlength="14" required><br><br>

        <label>Endereço:</label><br>
        <input type="text" name="funcionario[endereco]" required><br><br>

        <label>Telefone:</label><br>
        <input type="text" name="funcionario[telefone]" required><br><br>
        
        <label>Login:</label><br>
        <input type="text" name="funcionario[login_fun]" required><br><br>
        
        <label>Senha:</label><br>
        <input type="password" name="funcionario[senha_fun]" required><br><br>
        
        <label>Função:</label><br>
        <select name="funcionario[funcao]">
            <option value="funcionario">Funcionário</option>
            <option value="admin">Administrador</option>
        </select><br><br>

        <label for="fileToUpload">Selecionar Foto</label><br>
        <input type="file" name="funcionario[fileToUpload]" id="fileToUpload"><br><br>
        
        <button type="submit" name="cadastrar">Registrar Funcionário</button>
    </form>
</body>
</html>
