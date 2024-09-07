DROP DATABASE IF EXISTS ci4proj1;
CREATE DATABASE ci4proj1;
USE ci4proj1;
CREATE TABLE morada(
    codigo_postal INT(7) PRIMARY KEY,
    localidade VARCHAR(50) NOT NULL,
    concelho VARCHAR(50) NOT NULL,
    distrito VARCHAR(50) NOT NULL
);
CREATE TABLE medico(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(80) NOT NULL,
    nif INT(9) NOT NULL,
    nib VARCHAR(21) NOT NULL,
    especialidade VARCHAR(50) NOT NULL,
    morada VARCHAR(100) NOT NULL,
    codigo_postal INT(7) NOT NULL
);
CREATE TABLE enfermeiro(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(80) NOT NULL,
    nif INT(9) NOT NULL,
    nib INT(21) NOT NULL,
    especialidade VARCHAR(50) NOT NULL,
    morada VARCHAR(100) NOT NULL,
    codigo_postal INT(7) NOT NULL
);
CREATE TABLE utente(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(80) NOT NULL,
    numero_utente INT(9) NOT NULL,
    morada VARCHAR(100) NOT NULL,
    codigo_postal INT(7) NOT NULL
);
CREATE TABLE consulta(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    data DATETIME,
    estado INT(1) NOT NULL,
    id_medico INT(12) NOT NULL,
    id_utente INT(12) NOT NULL,
    id_receita INT(12) NOT NULL
);
CREATE TABLE consulta_enfermeiro(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    id_consulta INT(12) NOT NULL,
    id_enfermeiro INT(12) NOT NULL
);
CREATE TABLE receita(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    utilizacao VARCHAR(100) NOT NULL,
    receita_pdf VARCHAR(255) NOT NULL
);
CREATE TABLE produto(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    imagem VARCHAR(255) NOT NULL
);
CREATE TABLE receita_produto(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    id_receita INT(12) NOT NULL,
    id_produto INT(12) NOT NULL
);
CREATE TABLE utilizador(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    utilizador VARCHAR(20) NOT NULL,
    password CHAR(60) NOT NULL,
    medico BOOLEAN NOT NULL DEFAULT 0,
    ativo BOOLEAN NOT NULL DEFAULT 1,
    token CHAR(100)
);
CREATE TABLE contacto(
    id INT(12) PRIMARY KEY AUTO_INCREMENT,
    registo DATETIME NOT NULL,
    ativo BOOL DEFAULT 1
);
INSERT INTO `utilizador` (`utilizador`, `password`, `medico`, `ativo`) VALUES ('admin', '$2a$08$bZbkAufdD0GowUsEtHvcXe4FRG9BL.QNlNsJEGFej44z5Ma0BoxHO', 0, 1);