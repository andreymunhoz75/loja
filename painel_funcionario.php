<?php
include_once "objetos/FuncionarioController.php";
$controller = new FuncionarioController();
$controller->verificarAdmin();

$funcionarios = $controller->index();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["excluir"])) {
    $controller->ExcluirFuncionario($_GET["excluir"]);
    header("Location: painel_funcionario.php");
    exit();
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Gestão de Pessoas</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
</head>
<body>

<header class="main-header">
    <div class="logo">MINIMALIST.</div>
    <div class="header-actions">
        <a href="index.php" class="btn-text">CATÁLOGO</a>
        <a href="logout.php" class="btn-primary-small">SAIR</a>
    </div>
</header>

<main class="container">
    <div class="section-header" style="margin-bottom: 48px;">
        <h1 class="page-title">Gestão de Pessoas</h1>
        <a href="cadastro_funcionario.php" class="btn-buy" style="width: auto; padding: 12px 24px; font-size: 13px;">➕ NOVO FUNCIONÁRIO</a>
    </div>

    <div class="table-container">
        <table class="minimal-table">
            <thead>
                <tr>
                    <th>Identificação</th>
                    <th>Nome Completo</th>
                    <th>CPF</th>
                    <th>Função / Nível</th>
                    <th>Ações Disponíveis</th>
                </tr>
            </thead>
            <tbody>
                <?php if($funcionarios): ?>
                    <?php foreach($funcionarios as $func): ?>
                        <tr>
                            <td style="color: var(--gray-600); font-size: 11px;">#00<?= $func->id; ?></td>
                            <td style="font-weight: 500; font-size: 14px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <?php if(!empty($func->imagem_fun)): ?>
                                        <img src="uploads/<?= $func->imagem_fun; ?>" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                    <?php endif; ?>
                                    <?= $func->nome_fun; ?>
                                </div>
                            </td>
                            <td style="color: var(--gray-600);"><?= $func->cpf; ?></td>
                            <td>
                                <span style="font-size: 11px; font-weight: 600; text-transform: uppercase; padding: 4px 8px; border-radius: 4px; background: #EEE; color: <?= $func->funcao == 'admin' ? '#ef4444' : 'var(--gray-600)'; ?>;">
                                    <?= $func->funcao; ?>
                                </span>
                            </td>
                            <td style="display: flex; gap: 20px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em;">
                                <a href="atualizar_funcionario.php?alterar=<?= $func->id; ?>" style="color: var(--gray-900);">Editar</a>
                                <a href="painel_funcionario.php?excluir=<?= $func->id; ?>" style="color: #ef4444;" onclick="return confirm('Deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px; color: var(--gray-600);">Sem registros ativos no sistema.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 48px;">
        <a href="index.php" class="btn-outline">Voltar ao Catálogo de Produtos</a>
    </div>
</main>

<footer class="main-footer">
    <div class="copyright">
        &copy; 2026 Minimalist Store.
    </div>
</footer>

</body>
</html>
