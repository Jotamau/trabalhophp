<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
</head>
<body>
    <h1>Produtos Disponíveis</h1>
    
    <!-- Formulário de busca -->
    <form method="GET" action="listar_produtos.php">
        <input type="text" name="search" placeholder="Filtrar por descrição ou fabricante">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabela de produtos -->
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Fabricante</th>
                <th>Quantidade</th>
                <th>Preço de Custo</th>
                <th>Preço de Venda</th>
                <th>Imagem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conexão com o banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "loja";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Filtro de busca
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Consulta ao banco de dados
            $sql = "SELECT * FROM produto WHERE descricao LIKE '%$search%' OR fabricante LIKE '%$search%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['descricao'] . "</td>";
                    echo "<td>" . $row['fabricante'] . "</td>";
                    echo "<td>" . $row['qtd'] . "</td>";
                    echo "<td>R$ " . number_format($row['preco_custo'], 2, ',', '.') . "</td>";
                    echo "<td>R$ " . number_format($row['preco_venda'], 2, ',', '.') . "</td>";
                    echo "<td><img src='" . $row['imagem'] . "' alt='" . $row['descricao'] . "' width='100'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum produto encontrado.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <br>
    <a href="cadastrar.html">Cadastrar Novo Produto</a>
</body>
</html>
