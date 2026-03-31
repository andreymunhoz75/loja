<?php
include_once "objetos/FuncionarioController.php";

$controller = new FuncionarioController();
$controller->verificarAdmin();

$funcionarios = $controller->index();
$eh_admin = (isset($_SESSION['funcionario_nivel']) && $_SESSION['funcionario_nivel'] === 'admin');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['excluir']) && $eh_admin) {
    $controller->ExcluirFuncionario($_GET['excluir']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel de Gerenciamento de Funcionários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Painel de Gerenciamento de Funcionários</h1>
    <p>Bem-vindo, <?= htmlspecialchars($_SESSION['funcionario_nome'] ?? '') ?> (Função: <?= htmlspecialchars($_SESSION['funcionario_nivel'] ?? '') ?>)</p>
    
    <a href="index.php">Ir para a Loja</a> | 
    <a href="logout.php">Sair</a>
    <br><br>

    <?php if ($eh_admin): ?>
        <a href="cadastro_funcionario.php">Cadastrar Novo Funcionário</a><br><br>
    <?php endif; ?>

    <h2>Lista de Funcionários</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Função</th>
            <th>Login</th>
            <?php if ($eh_admin): ?>
                <th>Ações</th>
            <?php endif; ?>
        </tr>
        <?php if ($funcionarios): ?>
            <?php foreach ($funcionarios as $func): ?>
                <tr>
                    <td><?= htmlspecialchars($func->id) ?></td>
                    <td>
                        <?php if(empty($func->imagem_fun)) : ?>
                            <img style="width: 50px; height: 50px; object-fit: cover;" src="imagens/Image-not-found.png">
                        <?php else : ?>
                            <img style="width: 50px; height: 50px; object-fit: cover;" src="uploads/<?= htmlspecialchars($func->imagem_fun); ?>">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($func->nome_fun) ?></td>
                    <td><?= htmlspecialchars($func->cpf) ?></td>
                    <td><?= htmlspecialchars($func->endereco) ?></td>
                    <td><?= htmlspecialchars($func->telefone) ?></td>
                    <td><?= htmlspecialchars($func->funcao) ?></td>
                    <td><?= htmlspecialchars($func->login_fun) ?></td>
                    <?php if ($eh_admin): ?>
                        <td>
                            <a href="atualizar_funcionario.php?id=<?= $func->id ?>">Alterar</a>
                            | 
                            <a href="painel_funcionario.php?excluir=<?= $func->id ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">Nenhum funcionário encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
