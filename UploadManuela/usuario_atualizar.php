<?php
require 'includes/protege.php';
require 'classes/usuario.class.php';

$usuario  = new Usuario();
$mensagem = "";
$tipoMsg  = "success";

// 1) salvar alterações (formulário enviado)
if( isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['email']) ){
    $id = $_POST['id'];

    if( $usuario->alterar($id, trim($_POST['nome']), trim($_POST['email']), $_POST['senha']) ){
        // mantém o nome da NavBar atualizado se o usuário alterou a si mesmo
        if( $id == $_SESSION['id_usuario'] ){
            $_SESSION['nome_usuario'] = trim($_POST['nome']);
        }
        $mensagem = "Usuário atualizado com sucesso!";
    }else{
        $mensagem = "Esse e-mail já está em uso por outro usuário!";
        $tipoMsg  = "danger";
    }
    $_GET['id'] = $id; // continua mostrando o formulário
}

// 2) se veio um id, carrega o usuário para edição
$editar = array();
if( isset($_GET['id']) ){
    $editar = $usuario->buscarUsuario($_GET['id']);
}

$titulo = "Atualizar Usuário";
require 'includes/topo.php';
?>
<div class="caixa">
    <h2 class="text-center">Atualizar Usuário</h2>

    <?php if($mensagem != ""): ?>
        <div class="alert alert-<?php echo $tipoMsg; ?>"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <?php if( !empty($editar) ): ?>
        <form method="POST" style="max-width: 550px; margin: auto;">
            <input type="hidden" name="id" value="<?php echo $editar['id_usuario']; ?>">

            <label class="form-label fw-bold">Nome</label>
            <input type="text" name="nome" class="form-control mb-3" value="<?php echo htmlspecialchars($editar['nome_usuario']); ?>" required>

            <label class="form-label fw-bold">E-mail</label>
            <input type="email" name="email" class="form-control mb-3" value="<?php echo htmlspecialchars($editar['email_usuario']); ?>" required>

            <label class="form-label fw-bold">Nova senha <small class="fw-normal">(deixe em branco para manter a atual)</small></label>
            <input type="password" name="senha" class="form-control mb-3" minlength="4">

            <button type="submit" class="btn btn-vinho">Salvar</button>
            <a href="usuario_atualizar.php" class="btn btn-secondary">Voltar</a>
        </form>
    <?php else: ?>
        <?php $usuarios = $usuario->listar(); ?>
        <p>Escolha o usuário que deseja atualizar:</p>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>#</th><th>Nome</th><th>E-mail</th><th></th></tr></thead>
                <tbody>
                    <?php foreach( $usuarios as $u ): ?>
                        <tr>
                            <td><?php echo $u['id_usuario']; ?></td>
                            <td><?php echo htmlspecialchars($u['nome_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($u['email_usuario']); ?></td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-vinho" href="usuario_atualizar.php?id=<?php echo $u['id_usuario']; ?>">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require 'includes/rodape.php'; ?>