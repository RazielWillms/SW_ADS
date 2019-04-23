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
    <li><a href="tipoIngresso.php">Comprar Ingressos</a></li>
    <li><a href="cadastroCliente.php">Cadastrar-se</a></li>
    <li><a href="login.php">Entrar</a></li>
    <li><a href="logout.php">Sair</a></li>
</ul>
<imagem>
    <img src="img/sepultura.jpeg" ;><br>
</imagem>

<estilomenu>
    SEPULTURA<br>
</estilomenu>

<form>
    <input type="submit" name="action" value="Sobre o Evento"/>
    <input type="submit" name="action" value="Pontos de Venda"/>
    <input type="submit" name="action" value="Fotos Da Banda"/>
    <input type="submit" name="action" value="Como Chegar"/>
</form>
</body>
</html>

<?php
require_once "style.php";
require_once "funcoesEvento.php";

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
choose($action);
?>
