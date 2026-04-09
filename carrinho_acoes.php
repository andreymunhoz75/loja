<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($acao === 'add' && $id > 0) {
    // If product is already in cart, increment quantity
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]++;
    } else {
        // Add new product ID with quantity 1
        $_SESSION['carrinho'][$id] = 1;
    }
    // Redirect to cart page
    header("Location: carrinho.php");
    exit();
}

if ($acao === 'remover' && $id > 0) {
    // Remove item completely
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
    }
    header("Location: carrinho.php");
    exit();
}

if ($acao === 'limpar') {
    $_SESSION['carrinho'] = [];
    header("Location: carrinho.php");
    exit();
}

if ($acao === 'finalizar') {
    // For now, this just clears the cart and sets a success message
    $_SESSION['carrinho'] = [];
    $_SESSION['compra_sucesso'] = "Compra finalizada com sucesso! Agradecemos a preferência.";
    header("Location: carrinho.php");
    exit();
}

// Fallback
header("Location: index.php");
exit();
?>
