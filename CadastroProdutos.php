<?php
include_once "objetos/FuncionarioController.php";
$funcController = new FuncionarioController();
$funcController->verificarFuncionario();

include_once "objetos/ProdutoController.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controller = new ProdutoController();

    if(isset($_POST["cadastrar"])){
        $a = $controller->CadastrarProduto($_POST["produto"], $_FILES["produto"]);
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Novo Produto</title>
    <link rel="stylesheet" href="minimalist_store.css?v=<?= time(); ?>">
</head>
<body>

<header class="main-header">
    <div class="logo">MINIMALIST.</div>
    <div class="header-actions">
        <a href="index.php" title="Voltar">⬅️</a>
        <a href="logout.php" title="Sair">🚪</a>
    </div>
</header>

<main class="container-sm">
    <div class="form-card">
        <h2>Adicionar ao Catálogo</h2>
        <form action="CadastroProdutos.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Título do Produto</label>
                <input type="text" name="produto[nome]" placeholder="Ex: Cadeira de Design Escandinavo" required>
            </div>
            
            <div class="form-group">
                <label>Descrição Minimalista</label>
                <textarea name="produto[descricao]" rows="3" placeholder="O essencial sobre este item..." required></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Estoque</label>
                    <input type="number" name="produto[quantidade]" value="1" min="1" required>
                </div>
                
                <div class="form-group">
                    <label>Preço Sugerido (R$)</label>
                    <input type="number" name="produto[preco]" placeholder="0,00" step="0.01" min="0" required>
                </div>
            </div>

            <div class="form-group" style="border-top: 1px solid var(--gray-100); padding-top: 20px;">
                <label style="color: var(--gray-900);">Fotografia do Produto</label>
                <input type="file" name="produto[fileToUpload]" required>
            </div>

            <button name="cadastrar" class="btn-buy" style="margin-top: 32px; padding: 16px; font-size: 14px; letter-spacing: 0.1em; width: 100%;">CADASTRAR ITEM</button>
            <div style="text-align: center; margin-top: 24px;">
                <a href="index.php" class="btn-outline" style="width: 100%;">CANCELAR</a>
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
