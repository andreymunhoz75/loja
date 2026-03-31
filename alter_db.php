<?php
include_once "configs/database.php";

$banco = new Database();
$con = $banco->conectar();

$sql = "ALTER TABLE funcionario ADD COLUMN imagem_fun VARCHAR(255) NULL;";

try {
    $con->exec($sql);
    echo "Coluna imagem_fun adicionada ao banco com sucesso.\n";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "A coluna já existe.\n";
    } else {
        echo "Erro ao adicionar coluna: " . $e->getMessage() . "\n";
    }
}
?>
