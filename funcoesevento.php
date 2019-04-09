<?php
require_once "style.php";

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

function consultarLivrosBanco($pdo, $atualizarID = null)
{
    if (is_null($atualizarID)) {
        $consulta = $pdo->query('SELECT livro.id as "idLivro",
                                 livro.nome as "nomeLivro", livro.ano, autor.nome  as "nomeAutor"
                                 FROM livro, autor 
                                 where livro.id_autor = autor.id');
    } else {
        $consulta = $pdo->query(
            "SELECT * FROM livro, autor WHERE 
              livro.id_autor = autor.id and id = $atualizarID;");
    }
    $livrosArray = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $livrosArray;
}

?>
