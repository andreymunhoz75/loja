<?php
include_once "objetos/FuncionarioController.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_registrar"])) {
    $controller = new FuncionarioController();
    // Passando os dois argumentos necessários (dados do form e array de arquivos)
    $controller->RegistrarExterno($_POST["funcionario"], $_FILES["funcionario"]);
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Cadastro</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
    <style>
        body {
            background-color: var(--gray-50);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="form-card" style="width: 100%; max-width: 500px; padding: 40px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <div class="logo" style="margin-bottom: 24px; font-size: 1.5rem;">MINIMALIST.</div>
        <p style="color: var(--gray-600); font-size: 14px;">Crie sua conta para acessar nossa curadoria exclusiva.</p>
    </div>

    <form method="post" action="registrar.php" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nome Completo</label>
            <input type="text" name="funcionario[nome_fun]" placeholder="Como te chamamos?" required autofocus>
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
            <input type="text" name="funcionario[endereco]" placeholder="Sua localização..." required>
        </div>

        <input type="hidden" name="funcionario[funcao]" value="cliente">
        
        <div class="form-group">
            <label>Defina seu Login</label>
            <input type="text" name="funcionario[login_fun]" placeholder="Nome de usuário..." required>
        </div>
        
        <div class="form-group">
            <label>Sua Senha</label>
            <input type="password" name="funcionario[senha_fun]" placeholder="Escolha uma senha forte..." required>
        </div>

        <div class="form-group" style="border-top: 1px solid var(--gray-100); padding-top: 20px;">
            <label>Foto de Perfil (Opcional)</label>
            <input type="file" name="funcionario[fileToUpload]">
        </div>

        <button name="btn_registrar" class="btn-buy" style="margin-top: 10px; padding: 14px; width: 100%;">CRIAR CONTA</button>
        
        <div style="text-align: center; margin-top: 32px; font-size: 13px;">
            <p style="color: var(--gray-600); margin-bottom: 8px;">Já tem uma conta?</p>
            <a href="login.php" style="font-weight: 700; text-decoration: underline;">FAZER LOGIN</a>
        </div>
    </form>
</div>

</body>
</html>
