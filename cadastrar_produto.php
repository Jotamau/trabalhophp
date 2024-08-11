<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descricao = $_POST["descricao"];
    $fabricante = $_POST["fabricante"];
    $qtd = $_POST["qtd"];
    $preco_custo = $_POST["preco_custo"];
    $preco_venda = $_POST["preco_venda"];
    $imagem = $_FILES["imagem"]["name"];

    $target_dir = "uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($imagem);

    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO produto (descricao, fabricante, qtd, preco_custo, preco_venda, imagem) 
                VALUES ('$descricao', '$fabricante', '$qtd', '$preco_custo', '$preco_venda', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Produto cadastrado com sucesso!";
            echo "<a href='listar_produtos.php'>Voltar para a lista de produtos</a>"; // Link para voltar à listagem
        
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload do arquivo.";
    }

    $conn->close();
}
?>
