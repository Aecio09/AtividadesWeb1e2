CREATE DATABASE BANCO_TRISTE;

USE BANCO_TRISTE;

CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE vendedor (
    id_vendedor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    numero_de_vendas INT DEFAULT 0
);

CREATE TABLE venda (
    id_cliente INT NULL,
    id_vendedor INT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data DATE NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_vendedor)
);

ALTER TABLE venda ADD COLUMN id_venda INT AUTO_INCREMENT PRIMARY KEY;