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
?>
