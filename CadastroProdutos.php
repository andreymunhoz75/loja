<?php
include_once("objetos/ProdutoController.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controller = new ProdutoController();

    if(isset($_POST["cadastrar"])){
        $a = $controller->cadastrarProduto($_POST["produto"]);
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Produto</title>
</head>
<body>
<h1>Cadastro de Produto</h1>
<a href="index.php">Voltar</a>

<form action="CadastroProdutos.php" method="post">
    <label>Nome</label>
    <input type="text" name="produto[nome]"><br><br>
    <label>Descrição</label>
    <input type="text" name="produto[descricao]"><br><br>
    <label>Quantidade</label>
    <input type="number" name="produto[quantidade]" min="1" step="1"><br><br>
    <label>Preço</label>
    <input type="number" name="produto[preco]" min="0" step="0.01"><br><br>

    <button name="cadastrar">Cadastrar</button>
</form>
</body>
</html>
