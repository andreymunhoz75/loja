<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "objetos/ProdutoController.php";
$controller = new ProdutoController();

$carrinho_items = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$carrinho_count = count($carrinho_items);
$total = 0;

$produtos_no_carrinho = [];
foreach ($carrinho_items as $id => $qtd) {
    $produto = $controller->localizarProduto($id);
    if ($produto) {
        $produtos_no_carrinho[] = [
            'info' => $produto,
            'qtd' => $qtd,
            'subtotal' => $produto->preco * $qtd
        ];
        $total += ($produto->preco * $qtd);
    }
}

// Verifica se tem mensagem de sucesso
$mensagem_sucesso = '';
if (isset($_SESSION['compra_sucesso'])) {
    $mensagem_sucesso = $_SESSION['compra_sucesso'];
    unset($_SESSION['compra_sucesso']);
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Seu Carrinho</title>
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
        <!-- Espaço em branco no carrinho -->
    </div>
    
    <div class="header-actions">
        <a href="index.php" class="btn-text">CATÁLOGO</a>
        
        <?php if (isset($_SESSION["funcionario_logado"]) && $_SESSION["funcionario_logado"] === true): ?>
            <?php if ($_SESSION["funcionario_nivel"] === 'admin'): ?>
                <a href="painel_funcionario.php" class="btn-text">PAINEL GESTÃO</a>
            <?php endif; ?>
            <a href="logout.php" class="btn-primary-small">SAIR</a>
        <?php else: ?>
            <a href="login.php" class="btn-primary-small">ENTRAR</a>
        <?php endif; ?>
    </div>
</header>

<main class="container">
    <header class="section-header">
        <h1 class="page-title">Seu Carrinho</h1>
        <?php if($carrinho_count > 0): ?>
            <a href="carrinho_acoes.php?acao=limpar" class="btn-outline" style="color: #ef4444; border-color: #fca5a5;">Esvaziar Carrinho</a>
        <?php endif; ?>
    </header>

    <?php if(!empty($mensagem_sucesso)): ?>
        <div style="background: #ECFDF5; color: #065F46; padding: 20px; border-radius: 8px; font-size: 15px; text-align: center; margin-bottom: 40px; border: 1px solid #A7F3D0;">
            <p style="font-weight: 600; font-size: 18px; margin-bottom: 8px;">🎉 <?= $mensagem_sucesso; ?></p>
            <p>Seu pedido está sendo preparado com minimalismo e cuidado.</p>
        </div>
    <?php endif; ?>

    <?php if(empty($produtos_no_carrinho) && empty($mensagem_sucesso)): ?>
        <div style="text-align: center; padding: 100px 0;">
            <p style="font-size: 18px; color: var(--gray-600); margin-bottom: 24px;">Seu carrinho está vazio.</p>
            <a href="index.php" class="btn-buy" style="padding: 14px 28px; font-size: 14px; letter-spacing: 0.1em;">IR PARA O CATÁLOGO</a>
        </div>
    <?php elseif(!empty($produtos_no_carrinho)): ?>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 60px; align-items: start;">
            <!-- Lista de Produtos -->
            <div class="table-container">
                <table class="minimal-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th style="text-align: center;">Qtd</th>
                            <th style="text-align: right;">Subtotal</th>
                            <th style="width: 50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produtos_no_carrinho as $item): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <?php if(empty($item['info']->imagem)): ?>
                                            <div style="width: 60px; height: 60px; background: var(--gray-100); border-radius: 4px;"></div>
                                        <?php else: ?>
                                            <img src="uploads/<?= $item['info']->imagem; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <?php endif; ?>
                                        <div>
                                            <a href="ver-produto.php?id_produto=<?= $item['info']->id_produto; ?>" style="font-weight: 600; font-size: 14px; color: var(--gray-900);"><?= $item['info']->nome; ?></a>
                                            <div style="font-size: 12px; color: var(--gray-600); margin-top: 4px;">R$ <?= number_format($item['info']->preco, 2, ',', '.'); ?> cada</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: center; font-weight: 500;"><?= $item['qtd']; ?></td>
                                <td style="text-align: right; font-weight: 600;">R$ <?= number_format($item['subtotal'], 2, ',', '.'); ?></td>
                                <td style="text-align: center;">
                                    <a href="carrinho_acoes.php?acao=remover&id=<?= $item['info']->id_produto; ?>" title="Remover item" style="color: #ef4444; font-size: 16px;">&times;</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Resumo e Checkout -->
            <div class="form-card" style="padding: 32px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 24px; border-bottom: 1px solid var(--gray-100); padding-bottom: 16px;">Resumo do Pedido</h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 14px; color: var(--gray-600);">
                    <span>Subtotal (<?= array_sum(array_column($produtos_no_carrinho, 'qtd')); ?> itens)</span>
                    <span>R$ <?= number_format($total, 2, ',', '.'); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 24px; font-size: 14px; color: var(--gray-600);">
                    <span>Frete Sustentável</span>
                    <span style="color: #10B981; font-weight: 600;">Grátis</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 32px; font-size: 18px; font-weight: 700; border-top: 1px solid var(--gray-900); padding-top: 16px;">
                    <span>Total</span>
                    <span>R$ <?= number_format($total, 2, ',', '.'); ?></span>
                </div>

                <a href="carrinho_acoes.php?acao=finalizar" class="btn-buy" style="display: block; text-align: center; padding: 16px; font-size: 14px; letter-spacing: 0.1em; text-decoration: none;">FINALIZAR COMPRA</a>
                <p style="font-size: 11px; color: var(--gray-600); text-align: center; margin-top: 16px;">Pagamento seguro. Suas informações estão protegidas.</p>
            </div>
        </div>
    <?php endif; ?>
</main>

<footer class="main-footer">
    <div class="copyright">
        &copy; 2026 Minimalist Store. Pureza em cada detalhe.
    </div>
</footer>

</body>
</html>
