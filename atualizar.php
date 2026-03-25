<?php
include_once("objetos/ProdutoController.php");

$controller = new ProdutoController();

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["alterar"])){
    $a = $controller->localizarProduto($_GET["alterar"]);
}elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["produto"])) {
    $a = $controller->atualizarProduto($_POST["produto"]);

}else {
    header("location: index.php");
}

?>


<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Prdouto</title>
</head>
<body>
<h1>Atualização de Produto</h1>
<a href="index.php">Voltar</a>

<form action="atualizar.php" method="post">
    <input type="text" name="produto[id_produto]" value="<?= $a->id_produto ?>" hidden>
    <label>Nome</label>
    <input type="text" name="produto[nome]" value="<?= $a->nome ?>"><br><br>
    <label>descricao</label>
    <input type="text" name="produto[descricao]" value="<?= $a->descricao ?>" ><br><br>
    <label>quantidade</label>
    <input type="text" name="produto[quantidade]" value="<?= $a->quantidade ?>" ><br><br>
    <label>preco</label>
    <input type="text" name="produto[preco]" value="<?= $a->preco ?>" ><br><br>

    <button name="atualizar">Atualizar</button>
</form>
</body>
</html>
