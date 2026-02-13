<?php
include_once "objetos/ProdutoController.php";

$controller = new ProdutoController();
$produtos = $controller->index();
global $produtos;

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja</title>
</head>
<body>

<h1>Loja do LUFE</h1>
<h2>Produtos cadastrados</h2>

<table>
    <tr>
        <td>ID</td>
        <td>Nome</td>
        <td>Descrição</td>
        <td>Quantidade</td>
        <td>Preço</td>
    </tr>
    <?php if($produtos) : ?>
        <?php foreach($produtos as $produto) : ?>
            <tr>
                <td><?php echo $produto->id_produto; ?></td>
                <td><?php echo $produto->nome; ?></td>
                <td><?php echo $produto->descricao; ?></td>
                <td><?php echo $produto->quantidade; ?></td>
                <td><?php echo $produto->preco; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif;?>
</table>


</body>
</html>