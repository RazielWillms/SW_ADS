<?php
require_once "style.php";

function formingresso($pdo)
{
    ?>
    <form method="post" action="tipoIngresso.php">
        <estilobody>
            Selecione o Cliente:
            <select name="id_cliente">
                <?php
                $ClienteArray = consultarClientes($pdo);
                foreach ($ClienteArray as $ClienteDados) {
                    echo '<option value="' . $ClienteDados['id_cliente'] . '">' . $ClienteDados['nome_cliente'] . '</option>' . PHP_EOL;
                }
                ?>
            </select><br>
            Selecione o Tipo de Ingresso:
            <select name="id_tipo_ingresso">
                <?php
                $consulta = $pdo->query('SELECT * FROM Tipo_Ingresso');
                $IngressoArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
                foreach ($IngressoArray as $ingressoDados) {
                    echo '<option value="' . $ingressoDados['id_tipo_ingresso'] . '">' . $ingressoDados['descricao_ingresso'] . '</option>' . PHP_EOL;
                }
                ?>
            </select><br>
            Quantidade: <input type="number" name="volume_ingresso"/><br>

            <input type="submit" name="action" value="Cadastrar"/>
            <input type="reset" value="Limpar"><br>
        </estilobody>
    </form>
    <?php
}

function consultarIngressojoin($pdo, $atualizarID = null)
{
    if (is_null($atualizarID)) {
        $consulta = $pdo->query("select Tipo_Ingresso_Cliente.id_tipo_ingresso_cliente as 'id_Tipo_Ingresso_Cliente', Tipo_Ingresso_Cliente.id_tipo_ingresso, Tipo_Ingresso_Cliente.id_cliente, Tipo_Ingresso_Cliente.volume_ingresso as 'volume_ingresso', Cliente.id_cliente as 'id_cliente', Cliente.nome_cliente as 'cliente_nome', Tipo_Ingresso.id_tipo_ingresso as 'id_tipo_ingresso', Tipo_Ingresso.descricao_ingresso as 'ingresso_tipo'
 from Cliente, Tipo_Ingresso, Tipo_Ingresso_Cliente where Cliente.id_cliente = Tipo_Ingresso_Cliente.id_cliente and Tipo_Ingresso.id_tipo_ingresso = Tipo_Ingresso_Cliente.id_tipo_ingresso;");
    } else {
        $consulta = $pdo->query("select Tipo_Ingresso_Cliente.id_tipo_ingresso_cliente as 'id_Tipo_Ingresso_Cliente', Tipo_Ingresso_Cliente.id_tipo_ingresso, Tipo_Ingresso_Cliente.id_cliente, Tipo_Ingresso_Cliente.volume_ingresso as 'volume_ingresso', Cliente.id_cliente as 'id_cliente', Cliente.nome_cliente as 'cliente_nome', Tipo_Ingresso.id_tipo_ingresso as 'id_tipo_ingresso', Tipo_Ingresso.descricao_ingresso as 'ingresso_tipo'
 from Cliente, Tipo_Ingresso, Tipo_Ingresso_Cliente where Cliente.id_cliente = Tipo_Ingresso_Cliente.id_cliente and Tipo_Ingresso.id_tipo_ingresso = Tipo_Ingresso_Cliente.id_tipo_ingresso and Tipo_Ingresso_Cliente.id_tipo_ingresso_cliente = $atualizarID;");

    }
    $IngressoArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $IngressoArray;
}

function listarIngressojoin($pdoconexcao)
{
    $IngressoArray = consultarIngresso($pdoconexcao);
    $idvenda = $IngressoArray[0]['id_Tipo_Ingresso_Cliente'];
    $volumeingresso = $IngressoArray[0]['volume_ingresso'];

    $idcliente = $IngressoArray[0]['id_cliente'];
    $nomecliente = $IngressoArray[0]['cliente_nome'];

    $idingresso = $IngressoArray[0]['id_tipo_ingresso'];
    $nomeingresso = $IngressoArray[0]['ingresso_tipo'];

    echo $nomecliente;
    echo $nomeingresso;
    echo $volumeingresso;

    ?>
    <estilobody>
        <?php
        echo 'Cliente' . '- ' . 'Tipo Ingresso' . ' - ' . 'Quantidade' . '<br>';
        foreach ($IngressoArray as $ingressoDados) {
            echo '<a href="tipoIngresso.php?deletarID='
                . $ingressoDados['id_tipo_ingresso_cliente'] . '">Deletar</a> '
                . '<a href="tipoIngresso.php?atualizarID='
                . $ingressoDados['id_tipo_ingresso_cliente'] . '">Atualizar</a> '
                . $ingressoDados['cliente_nome'] . '-'
                . $ingressoDados['ingresso_tipo'] . '-'
                . $ingressoDados['volume_ingresso'] . '<br>' . PHP_EOL;
        }
        ?>
    </estilobody>
    <?php
}

function consultarIngresso($pdo, $atualizarID = null)
{
    if (is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT * FROM Tipo_Ingresso_Cliente');
    } else {
        $consulta = $pdo->query(
            "SELECT * FROM Tipo_Ingresso_Cliente WHERE id_tipo_ingresso_cliente = $atualizarID;");
    }
    $IngressoArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $IngressoArray;
}

function listarIngresso($pdoconexcao)
{
    $IngressoArray = consultarIngresso($pdoconexcao);
    if (!empty($IngressoArray)) {
        $idcliente = $IngressoArray[0]['id_cliente'];
        $idingresso = $IngressoArray[0]['id_tipo_ingresso'];
        $volumeingresso = $IngressoArray[0]['volume_ingresso'];

        ?>
        <estilobody>
            <?php
            echo 'Cliente' . '- ' . 'Tipo Ingresso' . ' - ' . 'Quantidade' . '<br>';
            foreach ($IngressoArray as $ingressoDados) {
                echo '<a href="tipoIngresso.php?deletarID='
                    . $ingressoDados['id_tipo_ingresso_cliente'] . '">Deletar</a> '
                    . '<a href="tipoIngresso.php?atualizarID='
                    . $ingressoDados['id_tipo_ingresso_cliente'] . '">Atualizar</a> '
                    . $ingressoDados['id_cliente'] . '-'
                    . $ingressoDados['id_tipo_ingresso'] . '-'
                    . $ingressoDados['volume_ingresso'] . '<br>' . PHP_EOL;
            }
            ?>
        </estilobody>
        <?php
    } else {
        echo "Sem Cadastros!!";
    }

}

function form()
{
    ?>
    <form method="post" action="cadastroCliente.php">
        <estilobody>
            Nome: <input type="text" name="nomeCliente"/><br>
            CPF : <input type="number" name="cpf"/><br>
            Email: <input type="text" name="email"/><br>
            Telefone: <input type="number" name="telefone"/><br>
            Defina uma senha: <input type="password" name="senha"/><br>

            <input type="submit" name="action" value="Cadastrar"/>
            <input type="reset" value="Limpar"><br>
        </estilobody>
    </form>
    <?php
}

function consultarClientes($pdo, $atualizarID = null)
{
    if (is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT * FROM Cliente');
    } else {
        $consulta = $pdo->query(
            "SELECT * FROM Cliente WHERE id_cliente = $atualizarID;");
    }
    $ClienteArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $ClienteArray;
}

function listarCliente($pdoconexcao)
{
    $ClienteArray = consultarClientes($pdoconexcao);
    if (!empty($ClienteArray)) {
        $id = $ClienteArray[0]['id_cliente'];
        $nomeCliente = $ClienteArray[0]['nome_cliente'];
        $cpf = $ClienteArray[0]['cpf'];
        $email = $ClienteArray[0]['email'];
        $telefone = $ClienteArray[0]['telefone'];

        ?>
        <estilobody>
            <?php
            echo 'Nome' . '- ' . 'cpf' . ' - ' . 'email' . ' - ' . 'telefone' . '<br>';
            foreach ($ClienteArray as $ClienteDados) {
                echo '<a href="cadastroCliente.php?deletarID='
                    . $ClienteDados['id_cliente'] . '">Deletar</a> '
                    . '<a href="cadastroCliente.php?atualizarID='
                    . $ClienteDados['id_cliente'] . '">Atualizar</a> '
                    . '<a href="endereco.php?atualizarID='
                    . $ClienteDados['id_cliente'] . '">Complementar</a> '
                    . $ClienteDados['nome_cliente'] . '-'
                    . $ClienteDados['cpf'] . '-'
                    . $ClienteDados['email'] . '-'
                    . $ClienteDados['telefone'] . '<br>' . PHP_EOL;
            }
            ?>
        </estilobody>
        <?php
    } else {
        echo "Sem Cadastros!!";
    }
}

function formComplementar($pdo, $atualizarID)
{
    $ClienteArray = consultarClientes($pdo, $atualizarID);

    if (is_array($ClienteArray) && count($ClienteArray) > 0) {
        $id = $ClienteArray[0]['id_cliente'];
        $nomeCliente = $ClienteArray[0]['nome_cliente'];
        $cpf = $ClienteArray[0]['cpf'];
        $email = $ClienteArray[0]['email'];
        $telefone = $ClienteArray[0]['telefone'];
        $senhaParaArmazenarNoBanco = $ClienteArray[0]['senha'];
        ?>
        <form method="post" action="endereco.php?atualizarID=<?php echo $atualizarID; ?>">
            <estilobody>
                <input type="hidden" value="<?php echo $id; ?>" name="id">
                Nome: <?php echo $nomeCliente; ?><br>
                CPF : <?php echo $cpf; ?><br>
                Email: <?php echo $email; ?><br>
                Telefone: <?php echo $telefone; ?><br>
                <input type="hidden" value="<?php echo $senhaParaArmazenarNoBanco; ?>" name="id">
                Cidade: <input type="text" name="cidade"/><br>
                Endereço: <input type="text" name="endereco"/><br>

                <input type="submit" name="action" value="Complementar"/>
                <a href="cadastroCliente.php">Cancelar</a>
                <br>
            </estilobody>
        </form>
        <?php
    }
}

function consultarComplemento($pdo, $atualizarID = null)
{
    if (is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT * FROM Endereco_Cliente, Cliente where Endereco_Cliente.id_cliente = Cliente.id_cliente');
    } else {
        $consulta = $pdo->query(
            "SELECT * FROM Endereco_Cliente, Cliente WHERE Endereco_Cliente.id_cliente = $atualizarID and Endereco_Cliente.id_cliente = Cliente.id_cliente;");
    }
    $ClienteArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $ClienteArray;
}

function listarComplemento($pdoconexcao)
{
    $ClienteArray = consultarComplemento($pdoconexcao);
    if (!empty($ClienteArray)) {
        $id = $ClienteArray[0]['id_cliente'];
        $nomeCliente = $ClienteArray[0]['nome_cliente'];
        $cpf = $ClienteArray[0]['cpf'];
        $email = $ClienteArray[0]['email'];
        $telefone = $ClienteArray[0]['telefone'];
        $cidade = $ClienteArray[0]['cidade'];
        $endereco = $ClienteArray[0]['endereco'];

        ?>
        <estilobody>
            <?php
            echo 'Nome' . '- ' . 'cpf' . ' - ' . 'email' . ' - ' . 'telefone' . '<br>';
            foreach ($ClienteArray as $ClienteDados) {
                echo '<a href="endereco.php?deletarID='
                    . $ClienteDados['id_cliente'] . '">Deletar</a> '
                    . $ClienteDados['nome_cliente'] . '-'
                    . $ClienteDados['cpf'] . '-'
                    . $ClienteDados['email'] . '-'
                    . $ClienteDados['telefone'] . '-'
                    . $ClienteDados['cidade'] . '-'
                    . $ClienteDados['endereco'] . '<br>' . PHP_EOL;
            }
            ?>
        </estilobody>
        <?php
    } else {
        echo "Sem Cadastros!!";
    }
}

function listarsobre()
{
    ?>
    <form method="post" action="menu.php">
    <estilobody>
        Estado: Rio Grande do Sul<br>
        Cidade: Santo Ângelo<br>
        Horário: 23:30<br>
        Dia: 23/11<br>
        Local: Fenamilho<br>
        <imagem>
            <img src="img/palco.jpg";><br>
        </imagem>
    </estilobody>
    </form>
    <?php
}

function listarvenda()
{
    ?>
    <form method="post" action="menu.php">
        <br><estilomenu>Locais de Venda:</estilomenu><br>

        <imagem>
            <img src="img/tiaraju.jpg";><br>
        </imagem>
        <estilobody>
            Nome: Posto Tiaraju<br><br>
        </estilobody>
        <imagem>
            <img src="img/neco.jpg";><br>
        </imagem>
        <estilobody>
            Nome: Neco Lanches<br><br>
        </estilobody>
        <imagem>
            <img src="img/cine.jpg";><br>
        </imagem>
        <estilobody>
            Nome: Cine Cisne<br><br>
        </estilobody>
    </form>
    <?php
}

function listarmidia()
{
    ?>
    <form method="post" action="menu.php">
        <br><estilomenu>Fotos Banda:</estilomenu><br>

        <imagem>
            <img src="img/midia.jpg";>
            <img src="img/midia2.jpg";><br>
        </imagem>
    </form>
    <?php
}

function mostrarlocalização()
{
    ?>
    <body>
    <br><estilomenu>Localização:</estilomenu><br>
    <section>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3512.7975093615228!2d-54.28488948540659!3d-28.304457459491513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94fe90ec99cda989%3A0x464b89a3d85adf95!2sFenamilho+-+Parque+Internacional+de+Exposi%C3%A7%C3%B5es+Siegfried+Ritter!5e0!3m2!1spt-BR!2sbr!4v1555980181831!5m2!1spt-BR!2sbr" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    </section>
    </body>
<?php
}

function choose($action){
    if (empty($action) || $action == 'Sobre o Evento') {
        listarsobre();
    }
    if ($action == 'Pontos de Venda') {
        listarvenda();
    }
    if ($action == 'Fotos Da Banda') {
        listarmidia();
    }
    if ($action == 'Como Chegar') {
        mostrarlocalização();
    }
}
?>
