DROP DATABASE IF EXISTS Healthbuddy;
CREATE DATABASE Healthbuddy;

USE Healthbuddy;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    idade INT NOT NULL,
    profissao VARCHAR(100) NOT NULL,
    saude VARCHAR(100) NOT NULL,
    objetivo VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE if not EXISTS medicamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE IF NOT EXISTS sintomas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sintoma VARCHAR(255) NOT NULL,
    description TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Inserir 5 pacientes
INSERT INTO users (name, email, idade, profissao, saude, objetivo, password)
VALUES
('Alice Souza', 'alice.souza@example.com', 28, 'Professora', 'Boa', 'Manter a saúde', '$2y$10$7Ph62nn4TBIHLq6G4f6nQugLa/x0vqbAIeEYZ/vz.aEbi.OVzDjue'),
('Bruno Lima', 'bruno.lima@example.com', 35, 'Engenheiro', 'Regular', 'Perder peso', '$2y$10$7Ph62nn4TBIHLq6G4f6nQugLa/x0vqbAIeEYZ/vz.aEbi.OVzDjue'),
('Carla Mendes', 'carla.mendes@example.com', 42, 'Designer', 'Boa', 'Aumentar a energia', '$2y$10$7Ph62nn4TBIHLq6G4f6nQugLa/x0vqbAIeEYZ/vz.aEbi.OVzDjue'),
('Daniel Costa', 'daniel.costa@example.com', 50, 'Médico', 'Regular', 'Controlar o estresse', '$2y$10$7Ph62nn4TBIHLq6G4f6nQugLa/x0vqbAIeEYZ/vz.aEbi.OVzDjue'),
('Eduarda Nunes', 'eduarda.nunes@example.com', 60, 'Aposentada', 'Frágil', 'Melhorar imunidade', '$2y$10$7Ph62nn4TBIHLq6G4f6nQugLa/x0vqbAIeEYZ/vz.aEbi.OVzDjue');

-- Recuperar os IDs dos usuários para vincular os medicamentos e sintomas
SELECT id FROM users;

-- Inserir medicamentos para cada usuário
INSERT INTO medicamentos (user_id, name, hora)
VALUES
(1, 'Paracetamol', '08:00:00'),
(1, 'Vitamina D', '12:00:00'),
(1, 'Omeprazol', '20:00:00'),
(2, 'Ibuprofeno', '07:00:00'),
(2, 'Cálcio', '13:00:00'),
(2, 'Loratadina', '22:00:00'),
(3, 'Aspirina', '09:00:00'),
(3, 'Multivitamínico', '14:00:00'),
(3, 'Metformina', '21:00:00'),
(4, 'Enalapril', '06:00:00'),
(4, 'Vitamina B12', '11:00:00'),
(4, 'Simvastatina', '18:00:00'),
(5, 'Losartana', '08:30:00'),
(5, 'Magnésio', '12:30:00'),
(5, 'Melatonina', '21:30:00');

-- Inserir sintomas para cada usuário
INSERT INTO sintomas (user_id, sintoma, description)
VALUES
(1, 'Dor de cabeça', 'Dor leve e ocasional na região frontal.'),
(1, 'Cansaço', 'Sensação de fadiga durante o dia.'),
(1, 'Refluxo', 'Desconforto após refeições.'),
(2, 'Febre', 'Temperatura elevada por curtos períodos.'),
(2, 'Congestão nasal', 'Dificuldade para respirar.'),
(2, 'Tosse', 'Tosse seca e persistente.'),
(3, 'Ansiedade', 'Sensação de nervosismo antes de reuniões.'),
(3, 'Insônia', 'Dificuldade para dormir à noite.'),
(3, 'Dores musculares', 'Dores leves nos braços e nas costas.'),
(4, 'Pressão alta', 'Leitura de pressão acima do normal.'),
(4, 'Fadiga', 'Cansaço ao fim do dia.'),
(4, 'Tontura', 'Episódios de desequilíbrio.'),
(5, 'Artrite', 'Dor nas articulações, especialmente ao acordar.'),
(5, 'Dores nas costas', 'Desconforto na região lombar.'),
(5, 'Imunidade baixa', 'Susceptibilidade a gripes e resfriados.');

-- Tabela para agendamento de consultas
CREATE TABLE IF NOT EXISTS consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    data_consulta DATE NOT NULL,
    hora_consulta TIME NOT NULL,
    medico VARCHAR(100) NOT NULL,
    especialidade VARCHAR(100) NOT NULL,
    historico TEXT,
    status ENUM('agendada', 'cancelada', 'realizada') DEFAULT 'agendada',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabela para médicos recomendados
CREATE TABLE IF NOT EXISTS medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especialidade VARCHAR(100) NOT NULL,
    endereco TEXT NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    avaliacao DECIMAL(3, 2),
    preco_consulta DECIMAL(10, 2),
    aceita_plano BOOLEAN DEFAULT FALSE
);

-- Tabela para configurações de acessibilidade
CREATE TABLE acessibilidade (
    user_id INT PRIMARY KEY,
    alto_contraste BOOLEAN DEFAULT FALSE,
    tamanho_fonte ENUM('normal', 'grande', 'extra-grande') DEFAULT 'normal',
    leitor_tela BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabela para histórico médico resumido
CREATE TABLE IF NOT EXISTS historico_medico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tipo ENUM('alergia', 'doenca', 'cirurgia', 'medicamento', 'outro') NOT NULL,
    descricao TEXT NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    gravidade ENUM('leve', 'moderada', 'grave'),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Inserir dados de exemplo para médicos
INSERT INTO medicos (nome, especialidade, endereco, telefone, latitude, longitude, avaliacao, preco_consulta, aceita_plano)
VALUES
('Dr. Carlos Silva', 'Psiquiatria', 'Av. Paulista, 1000, São Paulo - SP', '(11) 9999-8888', -23.563099, -46.656571, 4.8, 300.00, TRUE),
('Dra. Ana Oliveira', 'Neurologia', 'Rua Augusta, 200, São Paulo - SP', '(11) 9999-7777', -23.554321, -46.663210, 4.7, 350.00, TRUE),
('Dr. Marcos Santos', 'Cardiologia', 'Alameda Santos, 500, São Paulo - SP', '(11) 9999-6666', -23.567890, -46.653210, 4.9, 400.00, FALSE),
('Dra. Juliana Costa', 'Psicologia', 'Rua Oscar Freire, 300, São Paulo - SP', '(11) 9999-5555', -23.558765, -46.673210, 4.6, 250.00, TRUE),
('Dr. Roberto Almeida', 'Clínico Geral', 'Av. Rebouças, 600, São Paulo - SP', '(11) 9999-4444', -23.561234, -46.663210, 4.5, 200.00, TRUE);

-- Inserir dados de exemplo para histórico médico
INSERT INTO historico_medico (user_id, tipo, descricao, data_inicio, data_fim, gravidade)
VALUES
(1, 'alergia', 'Alergia a penicilina', NULL, NULL, 'grave'),
(1, 'doenca', 'Depressão moderada', '2020-01-01', NULL, 'moderada'),
(2, 'doenca', 'Hipertensão arterial', '2018-05-15', NULL, 'moderada'),
(3, 'cirurgia', 'Apendicectomia', '2015-10-20', '2015-11-01', 'moderada'),
(4, 'medicamento', 'Uso contínuo de Enalapril', '2019-03-10', NULL, 'leve'),
(5, 'doenca', 'Diabetes tipo 2', '2010-08-05', NULL, 'moderada');