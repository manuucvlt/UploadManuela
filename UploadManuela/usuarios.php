<?php
require 'includes/protege.php';
require 'classes/usuario.class.php';

$usuario  = new Usuario();
$usuarios = $usuario->listar();

$titulo = "Listar Usuários";
require 'includes/topo.php';
?>
<div class="caixa">
    <h2 class="text-center">Usuários Cadastrados</h2>

    <?php if( empty($usuarios) ): ?>
        <p class="text-center">Nenhum usuário cadastrado.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr><th>#</th><th>Nome</th><th>E-mail</th></tr>
                </thead>
                <tbody>
                    <?php foreach( $usuarios as $u ): ?>
                        <tr>
                            <td><?php echo $u['id_usuario']; ?></td>
                            <td><?php echo htmlspecialchars($u['nome_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($u['email_usuario']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require 'includes/rodape.php'; ?>