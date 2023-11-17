<?php

require_once('action/classes.php');
require_once('database/conexao.php');

$database = new Database();
$db = $database->Conexao();
$usuario = new Usuario($db);

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $senha = $_POST["senha"];

        $limiteS = 8;

        if (strlen($senha) >= $limiteS) {
            if ($usuario->cadastrar($nome, $email, $senha, $confSenha)) {
                print "<script>alert('Cadastro efetuado com sucesso!')</script>";
            } else {
                print "";
            }
        } else {
            print "<script>alert('A senha deve ter no mínimo 8 caracteres')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <style>
        .form-box {
            margin-top: 30px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .form-box .mb-3 {
            margin-bottom: 20px;
        }

        .form-box label {
            font-weight: bold;
        }

        .form-box .btn-primary {
            width: 100%;
        }

        #tit {
            margin-bottom: 15px;
            font-size: 30px;
            text-align: center;
        }

        #cadastrar {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form class="form-box" action="#" method="POST">
            <h1 id="tit">Cadastre-se</h1>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="confSenha" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="confSenha" name="confSenha" required>
            </div>
            <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-primary">Cadastrar</button>
            <a href="index.php">Já possui um cadastro?</a>
        </form>
    </div>
</body>

</html>