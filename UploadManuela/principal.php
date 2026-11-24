<?php
require 'includes/protege.php';
$titulo = "Página Principal";
require 'includes/topo.php';
?>
<div class="caixa text-center">
    <h2>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?>!</h2>
    <p>Use o menu acima para gerenciar produtos e usuários.</p>
    <a class="btn btn-vinho m-1" href="produtos.php">Mostrar produtos</a>
    <a class="btn btn-vinho m-1" href="cadastrar_produto.php">Inserir produto</a>
    <a class="btn btn-vinho m-1" href="usuarios.php">Listar usuários</a>
</div>
<?php require 'includes/rodape.php'; ?>