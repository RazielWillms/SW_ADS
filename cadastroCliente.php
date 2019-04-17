<estiloTitle>
    <?php
    require_once "style.php";
    session_start();
    if (session_id() == null || !isset($_SESSION['nome_cliente'])) {
        ?>
        <body>
        <ul>
            <li><a href="menu.php">Home</a></li>
        </ul>
        </body>
        <?php
        die('Usuário não logado!');

    }
    ?>
</estiloTitle>
<html>
<title>
    COMPRA INGRESSO
</title>
<body>
<ul>
    <li><a href="menu.php">Home</a></li>
</ul>
</body>
<head>
    <estiloTitle>
        Compra do Ingresso<br><br>
    </estiloTitle>
</head>
</html>

<?php
require_once "style.php";
require_once "funcoesEvento.php";

$pdo = new PDO("mysql:host=localhost:3306; dbname=RockinRS;charset=latin1", 'root', '');

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$atualizarID = filter_input(INPUT_GET, 'atualizarID', FILTER_VALIDATE_INT);
$deletarID = filter_input(INPUT_GET, 'deletarID', FILTER_VALIDATE_INT);

// exibe cadastro e listagem
if (empty($atualizarID) && empty($deletarID) && empty($action)) {
    formingresso($pdo);
    listarIngresso($pdo);
}

//cadastro
if (empty($atualizarID) && empty($deletarID) && $action == 'Cadastrar') {

    $idcliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    $idingresso = filter_input(INPUT_POST, 'id_tipo_ingresso', FILTER_VALIDATE_INT);
    $volumeingresso = filter_input(INPUT_POST, 'volume_ingresso', FILTER_VALIDATE_INT);

    //inserção BD
    $comandoSQL = "INSERT INTO Tipo_Ingresso_Cliente(id_tipo_ingresso, id_cliente, volume_ingresso)
                    VALUES('$idingresso', '$idcliente', ' $volumeingresso');";

    $pdo->exec($comandoSQL);


    formingresso($pdo);
    listarIngresso($pdo);
}

//apagar
if (empty($atualizarID) && !empty($deletarID) && empty($action)) {
    //delete BD
    $comandoSQL = "delete from Tipo_Ingresso_Cliente where id_tipo_ingresso_cliente = $deletarID;";
    $totalPagados = $pdo->exec($comandoSQL);

    formingresso($pdo);
    listarIngresso($pdo);
}

// exibe opção de atualizar no formulário
if (!empty($atualizarID) && empty($deletarID) && empty($action)) {

    $IngressoArray = consultarIngresso($pdo, $atualizarID);

    if (is_array($IngressoArray) && count($IngressoArray) > 0) {
        $idcliente = $IngressoArray[0]['id_cliente'];
        $idingresso = $IngressoArray[0]['id_tipo_ingresso'];
        $volumeingresso = $IngressoArray[0]['volume_ingresso'];
        ?>
        <form method="post" action="tipoIngresso.php?atualizarID=<?php echo $atualizarID; ?>">
            <estilobody>
                Selecione o Cliente:
                <select name="id_cliente">
                    <?php
                    $IngressoArray = consultarClientes($pdo);
                    foreach ($IngressoArray as $ingressoDados) {

                        $selected = ($ingressoDados['id_cliente'] == $idcliente) ? 'selected' : '';

                        echo '<option ' . $selected . ' value="' . $ingressoDados['id_cliente'] . '">' . $ingressoDados['nome_cliente'] . '</option>' . PHP_EOL;
                    }
                    ?>
                </select><br>
                Selecione o Tipo de Ingresso:
                <select name="id_tipo_ingresso">
                    <?php
                    $consulta = $pdo->query('SELECT * FROM Tipo_Ingresso');
                    $IngressoArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($IngressoArray as $ingressoDados) {

                        $selected = ($ingressoDados['id_tipo_ingresso'] == $idingresso) ? 'selected' : '';

                        echo '<option ' . $selected . ' value="' . $ingressoDados['id_tipo_ingresso'] . '">' . $ingressoDados['descricao_ingresso'] . '</option>' . PHP_EOL;
                    }
                    ?>
                </select><br>
                Quantidade: <input type="number" name="volume_ingresso" value="<?php echo $volumeingresso; ?>"/><br>

                <input type="submit" name="action" value="Atualizar"/>
                <a href="tipoIngresso.php">Cancelar</a>
            </estilobody>
        </form>
        <?php
    }
    listarIngresso($pdo);
}

//atualizar
if (!empty($atualizarID) && empty($deletarID) && $action == 'Atualizar') {
    $idcliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    $idingresso = filter_input(INPUT_POST, 'id_tipo_ingresso', FILTER_VALIDATE_INT);
    $volumeingresso = filter_input(INPUT_POST, 'volume_ingresso', FILTER_VALIDATE_INT);

    //atualização no BD
    $comandoSQL = "UPDATE Tipo_Ingresso_Cliente SET id_tipo_ingresso = '$idingresso', id_cliente = '$idcliente', volume_ingresso = '$volumeingresso'
                         WHERE id_tipo_ingresso_cliente = '$atualizarID';";
    $pdo->exec($comandoSQL);

    formingresso($pdo);
    listarIngresso($pdo);
}
?>
