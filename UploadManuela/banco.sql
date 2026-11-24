CREATE DATABASE IF NOT EXISTS imagem_db;
USE imagem_db;

CREATE TABLE IF NOT EXISTS produtos(
    id_produto int AUTO_INCREMENT PRIMARY KEY,
    nome_produto varchar(100),
    preco_produto decimal(10,2),
    descricao text
);

CREATE TABLE IF NOT EXISTS imagens(
    id_imagem int AUTO_INCREMENT PRIMARY KEY,
    nome_imagem varchar(100),
    fk_id_produto int,
    FOREIGN KEY (fk_id_produto) REFERENCES produtos(id_produto)
);

CREATE TABLE IF NOT EXISTS usuarios(
    id_usuario int AUTO_INCREMENT PRIMARY KEY,
    nome_usuario varchar(100) NOT NULL,
    email_usuario varchar(100) NOT NULL UNIQUE,
    senha_usuario varchar(255) NOT NULL
);

-- Usuário inicial para o primeiro login (e-mail: admin@admin.com | senha: admin123)
INSERT IGNORE INTO usuarios (nome_usuario, email_usuario, senha_usuario)
VALUES ('Administrador', 'admin@admin.com', '$2y$10$EarmiSrJEDm8rUXPgFBCYObY.GeAA0aYuO2t5g1S6uUX0IEnLYwLu');