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