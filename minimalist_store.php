<?php
include_once "objetos/FuncionarioController.php";
$funcController = new FuncionarioController();
// $funcController->verificarAutenticacao(); // Optional for public view

include_once "objetos/ProdutoController.php";
$controller = new ProdutoController();
$produtos = $controller->index();
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Curadoria de Produtos</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
</head>
<body>

<header class="main-header">
    <div class="logo">MINIMALIST.</div>
    
    <div class="search-container">
        <input type="text" class="search-input" placeholder="O que você está procurando?">
    </div>
    
    <div class="header-actions">
        <a href="#" title="Perfil">👤</a>
        <a href="#" title="Carrinho">🛒</a>
    </div>
</header>

<main class="container">
    <header class="page-header">
        <h1 class="page-title">Todos os Produtos</h1>
    </header>

    <div class="product-grid">
        <?php if($produtos) : ?>
            <?php foreach($produtos as $produto) : ?>
                <article class="product-card">
                    <div class="image-wrapper">
                        <?php if(empty($produto->imagem)) : ?>
                            <img src="imagens/Image-not-found.png" alt="Não encontrado">
                        <?php else : ?>
                            <img src="uploads/<?= $produto->imagem; ?>" alt="<?= $produto->nome; ?>">
                        <?php endif; ?>
                        
                        <div class="buy-button">ADICIONAR AO CARRINHO</div>
                    </div>
                    
                    <div class="product-info">
                        <div class="product-name"><?= $produto->nome; ?></div>
                        <div class="product-price">R$ <?= number_format($produto->preco, 2, ',', '.'); ?></div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Nenhum produto em estoque.</p>
        <?php endif; ?>
    </div>
</main>

<footer class="main-footer">
    <div class="footer-grid">
        <div class="footer-col">
            <h4>Institucional</h4>
            <ul>
                <li><a href="#">Quem Somos</a></li>
                <li><a href="#">Ética e Sustentabilidade</a></li>
                <li><a href="#">Carreiras</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Ajuda</h4>
            <ul>
                <li><a href="#">Dúvidas Frequentes</a></li>
                <li><a href="#">Política de Trocas</a></li>
                <li><a href="#">Acompanhar Pedido</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Contato</h4>
            <ul>
                <li><a href="#">suporte@minimalist.com.br</a></li>
                <li><a href="#">(11) 99999-9999</a></li>
                <li><a href="#">WhatsApp</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Redes Sociais</h4>
            <ul>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">Pinterest</a></li>
                <li><a href="#">LinkedIn</a></li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        &copy; 2026 Minimalist Store. Todos os direitos reservados.
    </div>
</footer>

</body>
</html>
