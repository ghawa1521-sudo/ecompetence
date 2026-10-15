-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `bd_grh` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bd_grh`;

DROP TABLE IF EXISTS `affecter`;
CREATE TABLE `affecter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateprise` date DEFAULT NULL,
  `etatAffectation` int(11) NOT NULL,
  `etatSave` int(11) NOT NULL,
  `signeNote` int(11) NOT NULL,
  `dateNote` date DEFAULT NULL,
  `signeCertificat` int(11) NOT NULL,
  `dateCertificat` date DEFAULT NULL,
  `id_doc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C290057A18E5153E` (`id_doc`),
  CONSTRAINT `FK_C290057A18E5153E` FOREIGN KEY (`id_doc`) REFERENCES `document` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `affecter` (`id`, `numero`, `dateprise`, `etatAffectation`, `etatSave`, `signeNote`, `dateNote`, `signeCertificat`, `dateCertificat`, `id_doc`) VALUES
(1,	'CE16-0000355',	'2017-08-16',	1,	0,	0,	NULL,	0,	NULL,	NULL),
(2,	'324546H',	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL),
(3,	'CP16-000456',	'2017-08-08',	1,	0,	0,	NULL,	0,	NULL,	NULL),
(4,	'CP16-0004565',	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL),
(5,	'vkfy',	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL),
(6,	'546546H',	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL),
(12,	NULL,	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL),
(13,	NULL,	NULL,	1,	1,	0,	NULL,	0,	NULL,	NULL),
(14,	NULL,	NULL,	1,	1,	0,	NULL,	0,	NULL,	NULL),
(16,	NULL,	NULL,	2,	0,	1,	'2017-10-24',	1,	'2017-10-24',	NULL),
(17,	NULL,	NULL,	1,	1,	0,	NULL,	0,	NULL,	NULL),
(18,	NULL,	NULL,	1,	1,	0,	NULL,	0,	NULL,	NULL),
(19,	NULL,	NULL,	2,	0,	1,	'2017-10-31',	1,	'2017-10-31',	NULL),
(20,	NULL,	NULL,	2,	0,	1,	'2017-10-31',	1,	'2017-11-14',	NULL),
(21,	NULL,	NULL,	2,	0,	1,	'2017-10-10',	1,	'2017-11-14',	NULL),
(22,	NULL,	NULL,	2,	0,	1,	'2017-10-30',	1,	'2017-10-31',	NULL),
(23,	NULL,	NULL,	2,	0,	1,	'2017-11-22',	1,	'2017-11-05',	NULL),
(24,	NULL,	NULL,	2,	0,	1,	'2017-11-13',	1,	'2017-11-13',	NULL),
(25,	NULL,	NULL,	2,	0,	1,	'2017-11-05',	1,	'2017-11-14',	NULL),
(26,	NULL,	NULL,	2,	0,	1,	'2017-11-07',	1,	'2017-11-07',	1),
(27,	NULL,	NULL,	2,	0,	1,	'2017-11-07',	1,	'2017-11-13',	NULL),
(28,	NULL,	NULL,	1,	1,	0,	NULL,	0,	NULL,	NULL),
(29,	NULL,	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL),
(30,	NULL,	NULL,	2,	0,	1,	'2017-11-21',	1,	'2017-11-13',	NULL),
(31,	NULL,	NULL,	2,	0,	1,	'2017-11-13',	1,	'2017-11-13',	NULL),
(32,	NULL,	NULL,	2,	0,	0,	'2017-11-23',	1,	'2017-11-23',	NULL),
(33,	NULL,	NULL,	2,	0,	1,	'2017-11-23',	1,	'2017-11-23',	NULL),
(34,	NULL,	NULL,	2,	0,	1,	'2017-11-23',	1,	'2017-11-23',	NULL),
(35,	NULL,	NULL,	0,	0,	0,	NULL,	0,	NULL,	NULL);

DROP TABLE IF EXISTS `agent`;
CREATE TABLE `agent` (
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_provenance` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `id_fonction` int(11) DEFAULT NULL,
  `id_emploi` int(11) DEFAULT NULL,
  `id_titre` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_promotion` int(11) DEFAULT NULL,
  `id_syndicat` int(11) DEFAULT NULL,
  `id_sexe` int(11) DEFAULT NULL,
  `id_direction` int(11) DEFAULT NULL,
  `id_echelon` int(11) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomJeuneFille` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateNaiss` date DEFAULT NULL,
  `nomPere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomMere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nbEnf` int(11) DEFAULT NULL,
  `indice` int(11) DEFAULT NULL,
  `datePremierService` date DEFAULT NULL,
  `datePriseServiceDge` date DEFAULT NULL,
  `agent_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `telBur` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telPort` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telDom` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quartier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomConjoint` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telConjoint` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descriComp` longtext COLLATE utf8_unicode_ci,
  `agent_cv` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telUrgent1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telUrgent2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_lieuNaiss` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_situationMatrimoniale` int(11) DEFAULT NULL,
  `id_situationMili` int(11) DEFAULT NULL,
  `cv_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_cv_at` datetime DEFAULT NULL,
  `numPoste` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_affecter` int(11) DEFAULT NULL,
  `CODE_DG` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_SD` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_SC` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_DC` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persUrgent1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persUrgent2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`matricule`),
  UNIQUE KEY `UNIQ_268B9C9D924BE9EF` (`id_affecter`),
  KEY `IDX_268B9C9D248F5D56` (`id_provenance`),
  KEY `IDX_268B9C9D7FE4B2B` (`id_type`),
  KEY `IDX_268B9C9D59DB3928` (`id_fonction`),
  KEY `IDX_268B9C9D52970517` (`id_emploi`),
  KEY `IDX_268B9C9D11F20684` (`id_titre`),
  KEY `IDX_268B9C9DA9B00A7B` (`id_classe`),
  KEY `IDX_268B9C9D7FEF12CB` (`id_lieuNaiss`),
  KEY `IDX_268B9C9D4128C1F6` (`id_promotion`),
  KEY `IDX_268B9C9D17ABADE3` (`id_syndicat`),
  KEY `IDX_268B9C9D47CCA38E` (`id_sexe`),
  KEY `IDX_268B9C9DBE7F6D94` (`id_direction`),
  KEY `IDX_268B9C9DB8075A76` (`id_echelon`),
  KEY `IDX_268B9C9D524749F2` (`id_situationMatrimoniale`),
  KEY `IDX_268B9C9D2CD04499` (`id_situationMili`),
  KEY `IDX_268B9C9DC75691A` (`CODE_DG`),
  KEY `IDX_268B9C9D90FFBC36` (`CODE_SD`),
  KEY `IDX_268B9C9DE9B2995` (`CODE_SC`),
  CONSTRAINT `FK_268B9C9D11F20684` FOREIGN KEY (`id_titre`) REFERENCES `titre` (`id`),
  CONSTRAINT `FK_268B9C9D17ABADE3` FOREIGN KEY (`id_syndicat`) REFERENCES `syndicat` (`id`),
  CONSTRAINT `FK_268B9C9D248F5D56` FOREIGN KEY (`id_provenance`) REFERENCES `provenance` (`id`),
  CONSTRAINT `FK_268B9C9D2CD04499` FOREIGN KEY (`id_situationMili`) REFERENCES `position_militaire` (`id`),
  CONSTRAINT `FK_268B9C9D4128C1F6` FOREIGN KEY (`id_promotion`) REFERENCES `promotion` (`id`),
  CONSTRAINT `FK_268B9C9D47CCA38E` FOREIGN KEY (`id_sexe`) REFERENCES `sexe` (`id`),
  CONSTRAINT `FK_268B9C9D524749F2` FOREIGN KEY (`id_situationMatrimoniale`) REFERENCES `situation_matrimoniale` (`id`),
  CONSTRAINT `FK_268B9C9D52970517` FOREIGN KEY (`id_emploi`) REFERENCES `emploi` (`id`),
  CONSTRAINT `FK_268B9C9D59DB3928` FOREIGN KEY (`id_fonction`) REFERENCES `fonction` (`id`),
  CONSTRAINT `FK_268B9C9D7FE4B2B` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`),
  CONSTRAINT `FK_268B9C9D7FEF12CB` FOREIGN KEY (`id_lieuNaiss`) REFERENCES `lieu_naissance` (`id`),
  CONSTRAINT `FK_268B9C9D90FFBC36` FOREIGN KEY (`CODE_SD`) REFERENCES `sous_direction` (`CODE_SD`),
  CONSTRAINT `FK_268B9C9D924BE9EF` FOREIGN KEY (`id_affecter`) REFERENCES `affecter` (`id`),
  CONSTRAINT `FK_268B9C9DA9B00A7B` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`),
  CONSTRAINT `FK_268B9C9DB8075A76` FOREIGN KEY (`id_echelon`) REFERENCES `echelon` (`id`),
  CONSTRAINT `FK_268B9C9DBE7F6D94` FOREIGN KEY (`id_direction`) REFERENCES `direction` (`id`),
  CONSTRAINT `FK_268B9C9DC75691A` FOREIGN KEY (`CODE_DG`) REFERENCES `direction_generale` (`CODE_DG`),
  CONSTRAINT `FK_268B9C9DE9B2995` FOREIGN KEY (`CODE_SC`) REFERENCES `service_direction` (`CODE_SC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `agent` (`matricule`, `id_provenance`, `id_type`, `id_fonction`, `id_emploi`, `id_titre`, `id_classe`, `id_promotion`, `id_syndicat`, `id_sexe`, `id_direction`, `id_echelon`, `nom`, `prenoms`, `nomJeuneFille`, `dateNaiss`, `nomPere`, `nomMere`, `nbEnf`, `indice`, `datePremierService`, `datePriseServiceDge`, `agent_image`, `image_name`, `updated_at`, `telBur`, `telPort`, `telDom`, `quartier`, `nomConjoint`, `telConjoint`, `descriComp`, `agent_cv`, `telUrgent1`, `telUrgent2`, `id_lieuNaiss`, `email`, `id_situationMatrimoniale`, `id_situationMili`, `cv_name`, `updated_cv_at`, `numPoste`, `id_affecter`, `CODE_DG`, `CODE_SD`, `CODE_SC`, `CODE_DC`, `persUrgent1`, `persUrgent2`) VALUES
('123874H',	1,	1,	7,	2,	NULL,	2,	NULL,	1,	2,	8,	3,	'KOUAO',	'TAIBA MARIE CLAUDE',	NULL,	'2007-11-01',	NULL,	NULL,	2,	760,	'2017-11-01',	'2017-11-13',	NULL,	'5a0975414aafc_armoirie2.png',	'2017-11-13 10:34:41',	'32456789',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	14,	'kjxzjixgisux@xnjsbxnjz.fr',	2,	NULL,	'5a0975414b5a7_obsevation séance du vendredi 30 JUIN.docx',	'2017-11-13 10:34:41',	NULL,	31,	'DG0001',	NULL,	NULL,	'DC0003',	NULL,	NULL),
('173892B',	1,	1,	2,	1,	NULL,	2,	NULL,	1,	2,	1,	1,	'Koffi',	'kouakou',	NULL,	'2017-11-06',	NULL,	NULL,	0,	345,	'2017-11-17',	'2017-11-07',	NULL,	'5a00c696ec7af_CI__-1997-01-01.jpg',	'2017-11-06 20:31:18',	'2345678',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	9,	'admin@stephenjlo.xyz',	1,	NULL,	'5a00c696ef236_Année Scolaire.docx',	'2017-11-06 20:31:18',	NULL,	26,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('223554G',	1,	1,	6,	1,	NULL,	1,	NULL,	1,	NULL,	2,	1,	'YAO',	'KOFFI',	NULL,	'2016-06-08',	'bklhk:',	'BKLJLJ',	2,	125,	'2016-07-04',	'2016-07-12',	NULL,	'Angular.png',	'2016-07-15 14:37:39',	'5346346D',	'1556156',	'BK/dsQ',	'ILYHIHL/',	'K/J§L',	'K/N§LJ§LK',	'NO',	NULL,	NULL,	NULL,	24,	'gjkhskls@vxsh.co',	3,	1,	'BILLET.pdf',	'2016-07-15 14:37:39',	'616513',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('278 944 J',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	2,	1,	1,	'ASSEMIAN',	'Yolande Amédée Djoma',	NULL,	'2016-06-07',	'OK xai',	'NO',	0,	456,	'2016-06-16',	'2016-06-08',	NULL,	'images.jpg',	'2016-06-08 08:33:02',	'234567903',	NULL,	NULL,	'plateau',	'test²',	NULL,	'OK',	NULL,	NULL,	NULL,	12,	'dogbo.curtis@gmail.com',	1,	1,	'cahier des charges pour la realisation des sites Web des ministeres.docx',	'2016-06-08 08:33:02',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('284589W',	1,	1,	1,	4,	NULL,	2,	NULL,	1,	2,	2,	2,	'DANHO',	NULL,	'TANON Marie-Noelle',	'1987-11-10',	'Kofii YAPO',	'Kouadio aya',	2,	670,	'2017-11-01',	'2017-11-23',	NULL,	'5a16ac8821629_tof_dge.jpg',	'2017-11-23 11:10:00',	'20213456',	NULL,	NULL,	'Abobo',	'Aya Kouamé',	'07 23 32 34',	NULL,	NULL,	NULL,	NULL,	5,	'koffi156@gmail.com',	2,	NULL,	'5a16ac882a4a8_facture hebergement mutualisé.pdf',	'2017-11-23 11:10:00',	NULL,	34,	'DG0001',	'SD000011',	NULL,	'DC00010',	NULL,	NULL),
('323065Z',	1,	1,	1,	4,	NULL,	2,	NULL,	1,	2,	2,	2,	'AMAVI',	'Ayélé Virginie Sandrine',	NULL,	'2017-11-01',	NULL,	NULL,	1,	654,	'2017-11-01',	'2017-11-23',	NULL,	'5a169b541f4b3_CI__-1997-01-01.jpg',	'2017-11-23 09:56:36',	'20213456',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	'fdghjkklmk@fghjk.fr',	1,	NULL,	'5a169b5421d6c_diagramme de classe.docx',	'2017-11-23 09:56:36',	NULL,	33,	'DG0001',	'SD000011',	NULL,	NULL,	NULL,	NULL),
('324999J',	1,	1,	1,	3,	NULL,	2,	NULL,	2,	1,	NULL,	3,	'RYTYUIO',	'BUOH8',	NULL,	'2017-12-13',	NULL,	NULL,	9,	2345,	'2017-12-13',	NULL,	NULL,	'5a237bdbe2b10_armoirie2.png',	'2017-12-03 04:21:47',	'34567890',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	6,	'abihsuhsoi@fnk.com',	3,	1,	'5a237bdbe3a88_cr presentation E-rh.odt',	'2017-12-03 04:21:47',	NULL,	35,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('365572C',	1,	1,	5,	3,	NULL,	2,	NULL,	2,	2,	2,	1,	'MOGNIN',	NULL,	'KOFFI Marie-Louise Chantal',	'1976-11-21',	NULL,	NULL,	2,	850,	'2012-02-01',	'2017-11-23',	NULL,	'5a1692f930958_armoirie2.png',	'2017-11-23 09:20:57',	'20213456',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	21,	'k.mognin@finances.gouv.ci',	2,	NULL,	'5a1692f931b59_facture hebergement Serveur Dédié.pdf',	'2017-11-23 09:20:57',	NULL,	32,	'DG0001',	NULL,	NULL,	NULL,	NULL,	NULL),
('385175Q',	NULL,	1,	2,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'SILUE',	'WONGNIGUE',	'2222222',	'2017-10-26',	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-10-24',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'-Connaisances en rédaction \r\n- PHP\r\n-Expert en Bavardage\r\n-Spécialiste à 9h heure d\'arrivée',	NULL,	NULL,	NULL,	NULL,	NULL,	2,	NULL,	'demo.docx',	'2017-10-26 08:23:47',	NULL,	16,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('385175T',	1,	1,	2,	1,	NULL,	2,	NULL,	3,	1,	1,	2,	'SILUE',	'FOLOGO',	NULL,	'2016-10-03',	'SILUE',	'SILUE',	2,	885,	'2017-06-01',	'2017-06-03',	NULL,	'29299196-Dessin-serrer-la-main-Vector-illustration-Banque-d\'images.jpg',	'2017-06-30 12:10:05',	'20214877',	'09609447',	'24396514',	'PLATEAU DOKUI',	'SILUE',	'09854721',	'ODFJNPOVJPOSVJPISFVJPISVJSPJIS',	NULL,	'09609447',	NULL,	11,	'silayeur@gmail.com',	2,	1,	'Enterprise Ressource Planning-Progiciel de Gestion Intégré.pdf',	'2017-06-30 12:10:06',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('428413M',	NULL,	1,	3,	2,	NULL,	NULL,	NULL,	NULL,	2,	1,	NULL,	'MEITE',	'Madioman',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Technicien de l\'Informatique en provenance de l\'OCPV',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'Loi_n92-570_du_11_septembre_1992.pdf',	'2017-10-24 15:21:55',	NULL,	NULL,	'DG0001',	'SD1001',	NULL,	'DC00010',	NULL,	NULL),
('765283P',	1,	1,	2,	1,	NULL,	1,	NULL,	NULL,	1,	1,	2,	'AHIBA',	'BOGUIE JEAN YVES',	NULL,	'1991-11-01',	NULL,	NULL,	0,	765,	'2017-11-01',	'2017-11-07',	NULL,	'5a0085e939173_armoirie2.png',	'2017-11-06 15:55:21',	'20214877',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	21,	'admin@stephenjlo.xyz',	1,	1,	'5a0085e93a512_Année Scolaire.docx',	'2017-11-06 15:55:21',	NULL,	25,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('875145D',	1,	1,	3,	1,	NULL,	2,	NULL,	1,	1,	1,	1,	'OTOKOR',	'Rodolphe',	NULL,	'2016-10-19',	'gvyiyivbuobuo',	'nouiniooi',	3,	625,	'2016-09-06',	'2016-10-01',	NULL,	'HBD.jpg',	'2016-11-13 14:07:30',	'20125125',	'i',	'noinio',	'ubuobio',	'nonionio',	'45646846+',	NULL,	NULL,	NULL,	NULL,	9,	'yapimobio15@univmetiers.ci',	2,	1,	'IFAP.docx',	'2016-11-13 14:07:30',	NULL,	NULL,	'DG0001',	'SD1001',	NULL,	'DC00010',	NULL,	NULL),
('876543',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	1,	1,	2,	'KOFFI',	'JOACHIM',	NULL,	'2017-10-31',	'DTFGHJKLM',	'TYGYUHIJOKPL',	0,	324,	'2017-10-31',	'2017-11-06',	NULL,	'59f8833491d9b_4.jpg',	'2017-10-31 14:05:40',	'12345678',	'567890',	'4567890',	'FCGVHBJNKL',	'FCYGVHBJNKL',	'23456789',	'Fournir des élément',	NULL,	'CGHVHJBNKL',	NULL,	12,	'abidjan@fdhdj.fr',	1,	2,	'59f8833492ff9_Année Scolaire.docx',	'2017-10-31 14:05:40',	NULL,	23,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('8765445H',	1,	1,	3,	1,	NULL,	2,	NULL,	NULL,	1,	1,	3,	'BOIDY',	'FRANCOIS',	NULL,	'2017-10-01',	NULL,	NULL,	2,	567,	'2017-11-01',	'2017-11-14',	NULL,	'5a0306f4c7931_Permis1.PNG',	'2017-11-08 13:30:28',	'54321344',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	37,	'asjsasos@sxjsk.ci',	1,	1,	'5a0306f4c8a5f_coursdanglais.pdf.pdf',	'2017-11-08 13:30:28',	NULL,	30,	'DG0001',	NULL,	NULL,	NULL,	NULL,	NULL),
('989609M',	1,	1,	10,	2,	NULL,	1,	NULL,	2,	2,	1,	1,	'YAPI',	'MOBIO',	NULL,	'2016-03-09',	'YAPI',	'OUATTARA',	23,	NULL,	'2016-03-23',	'2016-02-14',	NULL,	'SCAN11jpg0002.jpg',	'2016-03-23 11:51:12',	'3456789',	'02345647',	'24399417',	'ABOBO',	'OK',	NULL,	NULL,	'C:\\wamp\\tmp\\phpED34.tmp',	NULL,	NULL,	10,	'stephy.jlo@gmail.com',	1,	1,	'',	'2016-11-13 14:07:30',	'128',	NULL,	'DG0001',	NULL,	NULL,	NULL,	NULL,	NULL),
('A000034',	1,	1,	3,	1,	NULL,	1,	NULL,	1,	1,	1,	1,	'ANASSE',	'MARIE EDIGE',	NULL,	'2017-11-05',	NULL,	NULL,	2,	6543,	'2017-11-20',	'2017-11-05',	NULL,	'59ff482281ec8_CI__-1997-01-01.jpg',	'2017-11-05 17:19:30',	'456789',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	8,	'fghijokpl@oijh.html',	2,	2,	'59ff482283d71_facture hebergement mutualisé.pdf',	'2017-11-05 17:19:30',	NULL,	24,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('AB00003',	1,	1,	1,	2,	NULL,	2,	NULL,	1,	2,	NULL,	3,	'KOFFI',	NULL,	'ADJOUA CAROLINE',	'2007-11-01',	NULL,	NULL,	2,	567,	'2017-11-01',	NULL,	NULL,	'5a0172f606639_CI__-1997-01-01.jpg',	'2017-11-07 08:46:46',	'28767354',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	19,	'dogbo.curtis01@gmail.com',	2,	NULL,	'5a0172f608338_Éléments du cahier de charge.docx',	'2017-11-07 08:46:46',	NULL,	28,	'DG0001',	NULL,	NULL,	NULL,	NULL,	NULL),
('ABD5436',	1,	1,	3,	2,	NULL,	3,	NULL,	1,	1,	1,	2,	'KOUADJO',	'SEPHORA',	NULL,	'2017-10-01',	'ok',	'OK',	2,	546,	'2017-10-01',	'2017-10-17',	NULL,	NULL,	NULL,	'20213412',	'ok',	'ok',	'ok',	'ok',	'ok',	'BIEN DE PARTOU',	NULL,	'ok',	NULL,	12,	'tropicalway@ccooot.com',	1,	1,	'diagramme de classe.docx',	'2017-10-26 09:30:31',	NULL,	17,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('B2333',	1,	1,	2,	1,	NULL,	3,	NULL,	1,	2,	1,	3,	'Kané',	'Moussa',	NULL,	'2017-10-10',	NULL,	NULL,	3,	435,	'2017-10-06',	'2017-10-10',	NULL,	'mangue.jpg',	'2017-10-25 00:40:00',	'2323294204',	NULL,	NULL,	NULL,	NULL,	NULL,	'kpda,zd,',	NULL,	NULL,	NULL,	16,	'tropicalway@ooot.com',	1,	NULL,	'Année Scolaire.docx',	'2017-10-24 15:33:33',	NULL,	13,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('BHHD087',	1,	1,	2,	1,	NULL,	4,	NULL,	NULL,	1,	1,	2,	'GNANCHOU',	'JEAN LOUIS STEPHANE',	NULL,	'2008-02-18',	'hi',	'ihih',	2,	434,	'2017-10-04',	'2017-10-25',	NULL,	'20170528_191212.jpg',	'2017-10-26 11:33:18',	NULL,	'hi',	'hihi',	'hi',	'hihi',	'hihi',	'Technciens Informatique Spécialisé en réseau',	NULL,	'hi',	NULL,	15,	'azgihbdauihz@bhdbc.ci',	1,	1,	'procedure MEF.docx',	'2017-10-26 10:22:16',	NULL,	18,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('bujwhscia',	NULL,	1,	6,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'boullihi',	'hpçihpçiçjçp',	'oubiouhoi',	'2017-10-10',	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-10-31',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'bihnopjo',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'obsevation séance du vendredi 30 JUIN.docx',	'2017-10-29 13:31:15',	NULL,	20,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('bujwhscio',	NULL,	1,	6,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'boullihi',	'hpçihpçiçjçp',	'oubiouhoi',	'2017-10-10',	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-10-24',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'bihnopjo',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'obsevation séance du vendredi 30 JUIN.docx',	'2017-10-29 13:16:25',	NULL,	19,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('CE16-0000355',	1,	1,	3,	2,	NULL,	3,	NULL,	NULL,	1,	2,	2,	'AKO',	'CLEMENTS',	NULL,	'1987-03-01',	'ok',	'ok',	2,	567,	'2016-10-03',	'2017-08-16',	NULL,	'4.jpg',	'2017-10-17 10:16:17',	NULL,	NULL,	NULL,	'OK',	'ok',	'12345678',	NULL,	NULL,	NULL,	NULL,	10,	'admin@stephenjlo.xyz',	1,	1,	'facture hebergement Serveur Dédié.pdf',	'2017-10-17 10:16:17',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('DC2012783Z',	1,	1,	5,	1,	NULL,	1,	NULL,	2,	2,	1,	2,	'YAO',	'FELICITE',	NULL,	'2017-11-01',	NULL,	NULL,	2,	235,	'2017-11-01',	'2017-11-07',	NULL,	'5a0100b2b2857_20170528_191212.jpg',	'2017-11-07 00:39:14',	'2345678',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	14,	'stephy.jlo@gmail.com',	1,	NULL,	'5a0100b2b3ced_facture hebergement Serveur Dédié.pdf',	'2017-11-07 00:39:14',	NULL,	27,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('FBI0001',	1,	1,	1,	2,	NULL,	2,	NULL,	1,	1,	1,	3,	'?I?IP?PP?PI',	'?P?POO?P?PI',	NULL,	'2016-11-01',	',p,p,p,',	',p,p',	5,	45585,	'2016-11-01',	'2016-11-01',	NULL,	'proxy_logo.jpg',	'2016-11-13 19:53:15',	'49348937967',	NULL,	'2012122',	'4,k,k,kn',	',p,po,p,pi,',	'85525859',	'?P?P',	NULL,	'475R457',	NULL,	16,	'stephy.jlo@gmail.com',	1,	1,	'pgadmin.log',	'2016-11-13 19:53:15',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('GP0001',	1,	1,	5,	1,	NULL,	1,	NULL,	1,	1,	1,	2,	'KOFFI',	'LAZARE',	NULL,	'2017-10-15',	'WETXRCTVYBN',	'ERGHJK',	0,	156,	'2017-10-18',	'2017-11-07',	NULL,	'CI__-1997-01-01.jpg',	'2017-10-30 01:28:57',	'234356789',	'XCVBIUN',	'XCVHBIJNO',	'WEXRTCYTVYUBIUOIN',	'RTYHJKKL',	'RTYUIOJO',	'Bien de Partout\r\nTrès performant',	NULL,	'XDCFGVBH',	NULL,	20,	'otokkflorfo@yaho.fr',	1,	1,	'MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf',	'2017-10-30 01:28:57',	NULL,	21,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('I0001',	1,	1,	4,	1,	NULL,	1,	NULL,	1,	1,	1,	1,	'MASSOUO',	'T. FILBERT',	NULL,	'2016-04-12',	'KANGA',	'AHOUCHI FELICIYE',	2,	234,	'2016-04-10',	'2016-04-10',	NULL,	'7.jpg',	'2016-04-11 17:01:07',	'20 21 34 54',	'07 65 43 76',	'22 43 54 17',	'Angré',	'Ouattara Nadège',	'09536743',	NULL,	NULL,	NULL,	NULL,	10,	'stephenjlo@yahoo.fr',	1,	1,	'Database1.accdb',	'2016-04-11 17:01:07',	NULL,	NULL,	'DG0001',	NULL,	NULL,	NULL,	NULL,	NULL),
('I0002',	1,	1,	5,	1,	NULL,	1,	NULL,	2,	1,	1,	1,	'AHOULOU',	'OBROU MELAIN',	NULL,	'2016-04-12',	'XRYDY',	'IBGBUIHIU',	1,	536,	'2016-04-12',	'2016-04-17',	NULL,	'telechargement.jpg',	'2016-04-12 11:05:22',	'20214877',	'03 74 04 54',	'24 464743',	'BUIHOLI',	'?IPJKPO',	'0945687',	NULL,	NULL,	NULL,	NULL,	10,	'stephy2.jlo@gmail.com',	1,	1,	'clé_16G.TXT',	'2016-04-12 11:05:22',	NULL,	NULL,	'DG0001',	NULL,	NULL,	'DC00010',	NULL,	NULL),
('I0003H',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	1,	1,	2,	'GNAMIEN N\'GUESSAN',	'MARIE CLAIRE',	NULL,	'2016-11-01',	'ko',	',po n',	0,	235,	'2016-11-01',	'2016-11-22',	NULL,	'2.PNG',	'2016-11-21 09:16:13',	NULL,	'156489',	'buobuo',	'bobp',	'buobpi',	'156489489',	NULL,	NULL,	NULL,	NULL,	12,	'personnel.dge@gmail.com',	1,	1,	'POINT OBSERVATION.docx',	'2016-11-21 09:16:13',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('PC23456',	1,	1,	4,	2,	NULL,	2,	NULL,	NULL,	2,	1,	3,	'AKOSSI',	'BENDJO',	NULL,	'1997-01-15',	'oplzzoxa^pl',	'^;kp^;k^p;^p',	2,	343,	'2017-10-01',	'2017-10-24',	NULL,	'armoirie2.png',	'2017-10-25 13:16:28',	NULL,	'p^lp^l^pl',	'p^;lp^l^plp',	'^p;^p;lp^ml^p',	'ôk;p^;l^p',	';^p;l^pl;p^;',	'KELKUN DE OK',	NULL,	'^pl^plp',	NULL,	34,	'ingridamenanndry@gmail.com',	2,	NULL,	'adverbe.docx',	'2017-10-25 10:29:36',	NULL,	14,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('R0001',	1,	1,	7,	2,	NULL,	1,	NULL,	1,	2,	8,	1,	'BEDE',	'JUSTINE',	'OHOH',	'2016-04-10',	'KEHI Joseph',	'AHOUCHI FELICIYE',	2,	234,	'2016-04-14',	'2016-04-27',	NULL,	'telechargement.jpg',	'2016-04-12 11:19:17',	'20 21 48 77',	NULL,	'22 43 54 17',	'ABOBO',	'Ouattara Nadège',	'09536743',	NULL,	NULL,	NULL,	NULL,	4,	'stephenjlo@yahoo.fr',	2,	2,	'Classeur1.xlsx',	'2016-04-12 11:19:17',	NULL,	NULL,	'DG0001',	NULL,	NULL,	'DC0003',	NULL,	NULL),
('R0002',	1,	2,	10,	2,	NULL,	1,	NULL,	1,	1,	1,	1,	'AGENT',	'SRHMG',	NULL,	'2016-04-20',	'KORE JEAN',	'CHO MARTHE',	2,	234,	'2016-04-14',	'2016-04-08',	NULL,	'telechargement.jpg',	'2016-04-13 15:41:03',	'3456789',	NULL,	NULL,	'ATTIEKOI',	'KOUSSO JOELLE',	'234567890',	'OK',	NULL,	NULL,	NULL,	9,	'stephenjlo@yahoo.fr',	1,	1,	'clé_16G.TXT',	'2016-04-13 15:41:03',	NULL,	NULL,	'DG0001',	NULL,	NULL,	'DC00010',	NULL,	NULL),
('SQN0001',	1,	1,	5,	2,	NULL,	2,	NULL,	3,	2,	NULL,	2,	'AHOU',	NULL,	'AFFOUE CHANTAL',	'2017-11-01',	NULL,	NULL,	2,	345678909,	'2017-11-15',	NULL,	NULL,	'5a0173b4ebdf9_armoirie2.png',	'2017-11-07 08:49:56',	'32456789',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	'rdtftgyuhj@kljhgh.ci',	2,	NULL,	'5a0173b4ece30_facture hebergement Serveur Dédié.pdf',	'2017-11-07 08:49:56',	NULL,	29,	'DG0001',	NULL,	NULL,	NULL,	NULL,	NULL),
('test1',	1,	1,	3,	2,	NULL,	1,	NULL,	1,	1,	2,	1,	'kekenon',	'bouaffo',	NULL,	'2016-07-10',	'nionipk)',	'à)k)',	3,	325,	'2016-07-12',	'2016-07-17',	NULL,	'proxy_logo.jpg',	'2016-07-26 10:29:45',	'0655948945',	NULL,	NULL,	NULL,	'àk))ko',	'749748',	NULL,	NULL,	NULL,	NULL,	10,	'jl.yapi@finances.gouv.ci',	2,	2,	'BILLET.pdf',	'2016-07-26 10:29:46',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('TEST12',	1,	1,	1,	1,	NULL,	1,	NULL,	1,	2,	1,	1,	'ADO OK',	'NIOSCNPI',	NULL,	'2016-05-17',	'niojio',	'npionpio',	22,	235,	'2016-09-01',	'2016-09-04',	NULL,	'11646750.png',	'2016-09-13 13:52:47',	'2222111515',	'nioininio',	',pk,pn,iojnn',	'nojnipknpi',	'nippijnp',	'1561564189',	NULL,	NULL,	'nipiojnpij,pio',	NULL,	8,	'yapimobio15@univmetiers.ci',	1,	2,	'speach.docx',	'2016-09-13 13:52:47',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('TR08883',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	2,	1,	2,	'GNAMIEN',	'MARIE CLAIRE',	NULL,	'2017-10-16',	'GHKJLM',	'JKLML',	1,	840,	'2017-10-17',	'2017-10-29',	NULL,	'20170528_191212.jpg',	'2017-10-30 10:17:54',	'1234567',	'456789',	'456789',	'XCVHBHJKNL?',	'FCGVHBJNLK?MM.M',	'12345678',	NULL,	NULL,	'2345678',	NULL,	16,	'ndklsjsnksc@oj.com',	1,	2,	'facture hebergement Serveur Dédié.pdf',	'2017-10-30 10:17:54',	NULL,	22,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `agent_olds`;
CREATE TABLE `agent_olds` (
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_provenance` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `id_fonction` int(11) DEFAULT NULL,
  `id_emploi` int(11) DEFAULT NULL,
  `id_titre` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_promotion` int(11) DEFAULT NULL,
  `id_syndicat` int(11) DEFAULT NULL,
  `id_sexe` int(11) DEFAULT NULL,
  `id_direction` int(11) DEFAULT NULL,
  `id_echelon` int(11) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomJeuneFille` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateNaiss` date DEFAULT NULL,
  `nomPere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomMere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nbEnf` int(11) DEFAULT NULL,
  `indice` int(11) DEFAULT NULL,
  `datePremierService` date DEFAULT NULL,
  `datePriseServiceDge` date DEFAULT NULL,
  `agent_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `telBur` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telPort` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telDom` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quartier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomConjoint` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telConjoint` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descriComp` longtext COLLATE utf8_unicode_ci,
  `agent_cv` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telUrgent1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telUrgent2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_lieuNaiss` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_situationMatrimoniale` int(11) DEFAULT NULL,
  `id_situationMili` int(11) DEFAULT NULL,
  `cv_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_cv_at` datetime DEFAULT NULL,
  `numPoste` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_affecter` int(11) DEFAULT NULL,
  `CODE_DG` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_SD` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_SC` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_DC` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `agent_olds` (`matricule`, `id_provenance`, `id_type`, `id_fonction`, `id_emploi`, `id_titre`, `id_classe`, `id_promotion`, `id_syndicat`, `id_sexe`, `id_direction`, `id_echelon`, `nom`, `prenoms`, `nomJeuneFille`, `dateNaiss`, `nomPere`, `nomMere`, `nbEnf`, `indice`, `datePremierService`, `datePriseServiceDge`, `agent_image`, `image_name`, `updated_at`, `telBur`, `telPort`, `telDom`, `quartier`, `nomConjoint`, `telConjoint`, `descriComp`, `agent_cv`, `telUrgent1`, `telUrgent2`, `id_lieuNaiss`, `email`, `id_situationMatrimoniale`, `id_situationMili`, `cv_name`, `updated_cv_at`, `numPoste`, `id_affecter`, `CODE_DG`, `CODE_SD`, `CODE_SC`, `CODE_DC`) VALUES
('123874H',	1,	1,	7,	2,	NULL,	2,	NULL,	1,	2,	1,	3,	'KOUAO',	'TAIBA MARIE CLAUDE',	NULL,	'2007-11-01',	NULL,	NULL,	2,	760,	'2017-11-01',	'2017-11-13',	NULL,	'5a0975414aafc_armoirie2.png',	'2017-11-13 10:34:41',	'32456789',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	14,	'kjxzjixgisux@xnjsbxnjz.fr',	2,	NULL,	'5a0975414b5a7_obsevation séance du vendredi 30 JUIN.docx',	'2017-11-13 10:34:41',	NULL,	31,	'DG0001',	NULL,	NULL,	'DC0003'),
('173892B',	1,	1,	2,	1,	NULL,	2,	NULL,	1,	2,	1,	1,	'Koffi',	'kouakou',	NULL,	'2017-11-06',	NULL,	NULL,	0,	345,	'2017-11-17',	'2017-11-07',	NULL,	'5a00c696ec7af_CI__-1997-01-01.jpg',	'2017-11-06 20:31:18',	'2345678',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	9,	'admin@stephenjlo.xyz',	1,	NULL,	'5a00c696ef236_Année Scolaire.docx',	'2017-11-06 20:31:18',	NULL,	26,	NULL,	NULL,	NULL,	NULL),
('223554G',	1,	1,	6,	1,	NULL,	1,	NULL,	1,	NULL,	2,	1,	'YAO',	'KOFFI',	NULL,	'2016-06-08',	'bklhk:',	'BKLJLJ',	2,	125,	'2016-07-04',	'2016-07-12',	NULL,	'Angular.png',	'2016-07-15 14:37:39',	'5346346D',	'1556156',	'BK/dsQ',	'ILYHIHL/',	'K/J§L',	'K/N§LJ§LK',	'NO',	NULL,	NULL,	NULL,	24,	'gjkhskls@vxsh.co',	3,	1,	'BILLET.pdf',	'2016-07-15 14:37:39',	'616513',	NULL,	NULL,	NULL,	NULL,	NULL),
('278 944 J',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	2,	1,	1,	'ASSEMIAN',	'Yolande Amédée Djoma',	NULL,	'2016-06-07',	'OK xai',	'NO',	0,	456,	'2016-06-16',	'2016-06-08',	NULL,	'images.jpg',	'2016-06-08 08:33:02',	'234567903',	NULL,	NULL,	'plateau',	'test²',	NULL,	'OK',	NULL,	NULL,	NULL,	12,	'dogbo.curtis@gmail.com',	1,	1,	'cahier des charges pour la realisation des sites Web des ministeres.docx',	'2016-06-08 08:33:02',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('284589W',	1,	1,	1,	4,	NULL,	2,	NULL,	1,	2,	2,	2,	'DANHO',	NULL,	'TANON Marie-Noelle',	'1987-11-10',	'Kofii YAPO',	'Kouadio aya',	2,	670,	'2017-11-01',	'2017-11-23',	NULL,	'5a16ac8821629_tof_dge.jpg',	'2017-11-23 11:10:00',	'20213456',	NULL,	NULL,	'Abobo',	'Aya Kouamé',	'07 23 32 34',	NULL,	NULL,	NULL,	NULL,	5,	'koffi156@gmail.com',	2,	NULL,	'5a16ac882a4a8_facture hebergement mutualisé.pdf',	'2017-11-23 11:10:00',	NULL,	34,	'DG0001',	'SD000011',	NULL,	'DC00010'),
('323065Z',	1,	1,	1,	4,	NULL,	2,	NULL,	1,	2,	2,	2,	'AMAVI',	'Ayélé Virginie Sandrine',	NULL,	'2017-11-01',	NULL,	NULL,	1,	654,	'2017-11-01',	'2017-11-23',	NULL,	'5a169b541f4b3_CI__-1997-01-01.jpg',	'2017-11-23 09:56:36',	'20213456',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	'fdghjkklmk@fghjk.fr',	1,	NULL,	'5a169b5421d6c_diagramme de classe.docx',	'2017-11-23 09:56:36',	NULL,	33,	'DG0001',	'SD000011',	NULL,	NULL),
('324999J',	1,	1,	1,	3,	NULL,	2,	NULL,	2,	1,	NULL,	3,	'RYTYUIO',	'BUOH8',	NULL,	'2017-12-13',	NULL,	NULL,	9,	2345,	'2017-12-13',	NULL,	NULL,	'5a237bdbe2b10_armoirie2.png',	'2017-12-03 04:21:47',	'34567890',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	6,	'abihsuhsoi@fnk.com',	3,	1,	'5a237bdbe3a88_cr presentation E-rh.odt',	'2017-12-03 04:21:47',	NULL,	35,	NULL,	NULL,	NULL,	NULL),
('365572C',	1,	1,	5,	3,	NULL,	2,	NULL,	2,	2,	2,	1,	'MOGNIN',	NULL,	'KOFFI Marie-Louise Chantal',	'1976-11-21',	NULL,	NULL,	2,	850,	'2012-02-01',	'2017-11-23',	NULL,	'5a1692f930958_armoirie2.png',	'2017-11-23 09:20:57',	'20213456',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	21,	'k.mognin@finances.gouv.ci',	2,	NULL,	'5a1692f931b59_facture hebergement Serveur Dédié.pdf',	'2017-11-23 09:20:57',	NULL,	32,	'DG0001',	NULL,	NULL,	NULL),
('385175Q',	NULL,	1,	2,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'SILUE',	'WONGNIGUE',	'2222222',	'2017-10-26',	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-10-24',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'-Connaisances en rédaction \r\n- PHP\r\n-Expert en Bavardage\r\n-Spécialiste à 9h heure d\'arrivée',	NULL,	NULL,	NULL,	NULL,	NULL,	2,	NULL,	'demo.docx',	'2017-10-26 08:23:47',	NULL,	16,	NULL,	NULL,	NULL,	NULL),
('385175T',	1,	1,	2,	1,	NULL,	2,	NULL,	3,	1,	1,	2,	'SILUE',	'FOLOGO',	NULL,	'2016-10-03',	'SILUE',	'SILUE',	2,	885,	'2017-06-01',	'2017-06-03',	NULL,	'29299196-Dessin-serrer-la-main-Vector-illustration-Banque-d\'images.jpg',	'2017-06-30 12:10:05',	'20214877',	'09609447',	'24396514',	'PLATEAU DOKUI',	'SILUE',	'09854721',	'ODFJNPOVJPOSVJPISFVJPISVJSPJIS',	NULL,	'09609447',	NULL,	11,	'silayeur@gmail.com',	2,	1,	'Enterprise Ressource Planning-Progiciel de Gestion Intégré.pdf',	'2017-06-30 12:10:06',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('428413M',	NULL,	1,	3,	2,	NULL,	NULL,	NULL,	NULL,	2,	1,	NULL,	'MEITE',	'Madioman',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'Technicien de l\'Informatique en provenance de l\'OCPV',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'Loi_n92-570_du_11_septembre_1992.pdf',	'2017-10-24 15:21:55',	NULL,	NULL,	'DG0001',	'SD1001',	NULL,	'DC00010'),
('765283P',	1,	1,	2,	1,	NULL,	1,	NULL,	NULL,	1,	1,	2,	'AHIBA',	'BOGUIE JEAN YVES',	NULL,	'1991-11-01',	NULL,	NULL,	0,	765,	'2017-11-01',	'2017-11-07',	NULL,	'5a0085e939173_armoirie2.png',	'2017-11-06 15:55:21',	'20214877',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	21,	'admin@stephenjlo.xyz',	1,	1,	'5a0085e93a512_Année Scolaire.docx',	'2017-11-06 15:55:21',	NULL,	25,	NULL,	NULL,	NULL,	NULL),
('875145D',	1,	1,	3,	1,	NULL,	2,	NULL,	1,	1,	1,	1,	'OTOKOR',	'Rodolphe',	NULL,	'2016-10-19',	'gvyiyivbuobuo',	'nouiniooi',	3,	625,	'2016-09-06',	'2016-10-01',	NULL,	'HBD.jpg',	'2016-11-13 14:07:30',	'20125125',	'i',	'noinio',	'ubuobio',	'nonionio',	'45646846+',	NULL,	NULL,	NULL,	NULL,	9,	'yapimobio15@univmetiers.ci',	2,	1,	'IFAP.docx',	'2016-11-13 14:07:30',	NULL,	NULL,	'DG0001',	'SD1001',	NULL,	'DC00010'),
('876543',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	1,	1,	2,	'KOFFI',	'JOACHIM',	NULL,	'2017-10-31',	'DTFGHJKLM',	'TYGYUHIJOKPL',	0,	324,	'2017-10-31',	'2017-11-06',	NULL,	'59f8833491d9b_4.jpg',	'2017-10-31 14:05:40',	'12345678',	'567890',	'4567890',	'FCGVHBJNKL',	'FCYGVHBJNKL',	'23456789',	'Fournir des élément',	NULL,	'CGHVHJBNKL',	NULL,	12,	'abidjan@fdhdj.fr',	1,	2,	'59f8833492ff9_Année Scolaire.docx',	'2017-10-31 14:05:40',	NULL,	23,	NULL,	NULL,	NULL,	NULL),
('8765445H',	1,	1,	3,	1,	NULL,	2,	NULL,	NULL,	1,	1,	3,	'BOIDY',	'FRANCOIS',	NULL,	'2017-10-01',	NULL,	NULL,	2,	567,	'2017-11-01',	'2017-11-14',	NULL,	'5a0306f4c7931_Permis1.PNG',	'2017-11-08 13:30:28',	'54321344',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	37,	'asjsasos@sxjsk.ci',	1,	1,	'5a0306f4c8a5f_coursdanglais.pdf.pdf',	'2017-11-08 13:30:28',	NULL,	30,	'DG0001',	NULL,	NULL,	NULL),
('989609M',	1,	1,	10,	2,	NULL,	1,	NULL,	2,	2,	1,	1,	'YAPI',	'MOBIO',	NULL,	'2016-03-09',	'YAPI',	'OUATTARA',	23,	NULL,	'2016-03-23',	'2016-02-14',	NULL,	'SCAN11jpg0002.jpg',	'2016-03-23 11:51:12',	'3456789',	'02345647',	'24399417',	'ABOBO',	'OK',	NULL,	NULL,	'C:\\wamp\\tmp\\phpED34.tmp',	NULL,	NULL,	10,	'stephy.jlo@gmail.com',	1,	1,	'',	'2016-11-13 14:07:30',	'128',	NULL,	'DG0001',	NULL,	NULL,	NULL),
('A000034',	1,	1,	3,	1,	NULL,	1,	NULL,	1,	1,	1,	1,	'ANASSE',	'MARIE EDIGE',	NULL,	'2017-11-05',	NULL,	NULL,	2,	6543,	'2017-11-20',	'2017-11-05',	NULL,	'59ff482281ec8_CI__-1997-01-01.jpg',	'2017-11-05 17:19:30',	'456789',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	8,	'fghijokpl@oijh.html',	2,	2,	'59ff482283d71_facture hebergement mutualisé.pdf',	'2017-11-05 17:19:30',	NULL,	24,	NULL,	NULL,	NULL,	NULL),
('AB00003',	1,	1,	1,	2,	NULL,	2,	NULL,	1,	2,	NULL,	3,	'KOFFI',	NULL,	'ADJOUA CAROLINE',	'2007-11-01',	NULL,	NULL,	2,	567,	'2017-11-01',	NULL,	NULL,	'5a0172f606639_CI__-1997-01-01.jpg',	'2017-11-07 08:46:46',	'28767354',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	19,	'dogbo.curtis01@gmail.com',	2,	NULL,	'5a0172f608338_Éléments du cahier de charge.docx',	'2017-11-07 08:46:46',	NULL,	28,	'DG0001',	NULL,	NULL,	NULL),
('ABD5436',	1,	1,	3,	2,	NULL,	3,	NULL,	1,	1,	1,	2,	'KOUADJO',	'SEPHORA',	NULL,	'2017-10-01',	'ok',	'OK',	2,	546,	'2017-10-01',	'2017-10-17',	NULL,	NULL,	NULL,	'20213412',	'ok',	'ok',	'ok',	'ok',	'ok',	'BIEN DE PARTOU',	NULL,	'ok',	NULL,	12,	'tropicalway@ccooot.com',	1,	1,	'diagramme de classe.docx',	'2017-10-26 09:30:31',	NULL,	17,	NULL,	NULL,	NULL,	NULL),
('B2333',	1,	1,	2,	1,	NULL,	3,	NULL,	1,	2,	1,	3,	'Kané',	'Moussa',	NULL,	'2017-10-10',	NULL,	NULL,	3,	435,	'2017-10-06',	'2017-10-10',	NULL,	'mangue.jpg',	'2017-10-25 00:40:00',	'2323294204',	NULL,	NULL,	NULL,	NULL,	NULL,	'kpda,zd,',	NULL,	NULL,	NULL,	16,	'tropicalway@ooot.com',	1,	NULL,	'Année Scolaire.docx',	'2017-10-24 15:33:33',	NULL,	13,	NULL,	NULL,	NULL,	NULL),
('BHHD087',	1,	1,	2,	1,	NULL,	4,	NULL,	NULL,	1,	1,	2,	'GNANCHOU',	'JEAN LOUIS STEPHANE',	NULL,	'2008-02-18',	'hi',	'ihih',	2,	434,	'2017-10-04',	'2017-10-25',	NULL,	'20170528_191212.jpg',	'2017-10-26 11:33:18',	NULL,	'hi',	'hihi',	'hi',	'hihi',	'hihi',	'Technciens Informatique Spécialisé en réseau',	NULL,	'hi',	NULL,	15,	'azgihbdauihz@bhdbc.ci',	1,	1,	'procedure MEF.docx',	'2017-10-26 10:22:16',	NULL,	18,	NULL,	NULL,	NULL,	NULL),
('bujwhscia',	NULL,	1,	6,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'boullihi',	'hpçihpçiçjçp',	'oubiouhoi',	'2017-10-10',	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-10-31',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'bihnopjo',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'obsevation séance du vendredi 30 JUIN.docx',	'2017-10-29 13:31:15',	NULL,	20,	NULL,	NULL,	NULL,	NULL),
('bujwhscio',	NULL,	1,	6,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	'boullihi',	'hpçihpçiçjçp',	'oubiouhoi',	'2017-10-10',	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-10-24',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'bihnopjo',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'obsevation séance du vendredi 30 JUIN.docx',	'2017-10-29 13:16:25',	NULL,	19,	NULL,	NULL,	NULL,	NULL),
('CE16-0000355',	1,	1,	3,	2,	NULL,	3,	NULL,	NULL,	1,	2,	2,	'AKO',	'CLEMENTS',	NULL,	'1987-03-01',	'ok',	'ok',	2,	567,	'2016-10-03',	'2017-08-16',	NULL,	'4.jpg',	'2017-10-17 10:16:17',	NULL,	NULL,	NULL,	'OK',	'ok',	'12345678',	NULL,	NULL,	NULL,	NULL,	10,	'admin@stephenjlo.xyz',	1,	1,	'facture hebergement Serveur Dédié.pdf',	'2017-10-17 10:16:17',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('DC2012783Z',	1,	1,	5,	1,	NULL,	1,	NULL,	2,	2,	1,	2,	'YAO',	'FELICITE',	NULL,	'2017-11-01',	NULL,	NULL,	2,	235,	'2017-11-01',	'2017-11-07',	NULL,	'5a0100b2b2857_20170528_191212.jpg',	'2017-11-07 00:39:14',	'2345678',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	14,	'stephy.jlo@gmail.com',	1,	NULL,	'5a0100b2b3ced_facture hebergement Serveur Dédié.pdf',	'2017-11-07 00:39:14',	NULL,	27,	NULL,	NULL,	NULL,	NULL),
('FBI0001',	1,	1,	1,	2,	NULL,	2,	NULL,	1,	1,	1,	3,	'?I?IP?PP?PI',	'?P?POO?P?PI',	NULL,	'2016-11-01',	',p,p,p,',	',p,p',	5,	45585,	'2016-11-01',	'2016-11-01',	NULL,	'proxy_logo.jpg',	'2016-11-13 19:53:15',	'49348937967',	NULL,	'2012122',	'4,k,k,kn',	',p,po,p,pi,',	'85525859',	'?P?P',	NULL,	'475R457',	NULL,	16,	'stephy.jlo@gmail.com',	1,	1,	'pgadmin.log',	'2016-11-13 19:53:15',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('GP0001',	1,	1,	5,	1,	NULL,	1,	NULL,	1,	1,	1,	2,	'KOFFI',	'LAZARE',	NULL,	'2017-10-15',	'WETXRCTVYBN',	'ERGHJK',	0,	156,	'2017-10-18',	'2017-11-07',	NULL,	'CI__-1997-01-01.jpg',	'2017-10-30 01:28:57',	'234356789',	'XCVBIUN',	'XCVHBIJNO',	'WEXRTCYTVYUBIUOIN',	'RTYHJKKL',	'RTYUIOJO',	'Bien de Partout\r\nTrès performant',	NULL,	'XDCFGVBH',	NULL,	20,	'otokkflorfo@yaho.fr',	1,	1,	'MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf',	'2017-10-30 01:28:57',	NULL,	21,	NULL,	NULL,	NULL,	NULL),
('I0001',	1,	1,	4,	1,	NULL,	1,	NULL,	1,	1,	1,	1,	'MASSOUO',	'T. FILBERT',	NULL,	'2016-04-12',	'KANGA',	'AHOUCHI FELICIYE',	2,	234,	'2016-04-10',	'2016-04-10',	NULL,	'7.jpg',	'2016-04-11 17:01:07',	'20 21 34 54',	'07 65 43 76',	'22 43 54 17',	'Angré',	'Ouattara Nadège',	'09536743',	NULL,	NULL,	NULL,	NULL,	10,	'stephenjlo@yahoo.fr',	1,	1,	'Database1.accdb',	'2016-04-11 17:01:07',	NULL,	NULL,	'DG0001',	NULL,	NULL,	NULL),
('I0002',	1,	1,	5,	1,	NULL,	1,	NULL,	2,	1,	1,	1,	'AHOULOU',	'OBROU MELAIN',	NULL,	'2016-04-12',	'XRYDY',	'IBGBUIHIU',	1,	536,	'2016-04-12',	'2016-04-17',	NULL,	'telechargement.jpg',	'2016-04-12 11:05:22',	'20214877',	'03 74 04 54',	'24 464743',	'BUIHOLI',	'?IPJKPO',	'0945687',	NULL,	NULL,	NULL,	NULL,	10,	'stephy2.jlo@gmail.com',	1,	1,	'clé_16G.TXT',	'2016-04-12 11:05:22',	NULL,	NULL,	'DG0001',	NULL,	NULL,	'DC00010'),
('I0003H',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	1,	1,	2,	'GNAMIEN N\'GUESSAN',	'MARIE CLAIRE',	NULL,	'2016-11-01',	'ko',	',po n',	0,	235,	'2016-11-01',	'2016-11-22',	NULL,	'2.PNG',	'2016-11-21 09:16:13',	NULL,	'156489',	'buobuo',	'bobp',	'buobpi',	'156489489',	NULL,	NULL,	NULL,	NULL,	12,	'personnel.dge@gmail.com',	1,	1,	'POINT OBSERVATION.docx',	'2016-11-21 09:16:13',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('PC23456',	1,	1,	4,	2,	NULL,	2,	NULL,	NULL,	2,	1,	3,	'AKOSSI',	'BENDJO',	NULL,	'1997-01-15',	'oplzzoxa^pl',	'^;kp^;k^p;^p',	2,	343,	'2017-10-01',	'2017-10-24',	NULL,	'armoirie2.png',	'2017-10-25 13:16:28',	NULL,	'p^lp^l^pl',	'p^;lp^l^plp',	'^p;^p;lp^ml^p',	'ôk;p^;l^p',	';^p;l^pl;p^;',	'KELKUN DE OK',	NULL,	'^pl^plp',	NULL,	34,	'ingridamenanndry@gmail.com',	2,	NULL,	'adverbe.docx',	'2017-10-25 10:29:36',	NULL,	14,	NULL,	NULL,	NULL,	NULL),
('R0001',	1,	1,	7,	2,	NULL,	1,	NULL,	1,	2,	3,	1,	'BEDE',	'JUSTINE',	'OHOH',	'2016-04-10',	'KEHI Joseph',	'AHOUCHI FELICIYE',	2,	234,	'2016-04-14',	'2016-04-27',	NULL,	'telechargement.jpg',	'2016-04-12 11:19:17',	'20 21 48 77',	NULL,	'22 43 54 17',	'ABOBO',	'Ouattara Nadège',	'09536743',	NULL,	NULL,	NULL,	NULL,	4,	'stephenjlo@yahoo.fr',	2,	2,	'Classeur1.xlsx',	'2016-04-12 11:19:17',	NULL,	NULL,	'DG0001',	NULL,	NULL,	'DC0003'),
('R0002',	1,	2,	10,	2,	NULL,	1,	NULL,	1,	1,	3,	1,	'AGENT',	'SRHMG',	NULL,	'2016-04-20',	'KORE JEAN',	'CHO MARTHE',	2,	234,	'2016-04-14',	'2016-04-08',	NULL,	'telechargement.jpg',	'2016-04-13 15:41:03',	'3456789',	NULL,	NULL,	'ATTIEKOI',	'KOUSSO JOELLE',	'234567890',	'OK',	NULL,	NULL,	NULL,	9,	'stephenjlo@yahoo.fr',	1,	1,	'clé_16G.TXT',	'2016-04-13 15:41:03',	NULL,	NULL,	'DG0001',	NULL,	NULL,	'DC00010'),
('SQN0001',	1,	1,	5,	2,	NULL,	2,	NULL,	3,	2,	NULL,	2,	'AHOU',	NULL,	'AFFOUE CHANTAL',	'2017-11-01',	NULL,	NULL,	2,	345678909,	'2017-11-15',	NULL,	NULL,	'5a0173b4ebdf9_armoirie2.png',	'2017-11-07 08:49:56',	'32456789',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	'rdtftgyuhj@kljhgh.ci',	2,	NULL,	'5a0173b4ece30_facture hebergement Serveur Dédié.pdf',	'2017-11-07 08:49:56',	NULL,	29,	'DG0001',	NULL,	NULL,	NULL),
('test1',	1,	1,	3,	2,	NULL,	1,	NULL,	1,	1,	2,	1,	'kekenon',	'bouaffo',	NULL,	'2016-07-10',	'nionipk)',	'à)k)',	3,	325,	'2016-07-12',	'2016-07-17',	NULL,	'proxy_logo.jpg',	'2016-07-26 10:29:45',	'0655948945',	NULL,	NULL,	NULL,	'àk))ko',	'749748',	NULL,	NULL,	NULL,	NULL,	10,	'jl.yapi@finances.gouv.ci',	2,	2,	'BILLET.pdf',	'2016-07-26 10:29:46',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('TEST12',	1,	1,	1,	1,	NULL,	1,	NULL,	1,	2,	1,	1,	'ADO OK',	'NIOSCNPI',	NULL,	'2016-05-17',	'niojio',	'npionpio',	22,	235,	'2016-09-01',	'2016-09-04',	NULL,	'11646750.png',	'2016-09-13 13:52:47',	'2222111515',	'nioininio',	',pk,pn,iojnn',	'nojnipknpi',	'nippijnp',	'1561564189',	NULL,	NULL,	'nipiojnpij,pio',	NULL,	8,	'yapimobio15@univmetiers.ci',	1,	2,	'speach.docx',	'2016-09-13 13:52:47',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
('TR08883',	1,	1,	2,	1,	NULL,	1,	NULL,	1,	2,	1,	2,	'GNAMIEN',	'MARIE CLAIRE',	NULL,	'2017-10-16',	'GHKJLM',	'JKLML',	1,	840,	'2017-10-17',	'2017-10-29',	NULL,	'20170528_191212.jpg',	'2017-10-30 10:17:54',	'1234567',	'456789',	'456789',	'XCVHBHJKNL?',	'FCGVHBJNLK?MM.M',	'12345678',	NULL,	NULL,	'2345678',	NULL,	16,	'ndklsjsnksc@oj.com',	1,	2,	'facture hebergement Serveur Dédié.pdf',	'2017-10-30 10:17:54',	NULL,	22,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `agent_xx`;
CREATE TABLE `agent_xx` (
  `matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_provenance` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `id_fonction` int(11) DEFAULT NULL,
  `id_emploi` int(11) DEFAULT NULL,
  `id_titre` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_promotion` int(11) DEFAULT NULL,
  `id_syndicat` int(11) DEFAULT NULL,
  `id_sexe` int(11) DEFAULT NULL,
  `id_direction` int(11) DEFAULT NULL,
  `id_echelon` int(11) DEFAULT NULL,
  `id_affecter` int(11) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenoms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomJeuneFille` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateNaiss` date DEFAULT NULL,
  `nomPere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomMere` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nbEnf` int(11) DEFAULT NULL,
  `indice` int(11) DEFAULT NULL,
  `datePremierService` date DEFAULT NULL,
  `datePriseServiceDge` date DEFAULT NULL,
  `agent_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `agent_cv` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cv_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_cv_at` datetime DEFAULT NULL,
  `telBur` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telPort` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telDom` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quartier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomConjoint` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telConjoint` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descriComp` longtext COLLATE utf8_unicode_ci,
  `telUrgent1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telUrgent2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numPoste` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_DC` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_lieuNaiss` int(11) DEFAULT NULL,
  `id_situationMatrimoniale` int(11) DEFAULT NULL,
  `id_situationMili` int(11) DEFAULT NULL,
  `CODE_DG` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_SD` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CODE_SC` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`matricule`),
  UNIQUE KEY `UNIQ_73CC0E54924BE9EF` (`id_affecter`),
  KEY `IDX_73CC0E54248F5D56` (`id_provenance`),
  KEY `IDX_73CC0E547FE4B2B` (`id_type`),
  KEY `IDX_73CC0E5459DB3928` (`id_fonction`),
  KEY `IDX_73CC0E5452970517` (`id_emploi`),
  KEY `IDX_73CC0E5411F20684` (`id_titre`),
  KEY `IDX_73CC0E54A9B00A7B` (`id_classe`),
  KEY `IDX_73CC0E547FEF12CB` (`id_lieuNaiss`),
  KEY `IDX_73CC0E544128C1F6` (`id_promotion`),
  KEY `IDX_73CC0E5417ABADE3` (`id_syndicat`),
  KEY `IDX_73CC0E5447CCA38E` (`id_sexe`),
  KEY `IDX_73CC0E54BE7F6D94` (`id_direction`),
  KEY `IDX_73CC0E54B8075A76` (`id_echelon`),
  KEY `IDX_73CC0E54524749F2` (`id_situationMatrimoniale`),
  KEY `IDX_73CC0E542CD04499` (`id_situationMili`),
  KEY `IDX_73CC0E54C75691A` (`CODE_DG`),
  KEY `IDX_73CC0E5490FFBC36` (`CODE_SD`),
  KEY `IDX_73CC0E54E9B2995` (`CODE_SC`),
  CONSTRAINT `FK_73CC0E5411F20684` FOREIGN KEY (`id_titre`) REFERENCES `titre` (`id`),
  CONSTRAINT `FK_73CC0E5417ABADE3` FOREIGN KEY (`id_syndicat`) REFERENCES `syndicat` (`id`),
  CONSTRAINT `FK_73CC0E54248F5D56` FOREIGN KEY (`id_provenance`) REFERENCES `provenance` (`id`),
  CONSTRAINT `FK_73CC0E542CD04499` FOREIGN KEY (`id_situationMili`) REFERENCES `position_militaire` (`id`),
  CONSTRAINT `FK_73CC0E544128C1F6` FOREIGN KEY (`id_promotion`) REFERENCES `promotion` (`id`),
  CONSTRAINT `FK_73CC0E5447CCA38E` FOREIGN KEY (`id_sexe`) REFERENCES `sexe` (`id`),
  CONSTRAINT `FK_73CC0E54524749F2` FOREIGN KEY (`id_situationMatrimoniale`) REFERENCES `situation_matrimoniale` (`id`),
  CONSTRAINT `FK_73CC0E5452970517` FOREIGN KEY (`id_emploi`) REFERENCES `emploi` (`id`),
  CONSTRAINT `FK_73CC0E5459DB3928` FOREIGN KEY (`id_fonction`) REFERENCES `fonction` (`id`),
  CONSTRAINT `FK_73CC0E547FE4B2B` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`),
  CONSTRAINT `FK_73CC0E547FEF12CB` FOREIGN KEY (`id_lieuNaiss`) REFERENCES `lieu_naissance` (`id`),
  CONSTRAINT `FK_73CC0E5490FFBC36` FOREIGN KEY (`CODE_SD`) REFERENCES `sous_direction` (`CODE_SD`),
  CONSTRAINT `FK_73CC0E54924BE9EF` FOREIGN KEY (`id_affecter`) REFERENCES `affecter` (`id`),
  CONSTRAINT `FK_73CC0E54A9B00A7B` FOREIGN KEY (`id_classe`) REFERENCES `classe` (`id`),
  CONSTRAINT `FK_73CC0E54B8075A76` FOREIGN KEY (`id_echelon`) REFERENCES `echelon` (`id`),
  CONSTRAINT `FK_73CC0E54BE7F6D94` FOREIGN KEY (`id_direction`) REFERENCES `direction` (`id`),
  CONSTRAINT `FK_73CC0E54C75691A` FOREIGN KEY (`CODE_DG`) REFERENCES `direction_generale` (`CODE_DG`),
  CONSTRAINT `FK_73CC0E54E9B2995` FOREIGN KEY (`CODE_SC`) REFERENCES `service_direction` (`CODE_SC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `bouquin`;
CREATE TABLE `bouquin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `direction_id` int(11) DEFAULT NULL,
  `createur_id` int(11) DEFAULT NULL,
  `pj_id` int(11) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci NOT NULL,
  `datecreation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D659A171AF73D997` (`direction_id`),
  KEY `IDX_D659A17173A201E5` (`createur_id`),
  KEY `IDX_D659A171F26B1C97` (`pj_id`),
  KEY `IDX_D659A171BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_D659A17173A201E5` FOREIGN KEY (`createur_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_D659A171AF73D997` FOREIGN KEY (`direction_id`) REFERENCES `direction` (`id`),
  CONSTRAINT `FK_D659A171BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`),
  CONSTRAINT `FK_D659A171F26B1C97` FOREIGN KEY (`pj_id`) REFERENCES `pj` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `bouquin` (`id`, `direction_id`, `createur_id`, `pj_id`, `categorie_id`, `libelle`, `details`, `datecreation`) VALUES
(1,	1,	80,	6,	NULL,	'NOTE D\'INFORMATION',	'<p><strong>manger</strong><span style=\"font-size:24px\"><u><em> Bouger</em></u></span></p>',	'2017-11-20 12:30:51');

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(1,	'Note de synthèse'),
(2,	'TOFE');

DROP TABLE IF EXISTS `classe`;
CREATE TABLE `classe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libClas` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `classe` (`id`, `libClas`) VALUES
(1,	'1ere Classe'),
(2,	'2ème Classe'),
(3,	'Classe Principale'),
(4,	'Classe Exceptionnelle');

DROP TABLE IF EXISTS `conges`;
CREATE TABLE `conges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datecreation` datetime DEFAULT NULL,
  `datedebut` datetime DEFAULT NULL,
  `datefin` datetime DEFAULT NULL,
  `etat` int(11) NOT NULL,
  `datereprise` datetime DEFAULT NULL,
  `exercice_id` int(11) DEFAULT NULL,
  `type_conges_id` int(11) DEFAULT NULL,
  `nbrejours` int(11) DEFAULT NULL,
  `num_cessation_id` int(11) DEFAULT NULL,
  `num_reprise_id` int(11) DEFAULT NULL,
  `objetrefus` longtext COLLATE utf8_unicode_ci,
  `conge_objet` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objet_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_objet_at` datetime DEFAULT NULL,
  `externe` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6327DE3A268B9C9D` (`agent`),
  KEY `IDX_6327DE3A89D40298` (`exercice_id`),
  KEY `IDX_6327DE3A41CAB9FF` (`type_conges_id`),
  KEY `IDX_6327DE3AD677A60` (`num_cessation_id`),
  KEY `IDX_6327DE3A5B0336BF` (`num_reprise_id`),
  CONSTRAINT `FK_6327DE3A268B9C9D` FOREIGN KEY (`agent`) REFERENCES `agent` (`matricule`),
  CONSTRAINT `FK_6327DE3A41CAB9FF` FOREIGN KEY (`type_conges_id`) REFERENCES `type_conges` (`id`),
  CONSTRAINT `FK_6327DE3A5B0336BF` FOREIGN KEY (`num_reprise_id`) REFERENCES `numerisation` (`id`),
  CONSTRAINT `FK_6327DE3A89D40298` FOREIGN KEY (`exercice_id`) REFERENCES `exercice` (`id`),
  CONSTRAINT `FK_6327DE3AD677A60` FOREIGN KEY (`num_cessation_id`) REFERENCES `numerisation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proprietaire` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fixe` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Cellulaire` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `datecreation` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C62E63869E399D6` (`proprietaire`),
  CONSTRAINT `FK_4C62E63869E399D6` FOREIGN KEY (`proprietaire`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `decision`;
CREATE TABLE `decision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exercice_id` int(11) DEFAULT NULL,
  `pj_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `numero` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direction_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84ACBE4889D40298` (`exercice_id`),
  KEY `IDX_84ACBE48F26B1C97` (`pj_id`),
  KEY `IDX_84ACBE48AF73D997` (`direction_id`),
  CONSTRAINT `FK_84ACBE4889D40298` FOREIGN KEY (`exercice_id`) REFERENCES `exercice` (`id`),
  CONSTRAINT `FK_84ACBE48AF73D997` FOREIGN KEY (`direction_id`) REFERENCES `direction` (`id`),
  CONSTRAINT `FK_84ACBE48F26B1C97` FOREIGN KEY (`pj_id`) REFERENCES `pj` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `decision` (`id`, `exercice_id`, `pj_id`, `date`, `numero`, `direction_id`) VALUES
(4,	1,	5,	'2017-11-13 00:00:00',	'5446',	1),
(5,	1,	7,	'2017-11-01 00:00:00',	'546',	2);

DROP TABLE IF EXISTS `decision_agent`;
CREATE TABLE `decision_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `decision_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1CE5B94268B9C9D` (`agent`),
  KEY `IDX_1CE5B94BDEE7539` (`decision_id`),
  CONSTRAINT `FK_1CE5B94268B9C9D` FOREIGN KEY (`agent`) REFERENCES `agent` (`matricule`),
  CONSTRAINT `FK_1CE5B94BDEE7539` FOREIGN KEY (`decision_id`) REFERENCES `decision` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `decision_agent` (`id`, `agent`, `decision_id`) VALUES
(6,	'I0002',	4),
(7,	'I0001',	4),
(8,	'323065Z',	5),
(9,	'284589W',	5);

DROP TABLE IF EXISTS `demande`;
CREATE TABLE `demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_demande_id` int(11) NOT NULL,
  `emmeteur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objet` longtext COLLATE utf8_unicode_ci,
  `etatEmmission` int(11) NOT NULL,
  `dateRepSupDir` datetime DEFAULT NULL,
  `etatRepSupDir` int(11) DEFAULT NULL,
  `dateRepGrh` datetime DEFAULT NULL,
  `etatRepGrh` int(11) DEFAULT NULL,
  `grh` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SupDir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `destination` longtext COLLATE utf8_unicode_ci,
  `dateDeb` datetime DEFAULT NULL,
  `dateFin` datetime DEFAULT NULL,
  `datecreation` datetime NOT NULL,
  `etatNotifcation` int(11) NOT NULL,
  `motif_rejet` longtext COLLATE utf8_unicode_ci,
  `etatEncours` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2694D7A59DEA883D` (`type_demande_id`),
  KEY `IDX_2694D7A5B4F21B89` (`emmeteur`),
  KEY `IDX_2694D7A51C72F13B` (`SupDir`),
  KEY `IDX_2694D7A5ECB9F6A9` (`grh`),
  CONSTRAINT `FK_2694D7A51C72F13B` FOREIGN KEY (`SupDir`) REFERENCES `agent` (`matricule`),
  CONSTRAINT `FK_2694D7A59DEA883D` FOREIGN KEY (`type_demande_id`) REFERENCES `type_demande` (`id`),
  CONSTRAINT `FK_2694D7A5B4F21B89` FOREIGN KEY (`emmeteur`) REFERENCES `agent` (`matricule`),
  CONSTRAINT `FK_2694D7A5ECB9F6A9` FOREIGN KEY (`grh`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `demande` (`id`, `type_demande_id`, `emmeteur`, `objet`, `etatEmmission`, `dateRepSupDir`, `etatRepSupDir`, `dateRepGrh`, `etatRepGrh`, `grh`, `SupDir`, `destination`, `dateDeb`, `dateFin`, `datecreation`, `etatNotifcation`, `motif_rejet`, `etatEncours`) VALUES
(97,	1,	'I0001',	'Bonjour',	2,	'2017-11-05 19:11:00',	2,	NULL,	NULL,	NULL,	'I0002',	'ok',	'2017-11-15 00:00:00',	'2017-11-07 00:00:00',	'2017-11-05 19:09:56',	0,	'pas besoin',	1),
(98,	1,	'I0001',	'bon',	2,	'2017-11-05 19:12:42',	1,	'2017-11-05 19:14:58',	1,	NULL,	'I0002',	'ok',	'2017-11-08 00:00:00',	'2017-11-28 00:00:00',	'2017-11-05 19:11:41',	0,	NULL,	1),
(99,	3,	'I0001',	'ok',	0,	NULL,	0,	NULL,	NULL,	NULL,	'R0001',	'ok',	'2017-11-01 00:00:00',	'2017-11-08 00:00:00',	'2017-11-05 19:15:52',	0,	NULL,	0),
(100,	4,	'I0001',	'OK',	1,	'2017-11-06 15:04:50',	1,	NULL,	NULL,	NULL,	'R0001',	NULL,	NULL,	NULL,	'2017-11-06 11:47:30',	0,	NULL,	1),
(101,	1,	'323065Z',	'Raisons Familiales',	2,	'2017-11-23 10:09:12',	1,	'2017-11-23 10:11:56',	1,	NULL,	'365572C',	'Bouaké',	'2017-11-27 00:00:00',	'2017-11-28 00:00:00',	'2017-11-23 10:07:50',	0,	NULL,	1),
(102,	1,	'284589W',	'Raison Familiales',	2,	'2017-11-23 11:58:44',	1,	'2017-11-23 12:00:34',	1,	NULL,	'365572C',	'Yamoussoukro',	'2017-11-27 00:00:00',	'2017-11-28 00:00:00',	'2017-11-23 11:57:45',	0,	NULL,	1);

DROP TABLE IF EXISTS `diplome`;
CREATE TABLE `diplome` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_matricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intituleDipl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateDipl` date NOT NULL,
  `EtsDiplome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lieuDipl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EB4C4D4EE5E65AD8` (`agent_matricule`),
  CONSTRAINT `FK_EB4C4D4EE5E65AD8` FOREIGN KEY (`agent_matricule`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `direction`;
CREATE TABLE `direction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libDirect` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `siegeDirect` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `immeuble` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etage` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `sigle` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `etatDirection` int(11) NOT NULL,
  `CODE_DC` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_DG` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E4AD1B3C75691A` (`CODE_DG`),
  CONSTRAINT `FK_3E4AD1B3C75691A` FOREIGN KEY (`CODE_DG`) REFERENCES `direction_generale` (`CODE_DG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `direction` (`id`, `libDirect`, `siegeDirect`, `immeuble`, `etage`, `sigle`, `etatDirection`, `CODE_DC`, `CODE_DG`) VALUES
(1,	'Service Informatique et Maintenance',	'Plateau',	'OLLO',	'4',	'SIM',	0,	'DC00010',	'DG0001'),
(2,	'Service de la Qualité et de la Normalisation',	'Plateau',	'OLLO',	'5',	'SQN',	0,	'DC00012',	'DG0001'),
(3,	'Service des Ressources Humaines et Moyen Généraux',	'Plateau',	'Immeuble OLLO',	'3',	'SRHMG',	0,	'DC0009',	'DG0001'),
(4,	'Service de la Communication et de la Documentation',	'Plateau',	'ALLIANCE',	'4',	'SCD',	0,	'DC00011',	'DG0001'),
(5,	'Direction de la Prévision des Politiques et des Statistiques Economiques',	'Plateau',	'SCIAM',	'1',	'DPPSE',	1,	'DC0002',	'DG0001'),
(6,	'Direction des Etudes Stratégiques et des Projets',	'Plateau',	'Bélier',	'1',	'DESDP',	1,	'DC0001',	'DG0001'),
(7,	'Direction de la Promotion et de la Coopération Economique Internationale',	'Plateau',	'ALLIANCE',	'5',	'DPCEI',	1,	'DC0004',	'DG0001'),
(8,	'Direction des Affaires Economiques Régionales',	'Plateau',	'ALLIANCE',	'6',	'DAFER',	1,	'DC0003',	'DG0001');

DROP TABLE IF EXISTS `direction_centrale`;
CREATE TABLE `direction_centrale` (
  `CODE_DC` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `DESIGNATION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_DG` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CODE_DC`),
  KEY `IDX_EB42C87AC75691A` (`CODE_DG`),
  CONSTRAINT `FK_EB42C87AC75691A` FOREIGN KEY (`CODE_DG`) REFERENCES `direction_generale` (`CODE_DG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `direction_generale`;
CREATE TABLE `direction_generale` (
  `CODE_DG` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `DESIGNATION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abrv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CODE_DG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `direction_generale` (`CODE_DG`, `DESIGNATION`, `abrv`) VALUES
('DG0001',	'DIRECTION GENERALE DE L\'ECONOMIE',	'DGE'),
('DG0002',	'DIRECTION GENRALE ADJOINT 1',	'DGA 1'),
('DG0003',	'DIRECTION GENRALE ADJOINT 2',	'DGA 2'),
('DG0004',	'SECRETARIAT',	'SECRETARIAT'),
('DG0005',	'SGVM',	'SGVM');

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matricule_document` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_doc_at` datetime NOT NULL,
  `agent_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doc_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8698A76724EE076` (`matricule_document`),
  CONSTRAINT `FK_D8698A76724EE076` FOREIGN KEY (`matricule_document`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `document` (`id`, `libelle`, `matricule_document`, `updated_doc_at`, `agent_doc`, `doc_name`) VALUES
(1,	'Note de Service DRHs',	'278 944 J',	'2017-06-28 10:22:46',	NULL,	'HOMEWORK.docx'),
(2,	'Attestation de Prise de Service DGE',	'278 944 J',	'2017-06-28 10:47:15',	NULL,	'HOMEWORK.pdf'),
(3,	'Arrêté de promotion au grade A4',	'FBI0001',	'2017-06-30 02:39:24',	NULL,	'Upgrade11g.pdf.pdf'),
(4,	'Arrêté de promotion au grade A5',	NULL,	'2017-06-30 03:27:49',	NULL,	'Nouveau document texte.txt'),
(5,	'Arrêté de promotion au grade A5',	NULL,	'2017-06-30 03:30:30',	NULL,	'Nouveau document texte.txt'),
(6,	'test',	'I0002',	'2017-06-30 03:41:43',	NULL,	'COMM_RELA_HUM.pdf'),
(7,	'Arrêté de promotion au grade A4',	NULL,	'2017-06-30 09:35:07',	NULL,	'LES ECRITS PROFESSIONNELS.pptx.pptx'),
(8,	'Attestation de Prise de Service DGE',	'428413M',	'2017-06-30 09:53:40',	NULL,	'LES ECRITS PROFESSIONNELS.pptx.pptx'),
(9,	'Arrêté de promotion au grade A5',	'875145D',	'2017-06-30 11:01:47',	NULL,	'exo2.txt'),
(10,	'Un petit Test',	'B2333',	'2017-10-25 00:13:51',	NULL,	'diagramme de classe.docx'),
(11,	'Certificat',	'BHHD087',	'2017-10-26 11:36:26',	NULL,	'BALANCE YAPI.xls'),
(12,	'ok',	'A000034',	'2017-11-05 18:23:26',	NULL,	'59ff571e257e1_obsevation séance du vendredi 30 JUIN.docx'),
(13,	'Note d\'Affectation',	NULL,	'2017-11-07 00:17:31',	NULL,	'5a00fb9b62f30_SERVEURS DEDIES.docx'),
(14,	'Certificat de Prise de Service',	'173892B',	'2017-11-07 00:32:13',	NULL,	'5a00ff0d0b3ed_BALANCE YAPI.xls'),
(15,	'Note d\'Affectation',	'DC2012783Z',	'2017-11-07 00:41:52',	NULL,	'5a0101508a68c_note_affectation_YAO.pdf'),
(16,	'Certificat de Prise de Service',	'DC2012783Z',	'2017-11-07 00:53:56',	NULL,	'5a0104241e56b_certificat_prise_YAO.pdf'),
(17,	'Note d\'Affectation',	'123874H',	'2017-11-13 10:51:20',	NULL,	'5a097928a025f_note_affectation_KOUAO.pdf'),
(18,	'Certificat de Prise de Service',	'123874H',	'2017-11-13 10:56:25',	NULL,	'5a097a595e5cd_certificat_prise_KOUAO.pdf'),
(19,	'Note d\'Affectation',	'8765445H',	'2017-11-20 16:01:36',	NULL,	'5a12fc606270e_facture hebergement Serveur Dédié.pdf'),
(20,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:03:34',	NULL,	'5a12fcd62070c_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(21,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:04:34',	NULL,	'5a12fd123ed53_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(22,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:06:29',	NULL,	'5a12fd856191f_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(23,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:07:19',	NULL,	'5a12fdb7391cb_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(24,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:09:16',	NULL,	'5a12fe2c53360_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(25,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:10:17',	NULL,	'5a12fe69bb626_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(26,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:13:05',	NULL,	'5a12ff1185275_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(27,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:13:30',	NULL,	'5a12ff2a117ce_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(28,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:18:33',	NULL,	'5a130059b2268_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(29,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:18:54',	NULL,	'5a13006e6cc36_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(30,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:20:47',	NULL,	'5a1300df616c0_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(31,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:28:02',	NULL,	'5a130292db51f_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(32,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:29:11',	NULL,	'5a1302d75c980_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(33,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:34:10',	NULL,	'5a13040283606_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(34,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:34:34',	NULL,	'5a13041a41f94_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(35,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:36:19',	NULL,	'5a130483b5195_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(36,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:38:50',	NULL,	'5a13051abd466_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(37,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:40:38',	NULL,	'5a130586612e6_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(38,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 16:57:06',	NULL,	'5a130962e83ad_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(39,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 17:08:40',	NULL,	'5a130c1839c07_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(40,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 17:09:16',	NULL,	'5a130c3c2dad1_MTN - Cloud4africa (VEONE) - No facture au prorata 7608.pdf'),
(41,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 17:48:26',	NULL,	'5a13156a8b069_ELEMENTS DE DONNEES MANQUANTS SUR LE PORTAIL D.docx'),
(42,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 17:51:42',	NULL,	'5a13162ea3d03_ELEMENTS DE DONNEES MANQUANTS SUR LE PORTAIL D.docx'),
(43,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 17:53:07',	NULL,	'5a1316832df96_ELEMENTS DE DONNEES MANQUANTS SUR LE PORTAIL D.docx'),
(44,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 17:54:42',	NULL,	'5a1316e24e302_ELEMENTS DE DONNEES MANQUANTS SUR LE PORTAIL D.docx'),
(45,	'Certificat de Prise de Service',	'8765445H',	'2017-11-20 18:01:00',	NULL,	'5a13185c313a0_ELEMENTS DE DONNEES MANQUANTS SUR LE PORTAIL D.docx'),
(46,	'Note d\'Affectation',	'365572C',	'2017-11-23 09:24:28',	NULL,	'5a1693ccb758d_MASSOUO_CERTIFICAT DE TRAVAIL.pdf(2).pdf'),
(47,	'Certificat de Prise de Service',	'365572C',	'2017-11-23 09:30:28',	NULL,	'5a169534a7c2a_certificat_prise_MOGNIN(2).pdf'),
(48,	'Note d\'Affectation',	'323065Z',	'2017-11-23 10:01:24',	NULL,	'5a169c7470e3f_note_affectation_AMAVI.pdf'),
(49,	'Certificat de Prise de Service',	'323065Z',	'2017-11-23 10:03:39',	NULL,	'5a169cfb5277a_certificat_prise_AMAVI.pdf'),
(50,	'Note d\'Affectation',	'284589W',	'2017-11-23 11:43:32',	NULL,	'5a16b46469879_note_affectation_AMAVI.pdf'),
(51,	'Certificat de Prise de Service',	'284589W',	'2017-11-23 11:50:30',	NULL,	'5a16b606a0bfe_certificat_prise_DANHO.pdf');

DROP TABLE IF EXISTS `droit`;
CREATE TABLE `droit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bouquin_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `directions` longtext COLLATE utf8_unicode_ci,
  `responsables` longtext COLLATE utf8_unicode_ci,
  `agents` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CB7AA75196D9A379` (`bouquin_id`),
  CONSTRAINT `FK_CB7AA75196D9A379` FOREIGN KEY (`bouquin_id`) REFERENCES `bouquin` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `droit` (`id`, `bouquin_id`, `date`, `directions`, `responsables`, `agents`) VALUES
(1,	1,	'2017-11-20 12:30:55',	'1',	NULL,	NULL);

DROP TABLE IF EXISTS `echelon`;
CREATE TABLE `echelon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libEchelon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `echelon` (`id`, `libEchelon`) VALUES
(1,	'1ere Echelon'),
(2,	'2ème Echelon'),
(3,	'3ème Echelon'),
(4,	'4ème Echelon');

DROP TABLE IF EXISTS `emploi`;
CREATE TABLE `emploi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libEmpl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_grade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_74A0B0FAB7DFEF04` (`id_grade`),
  CONSTRAINT `FK_74A0B0FAB7DFEF04` FOREIGN KEY (`id_grade`) REFERENCES `grade` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `emploi` (`id`, `libEmpl`, `id_grade`) VALUES
(1,	'Ingénieur Informaticien',	11),
(2,	'Ingénieur des Techniques Informatique',	10),
(3,	'Administrateur des Services Financiers',	11),
(4,	'Secrétaire de Direction',	9);

DROP TABLE IF EXISTS `enfant`;
CREATE TABLE `enfant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_matricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomEnf` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prenEnf` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dateNaissEnf` date NOT NULL,
  `lieuNaissEnf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `scolarise` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_34B70CA2E5E65AD8` (`agent_matricule`),
  CONSTRAINT `FK_34B70CA2E5E65AD8` FOREIGN KEY (`agent_matricule`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `essai`;
CREATE TABLE `essai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `prenoms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `exercice`;
CREATE TABLE `exercice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annee` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `exercice` (`id`, `annee`, `etat`) VALUES
(1,	2016,	0);

DROP TABLE IF EXISTS `fonction`;
CREATE TABLE `fonction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libFonc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priorite` int(11) NOT NULL,
  `sup` int(11) NOT NULL,
  `type_compte_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_900D5BD46032730` (`type_compte_id`),
  CONSTRAINT `FK_900D5BD46032730` FOREIGN KEY (`type_compte_id`) REFERENCES `role_agent` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `fonction` (`id`, `libFonc`, `priorite`, `sup`, `type_compte_id`) VALUES
(1,	'Agent',	9,	0,	11),
(2,	'Chargé d\'Etudes',	8,	0,	11),
(3,	'Chef de Section',	7,	1,	10),
(4,	'Chef de Service',	6,	1,	10),
(5,	'Chef de Service Rattaché',	6,	1,	10),
(6,	'Sous Directeur',	5,	1,	10),
(7,	'Directeur',	3,	1,	8),
(8,	'Conseiller Technique',	4,	1,	12),
(9,	'Directeur Général Adjoint',	2,	1,	7),
(10,	'Directeur Général',	1,	1,	7);

DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libGrade` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `grade` (`id`, `libGrade`) VALUES
(1,	'D1'),
(2,	'D2'),
(3,	'D3'),
(4,	'C1'),
(5,	'C2'),
(6,	'C3'),
(7,	'B1'),
(8,	'B2'),
(9,	'B3'),
(10,	'A3'),
(11,	'A4'),
(12,	'A5'),
(13,	'A6'),
(14,	'A7');

DROP TABLE IF EXISTS `historique`;
CREATE TABLE `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bouquin_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EDBFD5EC96D9A379` (`bouquin_id`),
  KEY `IDX_EDBFD5ECA76ED395` (`user_id`),
  CONSTRAINT `FK_EDBFD5EC96D9A379` FOREIGN KEY (`bouquin_id`) REFERENCES `bouquin` (`id`),
  CONSTRAINT `FK_EDBFD5ECA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `lieu_naissance`;
CREATE TABLE `lieu_naissance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lieuNaiss` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `lieu_naissance` (`id`, `lieuNaiss`) VALUES
(1,	'ADDIS-ABEBA '),
(2,	'ABENGOUROU'),
(3,	'ABIDJAN'),
(4,	'ABIGUI'),
(5,	'ABOISSO'),
(6,	'ABOISSO COMOE'),
(7,	'ABONGOUA'),
(8,	'ABUJA'),
(9,	'ACCRA'),
(10,	'ADAOU'),
(11,	'ADIAKE'),
(12,	'ADJOUAN'),
(13,	'ADZOPE'),
(14,	'AFFERY'),
(15,	'AGBOVILLE'),
(16,	'AGNIBILEKRO'),
(17,	'AGOU'),
(18,	'AHOUANOU'),
(19,	'AKOBOISSUE'),
(20,	'AKOUPE'),
(21,	'ALEPE'),
(22,	'ALGER'),
(23,	'ALLOSSO'),
(24,	'AMANVI'),
(25,	'AMELEKIA'),
(26,	'ANANDA'),
(27,	'ANDE'),
(28,	'ANDO KEKRENOU'),
(29,	'ANGONDA'),
(30,	'ANIASSUE'),
(31,	'ANNEPE'),
(32,	'ANOUMABA'),
(33,	'ANYAMA'),
(34,	'APPIMANDOUM'),
(35,	'ARIKOKAKA'),
(36,	'ARRAH'),
(37,	'ASSAHARA'),
(38,	'ASSIE-KOUMASSI'),
(39,	'ASSIKOI'),
(40,	'ASSINIE MAFIA');

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `Lbl_menu` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Typecompte` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Lien_menu` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `class_lien` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Ordre` int(11) NOT NULL,
  `Actif_menu` int(11) NOT NULL,
  `Cat_menu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ID_menu` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `menu` (`Lbl_menu`, `Typecompte`, `Lien_menu`, `class_lien`, `Ordre`, `Actif_menu`, `Cat_menu`, `ID_menu`) VALUES
('Transmission courrier',	'ROLE_Service_Courrier',	'courrier_new',	'glyphicon glyphicon-send',	1,	0,	'1',	1),
('Mes courriers',	'ROLE_Service_Courrier',	'courrier_emis',	'glyphicon glyphicon-envelope',	2,	0,	'1',	2),
('Gestion des services',	'20',	'courrier_new',	'glyphicon glyphicon-briefcase',	3,	0,	'1',	3),
('Gestion des agents',	'20',	'courrier_new',	'fa fa-users',	4,	0,	'1',	4),
('Courrier arrivée',	'ROLE_DGE',	'courrier_dge',	'glyphicon glyphicon-envelope',	5,	0,	'1',	5),
('Suivi des diligences',	'20,ROLE_DGE',	'courrier_suivi',	'glyphicon glyphicon-bell',	6,	0,	'1',	6),
('Diligence imputée',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur,20',	'courrier_new',	'glyphicon glyphicon-envelope',	7,	0,	'1',	7),
('Diligence transmise',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur,20',	'courrier_new',	'glyphicon glyphicon-export',	9,	0,	'1',	8),
('Diligence traitée',	'ROLE_DGE,ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur',	'courrier_new',	'glyphicon glyphicon-import',	8,	0,	'1',	9),
('Mon compte',	'ROLE_DGE,ROLE_Directeur,ROLE_Service_Courrier,ROLE_Sous_Dir_Chef_Sec,ROLE_Charge_etudes,6,20,ROLE_Courrier_Interne',	'courrier_new',	'glyphicon glyphicon-user',	14,	0,	'3',	10),
('Diligence reçue',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur',	'courrier_csrecu',	'glyphicon glyphicon-inbox',	6,	0,	'1',	11),
('Archive',	'ROLE_DGE,ROLE_Directeur,ROLE_Service_Courrier,ROLE_Sous_Dir_Chef_Sec,20,ROLE_Courrier_Interne',	'courrier_new',	'glyphicon glyphicon-briefcase',	11,	0,	'1',	12),
('Tableau de bord',	'ROLE_DGE,ROLE_Directeur,ROLE_Service_Courrier,ROLE_Sous_Dir_Chef_Sec,ROLE_Charge_etudes,6,ROLE_Courrier_Interne,20',	'courrier_new',	'glyphicon glyphicon-search',	12,	0,	'3',	13),
('Diligence',	'ROLE_Courrier_Interne',	'courrier_int',	'glyphicon glyphicon-envelope',	1,	0,	'1',	14),
('Registre',	'ROLE_Courrier_Interne',	'courrier_new',	'glyphicon glyphicon-inbox',	2,	0,	'1',	15),
('Gestion des tables',	'20',	'courrier_new',	'glyphicon glyphicon-briefcase',	1,	0,	'1',	16),
('Courrier interne',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur,6,20',	'courrier_new',	'glyphicon glyphicon-send',	1,	0,	'2',	17),
('Diligence interne',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur,6,20',	'courrier_new',	'glyphicon glyphicon-envelope',	2,	0,	'2',	18),
('Diligence interne traitée',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur,6,20',	'courrier_new',	'glyphicon glyphicon-import',	3,	0,	'2',	19),
('Diligence reçue',	'ROLE_Charge_etudes',	'courrier_new',	'glyphicon glyphicon-inbox',	6,	0,	'1',	20),
('Diligence traitée',	'ROLE_Charge_etudes',	'courrier_new',	'glyphicon glyphicon-import',	8,	0,	'1',	21),
('Statistiques',	'ROLE_DGE,ROLE_Service_Courrier,ROLE_Sous_Dir_Chef_Sec,ROLE_Charge_etudes,6,ROLE_Courrier_Interne,ROLE_Directeur,20',	'courrier_new',	'glyphicon glyphicon-signal',	13,	0,	'3',	22),
('Diligence coordonée',	'ROLE_Sous_Dir_Chef_Sec,ROLE_Directeur,6,20',	'coordinateur_index',	'glyphicon glyphicon-envelope',	10,	0,	'1',	23);

DROP TABLE IF EXISTS `mutation`;
CREATE TABLE `mutation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_matricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateMutation` date NOT NULL,
  `sceOrigine` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sceDestination` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateValSceOri` date NOT NULL,
  `dateValSceDesti` date NOT NULL,
  `matSupOri` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `matSupDesti` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4F4978F6E5E65AD8` (`agent_matricule`),
  CONSTRAINT `FK_4F4978F6E5E65AD8` FOREIGN KEY (`agent_matricule`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `numerisation`;
CREATE TABLE `numerisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pj_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_35A58EF9F26B1C97` (`pj_id`),
  CONSTRAINT `FK_35A58EF9F26B1C97` FOREIGN KEY (`pj_id`) REFERENCES `pj` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `numerisation` (`id`, `pj_id`, `date`) VALUES
(1,	2,	'2017-10-31 00:00:00');

DROP TABLE IF EXISTS `periode_conges`;
CREATE TABLE `periode_conges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_conges_id` int(11) DEFAULT NULL,
  `duree` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75F0D35441CAB9FF` (`type_conges_id`),
  CONSTRAINT `FK_75F0D35441CAB9FF` FOREIGN KEY (`type_conges_id`) REFERENCES `type_conges` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `periode_conges` (`id`, `type_conges_id`, `duree`, `libelle`) VALUES
(1,	1,	15,	'Jours'),
(2,	1,	30,	'Jours');

DROP TABLE IF EXISTS `periode_quota`;
CREATE TABLE `periode_quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `periode_quota` (`id`, `libelle`) VALUES
(1,	'Mois'),
(2,	'Trimestre'),
(3,	'Semestre'),
(4,	'Année');

DROP TABLE IF EXISTS `personne`;
CREATE TABLE `personne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenoms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ville` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FCEC9EF349F3CAE` (`pays`),
  KEY `IDX_FCEC9EF43C3D9C3` (`ville`),
  CONSTRAINT `FK_FCEC9EF349F3CAE` FOREIGN KEY (`pays`) REFERENCES `test` (`id`),
  CONSTRAINT `FK_FCEC9EF43C3D9C3` FOREIGN KEY (`ville`) REFERENCES `ville` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `pj`;
CREATE TABLE `pj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `nom_origine` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `upload_report` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C381E34FFB88E14F` (`utilisateur_id`),
  CONSTRAINT `FK_C381E34FFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pj` (`id`, `utilisateur_id`, `nom_origine`, `image_name`, `upload_report`, `updated_at`) VALUES
(1,	78,	'SMAGIR 1 A PIGIER CÔTE D.docx',	'5a74891ef0abf.docx',	NULL,	'2018-02-02 15:51:59'),
(2,	NULL,	'SMAGIR 1 A PIGIER CÔTE D.docx',	'5a7493122dce4.docx',	NULL,	'2018-02-02 16:34:26');

DROP TABLE IF EXISTS `position_militaire`;
CREATE TABLE `position_militaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libPosition` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `position_militaire` (`id`, `libPosition`) VALUES
(1,	'Apte'),
(2,	'Inapte');

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numActePromo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `dateEffetPromo` date NOT NULL,
  `dateSignaPromo` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `provenance`;
CREATE TABLE `provenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ministere` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `posteOcu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `provenance` (`id`, `ministere`, `direction`, `service`, `posteOcu`) VALUES
(1,	'MPMEF',	'Direction Générale du Trésor',	'SI',	'Agent Comptable');

DROP TABLE IF EXISTS `quota`;
CREATE TABLE `quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_demande_id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `nbreQuota` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6C1C0FED9DEA883D` (`type_demande_id`),
  KEY `IDX_6C1C0FEDF384C1CF` (`periode_id`),
  CONSTRAINT `FK_6C1C0FED9DEA883D` FOREIGN KEY (`type_demande_id`) REFERENCES `type_demande` (`id`),
  CONSTRAINT `FK_6C1C0FEDF384C1CF` FOREIGN KEY (`periode_id`) REFERENCES `periode_quota` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `quota` (`id`, `type_demande_id`, `periode_id`, `nbreQuota`) VALUES
(1,	1,	1,	1),
(2,	4,	1,	3);

DROP TABLE IF EXISTS `recompense`;
CREATE TABLE `recompense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_matricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datePrix` date NOT NULL,
  `libPrix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motifPrix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1E9BC0DEE5E65AD8` (`agent_matricule`),
  CONSTRAINT `FK_1E9BC0DEE5E65AD8` FOREIGN KEY (`agent_matricule`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `role_agent`;
CREATE TABLE `role_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libRole` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roleBase` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `role_agent` (`id`, `libRole`, `roleBase`) VALUES
(1,	'Administateur',	'ROLE_SUPER_ADMIN'),
(2,	'Agent',	'ROLE_AGENT'),
(3,	'Responsable de Service',	'ROLE_RESPO'),
(4,	'Service Personnel (SRHMG)',	''),
(5,	'Chef de Service Ressources Humaines',	'ROLE_RESPO_SRHMG'),
(6,	'Secrétaire de Direction',	'ROLE_SECRETAIRE'),
(7,	'Niveau DGE',	'ROLE_DGE'),
(8,	'Niveau Directeur',	'ROLE_Directeur'),
(9,	'Niveau Service Courrier',	'ROLE_Service_Courrier'),
(10,	'Niveau Sous Dir. /Chef de Sec.',	'ROLE_Sous_Dir_Chef_Sec'),
(11,	'Niveau Chargé d\'études',	'ROLE_Charge_etudes'),
(12,	'Niveau Conseillers',	'ROLE_Conseillers'),
(13,	'Niveau Courrier Interne',	'ROLE_Courrier_Interne'),
(14,	'Niveau Administrateur',	'ROLE_Administrateur');

DROP TABLE IF EXISTS `sanction`;
CREATE TABLE `sanction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_matricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateSanct` date NOT NULL,
  `motifSanct` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6D6491AFE5E65AD8` (`agent_matricule`),
  CONSTRAINT `FK_6D6491AFE5E65AD8` FOREIGN KEY (`agent_matricule`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `service_direction`;
CREATE TABLE `service_direction` (
  `CODE_SC` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `DESIGNATION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_SD` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abrv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CODE_SC`),
  KEY `IDX_66DBEBF990FFBC36` (`CODE_SD`),
  CONSTRAINT `FK_66DBEBF990FFBC36` FOREIGN KEY (`CODE_SD`) REFERENCES `sous_direction` (`CODE_SD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `sexe`;
CREATE TABLE `sexe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libSexe` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sexe` (`id`, `libSexe`) VALUES
(1,	'M'),
(2,	'F');

DROP TABLE IF EXISTS `situation_matrimoniale`;
CREATE TABLE `situation_matrimoniale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libSituation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `situation_matrimoniale` (`id`, `libSituation`) VALUES
(1,	'Célibataire'),
(2,	'Marié(e)'),
(3,	'Veuf(ve)'),
(4,	'Divorcé(e)');

DROP TABLE IF EXISTS `sous_direction`;
CREATE TABLE `sous_direction` (
  `CODE_SD` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `DESIGNATION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_DC` int(11) DEFAULT NULL,
  `abrv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CODE_SD`),
  KEY `IDX_25433AFCB18AD03` (`CODE_DC`),
  CONSTRAINT `FK_25433AFCB18AD03` FOREIGN KEY (`CODE_DC`) REFERENCES `direction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sous_direction` (`CODE_SD`, `DESIGNATION`, `CODE_DC`, `abrv`) VALUES
('SD000011',	'Section Normalisation',	1,	''),
('SD1001',	'Sous-Direction des Études de Développement',	1,	''),
('SD1002',	'Sous-Direction du Développement du Secteur Bancaire et Financier',	6,	''),
('SD1003',	'Sous-Direction de l\'Évaluation des Politiques et Stratégies Sectorielles',	6,	''),
('SD1004',	'Sous-Direction du Suivi des Projets et des Actions Économiques en Régions',	6,	''),
('SD2001',	'Sous-Direction des Prévisions Économiques',	5,	''),
('SD2002',	'Sous-Direction de la Conjoncture',	5,	''),
('SD2003',	'Sous-Direction des Programmes et Politiques Économiques',	5,	''),
('SD2004',	'Sous-Direction des Politiques et Finances Publiques',	5,	''),
('SD2005',	'Sous-Direction de la Banque des Données et de la Diffusion',	5,	''),
('SD3001',	'Sous-Direction de la Surveillance Multilatérale',	8,	''),
('SD3002',	'Sous-Direction des Politiques et Stratégies d\' Intégration Régionale',	8,	''),
('SD3003',	'Sous- Direction du Suivi des Projets et Programmes Communautaires',	8,	''),
('SD3004',	'Sous-Direction du Suivi des Réformes et des Activités des Organisations Communautaires',	8,	''),
('SD4001',	'Sous-Direction de la Promotion et des Partenariats',	7,	''),
('SD4002',	'Sous-Direction de la Coopération Bilatérale',	7,	''),
('SD4003',	'Sous-Direction de l\' Appui et de l\'Accompagnement du Secteur Privé',	7,	''),
('SD4004',	'Sous-Direction des Affaires Multilatérales et de Développement',	7,	'');

DROP TABLE IF EXISTS `syndicat`;
CREATE TABLE `syndicat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libSynd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `syndicat` (`id`, `libSynd`) VALUES
(1,	'RESAFIG'),
(2,	'SYNAFIG'),
(3,	'ALTERNATIVE');

DROP TABLE IF EXISTS `tarchive`;
CREATE TABLE `tarchive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Date_archive` datetime NOT NULL,
  `Nom_fichier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Matricule_archiveur` int(11) NOT NULL,
  `Numtraitement` int(11) NOT NULL,
  `Obsrv` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Service_archive` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CodeCourrier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tbillet`;
CREATE TABLE `tbillet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateBillet` int(11) NOT NULL,
  `txtBillet` text COLLATE utf8_unicode_ci NOT NULL,
  `matricule` int(11) NOT NULL,
  `pjBillet` int(11) NOT NULL,
  `CodeCourrier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tcourrier`;
CREATE TABLE `tcourrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typecourrier_id` int(11) NOT NULL,
  `piecejointe_id` int(11) NOT NULL,
  `refOrigine` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `DateOrigine` date NOT NULL,
  `NumEnregistrement` int(11) NOT NULL,
  `Objet` text COLLATE utf8_unicode_ci NOT NULL,
  `ObservationScecour` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `AdresseEnreg` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CodeTypeCour` int(11) NOT NULL,
  `etatCourrier` int(11) NOT NULL,
  `codNatCour` int(11) NOT NULL,
  `exercice` int(11) NOT NULL,
  `etataff` int(11) NOT NULL,
  `id_cord` int(11) DEFAULT NULL,
  `id_invits` mediumtext COLLATE utf8_unicode_ci,
  `Id_identifiant` int(11) NOT NULL,
  `NumEnregistrements` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Source_cour` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Dest_cour` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATE_CREAT` datetime DEFAULT NULL,
  `DATE_MODIF` datetime DEFAULT NULL,
  `Etat_reception` int(11) NOT NULL,
  `etat_alert` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_909025B4D302940F` (`NumEnregistrement`),
  KEY `IDX_909025B4F5BC3B9A` (`typecourrier_id`),
  KEY `IDX_909025B48947BD0C` (`piecejointe_id`),
  CONSTRAINT `FK_909025B48947BD0C` FOREIGN KEY (`piecejointe_id`) REFERENCES `pj` (`id`),
  CONSTRAINT `FK_909025B4F5BC3B9A` FOREIGN KEY (`typecourrier_id`) REFERENCES `ttypecourrier` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tcourrier` (`id`, `typecourrier_id`, `piecejointe_id`, `refOrigine`, `DateOrigine`, `NumEnregistrement`, `Objet`, `ObservationScecour`, `AdresseEnreg`, `CodeTypeCour`, `etatCourrier`, `codNatCour`, `exercice`, `etataff`, `id_cord`, `id_invits`, `Id_identifiant`, `NumEnregistrements`, `Source_cour`, `Dest_cour`, `DATE_CREAT`, `DATE_MODIF`, `Etat_reception`, `etat_alert`) VALUES
(1,	1,	1,	'REF01',	'2018-02-02',	1,	'TEST CABINET<br>',	'RAS',	'',	1,	1,	1,	2017,	0,	NULL,	NULL,	0,	NULL,	'CABINET',	NULL,	'2018-02-02 15:51:57',	NULL,	1,	0);

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `test` (`id`, `pays`) VALUES
(1,	'Côte d\'Ivoire'),
(2,	'Mali');

DROP TABLE IF EXISTS `timputations`;
CREATE TABLE `timputations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courrier_id` int(11) NOT NULL,
  `Date_imput` datetime NOT NULL,
  `Service_imput` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Priorite_imput` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Delai_imput` datetime NOT NULL,
  `Coordinateur` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Inst_part` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Etat_imput` int(11) NOT NULL,
  `Etat_trait` int(11) NOT NULL,
  `Nbre_pers` int(11) NOT NULL,
  `Imputmatricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A7003B4B8BF41DC7` (`courrier_id`),
  KEY `IDX_A7003B4BD7AD59C3` (`Imputmatricule`),
  CONSTRAINT `FK_A7003B4B8BF41DC7` FOREIGN KEY (`courrier_id`) REFERENCES `tcourrier` (`id`),
  CONSTRAINT `FK_A7003B4BD7AD59C3` FOREIGN KEY (`Imputmatricule`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `timputations` (`id`, `courrier_id`, `Date_imput`, `Service_imput`, `Priorite_imput`, `Delai_imput`, `Coordinateur`, `Inst_part`, `Etat_imput`, `Etat_trait`, `Nbre_pers`, `Imputmatricule`) VALUES
(1,	1,	'2018-02-02 16:28:15',	'DG0001',	'ordinaire',	'2018-02-05 16:28:15',	'DC00010',	'',	0,	0,	2,	'989609M');

DROP TABLE IF EXISTS `timput_dir`;
CREATE TABLE `timput_dir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imputation_id` int(11) NOT NULL,
  `Service_imput` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Imput_matricule` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Etat_imput_dir` int(11) NOT NULL,
  `matriculeimpute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CA5779A11E40325` (`imputation_id`),
  KEY `id` (`id`),
  KEY `Service_imput` (`Service_imput`),
  KEY `IDX_CA5779A13E6DDAA0` (`matriculeimpute`),
  CONSTRAINT `FK_CA5779A11E40325` FOREIGN KEY (`imputation_id`) REFERENCES `timputations` (`id`),
  CONSTRAINT `FK_CA5779A13E6DDAA0` FOREIGN KEY (`matriculeimpute`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `timput_dir` (`id`, `imputation_id`, `Service_imput`, `Imput_matricule`, `Etat_imput_dir`, `matriculeimpute`) VALUES
(1,	1,	'DC0003',	'989609M',	0,	'123874H'),
(2,	1,	'DC00010',	'989609M',	0,	'I0002');

DROP TABLE IF EXISTS `timput_instruction`;
CREATE TABLE `timput_instruction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imputation_id` int(11) NOT NULL,
  `Id_imput_dir` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Inst_imput` int(11) NOT NULL,
  `Etat_inst` int(11) NOT NULL,
  `Imputmatricule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CB8C145F1E40325` (`imputation_id`),
  KEY `Id_imput_dir` (`Id_imput_dir`),
  KEY `Inst_imput` (`Inst_imput`),
  KEY `IDX_CB8C145FD7AD59C3` (`Imputmatricule`),
  CONSTRAINT `FK_CB8C145F1E40325` FOREIGN KEY (`imputation_id`) REFERENCES `timputations` (`id`),
  CONSTRAINT `FK_CB8C145FD7AD59C3` FOREIGN KEY (`Imputmatricule`) REFERENCES `agent` (`matricule`),
  CONSTRAINT `FK_CB8C145FDE1BAC67` FOREIGN KEY (`Inst_imput`) REFERENCES `tinstruction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `timput_instruction` (`id`, `imputation_id`, `Id_imput_dir`, `Inst_imput`, `Etat_inst`, `Imputmatricule`) VALUES
(1,	1,	'DC0003',	4,	0,	'989609M'),
(2,	1,	'DC00010',	4,	0,	'989609M');

DROP TABLE IF EXISTS `tinstruction`;
CREATE TABLE `tinstruction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libIbstruction` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tinstruction` (`id`, `libIbstruction`) VALUES
(1,	'Pour&nbsp;attribution '),
(2,	'Pour&nbsp;examen&nbsp;et&nbsp;suite&nbsp;à&nbsp;donner '),
(3,	'Pour&nbsp;allocution/&nbsp;Communication&nbsp;à&nbsp;préparer '),
(4,	' Pour&nbsp;disposition&nbsp;à&nbsp;prendre '),
(5,	'Pour&nbsp;présentation '),
(6,	'Pour&nbsp;suivi '),
(7,	'Pour&nbsp;information '),
(8,	'Pour&nbsp;diffusion '),
(9,	'Pour&nbsp;examen&nbsp;et&nbsp;avis '),
(10,	'M\'en&nbsp;parler/&nbsp;Me&nbsp;voir '),
(11,	'M\'en&nbsp;faire&nbsp;mémoire '),
(12,	'A&nbsp;classer '),
(13,	'Lettre&nbsp;de&nbsp;transmission&nbsp;au&nbsp;Cabinet '),
(14,	'Préparer&nbsp;un&nbsp;soit-transmis '),
(15,	'Instructions&nbsp;Particulières');

DROP TABLE IF EXISTS `titre`;
CREATE TABLE `titre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libTitre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tmp_traitement`;
CREATE TABLE `tmp_traitement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pjtraitement_id` int(11) NOT NULL,
  `DateTraitement` datetime NOT NULL,
  `libTraitement` text COLLATE utf8_unicode_ci NOT NULL,
  `txtTraitement` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `EtatTraitement` int(11) NOT NULL,
  `numTraitement` int(11) NOT NULL,
  `matriculeImpute` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `matriculeImputeur` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `CodeCourrier` int(11) NOT NULL,
  `Id_imput` int(11) NOT NULL,
  `etataff` int(11) NOT NULL,
  `modif` int(11) NOT NULL,
  `imputdir_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6D1452FE5DB28ECD` (`pjtraitement_id`),
  KEY `IDX_6D1452FE374212CD` (`imputdir_id`),
  CONSTRAINT `FK_6D1452FE374212CD` FOREIGN KEY (`imputdir_id`) REFERENCES `timput_dir` (`id`),
  CONSTRAINT `FK_6D1452FE5DB28ECD` FOREIGN KEY (`pjtraitement_id`) REFERENCES `pj` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tmp_traitement` (`id`, `pjtraitement_id`, `DateTraitement`, `libTraitement`, `txtTraitement`, `EtatTraitement`, `numTraitement`, `matriculeImpute`, `matriculeImputeur`, `CodeCourrier`, `Id_imput`, `etataff`, `modif`, `imputdir_id`) VALUES
(1,	2,	'2018-02-02 16:34:26',	'REPONSE SIM<br>',	'REPONSE SIM<br>',	1,	1,	'I0002',	'989609M',	1,	1,	1,	0,	2);

DROP TABLE IF EXISTS `tnaturecourrier`;
CREATE TABLE `tnaturecourrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libNatCour` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `tpriorite`;
CREATE TABLE `tpriorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libPriorite` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `tpriorite` (`id`, `libPriorite`) VALUES
(1,	'Niveau DGE'),
(2,	'Niveau Directeur'),
(3,	'Niveau Service Courrier'),
(4,	'Niveau Sous Dir. /Chef de Sec.'),
(5,	'Niveau Chargé d\'études'),
(6,	'Niveau Conseillers'),
(7,	'Niveau Courrier Interne'),
(8,	'Niveau Administrateur');

DROP TABLE IF EXISTS `tprovenance`;
CREATE TABLE `tprovenance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `LIB` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ETAT` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `treception`;
CREATE TABLE `treception` (
  `courrier_id` int(11) NOT NULL,
  `typecourrier_id` int(11) NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DateReception` datetime NOT NULL,
  `etatReception` int(11) NOT NULL,
  `matriculeReception` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `Id_imput` int(11) NOT NULL,
  `chrono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `servicereception` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `IDX_AAF7DC158BF41DC7` (`courrier_id`),
  KEY `IDX_AAF7DC15F5BC3B9A` (`typecourrier_id`),
  CONSTRAINT `FK_AAF7DC158BF41DC7` FOREIGN KEY (`courrier_id`) REFERENCES `tcourrier` (`id`),
  CONSTRAINT `FK_AAF7DC15F5BC3B9A` FOREIGN KEY (`typecourrier_id`) REFERENCES `ttypecourrier` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `treception` (`courrier_id`, `typecourrier_id`, `Id`, `DateReception`, `etatReception`, `matriculeReception`, `Id_imput`, `chrono`, `servicereception`) VALUES
(1,	1,	1,	'2018-02-02 16:31:16',	1,	'R0002',	1,	'01',	'DC00010');

DROP TABLE IF EXISTS `tspref`;
CREATE TABLE `tspref` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CODE_SPREF` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `LIB_SPREF` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ACTIF` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Code_spref` (`CODE_SPREF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ttraitement`;
CREATE TABLE `ttraitement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DateTraitement` datetime NOT NULL,
  `libTraitement` text COLLATE utf8_unicode_ci NOT NULL,
  `txtTraitement` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `EtatTraitement` int(11) NOT NULL,
  `numTraitement` int(11) NOT NULL,
  `matriculeImpute` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `matriculeImputeur` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `CodeCourrier` int(11) NOT NULL,
  `Id_imput` int(11) NOT NULL,
  `etataff` int(11) NOT NULL,
  `modif` int(11) NOT NULL,
  `pjtraitement_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ECC395CC5DB28ECD` (`pjtraitement_id`),
  CONSTRAINT `FK_ECC395CC5DB28ECD` FOREIGN KEY (`pjtraitement_id`) REFERENCES `pj` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ttypecourrier`;
CREATE TABLE `ttypecourrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LibCourrier` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ttypecourrier` (`id`, `LibCourrier`) VALUES
(1,	'Externe'),
(2,	'Interne');

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `type` (`id`, `libType`) VALUES
(1,	'Fonctionnaire'),
(2,	'Contractuel');

DROP TABLE IF EXISTS `type_conges`;
CREATE TABLE `type_conges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jours` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `sexe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `type_conges` (`id`, `libelle`, `jours`, `etat`, `sexe`) VALUES
(1,	'Annuel',	30,	1,	0),
(2,	'Mariage',	2,	1,	0),
(3,	'Naissance d\'un enfant',	3,	1,	1),
(4,	'Décès du conjoint, d\'un ascendant ou descendant',	5,	1,	0),
(5,	'Congé pour couche ou allaitement (14 semaines)',	98,	1,	2),
(6,	'Congé maladie courte duréee (15 jrs à 06 mois)',	180,	1,	0),
(7,	'Congé maladie longue durée (36 mois)',	1080,	1,	0);

DROP TABLE IF EXISTS `type_demande`;
CREATE TABLE `type_demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `type_demande` (`id`, `libelle`) VALUES
(1,	'AUTORISATION D\'ABSENCE'),
(3,	'ATTESTATION DE PRESENCE'),
(4,	'CERTIFICAT DE TRAVAIL');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `agent_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_1483A5E93414710B` (`agent_id`),
  UNIQUE KEY `UNIQ_1483A5E9C05FB297` (`confirmation_token`),
  CONSTRAINT `FK_1483A5E93414710B` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`matricule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `agent_id`, `token`) VALUES
(5,	'989609M',	'989609m',	'stephenjlo@yahoo.fr',	'stephenjlo@yahoo.fr',	1,	'nb5u2qrrrr4wkgwocsw484gocwco4os',	'$2y$13$nb5u2qrrrr4wkgwocsw48uV7ZYKw7FxqwA2tI.n1z1IKwyYlL/c/y',	'2018-02-02 15:52:31',	NULL,	NULL,	'a:2:{i:0;s:10:\"ROLE_AGENT\";i:1;s:8:\"ROLE_DGE\";}',	'989609M',	'urgvtb99vmqnd2j0dcq3nvs365'),
(78,	'I0001',	'i0001',	'stephanjlo@yahoo.fr',	'stephanjlo@yahoo.fr',	1,	'k4fer09fvrk80koc8sos04wcocgo8o0',	'$2y$13$k4fer09fvrk80koc8sos0ua.ajWStPEcrYbVuL11Yd5eYcHyAx.1K',	'2018-02-02 15:48:43',	'y-qh4rtpQGsrgbl3XpQIV4eadNbO_-aXAQK7Bk2woCk',	'2016-11-21 09:08:47',	'a:2:{i:0;s:10:\"ROLE_AGENT\";i:1;s:21:\"ROLE_SERVICE_COURRIER\";}',	'I0001',	'nrtdq2b0dn6hsga6a2gp9ptjp1'),
(79,	'I0002',	'i0002',	'stephy1.jlo@gmail.com',	'stephy1.jlo@gmail.com',	1,	'nb0akrfgcu8000s4kkw04kkck8wo84w',	'$2y$13$nb0akrfgcu8000s4kkw04e1k2Mz3XYxHs2vtFFWGg0tXihmaWncxu',	'2018-02-09 08:05:04',	NULL,	NULL,	'a:2:{i:0;s:10:\"ROLE_RESPO\";i:1;s:22:\"ROLE_SOUS_DIR_CHEF_SEC\";}',	'I0002',	'jfirtoqepsernaqsctev1qrtv3'),
(80,	'R0001',	'r0001',	'stephnjlo@yahoo.fr',	'stephnjlo@yahoo.fr',	1,	'8ikueiysh7cw84c8c80gcg80kooowc4',	'$2y$13$8ikueiysh7cw84c8c80gcezZaJ.RV7X039A/QP6RpY0aMoIPBTT0y',	'2018-02-01 15:32:43',	NULL,	NULL,	'a:2:{i:0;s:16:\"ROLE_RESPO_SRHMG\";i:1;s:21:\"ROLE_COURRIER_INTERNE\";}',	'R0001',	'dndtltv5lgl76f3b7uaiksutg2'),
(81,	'R0002',	'r0002',	'stephenjlos@yahoo.fr',	'stephenjlos@yahoo.fr',	1,	'7g0n1pblmn8k0gwkk8g08kcooowws8w',	'$2y$13$7g0n1pblmn8k0gwkk8g08eRazCVCmW4jQ2MCX0F3SHXNAApMpiYRe',	'2018-02-02 16:30:21',	NULL,	NULL,	'a:2:{i:0;s:10:\"ROLE_AGENT\";i:1;s:21:\"ROLE_COURRIER_INTERNE\";}',	'R0002',	'ni9njditm7iu0rrbfh3r4m6ca1'),
(82,	'278 944 J',	'278 944 j',	'dogbo.curtis@gmail.com',	'dogbo.curtis@gmail.com',	1,	'8v7j8n6a6dk488ok4wo44o0wckgc0kk',	'$2y$13$8v7j8n6a6dk488ok4wo44efZmE5OnM0FJwmSxpERP7ZGrxikcjlYO',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_RESPO\";}',	'278 944 J',	NULL),
(83,	'223554G',	'223554g',	'gjkhskls@vxsh.co',	'gjkhskls@vxsh.co',	1,	'nmlio97zsg0wws0o4o4ck4c880w4s8c',	'$2y$13$nmlio97zsg0wws0o4o4cku/2b/4hPhncbcr1slq0O3LsyNArD49vW',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'223554G',	NULL),
(84,	'test1',	'test1',	'jl.yapi@finances.gouv.ci',	'jl.yapi@finances.gouv.ci',	1,	's7aj0e3jarkwkocok8s4o40000kkg0o',	'$2y$13$s7aj0e3jarkwkocok8s4ouRoTIaB66fm8.M6bQARAMrnOzAww/Z/C',	'2016-07-26 10:31:09',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'test1',	NULL),
(85,	'TEST12',	'test12',	'yapimobio16@univmetiers.ci',	'yapimobio16@univmetiers.ci',	1,	'96ddboqkwocog8848c8co4c8488c80c',	'$2y$13$96ddboqkwocog8848c8couFlRM.iYA807aKNEAc.9QaLraBBUql7O',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'TEST12',	NULL),
(87,	'875145D',	'875145d',	'yapimobio15@univmetiers.ci',	'yapimobio15@univmetiers.ci',	1,	'9sct55qifx8g0wg4o4kgowo0koww88k',	'$2y$13$9sct55qifx8g0wg4o4kgouY2r2i93LdmsyNplppBc3wKjwOHSfEu2',	NULL,	'rNGLI0MyHDfcsQqVF6AmGWichT6Y3q-fkdW21hL1HBs',	'2016-11-13 19:45:58',	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'875145D',	NULL),
(88,	'FBI0001',	'fbi0001',	'stephy2.jlo@gmail.com',	'stephy2.jlo@gmail.com',	1,	'd3u13myn2jkkgogkso4w448owc8kww4',	'$2y$13$d3u13myn2jkkgogkso4w4usL.amE1P0dJOfze6pVzabbKSlaD4/Ta',	'2016-11-21 09:10:06',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'FBI0001',	NULL),
(89,	'I0003H',	'i0003h',	'personnel.dge@gmail.com',	'personnel.dge@gmail.com',	1,	'b0if60zuue0c8sk0o4kwkgwkocoskoc',	'$2y$13$b0if60zuue0c8sk0o4kwke84vhzReDUjt944SFJ58GXWT/AyS.4k.',	'2017-11-02 13:51:43',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'I0003H',	NULL),
(91,	'385175T',	'385175t',	'silayeur@gmail.com',	'silayeur@gmail.com',	1,	NULL,	'$2y$13$qE6yaRGz3Rz0cS4igXgLPut8sb.CT9u9Ty76yNs0NAaIFieTPEHS.',	'2017-06-30 12:21:16',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'385175T',	NULL),
(92,	'CE16-0000355',	'ce16-0000355',	'admin1@stephenjlo.xyz',	'admin1@stephenjlo.xyz',	1,	NULL,	'$2y$13$WiGf7OXXTcAwjiRR9XlFOucVLikchJcUxBDfDnxCDLO4/sih.YiiO',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'CE16-0000355',	NULL),
(93,	'B2333',	'b2333',	'tropicalway@ooot.com',	'tropicalway@ooot.com',	1,	NULL,	'$2y$13$O9XQ1PkBAeJM3TdkBxd3FexU6YwcpO56W/me3olaqPY1BOPFNkEcO',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'B2333',	NULL),
(94,	'PC23456',	'pc23456',	'ingridamenanndry@gmail.com',	'ingridamenanndry@gmail.com',	1,	NULL,	'$2y$13$XAohyEOApTxNK0SQooI7wOdV1pfiJPZCa7jhNhlyRa/L4ABvDbP9C',	'2017-10-31 06:39:36',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'PC23456',	NULL),
(95,	'ABD5436',	'abd5436',	'tropicalway@ccooot.com',	'tropicalway@ccooot.com',	1,	NULL,	'$2y$13$PkvHdZvOqc1qA/N3tzTZFeNFNJazZsKOeZBf2kpOEqYAPW/8OWNnu',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'ABD5436',	NULL),
(96,	'BHHD087',	'bhhd087',	'azgihbdauihz@bhdbc.ci',	'azgihbdauihz@bhdbc.ci',	1,	NULL,	'$2y$13$HDOwpb2h7DVRlGmIUrleJOm3uLJX6qVNG8daBNH4kHHVfhWEaYPLa',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'BHHD087',	NULL),
(97,	'GP0001',	'gp0001',	'otokkflorfo@yaho.fr',	'otokkflorfo@yaho.fr',	1,	NULL,	'$2y$13$7AtpWlLb1ZemLc.O8d3.6epVXh2AKd10p9v2vK6dTHtSiJLA4q8S6',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'GP0001',	NULL),
(98,	'173892B',	'173892b',	'admin@stephenjlo.xyz',	'admin@stephenjlo.xyz',	1,	NULL,	'$2y$13$3inWG/N4fnpjisoogOt8eOZR0gF9MzUM0A2mYOTcb/D6t8AQIVEJC',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'173892B',	NULL),
(99,	'DC2012783Z',	'dc2012783z',	'stephy4.jlo@gmail.com',	'stephy4.jlo@gmail.com',	1,	NULL,	'$2y$13$OpD.nsF.17AnM1t2cU5PWu2nhvr.R5.Ir38AeIosAR0rOiItSK9xm',	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'DC2012783Z',	NULL),
(100,	'123874H',	'123874h',	'kjxzjixgisux@xnjsbxnjz.fr',	'kjxzjixgisux@xnjsbxnjz.fr',	1,	NULL,	'$2y$13$O5YRFTrrc9nzahcdeIa0oerKMFGmLMzNK.Wsje6DbEQgA869GQGoS',	'2018-02-01 15:34:09',	NULL,	NULL,	'a:2:{i:0;s:10:\"ROLE_AGENT\";i:1;s:14:\"ROLE_DIRECTEUR\";}',	'123874H',	'qhu9e5hoduqdikc1auvquglc71'),
(101,	'AB00003',	'ab00003',	'dogbo.curtis01@gmail.com',	'dogbo.curtis01@gmail.com',	1,	NULL,	'$2y$13$LvacwdXPZ4jTj2FOfFgBqOcfLU/TVu42d6XnawtGpqvrxCUR4P9Nm',	NULL,	NULL,	NULL,	'a:0:{}',	'AB00003',	NULL),
(102,	'8765445H',	'8765445h',	'asjsasos@sxjsk.ci',	'asjsasos@sxjsk.ci',	1,	NULL,	'$2y$13$4oz4F2HTWF7/VOO.MZu0r.iLcs7J20Ey5NrCO6Cg1vtk.htdz7G5a',	'2017-11-21 14:30:17',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'8765445H',	'f45r2q2qsv4f9rd9q90nk5i9p5'),
(103,	'SQN0001',	'sqn0001',	'rdtftgyuhj@kljhgh.ci',	'rdtftgyuhj@kljhgh.ci',	1,	NULL,	'$2y$13$0g.6UAYxkFT2kz2CbF/jpeB62JJtyuxBLPM.Eqr7sXaS1Fvhd02Za',	NULL,	NULL,	NULL,	'a:0:{}',	'SQN0001',	NULL),
(104,	'365572C',	'365572c',	'k.mognin@finances.gouv.ci',	'k.mognin@finances.gouv.ci',	1,	NULL,	'$2y$13$s8ZU2ZhY9IEsr0X.xw0m1uwX0fNHw091/mzYIr3NLM4wbTHN5C8aK',	'2017-11-23 10:47:43',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_RESPO\";}',	'365572C',	'09btluckbp9an52m0q3ln1usf7'),
(105,	'323065Z',	'323065z',	'fdghjkklmk@fghjk.fr',	'fdghjkklmk@fghjk.fr',	1,	NULL,	'$2y$13$Yq9xY9OoBU1/tImlxkp5p.WZGD.O/nQ7DX1ebA2QpodZXEymSvAuS',	'2017-11-23 10:06:30',	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_AGENT\";}',	'323065Z',	'675pu0ju7svi08jmfk91834mb5'),
(106,	'284589W',	'284589w',	'koffi156@gmail.com',	'koffi156@gmail.com',	1,	NULL,	'$2y$13$nkTd.a2b/K/eG0xrfQXWMOKcSDEVZCDb4K.RRNAHTbWqnbIbJVB8i',	'2018-01-03 15:22:55',	NULL,	NULL,	'a:2:{i:0;s:10:\"ROLE_AGENT\";i:1;s:18:\"ROLE_CHARGE_ETUDES\";}',	'284589W',	'vn4n8lp1ror5d0m8nk9l4sbid7');

DROP TABLE IF EXISTS `ville`;
CREATE TABLE `ville` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pays_delaville` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_43C3D9C3ED5631CC` (`pays_delaville`),
  CONSTRAINT `FK_43C3D9C3ED5631CC` FOREIGN KEY (`pays_delaville`) REFERENCES `test` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ville` (`id`, `nom`, `pays_delaville`) VALUES
(1,	'Abidjan',	1),
(2,	'Bamako',	2),
(3,	'Tombouctou',	2),
(4,	'Kidal',	2),
(5,	'Bouake',	1);

-- 2018-02-09 17:02:04
