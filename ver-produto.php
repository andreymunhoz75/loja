<?php
include_once "objetos/FuncionarioController.php";
$funcController = new FuncionarioController();
$funcController->verificarAutenticacao();

include_once("objetos/ProdutoController.php");


$controller = new ProdutoController();

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id_produto"])){
    $a = $controller->localizarProduto($_GET["id_produto"]);
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produto: <?= $a->nome ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>#<?= $a->id_produto ?> - <?= $a->nome ?></h1>
<a href="index.php">Voltar</a>
<p><strong>Descrição: </strong><?= $a->descricao ?></p>
<p><strong>Quantidade: </strong><?= $a->quantidade ?></p>
<p><strong>Preço: </strong><?= $a->preco ?></p>

<tr>
    <?php if($a->imagem == "") : ?>
        <td><img style="width: 40%;" src="imagens/Image-not-found.png"></td>
    <?php else : ?>
        <td><img style="width: 40%;" src="uploads/<?= $a->imagem; ?>"</td>
    <?php endif; ?>

</tr>

</body>
</html>
