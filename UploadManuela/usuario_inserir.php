<?php
require 'includes/protege.php';
require 'classes/usuario.class.php';

$mensagem = "";
$tipoMsg  = "success";

if( isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) ){
    $usuario = new Usuario();

    if( $usuario->cadastrar(trim($_POST['nome']), trim($_POST['email']), $_POST['senha']) ){
        $mensagem = "Usuário cadastrado com sucesso!";
    }else{
        $mensagem = "Já existe um usuário com esse e-mail!";
        $tipoMsg  = "danger";
    }
}

$titulo = "Inserir Usuário";
require 'includes/topo.php';
?>
<div class="caixa" style="max-width: 550px;">
    <h2 class="text-center">Inserir Usuário</h2>

    <?php if($mensagem != ""): ?>
        <div class="alert alert-<?php echo $tipoMsg; ?>"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label class="form-label fw-bold">Nome</label>
        <input type="text" name="nome" class="form-control mb-3" required>

        <label class="form-label fw-bold">E-mail</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <label class="form-label fw-bold">Senha</label>
        <input type="password" name="senha" class="form-control mb-3" minlength="4" required>

        <button type="submit" class="btn btn-vinho w-100">Cadastrar</button>
    </form>
</div>
<?php require 'includes/rodape.php'; ?>