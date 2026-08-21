CREATE DATABASE REIDOACAI;

USE REIDOACAI;

CREATE TABLE ENDERECO(
    ID_END INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    RUA VARCHAR(100),
    BAIRRO VARCHAR(50),
    CIDADE VARCHAR(50),
    ESTADO CHAR(2),
    CEP CHAR(8),
    NUMERO VARCHAR(10),
    COMPLEMENTO VARCHAR(50)
);

CREATE TABLE CLIENTE(
    ID_CLI INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME_CLI VARCHAR(30),
    CPF_CLI CHAR(14),
    TEL_CLI CHAR(14),
    EMAIL_CLI VARCHAR(100),
    USUARIO VARCHAR(30),
    SENHA VARCHAR(255),
    COD_END INT NULL,
    FOREIGN KEY (COD_END) REFERENCES ENDERECO(ID_END)
);

CREATE TABLE PRODUTO(
    ID_PROD INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME_PROD VARCHAR(30),
    TIPO_PROD VARCHAR(30),
    VALOR_PROD DECIMAL(5,2),
    ESTOQUE INTEGER,
    IMAGEM VARCHAR(255)
);

CREATE TABLE ADICIONAL(
    ID_ADC INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NOME_ADC VARCHAR(30),
    TIPO_ADC VARCHAR(30),
    VALOR_ADC DECIMAL(5,2),
    ESTOQUE INTEGER,
    IMAGEM VARCHAR(255)
);

CREATE TABLE PEDIDO(
    ID_PED INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    STATUS_PED VARCHAR(20),
    METODO_PAG VARCHAR(30),
    VALOR_TOTAL DECIMAL(5,2),
    DATA_PED DATETIME,
    COD_END INT NOT NULL,
    COD_CLI INT NOT NULL,

    FOREIGN KEY (COD_END) REFERENCES ENDERECO(ID_END),
    FOREIGN KEY (COD_CLI) REFERENCES CLIENTE(ID_CLI)
);

CREATE TABLE ITEM_PEDIDO(
    ID_ITEM_PED INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    QUANTIDADE INTEGER,
    SUBTOTAL DECIMAL(5,2),
    COD_PED INT NOT NULL,
    COD_ADC INT NULL,
    COD_PROD INT NOT NULL,

    FOREIGN KEY (COD_PED) REFERENCES PEDIDO(ID_PED),
    FOREIGN KEY (COD_ADC) REFERENCES ADICIONAL(ID_ADC),
    FOREIGN KEY (COD_PROD) REFERENCES PRODUTO(ID_PROD)
);
INSERT INTO ENDERECO(RUA,BAIRRO,CIDADE,ESTADO,CEP,NUMERO,COMPLEMENTO)
VALUES('Rua 13 de Maio','Centro','Paulo de Faria','SP','15490015','498','Casa de esquina');

INSERT INTO produto(NOME_PROD,TIPO_PROD,VALOR_PROD,ESTOQUE,IMAGEM)
VALUES
('Açaí 400ml','Copo',25.00,20,'imagem/400ml.jpeg'),
('Açaí 500ml', 'Copo', 27.00,30,'imagem/500ml.jpeg'),
('Açaí 700ml', 'Copo', 35.00,30,'imagem/700ml.png'),
('Açaí 1litro', 'Pote', 50.00,30,'imagem/1litro.jpeg');

INSERT INTO ADICIONAL(NOME_ADC,VALOR_ADC,ESTOQUE,IMAGEM)
VALUES
('Creme de avelã',0.0,50,'imagem/avela.png'),
('Creme de Ovo Maltine',0,50,'imagem/cremeovomaltine.png'),
('Creme de Kinder Bueno',0,50,'imagem/kinderbueno.png'),
('Creme de Rafaello',0,50,'imagem/rafaello.png'),
('Creme de Oreo',0,50,'imagem/oreo.png'),
('Creme de morango',0,50,'imagem/crememorango.png'),
('Creme de ninho(chantilly)',0,50,'imagem/cremeninho.png'),
('Recheio de ninho(tipo chocolate branco',0,50,'imagem/recheioninho.png'),
('Gotas de chocolate',0,50,'imagem/gotaschocolate.png'),
('Disquete',0,50,'imagem/disquete.png'),
('Kit Kat',0,50,'imagem/kitkat.png'),
('Sonho de valsa',0,50,'imagem/sonhodevalsa.png'),
('Ouro Branco',0,50,'imagem/ourobranco.png'),
('Castanha',0,50,'imagem/castanha.png'),
('Paçoca',0,50,'imagem/pacoca.png'),
('Granola',0,50,'imagem/granola.png'),
('Leite ninho',0,50,'imagem/leiteninho.png'),
('Ovo Maltine',0,50,'imagem/ovomaltine.png'),
('Leite Condensado',0,50,'imagem/ovomaltine.png'),
('Chocobal',0,50,'imagem/chocobal.png'),
('Cereja',0,50,'imagem/cereja.png'),
('Morango',0,50,'imagem/morango.png'),
('Banana',0,50,'imagem/banana.png'),
('Calda de Chocolate',0,50,'imagem/caldachocolate.png'),
('Calda de Maracujá',0,50,'imagem/caldamaracuja.png'),
('Calda de Morango',0,50,'imagem/caldamorango.png'),
('Nutella Original',0,50,'imagem/nutella.png');

SELECT ID_CLI, NOME_CLI, USUARIO
FROM CLIENTE;

SELECT ID_END, RUA, NUMERO
FROM ENDERECO;

SELECT ID_PROD, NOME_PROD, VALOR_PROD
FROM PRODUTO;

SELECT ID_ADC, NOME_ADC, VALOR_ADC
FROM ADICIONAL;