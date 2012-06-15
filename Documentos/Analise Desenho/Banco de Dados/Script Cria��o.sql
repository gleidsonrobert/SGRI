CREATE DATABASE ti;
USE ti;

CREATE TABLE horarioTurma (
  idHorario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idTurma INTEGER UNSIGNED NOT NULL,
  inicioHorario TIME NOT NULL,
  fimHorario TIME NOT NULL,
  diaHorario CHAR(1) NOT NULL,
  PRIMARY KEY(idHorario),
  INDEX horarioTurma_FKIndex1(idTurma)
);

CREATE TABLE itemReserva (
  idReserva INTEGER UNSIGNED NOT NULL,
  idRecurso INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idReserva, idRecurso),
  INDEX Reserva_has_Recurso_FKIndex1(idReserva),
  INDEX Reserva_has_Recurso_FKIndex2(idRecurso)
);

CREATE TABLE ocorrencia (
  idOcorrencia INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  loginUsuario VARCHAR(20) NOT NULL,
  descricaoOcorrencia TEXT NOT NULL,
  dataOcorrencia DATE NOT NULL,
  PRIMARY KEY(idOcorrencia),
  INDEX Ocorrencia_FKIndex1(loginUsuario)
);

CREATE TABLE pessoa (
  cpfPessoa VARCHAR(11) NOT NULL,
  nomePessoa VARCHAR(50) NOT NULL,
  nascimentoPessoa DATE NULL,
  sexoPessoa CHAR(1) NULL,
  enderecoPessoa VARCHAR(100) NULL,
  cidadePessoa VARCHAR(50) NULL,
  ufPessoa CHAR(2) NULL,
  telefonePessoa VARCHAR(8) NULL,
  emailPessoa VARCHAR(50) NULL,
  graduacaoFuncionario VARCHAR(50) NULL,
  funcaoFuncionario VARCHAR(30) NULL,
  graduacaoProfessor VARCHAR(50) NULL,
  mestradoProfessor VARCHAR(50) NULL,
  doutoradoProfessor VARCHAR(50) NULL,
  cursoCoordenador VARCHAR(30) NULL,
  tipoPessoa CHAR(1) NOT NULL,
  PRIMARY KEY(cpfPessoa)
);

CREATE TABLE professorEvento (
  cpfProfessor VARCHAR(11) NOT NULL,
  idReserva INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(cpfProfessor, idReserva),
  INDEX Pessoa_has_Reserva_FKIndex1(cpfProfessor),
  INDEX Pessoa_has_Reserva_FKIndex2(idReserva)
);

CREATE TABLE recurso (
  idRecurso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  patrimonioEquipamento VARCHAR(30) NULL,
  descricaoEquipamento VARCHAR(100) NULL,
  tipoEquipamento VARCHAR(20) NULL,
  statusEquipamento BOOL NULL,
  numeroSala CHAR(3) NULL,
  descricaoSala VARCHAR(100) NULL,
  localizacaoSala VARCHAR(30) NULL,
  capacidadeSala INTEGER UNSIGNED NULL,
  tipoSala VARCHAR(20) NULL,
  tipoRecurso CHAR(1) NOT NULL,
  PRIMARY KEY(idRecurso)
);

CREATE TABLE reserva (
  idReserva INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  idHorario INTEGER UNSIGNED NULL,
  loginUsuario VARCHAR(20) NOT NULL,
  dataReserva DATE NOT NULL,
  dataAula DATE NULL,
  nomeEvento VARCHAR(50) NULL,
  inicioEvento DATE NULL,
  fimEvento DATE NULL,
  tipoReserva CHAR(1) NULL,
  PRIMARY KEY(idReserva),
  INDEX Reserva_FKIndex1(loginUsuario),
  INDEX Reserva_FKIndex2(idHorario)
);

CREATE TABLE turma (
  idTurma INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cpfProfessor VARCHAR(11) NOT NULL,
  disciplinaTurma VARCHAR(30) NOT NULL,
  numeroSala INTEGER UNSIGNED NULL,
  PRIMARY KEY(idTurma),
  INDEX Turma_FKIndex1(cpfProfessor)
);

CREATE TABLE usuario (
  loginUsuario VARCHAR(20) NOT NULL,
  senhaUsuario VARCHAR(20) NOT NULL,
  permissaoUsuario CHAR(1) NOT NULL,
  cpfPessoa VARCHAR(11) NOT NULL,
  PRIMARY KEY(loginUsuario),
  INDEX Usuario_FKIndex1(cpfPessoa)
);

INSERT INTO `horarioTurma` VALUES (7,22,'20:50:00','22:30:00','1');
INSERT INTO `horarioTurma` VALUES (8,22,'19:00:00','20:40:00','2');
INSERT INTO `horarioTurma` VALUES (9,23,'19:00:00','20:40:00','1');
INSERT INTO `horarioTurma` VALUES (10,23,'20:50:00','22:30:00','4');
INSERT INTO `horarioTurma` VALUES (11,24,'19:00:00','20:40:00','4');
INSERT INTO `horarioTurma` VALUES (12,24,'20:50:00','22:30:00','2');
INSERT INTO `itemReserva` VALUES (16,15);
INSERT INTO `itemReserva` VALUES (16,16);
INSERT INTO `itemReserva` VALUES (16,23);
INSERT INTO `itemReserva` VALUES (16,25);
INSERT INTO `itemReserva` VALUES (16,29);
INSERT INTO `itemReserva` VALUES (16,30);
INSERT INTO `itemReserva` VALUES (16,33);
INSERT INTO `itemReserva` VALUES (16,37);
INSERT INTO `itemReserva` VALUES (16,38);
INSERT INTO `itemReserva` VALUES (16,39);
INSERT INTO `itemReserva` VALUES (17,19);
INSERT INTO `itemReserva` VALUES (17,31);
INSERT INTO `itemReserva` VALUES (17,34);
INSERT INTO `itemReserva` VALUES (20,17);
INSERT INTO `itemReserva` VALUES (20,31);
INSERT INTO `itemReserva` VALUES (20,36);
INSERT INTO `itemReserva` VALUES (22,19);
INSERT INTO `itemReserva` VALUES (22,29);
INSERT INTO `itemReserva` VALUES (22,33);
INSERT INTO `itemReserva` VALUES (26,25);
INSERT INTO `itemReserva` VALUES (27,15);
INSERT INTO `itemReserva` VALUES (27,31);
INSERT INTO `itemReserva` VALUES (28,21);
INSERT INTO `itemReserva` VALUES (28,29);
INSERT INTO `ocorrencia` VALUES (4,'admin','Auditório pegou fogo!','2012-05-15');
INSERT INTO `pessoa` VALUES ('11111111111','Maria Augusta','0000-00-00','','  ','','','','',NULL,NULL,'','','',NULL,'P');
INSERT INTO `pessoa` VALUES ('11111111112','Manoel Palhares','0000-00-00','','  ','','','','',NULL,NULL,'','','',NULL,'P');
INSERT INTO `pessoa` VALUES ('11111111113','Viviane Cristina','0000-00-00','','  ','','','','',NULL,NULL,'','','',NULL,'P');
INSERT INTO `pessoa` VALUES ('11111111114','Rodrigo Richard','0000-00-00','','  ','','','','',NULL,NULL,'','','',NULL,'P');
INSERT INTO `pessoa` VALUES ('11111111115','Enivaldo Souza','0000-00-00','','  ','','','','',NULL,NULL,'','','',NULL,'P');
INSERT INTO `pessoa` VALUES ('11111111116','Francisco Silva','0000-00-00','','  ','','','','',NULL,NULL,'','','',NULL,'P');
INSERT INTO `pessoa` VALUES ('22222222221','Saulo Augusto','0000-00-00','','  ','','','','',NULL,NULL,'','','','','C');
INSERT INTO `pessoa` VALUES ('22222222222','Marcelo Werneck','0000-00-00','','  ','','','','',NULL,NULL,'','','','','C');
INSERT INTO `pessoa` VALUES ('33333333331','Tulio Henrique','0000-00-00','','  ','','','','','','',NULL,NULL,NULL,NULL,'F');
INSERT INTO `pessoa` VALUES ('33333333332','Wander Maia','0000-00-00','','  ','','','','','','',NULL,NULL,NULL,NULL,'F');
INSERT INTO `pessoa` VALUES ('33333333333','Romulo Jorge','0000-00-00','','  ','','','','','','',NULL,NULL,NULL,NULL,'F');
INSERT INTO `professorEvento` VALUES ('11111111111',16);
INSERT INTO `professorEvento` VALUES ('11111111111',17);
INSERT INTO `professorEvento` VALUES ('11111111113',17);
INSERT INTO `professorEvento` VALUES ('11111111114',16);
INSERT INTO `professorEvento` VALUES ('11111111114',20);
INSERT INTO `professorEvento` VALUES ('11111111115',20);
INSERT INTO `professorEvento` VALUES ('11111111115',22);
INSERT INTO `professorEvento` VALUES ('22222222221',16);
INSERT INTO `professorEvento` VALUES ('22222222221',17);
INSERT INTO `professorEvento` VALUES ('22222222221',22);
INSERT INTO `professorEvento` VALUES ('22222222222',16);
INSERT INTO `professorEvento` VALUES ('22222222222',20);
INSERT INTO `recurso` VALUES (12,'0001','Notebook 12 pol.','Notebook',0,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (13,'0002','Notebook 11 pol.','Notebook',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (14,'0003','Notebook 10 pol.','Notebook',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (15,'0004','Notebook 14 pol.','Notebook',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (16,'0005','Notebook 14 pol.','Notebook',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (17,'0006','Notebook 15 pol.','Notebook',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (18,'0007','Notebook 15 pol.','Notebook',0,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (19,'0008','Notebook 17 pol.','Notebook',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (20,'0009','Tablet 10 pol.','Notebook',0,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (21,'1110','Televisão 21 pol.','TV',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (22,'1111','Televisão 29 pol.','TV',0,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (23,'1112','Televisão 29 pol.','TV',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (24,'2220','DVD Player','DVD Player',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (25,'2221','DVD Player c/ microfone','DVD Player',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (26,'2222','Bluray Player','DVD Player',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (27,'2223','DVD Player portátil','DVD Player',0,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (28,'2224','DVD Player portátil','DVD Player',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (29,'3330','Projetor Multimídia 4:3','DataShow',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (30,'3331','Projetor Multimídia 4:3','DataShow',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (31,'3332','Projetor Multimídia 16:9','DataShow',1,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (32,'3333','Projetor Multimídia 16:9','DataShow',0,NULL,NULL,NULL,NULL,NULL,'E');
INSERT INTO `recurso` VALUES (33,NULL,NULL,NULL,NULL,'0','Auditório Principal','Prédio 2',300,'Auditorio','S');
INSERT INTO `recurso` VALUES (34,NULL,NULL,NULL,NULL,'0','Auditório Novo','Prédio 5',500,'Auditorio','S');
INSERT INTO `recurso` VALUES (35,NULL,NULL,NULL,NULL,'305','Laboratório de Montagem e Manutenção','Prédio 2',20,'Laboratorio','S');
INSERT INTO `recurso` VALUES (36,NULL,NULL,NULL,NULL,'312','Laboratório de Infra-Estrutura','Prédio 2',20,'Laboratorio','S');
INSERT INTO `recurso` VALUES (37,NULL,NULL,NULL,NULL,'304','Sala Multimeios','Prédio 3',50,'Multimeio','S');
INSERT INTO `recurso` VALUES (38,NULL,NULL,NULL,NULL,'201','Sala p/ Palestras','Prédio 4',60,'Sala de Aula','S');
INSERT INTO `recurso` VALUES (39,NULL,NULL,NULL,NULL,'202','Sala p/ Palestras','Prédio 4',60,'Sala de Aula','S');
INSERT INTO `reserva` VALUES (16,NULL,'saulo.augusto','2012-05-25',NULL,'14ª Semana de Sistemas','2012-05-14','2012-05-17','E');
INSERT INTO `reserva` VALUES (17,NULL,'saulo.augusto','2012-05-25',NULL,'Programação em Dispositivos Móveis','2012-05-07','2012-05-09','E');
INSERT INTO `reserva` VALUES (20,NULL,'marcelo.werneck','2012-05-25',NULL,'Desenvolvimento Dot.Net','2012-05-17','2012-05-18','E');
INSERT INTO `reserva` VALUES (22,NULL,'saulo.augusto','2012-05-31',NULL,'Evento de Teste','2012-06-10','2012-06-11','E');
INSERT INTO `reserva` VALUES (26,9,'manoel.palhares','2012-06-03','2012-06-04',NULL,NULL,NULL,'A');
INSERT INTO `reserva` VALUES (27,7,'maria.augusta','2012-06-03','2012-06-04',NULL,NULL,NULL,'A');
INSERT INTO `reserva` VALUES (28,12,'saulo.augusto','2012-06-03','2012-06-05',NULL,NULL,NULL,'A');
INSERT INTO `turma` VALUES (22,'11111111111','Projeto de Sistemas de Informacao',304);
INSERT INTO `turma` VALUES (23,'11111111112','Banco de Dados I',304);
INSERT INTO `turma` VALUES (24,'22222222221','Inteligencia Artificial',304);
INSERT INTO `usuario` VALUES ('admin','123','S','00000000000');
INSERT INTO `usuario` VALUES ('enivaldo.souza','123','P','11111111115');
INSERT INTO `usuario` VALUES ('francisco.silva','123','P','11111111116');
INSERT INTO `usuario` VALUES ('manoel.palhares','123','P','11111111112');
INSERT INTO `usuario` VALUES ('marcelo.werneck','123','C','22222222222');
INSERT INTO `usuario` VALUES ('maria.augusta','123','P','11111111111');
INSERT INTO `usuario` VALUES ('rodrigo.richard','123','P','11111111114');
INSERT INTO `usuario` VALUES ('romulo.jorge','123','F','33333333333');
INSERT INTO `usuario` VALUES ('saulo.augusto','123','C','22222222221');
INSERT INTO `usuario` VALUES ('tulio.henrique','123','F','33333333331');
INSERT INTO `usuario` VALUES ('viviane.cristina','123','P','11111111113');
INSERT INTO `usuario` VALUES ('wander.maia','123','F','33333333332');