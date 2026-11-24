<?php
class Produto{
    private $pdo;

    public function __construct(){
        $this->conecta();
    }

    private function conecta(){
        $dns  = "mysql:host=localhost;dbname=imagem_db";
        $user = "root";
        $pass = "";

        try{
            $this->pdo = new PDO($dns, $user, $pass);
            //echo"<h1>Conexão realizada com Sucesso!</h1>";
        }catch(PDOException $e){
            echo "Erro: ".$e->getMessage();
            exit();
        }
    }

    public function enviarProdutos($nome, $descricao, $preco, $foto = array()){
        //inserir Produto na tabela produtos
        $sql = "INSERT INTO produtos (nome_produto, descricao, preco_produto) VALUES (:n, :d, :p)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':d', $descricao);
        $stmt->bindValue(':p', $preco);

        $isOk = $stmt->execute();

        if($isOk){
            $id_produto = $this->pdo->lastInsertId();

            //inserir Imagem na tabela imagens
            if( count( $foto ) > 0 ){
                foreach( $foto as $nome_foto ){
                    $sql = "INSERT INTO imagens (nome_imagem, fk_id_produto) VALUES (:n, :p)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindValue(':n', $nome_foto);
                    $stmt->bindValue(':p', $id_produto);
                    $stmt->execute();
                }
            }
        }
    }

    public function buscarProdutos(){
        $sql = "SELECT p.*, (SELECT nome_imagem FROM imagens i WHERE i.fk_id_produto = p.id_produto ORDER BY i.id_imagem LIMIT 1) AS foto_capa FROM produtos p";
        $sql = $this->pdo->query($sql);

        if( $sql->rowCount() > 0 ){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarProduto($id){
        $sql = "SELECT * FROM produtos WHERE id_produto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if( $stmt->rowCount() > 0 ){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarImagens($id){
        $sql = "SELECT * FROM imagens WHERE fk_id_produto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if( $stmt->rowCount() > 0 ){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }
}