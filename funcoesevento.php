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
                foreach ($ClienteArray as $ClienteDados){
                    echo '<option value="' . $ClienteDados['id_cliente'] .'">' .$ClienteDados['nome_cliente'] . '</option>' . PHP_EOL;
                }
                ?>
    </select><br>
    Selecione o Tipo de Ingresso:
    <select name="id_tipo_ingresso">
    <?php
    $consulta = $pdo->query('SELECT * FROM Tipo_Ingresso');
    $IngressoArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    foreach ($IngressoArray as $ingressoDados){
        echo '<option value="' . $ingressoDados['id_tipo_ingresso'] .'">' .$ingressoDados['descricao_ingresso'] . '</option>' . PHP_EOL;
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

function listarIngresso($pdo)
{
    $IngressoArray = consultarIngresso($pdo);
    $idcliente = $IngressoArray[0]['id_cliente'];
    $idingresso = $IngressoArray[0]['id_tipo_ingresso'];
    $volumeingresso = $IngressoArray[0]['volume_ingresso'];

    $clienteArray = consultarClientes($pdo);
    $nome = $clienteArray[0]['nome_cliente'];

    $consulta = $pdo->query('SELECT * FROM Tipo_Ingresso');
    $tipoArray = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $tipo = $tipoArray[0]['descricao_ingresso'];

    ?>
    <estilobody>
        <?php
        echo 'Cliente' . '- ' . 'Tipo Ingresso' . ' - ' . 'Quantidade' . '<br>';
        foreach ($IngressoArray as $ingressoDados) {
            echo '<a href="tipoIngresso.php?DeletarID='
                . $ingressoDados['id_tipo_ingresso_cliente'] . '">Deletar</a> '
                . '<a href="tipoIngresso.php?AtualizarID='
                . $ingressoDados['id_tipo_ingresso_cliente'] . '">Atualizar</a> '
                . $ingressoDados['id_cliente'] . '-'
                . $ingressoDados['id_tipo_ingresso'] . '-'
                . $ingressoDados['volume_ingresso'] . '<br>' . PHP_EOL;
        }
        ?>
    </estilobody>
    <?php
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
            echo '<a href="cadastroCliente.php?DeletarID='
                . $ClienteDados['id_cliente'] . '">Deletar</a> '
                . '<a href="cadastroCliente.php?AtualizarID='
                . $ClienteDados['id_cliente'] . '">Atualizar</a> '
                . $ClienteDados['nome_cliente'] . '-'
                . $ClienteDados['cpf'] . '-'
                . $ClienteDados['email'] . '-'
                . $ClienteDados['telefone'] . '<br>' . PHP_EOL;
        }
        ?>
    </estilobody>
    <?php
}

?>
