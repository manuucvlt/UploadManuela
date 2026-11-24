<?php
session_start();

// se já está logado, vai direto para a página principal
if( isset($_SESSION['id_usuario']) ){
    header('Location: principal.php');
    exit();
}

$erro = "";

if( isset($_POST['email']) && isset($_POST['senha']) ){
    require 'classes/usuario.class.php';
    $usuario = new Usuario();
    $dados = $usuario->login(trim($_POST['email']), $_POST['senha']);

    if( !empty($dados) ){
        session_regenerate_id(true); // evita fixação de sessão
        $_SESSION['id_usuario']   = $dados['id_usuario'];
        $_SESSION['nome_usuario'] = $dados['nome_usuario'];
        header('Location: principal.php');
        exit();
    }else{
        $erro = "E-mail ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/painel.css">
</head>
<body class="painel">
    <div class="container" style="max-width: 420px;">
        <div class="caixa mt-5">
            <h2 class="text-center">Login</h2>

            <?php if($erro != ""): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form method="POST">
                <label class="form-label fw-bold">E-mail</label>
                <input type="email" name="email" class="form-control mb-3" required>

                <label class="form-label fw-bold">Senha</label>
                <input type="password" name="senha" class="form-control mb-3" required>

                <button type="submit" class="btn btn-vinho w-100">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>