<?php
session_start();

require_once('action/classes.php');
require_once('database/conexao.php');

$database = new Database();
$db = $database->Conexao();
$crud = new Crud($db);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read';
            $rows = $crud->read();
            break;
        default:
            $rows = $crud->read();
            break;
    }
} else {
    $rows = $crud->read();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento das turmas</title>
    
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
            margin-top: 125px;
            margin-bottom: 10px;
        }

        .form-container {
            margin-top: 15px;
            margin-bottom: 50px;
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
            position: relative;
            background-color: #2980b9;
            color: white;
            padding: 15px 80px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            align-items: center;
            margin-top: 5px;
            left: 160px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
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
        .a{
            color: #007bff;
            right: 185px;
            top: 45px;
            margin-left: 150px;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <nav>
            <h1>Registrar novas turmas</h1>
            <ul>
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
                    <input type="text" name="quantidade_alunos" value="<?php echo $quantidade_alunos?>">
                    <input type="submit" id="a" class="att" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
                </form>
            </div>
        <?php
        } else {
        ?>
            <div class="form-container">
                <form action="?action=create" method="POST">
                    <label for="curso">Nome</label>
                    <input type="text" name="curso" required>

                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" required>

                    <label for="quantidade_alunos">Quantidades de alunos</label>
                    <input type="text" name="quantidade_alunos" required>

                    <input type="submit" id="a" value="Cadastrar" name="enviar">

                    <a href="turmas.php" class="a">Ver turmas registradas</a>

                </form>

            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>