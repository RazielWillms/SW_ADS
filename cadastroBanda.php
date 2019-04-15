<html>
<title>
    CADASTRO BANDA
</title>
<head>
    <estiloTitle>
        Cadastro da Banda<br><br>
    </estiloTitle>
</head>
<body>
<form method="post">
    <estilobody>
        Nome_______: <input type="text" name="nomeBanda"/><br>
        Nrº Integrantes: <input type="number" name="nr"/><br>
        Gênero______: <input type="text" name="genero"/><br>

        <input type="submit" name="action" value="Cadastrar"/>
    </estilobody>
</form>
</body>
</html>
<?php
require_once "style.php";
require_once "funcoesEvento.php";
$enviar = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

//cadastro
if ($enviar == 'Cadastrar') {
    $nomeBanda = filter_input(INPUT_POST, 'nomeBanda', FILTER_SANITIZE_STRING);
    $nr_integrantes = filter_input(INPUT_POST, 'nr', FILTER_VALIDATE_INT);
    $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
    $ordem = filter_input(INPUT_POST, 'ordem', FILTER_VALIDATE_INT);

    //inserção BD
    $pdo = new PDO("mysql:host=localhost:3306; dbname=RockinRS;charset=latin1", 'root', '');

    $comandoSQL = "INSERT INTO BandaDados(nome_Banda, genero, nr_integrantes)
                    VALUES('$nomeBanda', '$genero', ' $nr_integrantes');";

    $pdo->exec($comandoSQL);

    //acesso BD
    $consulta = $pdo->query('SELECT * FROM BandaDados;');
    $BandaArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $id = $BandaArray[0]['id_bandaDados'];
    $nomeBanda = $BandaArray[0]['Nome_Banda'];
    $nr_integrantes = $BandaArray[0]['nr_integrantes'];
    $genero = $BandaArray[0]['genero'];

    ?>
    <estilobody>
        <?php
        echo 'Nome' . '- ' . 'Integrantes' . ' - ' . 'genero' . '<br>';
        foreach ($BandaArray as $BandaDados) {
            echo $BandaDados['Nome_Banda'] . '-' .
                $BandaDados['nr_integrantes'] . '-' .
                $BandaDados['genero'] . '<br>' . PHP_EOL;
        }
        ?>
    </estilobody>
    <?php
}

?>
