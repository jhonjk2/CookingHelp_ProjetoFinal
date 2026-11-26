CREATE DATABASE cooking_help;
USE cooking_help;

CREATE TABLE utilizadores (
    id_utilizador    INT AUTO_INCREMENT PRIMARY KEY,
    nome             VARCHAR(100) NOT NULL,
    email            VARCHAR(150) NOT NULL UNIQUE,
    password_hash    VARCHAR(255) NOT NULL,
    consentimento_em DATETIME     NOT NULL,
    criado_em        DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome         VARCHAR(120) NOT NULL UNIQUE,
    descricao    VARCHAR(200) NULL
);

CREATE TABLE receitas (
    id_receita    INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria  INT           NOT NULL,
    titulo        VARCHAR(200)  NOT NULL,
    tempo_preparo SMALLINT      NULL,
    dificuldade   VARCHAR(30)   NULL,
    imagem        VARCHAR(255)  NULL,
    ingredientes  TEXT          NOT NULL,
    modo_preparo  TEXT          NOT NULL,
    CONSTRAINT fk_receitas_categorias
        FOREIGN KEY (id_categoria) REFERENCES
        categoria (id_categoria)
        on DELETE RESTRICT
);

