CREATE TABLE usuarios (
	id_usuario MEDIUMINT UNSIGNED AUTO_INCREMENT,
	nome_usuario VARCHAR(50) NOT NULL,
	senha VARCHAR(50) NOT NULL,
	cpf CHAR(14) UNIQUE,	#999.999.999-99
	cnpj CHAR(18) UNIQUE,	#99.999.999/9999-99 
	cep CHAR(9) NOT NULL,	#99999-999
	email_usuario VARCHAR(50) NOT NULL UNIQUE,
	telefone_usuario CHAR(15) NOT NULL, #(99) 99999-9999
	admin TINYINT(1) DEFAULT 0, #0 ou 1
		PRIMARY KEY (id_usuario)
);

CREATE TABLE registros_financeiros (
	id_registro MEDIUMINT UNSIGNED AUTO_INCREMENT,
	data_registro DATE NOT NULL, #'AAAA-MM-DD'
	valor DECIMAL(11, 2) NOT NULL, #999999999.99
	descricao TEXT NOT NULL,
		PRIMARY KEY (id_registro)
);

CREATE TABLE pedidos (
	id_pedido MEDIUMINT UNSIGNED AUTO_INCREMENT,
	tipo_evento VARCHAR(50) NOT NULL,
	orcamento DECIMAL(11, 2) UNSIGNED NOT NULL, #999999999.99
	status_pedido VARCHAR(20) DEFAULT 'Pendente',
	data_pedido DATE DEFAULT CURRENT_DATE(), #'AAAA-MM-DD'
	inicio_evento DATETIME NOT NULL,	#'AAAA-MM-DD HH:MM'
	fim_evento DATETIME NOT NULL,		#'AAAA-MM-DD HH:MM'
	qtd_convidados MEDIUMINT UNSIGNED NOT NULL,
	endereco TINYTEXT NOT NULL,
	observacoes TEXT,
		PRIMARY KEY (id_pedido),
  
	usuario_id MEDIUMINT UNSIGNED NOT NULL,
		FOREIGN KEY (usuario_id) REFERENCES usuarios (id_usuario)
);

CREATE TABLE funcionarios (
	cpf_funcionario CHAR(14),	#999.999.999-99
	nome_funcionario VARCHAR(50) NOT NULL,
	cargo VARCHAR(50) NOT NULL,
	salario DECIMAL(11, 2) UNSIGNED NOT NULL,	#999999999.99
	email_funcionario VARCHAR(50) NOT NULL,
	telefone_funcionario CHAR(15) NOT NULL,	#(99) 99999-9999
		PRIMARY KEY (cpf_funcionario)
);

CREATE TABLE pedido_funcionarios (
	pedido_id MEDIUMINT UNSIGNED NOT NULL,
	funcionario_cpf CHAR(14) NOT NULL,
		FOREIGN KEY (pedido_id) REFERENCES pedidos (id_pedido),
		FOREIGN KEY (funcionario_cpf) REFERENCES funcionarios (cpf_funcionario)
);

CREATE TABLE utilitarios (
	id_utilitario SMALLINT UNSIGNED AUTO_INCREMENT,
	nome_utilitario VARCHAR(50) NOT NULL,
	preco_utilitario DECIMAL(11, 2) UNSIGNED NOT NULL, #999999999.99
	estoque_utilitario MEDIUMINT UNSIGNED NOT NULL,
	descricao_utilitario TINYTEXT,
	url_imagem_u TEXT NOT NULL,
		PRIMARY KEY (id_utilitario)
);

CREATE TABLE pedido_utilitarios (
	pedido_id MEDIUMINT UNSIGNED NOT NULL,
	utilitario_id SMALLINT UNSIGNED NOT NULL,
	qtd_utilitario MEDIUMINT UNSIGNED NOT NULL,
		FOREIGN KEY (pedido_id) REFERENCES pedidos (id_pedido),
		FOREIGN KEY (utilitario_id) REFERENCES utilitarios (id_utilitario)
);

CREATE TABLE comidas (
	id_comida SMALLINT UNSIGNED AUTO_INCREMENT,
	nome_comida VARCHAR(50) NOT NULL,
	preco_comida DECIMAL(11, 2) UNSIGNED NOT NULL, #999999999.99
	estoque_comida MEDIUMINT UNSIGNED NOT NULL,
	tipo VARCHAR(9) NOT NULL, #Entrada, Principal, Sobremesa ou Bebida
  	categoria VARCHAR(50) NOT NULL,
	descricao_comida TINYTEXT,
	url_imagem_c TEXT NOT NULL,
		PRIMARY KEY (id_comida)
);

CREATE TABLE pedido_comidas (
	pedido_id MEDIUMINT UNSIGNED NOT NULL,
	comida_id SMALLINT UNSIGNED NOT NULL,
	qtd_comida MEDIUMINT UNSIGNED NOT NULL,
		FOREIGN KEY (pedido_id) REFERENCES pedidos (id_pedido),
		FOREIGN KEY (comida_id) REFERENCES comidas (id_comida)
);