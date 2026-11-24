<?php
require 'includes/protege.php';
require 'classes/produto.class.php';

$produto = new Produto();

if( isset($_GET['id']) && !empty($_GET['id']) ){
    $id_produto   = $_GET['id'];
    $dadosProduto = $produto->buscarProduto($id_produto);
    $dadosImagens = $produto->buscarImagens($id_produto);

    if( empty($dadosProduto) ){
        header('Location: produtos.php');
        exit();
    }
}else{
    header('Location: produtos.php');
    exit();
}

$titulo = $dadosProduto['nome_produto'];
require 'includes/topo.php';
?>
<div class="caixa">
    <a href="produtos.php" class="btn btn-vinho mb-3">&larr; Voltar</a>

    <h2><?php echo htmlspecialchars($dadosProduto['nome_produto']); ?></h2>
    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($dadosProduto['descricao']); ?></p>
    <p><strong>Valor:</strong> R$ <?php echo number_format($dadosProduto['preco_produto'], 2, ',', '.'); ?></p>

    <?php if( !empty($dadosImagens) ): ?>
        <div class="row g-3 galeria">
            <?php foreach( $dadosImagens as $img ): ?>
                <div class="col-12 col-sm-6 col-md-4">
                    <img src="imagens/<?php echo htmlspecialchars($img['nome_imagem']); ?>" alt="<?php echo htmlspecialchars($dadosProduto['nome_produto']); ?>">
                    <button class="btn btn-success w-100 mt-2">Comprar</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Este produto não possui imagens.</p>
    <?php endif; ?>
</div>
<?php require 'includes/rodape.php'; ?>