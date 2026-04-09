<?php
include_once "objetos/FuncionarioController.php";
$funcController = new FuncionarioController();
$funcController->verificarFuncionario();

include_once("objetos/ProdutoController.php");
$controller = new ProdutoController();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST["atualizar"])){
        $id = $_POST["produto"]["id_produto"];
        $sucesso = $controller->AtualizarProduto($_POST["produto"], $_FILES["produto"]);
        if($sucesso) {
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar produto.');</script>";
            $produto = $controller->localizarProduto($id);
        }
    }
}

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["alterar"])){
    $produto = $controller->localizarProduto($_GET["alterar"]);
    if(!$produto) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minimalist Store | Atualizar Produto</title>
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
        <h2>Editar Item #<?= $produto->id_produto; ?></h2>
        <form action="atualizar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="produto[id_produto]" value="<?= $produto->id_produto; ?>">
            
            <div class="form-group">
                <label>Título do Produto</label>
                <input type="text" name="produto[nome]" value="<?= $produto->nome; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Descrição Minimalista</label>
                <textarea name="produto[descricao]" rows="3" required><?= $produto->descricao; ?></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Estoque</label>
                    <input type="number" name="produto[quantidade]" value="<?= $produto->quantidade; ?>" min="0" required>
                </div>
                
                <div class="form-group">
                    <label>Preço Sugerido (R$)</label>
                    <input type="number" name="produto[preco]" value="<?= $produto->preco; ?>" step="0.01" min="0" required>
                </div>
            </div>

            <div class="form-group" style="text-align: center; border-top: 1px solid var(--gray-100); padding-top: 20px;">
                <label>Fotografia Atual</label>
                <img src="uploads/<?= $produto->imagem; ?>" style="max-height: 120px; border-radius: 6px; margin: 15px 0;">
                <input type="file" name="produto[fileToUpload]" id="fileToUpload">
            </div>

            <button name="atualizar" class="btn-buy" style="margin-top: 32px; padding: 16px; font-size: 14px; letter-spacing: 0.1em; width: 100%;">SALVAR ALTERAÇÕES</button>
            <div style="text-align: center; margin-top: 24px;">
                <a href="index.php" class="btn-outline" style="width: 100%;">DESCATAR</a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
