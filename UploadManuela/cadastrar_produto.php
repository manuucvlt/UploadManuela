<?php
require 'includes/protege.php';
require 'classes/produto.class.php';

$mensagem = "";
$tipoMsg  = "success";

#verifica se o usuario enviou os dados do formulario
if( isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['preco']) ){
    $nome       = $_POST['nome'];
    $descricao  = $_POST['descricao'];
    $preco      = $_POST['preco'];
    $foto       = array();
    $tipoOk     = true;

    #verifica se o usuario enviou alguma foto
    if( isset($_FILES['foto']) ){
        #percorrer o array de fotos e mover essas fotos para a pasta de imagens
        for( $i = 0; $i < count($_FILES['foto']['name']); $i++ ){
            if( $_FILES['foto']['type'][$i] == 'image/jpeg' ){
                $tipo = "jpg";
            }else if( $_FILES['foto']['type'][$i] == 'image/png' ){
                $tipo = "png";
            }else{
                $tipoOk = false;
                break;
            }

            $nome_arquivo = md5( $_FILES['foto']['name'][$i].time().$i ).".".$tipo;
            move_uploaded_file($_FILES['foto']['tmp_name'][$i], 'imagens/'.$nome_arquivo);

            #adiciona o nome da foto no array de fotos, para enviar para o banco de dados
            array_push($foto, $nome_arquivo);
        }
    }

    if( !$tipoOk ){
        $mensagem = "Tipo de arquivo não permitido! Envie apenas JPG ou PNG.";
        $tipoMsg  = "danger";
    }else{
        $produto = new Produto();
        $produto->enviarProdutos($nome, $descricao, $preco, $foto);
        $mensagem = "Produto enviado com sucesso!";
    }
}

$titulo = "Inserir Produto";
require 'includes/topo.php';
?>
<div class="caixa" style="max-width: 650px;">
    <h2 class="text-center">Cadastro de Produto</h2>

    <?php if($mensagem != ""): ?>
        <div class="alert alert-<?php echo $tipoMsg; ?>"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label class="form-label fw-bold">Nome do Produto</label>
        <input type="text" name="nome" class="form-control mb-3" required>

        <label class="form-label fw-bold">Valor do Produto (R$)</label>
        <input type="number" name="preco" step="0.01" class="form-control mb-3" required>

        <label class="form-label fw-bold">Descrição do Produto</label>
        <textarea name="descricao" rows="4" class="form-control mb-3" required></textarea>

        <label class="form-label fw-bold">Imagens (JPG ou PNG)</label>
        <input type="file" name="foto[]" multiple accept="image/jpeg,image/png" class="form-control mb-3" required>

        <button type="submit" class="btn btn-vinho w-100">Enviar</button>
    </form>
</div>
<?php require 'includes/rodape.php'; ?>