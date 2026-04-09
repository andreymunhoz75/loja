<?php
include_once "objetos/FuncionarioController.php";
$controller = new FuncionarioController();
$controller->verificarAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["atualizar"])) {
    // Passando dados e arquivos pro controller
    $sucesso = $controller->AtualizarFuncionario($_POST["funcionario"], $_FILES["funcionario"]);
    if($sucesso){
        header("Location: painel_funcionario.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["alterar"])) {
    $func = $controller->localizarFuncionario($_GET["alterar"]);
    if(!$func) {
        header("Location: painel_funcionario.php");
        exit();
    }
} else {
    header("Location: painel_funcionario.php");
    exit();
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Atualizar Funcionário</title>
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
        <h2>Editar Parceiro #<?= $func->id; ?></h2>
        <form action="atualizar_funcionario.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="funcionario[id]" value="<?= $func->id; ?>">
            
            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="funcionario[nome_fun]" value="<?= $func->nome_fun; ?>" required autofocus>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="funcionario[cpf]" value="<?= $func->cpf; ?>" required>
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" name="funcionario[telefone]" value="<?= $func->telefone; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Endereço</label>
                <input type="text" name="funcionario[endereco]" value="<?= $func->endereco; ?>" required>
            </div>

            <div class="form-group">
                <label>Nível de Acesso</label>
                <select name="funcionario[funcao]" required>
                    <option value="comum" <?= $func->funcao == 'comum' ? 'selected' : ''; ?>>Colaborador</option>
                    <option value="admin" <?= $func->funcao == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Login de Usuário</label>
                <input type="text" name="funcionario[login_fun]" value="<?= $func->login_fun; ?>" required>
            </div>

            <div class="form-group">
                <label>Alterar Senha (Opcional)</label>
                <input type="password" name="funcionario[senha_fun]" placeholder="Deixe vazio para manter...">
            </div>

            <div class="form-group" style="text-align: center; border-top: 1px solid var(--gray-100); padding-top: 15px;">
                <label>Foto de Perfil</label>
                <?php if(!empty($func->imagem_fun)): ?>
                    <img src="uploads/<?= $func->imagem_fun; ?>" style="max-height: 80px; border-radius: 40px; margin: 10px 0;">
                <?php endif; ?>
                <input type="file" name="funcionario[fileToUpload]">
            </div>

            <button name="atualizar" class="btn-buy" style="margin-top: 24px; width: 100%;">SALVAR ALTERAÇÕES</button>
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
