-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-07-08 15:09:39
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `frame`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_permission`
--

CREATE TABLE `tp_permission` (
  `per_id` int(11) NOT NULL COMMENT '权限ID',
  `controller` varchar(20) DEFAULT NULL COMMENT '控制器名称',
  `action` varchar(20) DEFAULT NULL COMMENT '操作名称',
  `type` tinyint(4) DEFAULT '0' COMMENT '资源类型(0 - 目录,1 - 菜单，2 - 按钮)',
  `pid` int(11) DEFAULT '0' COMMENT '父级ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

--
-- 转存表中的数据 `tp_permission`
--

INSERT INTO `tp_permission` (`per_id`, `controller`, `action`, `type`, `pid`) VALUES
(1, 'index', 'test1', 1, 0),
(2, 'index', 'test3', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `tp_role`
--

CREATE TABLE `tp_role` (
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `role_name` varchar(20) NOT NULL COMMENT '角色名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

--
-- 转存表中的数据 `tp_role`
--

INSERT INTO `tp_role` (`role_id`, `role_name`) VALUES
(1, '管理员'),
(2, '销售');

-- --------------------------------------------------------

--
-- 表的结构 `tp_role_permission`
--

CREATE TABLE `tp_role_permission` (
  `rp_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `per_id` int(11) NOT NULL COMMENT '权限ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色权限关联表';

--
-- 转存表中的数据 `tp_role_permission`
--

INSERT INTO `tp_role_permission` (`rp_id`, `role_id`, `per_id`) VALUES
(4, 1, 1),
(5, 2, 2),
(6, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tp_sequence`
--

CREATE TABLE `tp_sequence` (
  `seq_name` varchar(80) NOT NULL,
  `seq_no` int(11) NOT NULL,
  `seq_last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='计数表';

--
-- 转存表中的数据 `tp_sequence`
--

INSERT INTO `tp_sequence` (`seq_name`, `seq_no`, `seq_last_update`) VALUES
('user', 2, '2021-07-08 07:21:21');

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

CREATE TABLE `tp_user` (
  `user_id` varchar(10) NOT NULL COMMENT '用户ID',
  `uname` varchar(20) NOT NULL COMMENT '用户名称',
  `password` varchar(32) NOT NULL COMMENT '用户密码MD5加密',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表 ';

--
-- 转存表中的数据 `tp_user`
--

INSERT INTO `tp_user` (`user_id`, `uname`, `password`, `mobile`) VALUES
('U0001', 'admin', 'e10adc3949ba59abbe56e057f20f883e', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_user_role`
--

CREATE TABLE `tp_user_role` (
  `ur_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tp_user_role`
--

INSERT INTO `tp_user_role` (`ur_id`, `user_id`, `role_id`) VALUES
(4, '1', 1),
(5, '1', 2),
(6, '2', 6);

--
-- 转储表的索引
--

--
-- 表的索引 `tp_permission`
--
ALTER TABLE `tp_permission`
  ADD PRIMARY KEY (`per_id`);

--
-- 表的索引 `tp_role`
--
ALTER TABLE `tp_role`
  ADD PRIMARY KEY (`role_id`);

--
-- 表的索引 `tp_role_permission`
--
ALTER TABLE `tp_role_permission`
  ADD PRIMARY KEY (`rp_id`);

--
-- 表的索引 `tp_sequence`
--
ALTER TABLE `tp_sequence`
  ADD PRIMARY KEY (`seq_name`);

--
-- 表的索引 `tp_user`
--
ALTER TABLE `tp_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- 表的索引 `tp_user_role`
--
ALTER TABLE `tp_user_role`
  ADD PRIMARY KEY (`ur_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tp_permission`
--
ALTER TABLE `tp_permission`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tp_role`
--
ALTER TABLE `tp_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tp_role_permission`
--
ALTER TABLE `tp_role_permission`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `tp_user_role`
--
ALTER TABLE `tp_user_role`
  MODIFY `ur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
