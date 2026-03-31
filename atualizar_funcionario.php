<?php
include_once "objetos/FuncionarioController.php";

$controller = new FuncionarioController();
$controller->verificarAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $controller->AtualizarFuncionario($_POST['funcionario'], $_FILES['funcionario']);
}

$funcionario = null;
if (isset($_GET['id'])) {
    $funcionario = $controller->localizarFuncionario($_GET['id']);
}

if (!$funcionario) {
    echo "Funcionário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atualizar Funcionário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Atualizar Dados do Funcionário</h1>
    <a href="painel_funcionario.php">Voltar ao Painel</a><br><br>
    
    <form action="atualizar_funcionario.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="funcionario[id]" value="<?= htmlspecialchars($funcionario->id) ?>">
        
        <label>Nome:</label><br>
        <input type="text" name="funcionario[nome_fun]" value="<?= htmlspecialchars($funcionario->nome_fun) ?>" required><br><br>

        <label>CPF:</label><br>
        <input type="text" name="funcionario[cpf]" maxlength="14" value="<?= htmlspecialchars($funcionario->cpf) ?>" required><br><br>

        <label>Endereço:</label><br>
        <input type="text" name="funcionario[endereco]" value="<?= htmlspecialchars($funcionario->endereco) ?>" required><br><br>

        <label>Telefone:</label><br>
        <input type="text" name="funcionario[telefone]" value="<?= htmlspecialchars($funcionario->telefone) ?>" required><br><br>
        
        <label>Login:</label><br>
        <input type="text" name="funcionario[login_fun]" value="<?= htmlspecialchars($funcionario->login_fun) ?>" required><br><br>
        
        <label>Nova Senha (deixe em branco para não alterar):</label><br>
        <input type="password" name="funcionario[senha_fun]"><br><br>
        
        <label>Função:</label><br>
        <select name="funcionario[funcao]">
            <option value="funcionario" <?= ($funcionario->funcao == 'funcionario') ? 'selected' : '' ?>>Funcionário</option>
            <option value="admin" <?= ($funcionario->funcao == 'admin') ? 'selected' : '' ?>>Administrador</option>
        </select><br><br>

        <label for="fileToUpload">Trocar Imagem (Opcional):</label><br>
        <input type="file" name="funcionario[fileToUpload]" id="fileToUpload"><br><br>
        
        <button type="submit" name="atualizar">Salvar Alterações</button>
    </form>
</body>
</html>
