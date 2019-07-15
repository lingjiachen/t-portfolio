-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 
-- 伺服器版本: 10.1.13-MariaDB
-- PHP 版本： 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `portfolio`
--

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'qwert', 'teacher1@gmail.com', '123456'),
(2, 'aaa', 'teacher2@gmail.com', '123456'),
(3, 'qwert', 'teacher3@gmail.com', '123456');

-- --------------------------------------------------------

--
-- 資料表結構 `works`
--

CREATE TABLE `works` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `status` enum('APPROVED','NOT_APPROVED','','') DEFAULT 'NOT_APPROVED',
  `title` varchar(300) NOT NULL,
  `author` varchar(300) NOT NULL,
  `publication` varchar(300) NOT NULL,
  `category` varchar(300) NOT NULL,
  `date` date NOT NULL,
  `keywords` varchar(300) NOT NULL,
  `type` enum('journal','conference','project','other') NOT NULL DEFAULT 'journal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `works`
--

INSERT INTO `works` (`id`, `userId`, `status`, `title`, `author`, `publication`, `category`, `date`, `keywords`, `type`) VALUES
(1, 2, 'NOT_APPROVED', '1', '1', '1', 'TSSCI,1', '2017-12-26', '1', 'journal'),
(2, 2, 'NOT_APPROVED', '', '', '', '', '0000-00-00', '', 'journal'),
(3, 2, 'APPROVED', '1', '1', '1', 'TSSCI,1', '2017-12-26', '1', 'journal'),
(5, 2, 'APPROVED', 'a', 'b', 'c', 'SSCI', '2017-12-08', 'a', 'journal'),
(9, 2, 'APPROVED', 'a', 'b', 'c', 'SSCI', '2017-12-13', '', 'journal'),
(10, 2, 'APPROVED', 'a', 'b', 'c', 'SSCI', '2017-12-13', '', 'journal'),
(11, 2, 'APPROVED', '4', '5', '5', 'TSSCI,5', '2017-12-07', '5', 'journal'),
(12, 2, 'APPROVED', 'a', 'adsfa', 'a', 'SSCI', '2017-11-07', 'a', 'journal'),
(13, 0, 'APPROVED', '1', '1', '1', 'TSSCI,1', '2017-12-26', '1', 'journal'),
(15, 0, 'APPROVED', '1', '1', '1', 'TSSCI,1', '2017-12-26', '1', 'journal'),
(17, 0, 'APPROVED', 'a', 'b', 'c', 'SSCI', '2017-12-08', 'a', 'journal'),
(19, 0, 'APPROVED', '', '', '', '', '0000-00-00', '', 'project'),
(20, 0, 'APPROVED', '', '', '', '', '0000-00-00', '', 'conference'),
(21, 0, 'APPROVED', 'a', 'b', 'c', 'SSCI', '2017-12-13', '', 'project'),
(22, 0, 'APPROVED', 'a', 'b', 'c', 'SSCI', '2017-12-13', '', 'other'),
(23, 0, 'APPROVED', '4', '5', '5', 'TSSCI,5', '2017-12-07', '5', 'conference'),
(24, 1, 'APPROVED', 'a', 'adsfa', 'a', 'SSCI', '2017-11-07', 'a', 'journal'),
(25, 2, 'NOT_APPROVED', 'e', 'e', 'e', 'a:1:{i:0;s:4:"SSCI";}', '2018-01-25', 'e', 'journal'),
(26, 2, 'NOT_APPROVED', 'f', 'f', 'f', 'TSSCI', '2018-01-25', 'f', 'journal'),
(27, 2, 'NOT_APPROVED', 'g', 'g', 'g', 'TSSCI', '2018-01-25', 'g', 'journal'),
(28, 2, 'NOT_APPROVED', 'h', 'h', 'h', 'TSSCI', '2018-01-25', 'h', 'journal'),
(29, 2, 'NOT_APPROVED', 'i', 'i', 'i', 'SSCI', '2018-01-25', 'i', 'journal'),
(30, 2, 'NOT_APPROVED', 'qq', 'qq', 'qq', 'TSSCI', '2018-01-25', 'qq', 'journal');

-- --------------------------------------------------------

--
-- 資料表結構 `教學_其他`
--

CREATE TABLE `教學_其他` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `教學貢獻名稱` int(11) NOT NULL,
  `描述與說明` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_專著`
--

CREATE TABLE `教學_專著` (
  `id` int(11) NOT NULL,
  `年度` int(11) NOT NULL,
  `專著名稱` int(11) NOT NULL,
  `出版單位` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_專題`
--

CREATE TABLE `教學_專題` (
  `id` int(11) NOT NULL,
  `完成學年學期` varchar(300) NOT NULL,
  `指導類別` varchar(300) NOT NULL,
  `指導題目` varchar(300) NOT NULL,
  `班級` varchar(300) NOT NULL,
  `學生姓名` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_教材`
--

CREATE TABLE `教學_教材` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `班級` int(11) NOT NULL,
  `課程名稱` int(11) NOT NULL,
  `製作項目` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_研習`
--

CREATE TABLE `教學_研習` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `活動名稱` int(11) NOT NULL,
  `時數` int(11) NOT NULL,
  `活動日期` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_計畫`
--

CREATE TABLE `教學_計畫` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `校內外` int(11) NOT NULL,
  `教學計畫項目` int(11) NOT NULL,
  `計畫狀態` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_論文`
--

CREATE TABLE `教學_論文` (
  `id` int(11) NOT NULL,
  `畢業學年度` int(11) NOT NULL,
  `論文名稱` int(11) NOT NULL,
  `研究生` int(11) NOT NULL,
  `學位類別` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_輔導`
--

CREATE TABLE `教學_輔導` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `輔導科目` int(11) NOT NULL,
  `地點` int(11) NOT NULL,
  `輔導日期` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `教學_鐘點`
--

CREATE TABLE `教學_鐘點` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `教師名稱` int(11) NOT NULL,
  `專兼任` int(11) NOT NULL,
  `職稱` int(11) NOT NULL,
  `兼行政職` int(11) NOT NULL,
  `演講` int(11) NOT NULL,
  `實習` int(11) NOT NULL,
  `合計` int(11) NOT NULL,
  `應授` int(11) NOT NULL,
  `實兼` int(11) NOT NULL,
  `夜間` int(11) NOT NULL,
  `日超` int(11) NOT NULL,
  `夜超` int(11) NOT NULL,
  `義務` int(11) NOT NULL,
  `論文` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `教學_鐘點`
--

INSERT INTO `教學_鐘點` (`id`, `學年學期`, `教師名稱`, `專兼任`, `職稱`, `兼行政職`, `演講`, `實習`, `合計`, `應授`, `實兼`, `夜間`, `日超`, `夜超`, `義務`, `論文`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2),
(2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4);

-- --------------------------------------------------------

--
-- 資料表結構 `教學_開課`
--

CREATE TABLE `教學_開課` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `課程名稱` int(11) NOT NULL,
  `學分數` int(11) NOT NULL,
  `開課老師` int(11) NOT NULL,
  `開課班級` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_兼任`
--

CREATE TABLE `服務_兼任` (
  `id` int(11) NOT NULL,
  `開始日期` int(11) NOT NULL,
  `結束日期` int(11) NOT NULL,
  `兼任行政單位` int(11) NOT NULL,
  `職稱` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_委員會`
--

CREATE TABLE `服務_委員會` (
  `id` int(11) NOT NULL,
  `學年學期` int(11) NOT NULL,
  `級別` int(11) NOT NULL,
  `委員會名稱` int(11) NOT NULL,
  `擔任職務` int(11) NOT NULL,
  `說明` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_專業組織`
--

CREATE TABLE `服務_專業組織` (
  `id` int(11) NOT NULL,
  `開始日期` int(11) NOT NULL,
  `結束日期` int(11) NOT NULL,
  `組織名稱` int(11) NOT NULL,
  `職稱` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_招生`
--

CREATE TABLE `服務_招生` (
  `id` int(11) NOT NULL,
  `開始日期` int(11) NOT NULL,
  `結束日期` int(11) NOT NULL,
  `招生類別` int(11) NOT NULL,
  `招生工作` int(11) NOT NULL,
  `主辦單位` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_推廣活動`
--

CREATE TABLE `服務_推廣活動` (
  `id` int(11) NOT NULL,
  `日期` int(11) NOT NULL,
  `活動類別` int(11) NOT NULL,
  `活動名稱` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_推廣計畫`
--

CREATE TABLE `服務_推廣計畫` (
  `id` int(11) NOT NULL,
  `開始日期` int(11) NOT NULL,
  `結束日期` int(11) NOT NULL,
  `計畫名稱` int(11) NOT NULL,
  `委託單位` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `服務_推廣課程`
--

CREATE TABLE `服務_推廣課程` (
  `id` int(11) NOT NULL,
  `日期` int(11) NOT NULL,
  `課程總時數` int(11) NOT NULL,
  `開課單位或計畫名稱` int(11) NOT NULL,
  `課程名稱` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `email_3` (`email`),
  ADD KEY `name` (`name`);

--
-- 資料表索引 `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `works`
--
ALTER TABLE `works`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
