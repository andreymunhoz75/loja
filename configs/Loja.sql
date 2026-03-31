create database Loja;

use Loja;

create table produtos (
id_produto int not null auto_increment primary key,
nome varchar(50) not null,
descricao varchar(255) not null,
quantidade int not null,
preco decimal(10,2) not null,
imagem varchar(255) null
);

CREATE TABLE funcionario (
    id int not null AUTO_INCREMENT PRIMARY KEY,
    nome_fun VARCHAR(50) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    funcao VARCHAR(25) NOT NULL,
    login_fun VARCHAR(25) NOT NULL,
    senha_fun VARCHAR(255) NOT NULL,
    imagem_fun VARCHAR(255) NULL
);

INSERT INTO produtos (nome, descricao, quantidade, preco) VALUES
('Teclado Mecânico RGB', 'Teclado gamer com iluminação RGB e switches blue', 25, 289.90),
('Mouse Sem Fio', 'Mouse wireless ergonômico 1600 DPI', 40, 79.99),
('Monitor 24 Polegadas', 'Monitor LED Full HD com painel IPS', 12, 899.00),
('Headset Gamer', 'Headset com microfone e som surround 7.1', 30, 199.50),
('Cadeira Gamer', 'Cadeira ergonômica com ajuste de altura e inclinação', 8, 1299.00),
('Pendrive 64GB', 'Pendrive USB 3.0 velocidade alta', 100, 39.90),
('HD Externo 1TB', 'HD portátil USB 3.0 para backup', 15, 349.00),
('Notebook i5 8GB', 'Notebook com processador Intel i5 e 8GB RAM', 6, 2899.99),
('Fonte 500W', 'Fonte ATX 500W certificação 80 Plus', 20, 249.90),
('Placa de Vídeo 4GB', 'Placa de vídeo dedicada 4GB GDDR5', 10, 899.90);

-- Inserindo usuario admin inicial com senha '123'
INSERT INTO funcionario (nome_fun, cpf, endereco, telefone, funcao, login_fun, senha_fun, imagem_fun) VALUES
('Administrador', '000.000.000-00', 'Rua Admin, 123', '(00)00000-0000', 'admin', 'admin', '$2y$10$e.w2Q3ZOS.M9sWf8qG0QjOH0H3Q9G2n.5i.Z.r1Yy2B.q5k3X3q6m', NULL);