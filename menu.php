<html>
<title>
    Menu
</title>
<style type="text/css">
    img {
        width: 350px;
        height: 250px;
    }
</style>
<body>
<ul>
<!--    --><?php
//    if (session_id() != null && isset($_SESSION['nome_cliente'])) {
//        ?>
<!--        <li><a href="menu.php">Home</a></li>-->
<!--        <li><a href="tipoIngresso.php">Comprar Ingressos</a></li>-->
<!--        <li><a href="logout.php">Logout</a></li>-->
<!--        --><?php
//    } else {
//        if (session_id() == null && !isset($_SESSION['nome_cliente'])) {
//            ?>
<!--            <li><a href="menu.php">Home</a></li>-->
<!--            <li><a href="cadastroCliente.php">Cadastrar-se</a></li>-->
<!--            <li><a href="login.php">login</a></li>-->
<!--            --><?php
//        }
//    }
//    ?>
        <li><a href="menu.php">Home</a></li>
        <li><a href="cadastroCliente.php">Cadastrar-se</a></li>
        <li><a href="tipoIngresso.php">Comprar Ingressos</a></li>
        <li><a href="login.php">login</a></li>
        <li><a href="logout.php">Logout</a></li>
</ul>
<imagem>
    <img src="img/sepultura.jpeg" ;><br>
</imagem>

<estilomenu>
    SEPULTURA 23/11<br>
</estilomenu>
<estilobody>
    Estado: Rio Grande do Sul<br>
    Cidade: Santo Ângelo<br>
    Horário: 23:30<br>
</estilobody>

</body>
</html>

<?php
require_once "style.php";
?>
