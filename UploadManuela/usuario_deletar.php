<?php
require 'includes/protege.php';
require 'classes/usuario.class.php';

$usuario  = new Usuario();
$mensagem = "";
$tipoMsg  = "success";

// apagar via POST (nunca via link GET)
if( isset($_POST['id']) ){
    if( $_POST['id'] == $_SESSION['id_usuario'] ){
        $mensagem = "Você não pode apagar o usuário com o qual está logado!";
        $tipoMsg  = "danger";
    }else{
        $usuario->apagar($_POST['id']);
        $mensagem = "Usuário apagado com sucesso!";
    }
}

$usuarios = $usuario->listar();

$titulo = "Deletar Usuário";
require 'includes/topo.php';
?>
<div class="caixa">
    <h2 class="text-center">Deletar Usuário</h2>

    <?php if($mensagem != ""): ?>
        <div class="alert alert-<?php echo $tipoMsg; ?>"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <?php if( empty($usuarios) ): ?>
        <p class="text-center">Nenhum usuário cadastrado.</p>
    <?php else: ?>
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
                                <form method="POST" onsubmit="return confirm('Apagar este usuário?');" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $u['id_usuario']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require 'includes/rodape.php'; ?>