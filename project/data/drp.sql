-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-10-13 17:26:08
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `drp`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_customer`
--

CREATE TABLE `tp_customer` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `address` varchar(300) DEFAULT NULL COMMENT '地址',
  `contact` varchar(50) DEFAULT NULL COMMENT '联系人',
  `name` varchar(200) NOT NULL COMMENT '客户名称',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  `deleted` tinyint(4) DEFAULT '0' COMMENT '是否删除（0-正常 1-删除）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户表';

--
-- 转存表中的数据 `tp_customer`
--

INSERT INTO `tp_customer` (`id`, `address`, `contact`, `name`, `phone`, `remark`, `deleted`) VALUES
(1, 'dfdfd', '到达', '客户1', '当地', '顶顶顶', 0),
(2, '', '', '客户2', '', '', 0),
(3, '', '', '客户4', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tp_goods`
--

CREATE TABLE `tp_goods` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `code` varchar(50) NOT NULL COMMENT '商品编号',
  `in_qty` int(11) DEFAULT '0' COMMENT '库存数量',
  `min_num` int(11) DEFAULT '0' COMMENT '库存下限',
  `model` varchar(50) NOT NULL COMMENT '商品型号',
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `producer` varchar(200) NOT NULL COMMENT '生产产商',
  `purchasing_price` float DEFAULT '0' COMMENT '采购价格',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `selling_price` float DEFAULT '0' COMMENT '出售价格',
  `unit` varchar(10) NOT NULL COMMENT '商品单位',
  `goods_cate_id` int(11) NOT NULL COMMENT '商品类别',
  `state` tinyint(4) DEFAULT '1' COMMENT '商品状态',
  `last_purchasing_price` float DEFAULT '0' COMMENT '上次采购价',
  `deleted` tinyint(4) DEFAULT '0' COMMENT '是否删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品表';

-- --------------------------------------------------------

--
-- 表的结构 `tp_goods_cate`
--

CREATE TABLE `tp_goods_cate` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '类别名称',
  `pid` int(11) DEFAULT '0' COMMENT '父级分类',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品分类表';

-- --------------------------------------------------------

--
-- 表的结构 `tp_goods_unit`
--

CREATE TABLE `tp_goods_unit` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `name` varchar(20) NOT NULL COMMENT '单位名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品单位表';

-- --------------------------------------------------------

--
-- 表的结构 `tp_menu`
--

CREATE TABLE `tp_menu` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `title` varchar(50) NOT NULL COMMENT '名称',
  `type` tinyint(4) DEFAULT '0' COMMENT '(0-主菜单，1-子菜单，2-按钮，)',
  `href` varchar(200) DEFAULT NULL COMMENT '访问操作',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级',
  `acl_value` varchar(255) NOT NULL COMMENT '权限码',
  `grade` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

--
-- 转存表中的数据 `tp_menu`
--

INSERT INTO `tp_menu` (`id`, `icon`, `title`, `type`, `href`, `pid`, `acl_value`, `grade`) VALUES
(1, NULL, '根目录', -1, '', 0, '1', NULL),
(2, NULL, '系统设置', 0, '', 1, '6000', NULL),
(3, NULL, '用户管理', 1, 'system/user', 2, '6010', NULL),
(4, NULL, '角色管理', 1, 'system/role', 2, '6020', NULL),
(5, NULL, '菜单管理', 1, 'system/menu', 2, '6030', NULL),
(10, NULL, '用户信息', 2, 'domin.User/add', 3, '6011', NULL),
(11, NULL, '编辑用户', 2, 'domain.User/edit', 3, '6012', NULL),
(12, NULL, '删除用户', 2, 'domain.User/delete', 3, '6013', NULL),
(13, NULL, '基础资料管理', 0, '', 1, '1000', NULL),
(14, NULL, '供应商管理', 1, 'baseinfo/supplier', 13, '1010', NULL),
(15, NULL, '客户管理', 1, 'baseinfo/customer', 13, '1020', NULL),
(16, NULL, '商品管理', 1, 'baseinfo/goods', 13, '1030', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `tp_role`
--

CREATE TABLE `tp_role` (
  `id` int(11) NOT NULL COMMENT '角色ID',
  `name` varchar(30) NOT NULL COMMENT '角色名称',
  `remark` varchar(100) NOT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

--
-- 转存表中的数据 `tp_role`
--

INSERT INTO `tp_role` (`id`, `name`, `remark`) VALUES
(1, '系统管理员', ''),
(2, '普通用户', '测试');

-- --------------------------------------------------------

--
-- 表的结构 `tp_role_menu`
--

CREATE TABLE `tp_role_menu` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色菜单关系表';

--
-- 转存表中的数据 `tp_role_menu`
--

INSERT INTO `tp_role_menu` (`id`, `role_id`, `menu_id`) VALUES
(30, 1, 1),
(31, 1, 2),
(32, 1, 3),
(33, 1, 10);

-- --------------------------------------------------------

--
-- 表的结构 `tp_supplier`
--

CREATE TABLE `tp_supplier` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `address` varchar(300) DEFAULT NULL COMMENT '地址',
  `contact` varchar(50) DEFAULT NULL COMMENT '联系人',
  `name` varchar(200) NOT NULL COMMENT '供应商名称',
  `phone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  `deleted` tinyint(4) DEFAULT '0' COMMENT '是否删除（0-正常 1-删除）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='供应商表';

--
-- 转存表中的数据 `tp_supplier`
--

INSERT INTO `tp_supplier` (`id`, `address`, `contact`, `name`, `phone`, `remark`, `deleted`) VALUES
(1, 'dfdfd', 'fdfdfd', '供应商1', 'dfdfd', 'ddd', 0),
(2, '', '', '供应商3', '', '', 0),
(3, '', '', '供应商2', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tp_user`
--

CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(20) NOT NULL COMMENT '用户名称',
  `pass` char(32) NOT NULL COMMENT '密码',
  `real_name` varchar(20) DEFAULT NULL COMMENT '真实姓名',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `locked` tinyint(4) DEFAULT '0' COMMENT '是否禁用(0-正常 1-禁用)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

--
-- 转存表中的数据 `tp_user`
--

INSERT INTO `tp_user` (`id`, `name`, `pass`, `real_name`, `remark`, `locked`) VALUES
(1, 'admin', 'a00515076edfa9d26e8f398043443ace', 'Brightness', 'test', 0),
(2, 'test', 'a00515076edfa9d26e8f398043443ace', 'Brightness', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tp_user_role`
--

CREATE TABLE `tp_user_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户角色关系表';

--
-- 转存表中的数据 `tp_user_role`
--

INSERT INTO `tp_user_role` (`id`, `role_id`, `user_id`) VALUES
(7, 2, 1),
(8, 2, 2);

--
-- 转储表的索引
--

--
-- 表的索引 `tp_customer`
--
ALTER TABLE `tp_customer`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_goods`
--
ALTER TABLE `tp_goods`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_goods_cate`
--
ALTER TABLE `tp_goods_cate`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_goods_unit`
--
ALTER TABLE `tp_goods_unit`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_menu`
--
ALTER TABLE `tp_menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_role`
--
ALTER TABLE `tp_role`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_role_menu`
--
ALTER TABLE `tp_role_menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_supplier`
--
ALTER TABLE `tp_supplier`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_user`
--
ALTER TABLE `tp_user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `tp_user_role`
--
ALTER TABLE `tp_user_role`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tp_customer`
--
ALTER TABLE `tp_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tp_goods`
--
ALTER TABLE `tp_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `tp_goods_cate`
--
ALTER TABLE `tp_goods_cate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `tp_goods_unit`
--
ALTER TABLE `tp_goods_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `tp_menu`
--
ALTER TABLE `tp_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `tp_role`
--
ALTER TABLE `tp_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tp_role_menu`
--
ALTER TABLE `tp_role_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=34;

--
-- 使用表AUTO_INCREMENT `tp_supplier`
--
ALTER TABLE `tp_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `tp_user`
--
ALTER TABLE `tp_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tp_user_role`
--
ALTER TABLE `tp_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
