<?php
// Cabeçalho + NavBar (Bootstrap). Antes de incluir, defina $titulo se quiser.
$titulo = isset($titulo) ? $titulo : 'Sistema';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/painel.css">
</head>
<body class="painel">

<nav class="navbar navbar-expand-lg navbar-vinho">
    <div class="container">
        <a class="navbar-brand fw-bold" href="principal.php">Loja</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Produtos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="produtos.php">Mostrar produtos</a></li>
                        <li><a class="dropdown-item" href="cadastrar_produto.php">Inserir produto</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Usuários</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="usuario_inserir.php">Inserir usuário</a></li>
                        <li><a class="dropdown-item" href="usuario_atualizar.php">Atualizar usuário</a></li>
                        <li><a class="dropdown-item" href="usuarios.php">Listar usuários</a></li>
                        <li><a class="dropdown-item" href="usuario_deletar.php">Deletar usuário</a></li>
                    </ul>
                </li>
            </ul>

            <span class="navbar-text me-3">Olá, <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></span>
            <a class="btn btn-sm btn-light" href="logout.php">Sair</a>
        </div>
    </div>
</nav>

<main class="container">