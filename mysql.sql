CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jus_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `casos` varchar(45) DEFAULT NULL,
  `id_casos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_casos` (`id_casos`),
  CONSTRAINT `jus_adv_ibfk_1` FOREIGN KEY (`id_casos`) REFERENCES `casos` (`id_casos`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cliente_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `id_casos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `id_casos` (`id_casos`),
  CONSTRAINT `cliente_adv_ibfk_1` FOREIGN KEY (`id_casos`) REFERENCES `casos` (`id_casos`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `casos` (
  `id_casos` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `adv` varchar(100) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  PRIMARY KEY (`id_casos`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
