<?php
class Usuario{
    private $pdo;

    public function __construct(){
        $this->conecta();
    }

    private function conecta(){
        $dns  = "mysql:host=localhost;dbname=imagem_db;charset=utf8mb4";
        $user = "root";
        $pass = "";

        try{
            $this->pdo = new PDO($dns, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Erro: ".$e->getMessage();
            exit();
        }
    }

    // INSERIR -------------------------------------------------------
    // Retorna true se cadastrou, false se o e-mail já existe
    public function cadastrar($nome, $email, $senha){
        if( $this->emailExiste($email) ){
            return false;
        }

        $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES (:n, :e, :s)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':e', $email);
        $stmt->bindValue(':s', password_hash($senha, PASSWORD_DEFAULT)); // nunca guardar senha pura

        return $stmt->execute();
    }

    // ALTERAR -------------------------------------------------------
    // Se $senha vier vazia, mantém a senha atual
    // Retorna true se alterou, false se o e-mail já pertence a outro usuário
    public function alterar($id, $nome, $email, $senha = ""){
        if( $this->emailExiste($email, $id) ){
            return false;
        }

        if( $senha !== "" ){
            $sql = "UPDATE usuarios SET nome_usuario = :n, email_usuario = :e, senha_usuario = :s WHERE id_usuario = :id";
        }else{
            $sql = "UPDATE usuarios SET nome_usuario = :n, email_usuario = :e WHERE id_usuario = :id";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':e', $email);
        $stmt->bindValue(':id', $id);

        if( $senha !== "" ){
            $stmt->bindValue(':s', password_hash($senha, PASSWORD_DEFAULT));
        }

        return $stmt->execute();
    }

    // APAGAR --------------------------------------------------------
    public function apagar($id){
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    // LISTAR --------------------------------------------------------
    public function listar(){
        $sql = "SELECT id_usuario, nome_usuario, email_usuario FROM usuarios ORDER BY nome_usuario";
        $stmt = $this->pdo->query($sql);

        if( $stmt->rowCount() > 0 ){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarUsuario($id){
        $sql = "SELECT id_usuario, nome_usuario, email_usuario FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if( $stmt->rowCount() > 0 ){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    // LOGIN ---------------------------------------------------------
    // Retorna os dados do usuário (sem a senha) ou array vazio se falhar
    public function login($email, $senha){
        $sql = "SELECT * FROM usuarios WHERE email_usuario = :e";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':e', $email);
        $stmt->execute();

        if( $stmt->rowCount() > 0 ){
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if( password_verify($senha, $usuario['senha_usuario']) ){
                unset($usuario['senha_usuario']);
                return $usuario;
            }
        }
        return array();
    }

    // AUXILIAR ------------------------------------------------------
    // $ignorarId serve para o ALTERAR não acusar o próprio e-mail do usuário
    private function emailExiste($email, $ignorarId = 0){
        $sql = "SELECT id_usuario FROM usuarios WHERE email_usuario = :e AND id_usuario <> :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':e', $email);
        $stmt->bindValue(':id', $ignorarId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}