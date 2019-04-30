<?php
require_once "style.php";
$pdo = new PDO("mysql:host=localhost:3306;dbname=RockinRS;charset=latin1", 'root', '');

$senhaAberta = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

if (!is_null($senhaAberta)) {
    $nome = filter_input(INPUT_POST, 'nomeCliente', FILTER_DEFAULT);

    $consulta = $pdo->query("select * from Cliente where nome_cliente = '$nome'");

    $usuario = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $logou = password_verify($senhaAberta, $usuario[0]['senha']);

    if ($logou) {
        session_start();
        $_SESSION['nome_cliente'] = $usuario[0]['nome_cliente'];
        header("location: menu.php");
        die();
        echo 'Senha válida';
    } else {
        echo 'Senha inválida.';
    }
}
?>
<html>
<title>
    LOGIN
</title>
<ul>
    <li><a href="menu.php">Home</a></li>
</ul>
<head>
    <estiloTitle>
        Entrar no Sistema<br>
    </estiloTitle>
</head>
<body>
<form method="post">
    <estilobody>
        Usuário:<input type="text" name="nomeCliente"/><br>
        Senha:<input type="password" name="senha"/><br>
        <input type="submit" name="action" value="Login"/>
    </estilobody>
</form>
</body>
</html>
