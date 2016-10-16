-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 �?09 �?13 �?17:57
-- 服务器版本: 5.5.47
-- PHP 版本: 5.5.30

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cms`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL COMMENT '管理员姓名',
  `pwd` varchar(225) NOT NULL COMMENT '管理员密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `name`, `pwd`) VALUES
(1, 'aa', 'aa');

-- --------------------------------------------------------

--
-- 表的结构 `alone`
--

CREATE TABLE IF NOT EXISTS `alone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `content` text NOT NULL,
  `simple_content` varchar(225) DEFAULT NULL COMMENT '简介',
  `pic1` varchar(225) DEFAULT NULL COMMENT '单页中引入的图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='单页具体内容' AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  `mark` int(11) NOT NULL COMMENT '标识',
  `default` int(1) NOT NULL DEFAULT '0' COMMENT '默认banner标识，默认不可删除',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`id`, `name`, `mark`, `default`) VALUES
(1, '默认轮播', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cate`
--

CREATE TABLE IF NOT EXISTS `cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL COMMENT '栏目名称',
  `tid` int(11) NOT NULL COMMENT '栏目类型',
  `hide` int(1) NOT NULL DEFAULT '1' COMMENT '显示隐藏 1显示 0隐藏',
  `parent` int(11) NOT NULL DEFAULT '0',
  `mark` int(11) NOT NULL COMMENT '栏目标示',
  `order1` int(11) NOT NULL DEFAULT '10' COMMENT '排序',
  `tpl_list` varchar(225) NOT NULL COMMENT '列表页模板',
  `tpl_content` varchar(225) NOT NULL COMMENT '内容页模板',
  `list_num` int(11) NOT NULL COMMENT '列表页列表数',
  `content` text COMMENT '栏目内容，用于标注',
  `is_content` int(1) NOT NULL DEFAULT '0' COMMENT '是否有编辑内容，用于单页，此内容非当前表中的内容',
  `pic1` varchar(225) DEFAULT NULL COMMENT '栏目图片',
  `pic2` varchar(225) DEFAULT NULL COMMENT '栏目图片',
  `pic3` varchar(225) DEFAULT NULL COMMENT '栏目图片',
  `url` varchar(255) NOT NULL COMMENT 'url链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `content` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=ucs2 COMMENT='评论' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `fragment`
--

CREATE TABLE IF NOT EXISTS `fragment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `content` text NOT NULL,
  `simple_content` varchar(225) NOT NULL,
  `pic` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='页面片段内容' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `img`
--

CREATE TABLE IF NOT EXISTS `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(225) NOT NULL,
  `bid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- 表的结构 `list_content`
--

CREATE TABLE IF NOT EXISTS `list_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL COMMENT '栏目id',
  `content` text NOT NULL COMMENT '内容',
  `order` int(11) NOT NULL COMMENT '排序',
  `simple_content` varchar(225) NOT NULL COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;

--
-- 转存表中的数据 `list_content`
--

INSERT INTO `list_content` (`id`, `mid`, `content`, `order`, `simple_content`) VALUES
(63, 88, '<p>\n	简单的慕斯烘焙课：曲奇饼干，戚风蛋糕卷，慕斯等\n</p>\n<p>\n	要求：需要提前一天预定，可加店主微信，或电话联系。\n</p>\n<p>\n	时间：可预定2-3小时，或半天兼可\n</p>', 10, '');

-- --------------------------------------------------------

--
-- 表的结构 `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT '栏目标识',
  `title` varchar(225) NOT NULL COMMENT '内容标题',
  `date` int(11) NOT NULL COMMENT '内容日期',
  `author` varchar(225) NOT NULL DEFAULT '管理员' COMMENT '内容编写者',
  `tbpic` varchar(225) DEFAULT NULL COMMENT '缩略图',
  `url` varchar(225) NOT NULL COMMENT '列表url链接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='栏目内容主体' AUTO_INCREMENT=90 ;

--
-- 转存表中的数据 `main`
--

INSERT INTO `main` (`id`, `cid`, `title`, `date`, `author`, `tbpic`, `url`) VALUES
(83, 46, '欧蕾咖啡', 1472918145, '管理员', '/upload/2016-09-03/57caf2726eb96.jpg', ''),
(84, 46, '维也纳咖啡', 1472918174, '管理员', '/upload/2016-09-03/57caf2929d510.jpg', ''),
(85, 46, '卡布奇诺', 1472918247, '管理员', '/upload/2016-09-03/57caf2d823f8f.jpg', ''),
(86, 46, '夏威夷咖啡', 1472918278, '管理员', '/upload/2016-09-03/57caf2fbb8a9c.jpg', ''),
(87, 46, '白咖啡 ', 1472918294, '管理员', '/upload/2016-09-03/57caf30f977e4.jpg', ''),
(88, 45, '三木活动之简单烘焙课', 1472920319, '管理员', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `tid` int(11) NOT NULL,
  `tname` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目类型';

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`tid`, `tname`) VALUES
(1, '单页'),
(2, '列表');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
