<?php
include_once "objetos/FuncionarioController.php";

$erro = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["btn_entrar"])) {
    $controller = new FuncionarioController();
    $sucesso = $controller->login($_POST["login"], $_POST["senha"]);
    if ($sucesso) {
        header("Location: index.php");
        exit();
    } else {
        $erro = "Credenciais inválidas. Tente novamente.";
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Acesso</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
    <style>
        body {
            background-color: var(--gray-50);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>

<div class="form-card" style="width: 100%; max-width: 400px; padding: 40px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <div class="logo" style="margin-bottom: 24px; font-size: 1.5rem;">MINIMALIST.</div>
        <p style="color: var(--gray-600); font-size: 14px;">Identifique-se para continuar sua curadoria.</p>
    </div>

    <?php if(!empty($erro)): ?>
        <div style="background: #FEF2F2; color: #991B1B; padding: 12px; border-radius: 6px; font-size: 13px; text-align: center; margin-bottom: 24px; border: 1px solid #FCA5A5;">
            <?= $erro; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="form-group">
            <label>Usuário ou E-mail</label>
            <input type="text" name="login" placeholder="Ex: silva.art" required autofocus>
        </div>
        
        <div class="form-group">
            <label>Sua Senha</label>
            <input type="password" name="senha" placeholder="••••••••" required>
        </div>

        <button name="btn_entrar" class="btn-buy" style="margin-top: 10px; padding: 14px; width: 100%;">ENTRAR</button>
        
        <div style="text-align: center; margin-top: 32px; font-size: 13px;">
            <p style="color: var(--gray-600); margin-bottom: 8px;">Novo por aqui?</p>
            <a href="registrar.php" style="font-weight: 700; text-decoration: underline;">CRIAR UMA CONTA</a>
        </div>
    </form>
</div>

</body>
</html>
