SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `testing`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `odc`
--

CREATE TABLE IF NOT EXISTS `odc` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tag` tinytext CHARACTER SET utf8 NOT NULL,
  `page` text CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET ucs2,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;
