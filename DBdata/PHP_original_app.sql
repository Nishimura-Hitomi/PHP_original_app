-- phpMyAdmin SQL Dump
-- version 5.1.3-2.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 10 月 12 日 07:27
-- サーバのバージョン： 10.7.3-MariaDB
-- PHP のバージョン: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `PHP_original_app`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `comment_num` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `delflag` tinyint(4) DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `comments`
--

INSERT INTO `comments` (`id`, `thread_id`, `comment_num`, `user_id`, `content`, `delflag`, `created`, `modified`) VALUES
(1, 4, 1, 2, '可愛いワンちゃんですね！名前はなんていうんですか？', 0, '2022-10-03 04:20:14', '2022-10-03 04:20:14'),
(2, 4, 2, 1, 'コメントありがとうございます！この子はいちごちゃんって言います！', 0, '2022-10-05 11:45:58', '2022-10-05 11:45:58'),
(3, 14, 1, 3, '動物好きなお友達がいるの羨ましいです！そして可愛い！', 0, '2022-10-10 08:28:05', '2022-10-10 08:28:05'),
(4, 4, 3, 5, '今日のいちごちゃんも可愛いですね！おすすめの散歩スポットはどこですか？', 0, '2022-10-10 12:30:36', '2022-10-10 12:30:36'),
(5, 4, 4, 1, 'おすすめの散歩スポットは今の季節だと〇〇公園とかですかね〜！わんちゃんも多いしお友達増えますよ♪', 0, '2022-10-10 12:33:26', '2022-10-10 12:33:26'),
(6, 4, 5, 5, 'そうなんですね！今度行ってみます。', 0, '2022-10-10 12:33:33', '2022-10-10 12:33:33');

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `favorites`
--

INSERT INTO `favorites` (`id`, `thread_id`, `user_id`, `created`) VALUES
(45, 4, 1, '2022-10-09 09:14:32'),
(46, 5, 1, '2022-10-10 12:43:00'),
(50, 3, 1, '2022-10-11 04:15:26'),
(51, 14, 1, '2022-10-11 05:22:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follow_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `follows`
--

INSERT INTO `follows` (`id`, `follow_id`, `user_id`, `created`) VALUES
(50, 3, 1, '2022-10-11 05:30:52'),
(51, 4, 1, '2022-10-11 06:19:39'),
(52, 5, 1, '2022-10-11 06:19:42'),
(53, 6, 1, '2022-10-11 06:19:45'),
(54, 10, 1, '2022-10-11 08:45:14'),
(55, 2, 1, '2022-10-12 06:56:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `body` text DEFAULT NULL,
  `thread_img` varchar(255) DEFAULT NULL,
  `delflag` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `threads`
--

INSERT INTO `threads` (`id`, `user_id`, `title`, `body`, `thread_img`, `delflag`, `created`, `modified`) VALUES
(3, 1, '可愛いハムスター', 'ハムスターのハムちゃんです！', 'img_63453e470c4a9.jpg', 0, '2022-10-01 12:00:34', '2022-10-11 10:01:27'),
(4, 1, '犬の散歩', '今日の散歩の様子です！可愛いと思ったらコメントください＾＾', 'img_63453f4caf9e8.jpg', 0, '2022-10-02 05:48:30', '2022-10-11 10:02:52'),
(5, 2, '新しい家族【猫】', '家に新しい家族がやってきました！\r\nこれからよろしくね！', 'img_6345404662ae8.jpeg', 0, '2022-10-05 06:30:23', '2022-10-11 10:07:02'),
(6, 3, 'モルモルモルモット', 'モルモットのモルモルちゃんです！名前覚えていってね！', 'img_634540ec3cc9d.jpeg', 0, '2022-10-07 04:51:28', '2022-10-11 10:09:48'),
(7, 4, '【犬】チョコタン【チワワ】', 'チワワが一番可愛いと思って生きてます。同志求む！', 'img_6345418a9bcc1.jpeg', 0, '2022-10-07 04:51:47', '2022-10-11 10:12:26'),
(8, 5, '花と犬', 'もうすっかり秋ですね。最近は犬のもっちーと花畑を散歩するのがブームです。', 'img_634542130fcd6.jpeg', 0, '2022-10-07 04:52:04', '2022-10-11 10:14:43'),
(9, 6, '猫の一歳記念写真', 'うちのみーちゃんが一歳になりました。これからもすくすく育ってね！', 'img_63454296eb3b1.jpeg', 0, '2022-10-07 04:52:32', '2022-10-11 10:16:54'),
(10, 7, 'メリークリスマス【ハムスター】', '電飾のケーブルはハムスターの餌食になりやすいので皆さんも気をつけてください！', 'img_63454325a8ce1.jpeg', 0, '2022-10-07 04:52:49', '2022-10-11 10:19:17'),
(11, 10, 'うさぎの散歩', 'うさぎ友達募集中！', 'img_634543956bee7.jpeg', 0, '2022-10-07 04:53:09', '2022-10-11 10:21:09'),
(12, 3, 'ハムハムハムスター', 'ハムスターのハムハムちゃんです！手のひらサイズ！', 'img_6345411a416f2.jpeg', 0, '2022-10-07 04:53:27', '2022-10-11 10:10:34'),
(13, 2, '好きな犬のタイプ', '大型犬ってかっこいいですよね。飼ったことないけど憧れます。', 'img_6345408fbc51d.jpeg', 0, '2022-10-08 04:00:36', '2022-10-11 10:08:15'),
(14, 1, '友達の猫ちゃん', '友達の家に行ったら可愛い猫ちゃんがいました！', 'img_63453f7c003ac.jpeg', 0, '2022-10-10 08:18:27', '2022-10-11 10:03:40');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `delflag` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `authority` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`, `delflag`, `created`, `modified`, `authority`) VALUES
(1, 'アザラシ＠管理ユーザー', 'a@gmail.com', '$2y$10$TkNgj/jgcMDRFC/PlEOgpOTV92qE/CKIg772JOKNE2rliwtD/ZBki', 'img_63425d4104930.png', 0, '2022-09-30 06:11:09', '2022-10-12 07:05:23', 99),
(2, 'ネコ', 'b@gmail.com', '$2y$10$wmelEiyJ68iKcya.TgQVP.ma2xlzqo120tM4rPuPiy1GK7.HvhxEK', 'img_634533dc71f22.png', 0, '2022-09-30 06:14:56', '2022-10-11 09:14:04', 1),
(3, 'ヒツジ', 'c@gmail.com', '$2y$10$yp5e1Rzp1Kefq7sCfPi5heVzaywgw11iljPmr9rwqoj40/XBiYS6S', 'img_634533efa73bb.png', 0, '2022-09-30 07:51:10', '2022-10-11 09:15:31', 1),
(4, 'ブタ', 'd@gmail.com', '$2y$10$eywXuEYusN5PtUDLttDs/us1SHqrfloJ8VMEpVNNbgujO3Qsb9cY.', 'img_6345340584d24.png', 0, '2022-10-10 05:53:34', '2022-10-11 09:14:45', 1),
(5, 'シカ', 'e@gmail.com', '$2y$10$X7ungllhi4bin0oZRsRQCOqbFhZ58pMIdlcI3lpYYMwI8Oy2A/xnu', 'img_63453414a149d.png', 0, '2022-10-10 05:54:32', '2022-10-11 09:15:00', 1),
(6, 'タヌキ', 'f@gmail.com', '$2y$10$hm4yY51st9PBR92nAIs1yO9TdVfi0uHGoUylocAg0lnWBgULE89kO', 'img_634534294b272.png', 0, '2022-10-10 05:56:56', '2022-10-11 09:15:21', 1),
(7, 'キツネ', 'g@gmail.com', '$2y$10$/Z64.yPQ2uI.hAC.mXDSR.vwdPdq4nbbI97.dDt1vr92EMnY5XDKi', 'img_63453447f00cd.png', 0, '2022-10-10 11:30:46', '2022-10-11 09:15:51', 1),
(10, 'キリン', 'h@gmail.com', '$2y$10$9U6uQR5ucVepsA28k/Wmb.KKfE/YZvH44HRo13.aWpvswmoMJDvrW', 'img_634534b08fcc7.png', 0, '2022-10-10 12:00:31', '2022-10-11 09:17:36', 1);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- テーブルの AUTO_INCREMENT `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- テーブルの AUTO_INCREMENT `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
