<?php
session_start();
require_once('action/classes.php');
require_once('database/conexao.php');

$database = new Database();
$db = $database->Conexao();
$usuario = new Usuario($db);

if (isset($_POST['logar'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($usuario->logar($email, $senha)) {

        $_SESSION['email'] = $email;

        header("Location:turmas.php");
        exit();
    } else {
        print "<script>alert('Seu email e senha não correspondem.Tente novamente.')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            border-radius: 7px;
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
        #logar{
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">

        <form class="form-box" method="POST" action="">
        <h1 id="tit">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" name="logar" id="logar" class="btn btn-primary">Logar</button>
            <a href="cadastro.php">Ainda não possui um cadastro?</a>
        </form>
    </div>
</body>

</html>