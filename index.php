<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "objetos/FuncionarioController.php";
include_once "objetos/ProdutoController.php";

$controller = new ProdutoController();
$produtos = $controller->index();

$a = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["pesquisar"])) {
    $a = $controller->pesquisarProduto($_POST["tipo"], $_POST["pesquisar"]);
}

// Verifica se é administrador ou funcionário (comum).
// Se for "cliente", is_employee é falso e não tem acesso às ferramentas de edição.
$is_employee = isset($_SESSION["funcionario_logado"]) && ($_SESSION["funcionario_nivel"] === 'admin' || $_SESSION["funcionario_nivel"] === 'comum');
$is_admin = isset($_SESSION["funcionario_logado"]) && $_SESSION["funcionario_nivel"] === 'admin';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["excluir"])){
    if($is_employee) {
        $controller->excluirProduto($_GET["excluir"]);
    }
    header("Location: index.php");
    exit();
}

$carrinho_count = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Catálogo</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
</head>
<body>

<header class="main-header">
    <div class="logo">MINIMALIST.</div>
    
    <div class="search-container">
        <form method="POST" action="index.php" style="display: flex; width: 100%;">
            <input type="text" name="pesquisar" class="search-input" placeholder="O que você está procurando?">
            <input type="hidden" name="tipo" value="nome">
        </form>
    </div>
    
    <div class="header-actions">
        <a href="carrinho.php" class="btn-text">CARRINHO (<?= $carrinho_count; ?>)</a>
        
        <?php if ($is_employee): ?>
            <?php if ($is_admin): ?>
                <a href="painel_funcionario.php" class="btn-text">PAINEL GESTÃO</a>
            <?php endif; ?>
            <a href="CadastroProdutos.php" class="btn-text">NOVO PRODUTO</a>
        <?php endif; ?>

        <?php if (isset($_SESSION["funcionario_logado"]) && $_SESSION["funcionario_logado"] === true): ?>
            <a href="logout.php" class="btn-primary-small">SAIR</a>
        <?php else: ?>
            <a href="login.php" class="btn-primary-small">ENTRAR</a>
        <?php endif; ?>
    </div>
</header>

<main class="container">
    <?php if($a !== null): ?>
        <header class="section-header">
            <h1 class="page-title">Resultados da Busca</h1>
            <a href="index.php" class="btn-outline">Limpar Filtros</a>
        </header>

        <div class="product-grid">
            <?php if(count($a) > 0): ?>
                <?php foreach($a as $produto): ?>
                    <article class="product-card">
                        <div class="image-wrapper">
                            <a href="ver-produto.php?id_produto=<?= $produto->id_produto; ?>" style="display: contents;">
                                <?php if(empty($produto->imagem)): ?>
                                    <img src="imagens/Image-not-found.png" alt="Não encontrado">
                                <?php else: ?>
                                    <img src="uploads/<?= $produto->imagem; ?>" alt="<?= $produto->nome; ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="product-info">
                            <div class="product-name"><?= $produto->nome; ?></div>
                            <div class="product-price">R$ <?= number_format($produto->preco, 2, ',', '.'); ?></div>
                        </div>
                        <a href="carrinho_acoes.php?acao=add&id=<?= $produto->id_produto; ?>" class="buy-button" style="text-decoration: none;">COMPRAR AGORA</a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: span 4; text-align: center; color: var(--gray-600); padding: 80px 0;">Nenhum item encontrado.</p>
            <?php endif; ?>
        </div>
        <div style="margin-top: 80px; border-top: 1px solid var(--gray-100); padding-top: 80px;"></div>
    <?php endif; ?>

    <header class="section-header">
        <h1 class="page-title">Nosso Catálogo</h1>
        <p style="color: var(--gray-600);">O essencial para o seu espaço.</p>
    </header>

    <div class="product-grid">
        <?php if($produtos) : ?>
            <?php foreach($produtos as $produto) : ?>
                <article class="product-card">
                    <div class="image-wrapper">
                        <a href="ver-produto.php?id_produto=<?= $produto->id_produto; ?>" style="display: contents;">
                            <?php if(empty($produto->imagem)) : ?>
                                <img src="imagens/Image-not-found.png" alt="Sem imagem">
                            <?php else : ?>
                                <img src="uploads/<?= $produto->imagem; ?>" alt="<?= $produto->nome; ?>">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="product-info">
                        <div class="product-name"><?= $produto->nome; ?></div>
                        <div class="product-price">R$ <?= number_format($produto->preco, 2, ',', '.'); ?></div>
                        
                        <?php if($is_employee): ?>
                            <div style="margin-top: 10px; display: flex; gap: 12px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;">
                                <a href="atualizar.php?alterar=<?= $produto->id_produto?>" style="color: var(--gray-600);">Editar</a>
                                <a href="index.php?excluir=<?= $produto->id_produto?>" style="color: #ef4444;" onclick="return confirm('Deseja excluir?')">Excluir</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="carrinho_acoes.php?acao=add&id=<?= $produto->id_produto; ?>" class="buy-button" style="text-decoration: none;">COMPRAR AGORA</a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: span 4; text-align: center; color: var(--gray-600); padding: 80px 0;">Aguardando novos envios.</p>
        <?php endif;?>
    </div>
</main>

<footer class="main-footer">
    <div class="copyright">
        &copy; 2026 Minimalist Store. Pureza em cada detalhe.
    </div>
</footer>

</body>
</html>