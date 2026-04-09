<?php
include_once "objetos/FuncionarioController.php";
$controller = new FuncionarioController();
$controller->verificarAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["cadastrar"])) {
    $sucesso = $controller->CadastrarFuncionario($_POST["funcionario"], $_FILES["funcionario"]);
    if($sucesso){
        header("Location: painel_funcionario.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Novo Funcionário</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
</head>
<body>

<header class="main-header">
    <div class="logo">MINIMALIST.</div>
    <div class="header-actions">
        <a href="index.php" title="Voltar">⬅️</a>
        <a href="painel_funcionario.php" title="Gestão">⚙️</a>
        <a href="logout.php" title="Sair">🚪</a>
    </div>
</header>

<main class="container-sm">
    <div class="form-card">
        <h2>Cadastrar Parceiro</h2>
        <form action="cadastro_funcionario.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="funcionario[nome_fun]" placeholder="Ex: Lucas Gabriel" required autofocus>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="funcionario[cpf]" placeholder="000.000.000-00" required>
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="funcionario[telefone]" placeholder="(00) 00000-0000" required>
                </div>
            </div>

            <div class="form-group">
                <label>Endereço</label>
                <input type="text" name="funcionario[endereco]" placeholder="Rua..." required>
            </div>

            <div class="form-group">
                <label>Nível de Acesso</label>
                <select name="funcionario[funcao]" required>
                    <option value="comum">Colaborador (Padrão)</option>
                    <option value="admin">Administrador (Gestão)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Login de Usuário</label>
                <input type="text" name="funcionario[login_fun]" placeholder="Ex: lucas.gabriel" required>
            </div>
            
            <div class="form-group">
                <label>Senha Provisória</label>
                <input type="password" name="funcionario[senha_fun]" placeholder="Senha de segurança..." required>
            </div>

            <div class="form-group" style="border-top: 1px solid var(--gray-100); padding-top: 20px;">
                <label>Foto de Perfil</label>
                <input type="file" name="funcionario[fileToUpload]">
            </div>

            <button name="cadastrar" class="btn-buy" style="margin-top: 24px; width: 100%;">CADASTRAR FUNCIONÁRIO</button>
            <div style="text-align: center; margin-top: 24px;">
                <a href="painel_funcionario.php" class="btn-outline" style="width: 100%;">CANCELAR</a>
            </div>
        </form>
    </div>
</main>

<footer class="main-footer">
    <div class="copyright">
        &copy; 2026 Minimalist Store.
    </div>
</footer>

</body>
</html>
