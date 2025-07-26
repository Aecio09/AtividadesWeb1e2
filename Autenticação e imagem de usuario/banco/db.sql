CREATE DATABASE banco_feliz;

USE banco_feliz;

CREATE TABLE paciente(
id_paciente int auto_increment primary key,
nome varchar (50) not null  
);

CREATE TABLE medico(
    id_medico int auto_increment primary key,
    nome varchar(55) not null,
    especialidade varchar(255) not null
);

CREATE TABLE consulta (
    id_consulta INT AUTO_INCREMENT PRIMARY KEY,
    id_medico INT NULL,
    id_paciente INT NULL,
    data_hora DATETIME NOT NULL,
    observacao TEXT,
    FOREIGN KEY (id_medico) REFERENCES medico(id_medico) ON DELETE SET NULL,
    FOREIGN KEY (id_paciente) REFERENCES paciente(id_paciente) ON DELETE SET NULL
);

alter TABLE consulta add descricao TEXT not null;

alter TABLE paciente add tipo_sanguineo varchar(10) not null;

CREATE TABLE usuario(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE Imagem (
    id_imagem INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255) NOT NULL
);

alter table paciente add column Imagem_id INT,
add foreign key (Imagem_id) references Imagem(id_imagem) on delete set null;