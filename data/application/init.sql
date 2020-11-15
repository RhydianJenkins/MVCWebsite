--
-- Database: `tata_db`
--

CREATE DATABASE IF NOT EXISTS `tata_db`;
USE `tata_db`;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `ID` int(11) NOT NULL COMMENT 'Unique identifier of the member.',
  `firstname` VARCHAR(255) NOT NULL COMMENT 'First name of the The member''s first name.',
  `surname` VARCHAR(255) NOT NULL COMMENT 'The member''s surname.',
  `email` VARCHAR(255) NOT NULL COMMENT 'The unique member''s email, used to log in.',
  `picture` longtext DEFAULT NULL COMMENT 'Base64 encoded profile picture, defaulting to null on creation',
  `resetcode` VARCHAR(255) DEFAULT NULL COMMENT 'The reset code generated when the member selects to reset their password.',
  `password` VARCHAR(255) NOT NULL COMMENT 'The member''s password; hashed and salted.',
  `salt` VARCHAR(255) NOT NULL COMMENT 'The member''s unique salt for their password.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `portsmouth_numbers`
--

CREATE TABLE IF NOT EXISTS `portsmouth_numbers` (
  `ID` int(11) NOT NULL,
  `class` VARCHAR(255) NOT NULL,
  `configuration` VARCHAR(255) NOT NULL,
  `club_pn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tata Steel Sailing Club Portsmouth Number List';

--
-- Dumping data for table `portsmouth_numbers`
--

INSERT INTO `portsmouth_numbers` (`ID`, `class`, `configuration`, `club_pn`) VALUES
(1, '505', '2|S|C', 903),
(2, '2000', '2|S|A', 1112),
(3, '29ER', '2|S|A', 907),
(4, 'ALBACORE', '2|S|0', 1038),
(5, 'B14', '2|S|A', 860),
(6, 'BLAZE', '1|U|0', 1027),
(7, 'BYTE CII', '1|U|0', 1138),
(8, 'CHALLENGER', '1|U|0', 1173),
(9, 'COMET TRIO', '2|S|A', 1097),
(10, 'DEVOTI D-ONE', '0|U|CA', 948),
(11, 'EVOTI D-ZERO', '1|U|0', 1029),
(12, 'ENTERPRISE', '2|S|0', 1119),
(13, 'EUROPE', '1|U|0', 1141),
(14, 'FINN', '1|U|0', 1051),
(15, 'FIREBALL', '2|S|C', 953),
(16, 'FIREFLY', '2|S|0', 1172),
(17, 'FLYING FIFTEEN', '2|S|C', 1009),
(18, 'GRADUATE', '2|S|0', 1129),
(19, 'HADRON H2', '1|U|0', 1034),
(20, 'INTERNATIONAL CANOE', '1|S|0', 890),
(21, 'K1', '1|S|0', 1070),
(22, 'K6', '2|S|A', 913),
(23, 'KESTREL', '2|S|C', 1038),
(24, 'LARK', '2|S|C', 1073),
(25, 'LASER', '1|U|0', 1098),
(26, 'LASER 2', '2|S|C', 1085),
(27, 'LASER 4.7', '1|U|0', 1208),
(28, 'LASER 4000', '2|S|A', 917),
(29, 'LASER EPS', '1|U|0', 1033),
(30, 'LASER RADIAL', '1|U|0', 1142),
(31, 'LASER STRATOS', '2|S|A', 1100),
(32, 'LIGHTNING 368', '1|U|0', 1167),
(33, 'MERLIN-ROCKET', '2|S|C', 980),
(34, 'MIRACLE', '2|S|C', 1197),
(35, 'MIRROR (D/H)', '2|S|0', 1390),
(36, 'MIRROR (S/H)', '1|S|0', 1381),
(37, 'MUSTO SKIFF', '1|U|A', 849),
(38, 'NATIONAL 12', '2|S|0', 1064),
(39, 'OK', '1|U|0', 1104),
(40, 'OPTIMIST', '1|U|0', 1645),
(41, 'OSPREY', '2|S|C', 936),
(42, 'PHANTOM', '1|U|0', 1002),
(43, 'RS 100 10.2', '1|U|A', 981),
(44, 'RS 100 8.4', '1|U|A', 1003),
(45, 'RS 200', '2|S|A', 1051),
(46, 'RS 300', '1|U|0', 964),
(47, 'RS 400', '2|S|A', 946),
(48, 'RS 500', '2|S|A', 963),
(49, 'RS 600', '1|U|0', 916),
(50, 'RS 700', '1|U|A', 845),
(51, 'RS 800', '2|S|A', 799),
(52, 'RS AERO 5', '1|U|0', 1136),
(53, 'RS AERO 7', '2|S|C', 1065),
(54, 'RS FEVA XL', '2|S|A', 1238),
(55, 'RS QUEST', '2|S|A', 1219),
(56, 'RS TERA PRO', '1|U|0', 1359),
(57, 'RS TERA SPORT', '1|U|0', 1438),
(58, 'RS VAREO', '1|S|A', 1084),
(59, 'RS VISION', '2|S|A', 1137),
(60, 'SCORPION', '2|S|C', 1036),
(61, 'SOLO', '1|U|0', 1140),
(62, 'SOLUTION', '1|U|0', 1089),
(63, 'SPRINT 15', '1|U|0', 926),
(64, 'SPRINT 15 SPORT', '2|S|0', 904),
(65, 'STREAKER', '1|U|0', 1128),
(66, 'SUPERNOVA', '1|U|0', 1077),
(67, 'TASAR', '2|S|0', 1020),
(68, 'TOPPER', '1|U|0', 1365),
(69, 'TOPPER 4.2', '1|U|0', 1416),
(70, 'WANDERER', '2|S|C', 1190),
(71, 'WAYFARER', '2|S|C', 1102),
(72, 'WINDSURFER', '0||0', 940),
(73, 'CONTENDER', '1|U|0', 974),
(75, '420', '2|S|C', 1110);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `portsmouth_numbers`
--
ALTER TABLE `portsmouth_numbers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CLASS` (`class`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the member.', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `portsmouth_numbers`
--
ALTER TABLE `portsmouth_numbers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;