<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "objetos/FuncionarioController.php";
include_once "objetos/ProdutoController.php";

$controller = new ProdutoController();

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["id_produto"])){
    $produto = $controller->localizarProduto($_GET["id_produto"]);
    if(!$produto) {
        header("Location: index.php");
        exit();
    }
} else {
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
    <title>Minimalist Store | <?= $produto->nome; ?></title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
    <style>
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-actions a {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .btn-text {
            color: var(--gray-600);
            padding: 8px 12px;
        }
        .btn-text:hover {
            color: var(--gray-900);
        }
        .btn-primary-small {
            background: var(--gray-900);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 4px;
        }
        .btn-primary-small:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<header class="main-header">
    <div class="logo">
        <a href="index.php" style="color: inherit;">MINIMALIST.</a>
    </div>
    
    <div class="search-container">
        <!-- Espaço em branco no ver produto -->
    </div>
    
    <div class="header-actions">
        <a href="index.php" class="btn-text">CATÁLOGO</a>
        <a href="carrinho.php" class="btn-text">CARRINHO (<?= $carrinho_count; ?>)</a>
        
        <?php if (isset($_SESSION["funcionario_logado"]) && $_SESSION["funcionario_logado"] === true): ?>
            <a href="logout.php" class="btn-primary-small">SAIR</a>
        <?php else: ?>
            <a href="login.php" class="btn-primary-small">ENTRAR</a>
        <?php endif; ?>
    </div>
</header>

<main class="container">
    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 80px; align-items: start;">
        <div class="image-wrapper" style="aspect-ratio: auto; min-height: 500px; background: #FFF;">
            <?php if(empty($produto->imagem)) : ?>
                <img src="imagens/Image-not-found.png" alt="Sem imagem">
            <?php else : ?>
                <img src="uploads/<?= $produto->imagem; ?>" alt="<?= $produto->nome; ?>" style="width: 100%; object-fit: contain;">
            <?php endif; ?>
        </div>
        
        <div style="padding-top: 40px;">
            <p style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--gray-600); margin-bottom: 24px;">CÓDIGO #<?= $produto->id_produto; ?></p>
            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 12px; line-height: 1.1;"><?= $produto->nome; ?></h1>
            <div style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 40px;">R$ <?= number_format($produto->preco, 2, ',', '.'); ?></div>
            
            <div style="margin-bottom: 40px; border-top: 1px solid var(--gray-100); padding-top: 40px;">
                <p style="font-size: 16px; color: var(--gray-600); line-height: 1.8;"><?= nl2br($produto->descricao); ?></p>
            </div>
            
            <div style="margin-bottom: 40px; background: var(--gray-50); padding: 20px; border-radius: var(--radius);">
                <p style="font-size: 14px; font-weight: 500;">📦 Em estoque: <strong><?= $produto->quantidade; ?> unidades</strong></p>
                <p style="font-size: 13px; color: var(--gray-600); margin-top: 8px;">Envio imediato com embalagem sustentável.</p>
            </div>

            <form action="carrinho_acoes.php" method="GET">
                <input type="hidden" name="acao" value="add">
                <input type="hidden" name="id" value="<?= $produto->id_produto; ?>">
                <button type="submit" class="btn-buy" style="padding: 18px; font-size: 14px; letter-spacing: 0.1em; width: 100%; border: none; cursor: pointer;">ADICIONAR AO CARRINHO</button>
            </form>
            
            <div style="text-align: center; margin-top: 24px;">
                <a href="index.php" class="btn-outline" style="width: 100%;">VOLTAR AO CATÁLOGO</a>
            </div>
        </div>
    </div>
</main>

<footer class="main-footer">
    <div class="copyright">
        &copy; 2026 Minimalist Store.
    </div>
</footer>

</body>
</html>
