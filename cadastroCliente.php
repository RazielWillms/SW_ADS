<html>
<title>
    CADASTRO CLIENTE
</title>
<body>
<ul>
    <li><a href="menu.php">Home</a></li>
</ul>
</body>
<head>
    <estiloTitle>
        Cadastro do Cliente<br><br>
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
    form();
    listarCliente($pdo);
}

//cadastro
if (empty($atualizarID) && empty($deletarID) && $action == 'Cadastrar') {

    $nomeCliente = filter_input(INPUT_POST, 'nomeCliente', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_VALIDATE_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_VALIDATE_INT);
    $senhaAberta = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $senhaParaArmazenarNoBanco = password_hash($senhaAberta, PASSWORD_DEFAULT);

    //inserção BD
    $comandoSQL = "INSERT INTO Cliente(nome_cliente, cpf, email, telefone, senha)" . "VALUES('$nomeCliente', '$cpf', '$email', '$telefone','$senhaParaArmazenarNoBanco');";

    $pdo->exec($comandoSQL);

    header("location: http://localhost/acessoBD/SW_AVALIA%C3%87%C3%83O/login.php");

    form();
    listarCliente($pdo);
}

//apagar
if (empty($atualizarID) && !empty($deletarID) && empty($action)) {
    //delete BD
    $comandoSQL = "delete from Cliente where id_cliente = $deletarID;";
    $totalPagados = $pdo->exec($comandoSQL);

    form();
    listarCliente($pdo);
}

// exibe opção de atualizar no formulário
if (!empty($atualizarID) && empty($deletarID) && empty($action)) {

    $ClienteArray = consultarClientes($pdo, $atualizarID);

    if (is_array($ClienteArray) && count($ClienteArray) > 0) {
        $id = $ClienteArray[0]['id_cliente'];
        $nomeCliente = $ClienteArray[0]['nome_cliente'];
        $cpf = $ClienteArray[0]['cpf'];
        $email = $ClienteArray[0]['email'];
        $telefone = $ClienteArray[0]['telefone'];
        $senhaParaArmazenarNoBanco = $ClienteArray[0]['senha'];
        ?>
        <form method="post" action="cadastroCliente.php?atualizarID=<?php echo $atualizarID; ?>">
            <estilobody>
                <input type="hidden" value="<?php echo $id; ?>" name="id">
                Nome: <input type="text" value="<?php echo $nomeCliente; ?>" name="nomeCliente"/><br>
                CPF : <input type="number" value="<?php echo $cpf; ?>" name="cpf"/><br>
                Email: <input type="text" value="<?php echo $email; ?>" name="email"/><br>
                Telefone: <input type="number" value="<?php echo $telefone; ?>" name="telefone"/><br>
                <input type="hidden" value="<?php echo $senhaParaArmazenarNoBanco; ?>" name="id">

                <input type="submit" name="action" value="Atualizar"/>
                <a href="cadastroCliente.php">Cancelar</a>
                <br>
            </estilobody>
        </form>
        <?php
    }
    listarCliente($pdo);
//    $atualizarID = null;
}

//atualizar
if (!empty($atualizarID) && empty($deletarID) && $action == 'Atualizar') {
    $nomeCliente = filter_input(INPUT_POST, 'nomeCliente', FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_VALIDATE_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_VALIDATE_INT);
    $senhaAberta = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $senhaParaArmazenarNoBanco = password_hash($senhaAberta, PASSWORD_DEFAULT);

//    atualização no BD
    $comandoSQL = "UPDATE Cliente SET nome_cliente = '$nomeCliente', cpf = '$cpf', email = '$email', telefone = '$telefone'
                         WHERE id_cliente = '$atualizarID';";
    $pdo->exec($comandoSQL);

    form();
    listarCliente($pdo);
}
?>
