<?php
require 'includes/protege.php';
require 'classes/produto.class.php';

$produto = new Produto();
$dadosProduto = $produto->buscarProdutos();

$titulo = "Produtos";
require 'includes/topo.php';
?>
<div class="caixa">
    <h2 class="text-center">Produtos</h2>

    <?php if( empty($dadosProduto) ): ?>
        <p class="text-center">Ainda não há produtos cadastrados aqui!</p>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach( $dadosProduto as $p ): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a class="link-card" href="exibir_produto.php?id=<?php echo $p['id_produto']; ?>">
                        <div class="card-produto">
                            <?php if( $p['foto_capa'] ): ?>
                                <img src="imagens/<?php echo htmlspecialchars($p['foto_capa']); ?>" alt="<?php echo htmlspecialchars($p['nome_produto']); ?>">
                            <?php endif; ?>
                            <h5><?php echo htmlspecialchars($p['nome_produto']); ?></h5>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php require 'includes/rodape.php'; ?>