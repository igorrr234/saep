<?php
session_start();

require_once('action/classes.php');
require_once('database/conexao.php');

$database = new Database();
$db = $database->Conexao();
$crud = new Crud($db);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'read';
            $rows = $crud->read();
            break;
        case 'update':
            if (isset($_POST['id'])) {
                $crud->update($_POST);
            }
            $rows = $crud->read();
            break;
        case 'delete':
            $crud->delete($_GET['id']);
            $rows = $crud->read();
            break;
        default:
            $rows = $crud->read();
            break;
    }
} else {
    $rows = $crud->read();
}
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $rows = $crud->search($searchTerm);
} else {
    $rows = $crud->read();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas registradas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 80px auto 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .form-container {
            margin-top: 15px;
            margin-bottom: 90px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #2980b9;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333;
            margin-top: 70px;
            margin-bottom: 40px;
        }

        th,
        td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            display: inline-block;
            padding: 4px 6px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin: 4px;
        }

        a.delete {
            background-color: #007bff;
        }

        a:hover {
            background-color: #007bff;
        }

        a.delete:hover {
            background-color: #c82333;
        }

        a.edit:hover {
            background-color: #DCDC;
        }

        #a {
            margin-top: 5px;
            margin-right: -22px;
            margin-bottom: 80px;
        }

        .navbar {
            background-color: #007bff;
            padding: 5px 0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .navbar h1 {
            margin-right: 900px;
            color: #fff;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            right: 10px;
        }

        .navbar li {
            display: inline-block;
            margin-right: 10px;
            position: relative;
            top: -40px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
        }

        #b {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <nav>
            <h1>Turmas registradas</h1>
            <ul>
                <li>
                    <?php if (isset($_SESSION['email'])) : ?>
                <li class="logs"><a href="logout.php">Sair</a></li>
                <li class="logs"><a>Bem-vindo, <?php echo $_SESSION['email']; ?>!</a></li>
            <?php else : ?>
                <li class="logs">
                    <a href="index.php">Login</a>
                </li>

                <li class="logs">
                    <a href="cadastro.php">Cadastro</a>
                </li>
            <?php endif; ?>
            </li>
            </ul>

        </nav>
    </div>
    <div class="container">
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $crud->readOne($id);

            if (!$result) {
                echo "Registro não encontrado.";
                exit();
            }
            $curso = $result['curso'];
            $descricao = $result['descricao'];
            $quantidade_alunos = $result['quantidade_alunos'];
        ?>
            <div class="form-container">
                <form action="?action=update" method="post">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <label for="curso">Nome</label>
                    <input type="text" name="curso" value="<?php echo $curso ?>">
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" value="<?php echo $descricao ?>">
                    <label for="quantidade_alunos">Quantidade de alunos</label>
                    <input type="text" name="quantidade_alunos" value="<?php echo $quantidade_alunos ?>">
                    <input type="submit" id="a" class="att" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
                </form>
            </div>
        <?php
        } else {
        ?>
        <?php
        }
        ?>
        <table>
            <t <tr>
                <td colspan="7" style="font-size: 20px; text-align: center;">
                    <strong>Turmas registradas</strong>
                </td>
                </tr>
                <tr>
                    <td>Nome</td>
                    <td>Descrição</td>
                    <td>Quantidade de alunos</td>
                </tr>
                <?php
                if (isset($rows)) {
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['curso'] . "</td>";
                        echo "<td>" . $row['descricao'] . "</td>";
                        echo "<td>" . $row['quantidade_alunos'] . "</td>";
                        echo "<td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Não há registros a serem exibidos</td></tr>";
                }
                ?>
        </table>
        <h2>Deseja adicionar uma nova turma?</h2>
        <a href="index.php">Faça login</a>
    </div>
</body>

</html>