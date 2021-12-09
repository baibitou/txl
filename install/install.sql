DROP TABLE IF EXISTS `shua_config`;
create table `shua_config` (
`k` varchar(32) NOT NULL,
`v` text NULL,
PRIMARY KEY  (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `shua_config` VALUES ('cache', '');
INSERT INTO `shua_config` VALUES ('version', '1001');
INSERT INTO `shua_config` VALUES ('admin_user', 'admin');
INSERT INTO `shua_config` VALUES ('admin_pwd', 'admin');
INSERT INTO `shua_config` VALUES ('alipay_api', '2');
INSERT INTO `shua_config` VALUES ('tenpay_api', '2');
INSERT INTO `shua_config` VALUES ('qqpay_api', '2');
INSERT INTO `shua_config` VALUES ('wxpay_api', '2');
INSERT INTO `shua_config` VALUES ('style', '1');
INSERT INTO `shua_config` VALUES ('sitename', '操你妈');
INSERT INTO `shua_config` VALUES ('keywords', '小柠檬');
INSERT INTO `shua_config` VALUES ('description', '程序错乱');
INSERT INTO `shua_config` VALUES ('kfqq', '123456789');
INSERT INTO `shua_config` VALUES ('anounce', '<div class="list-group-item reed"><span class="btn btn-danger btn-xs">1</span> 操你妈
</div>
<div class="list-group-item reed"><span class="btn btn-success btn-xs">2</span>傻逼
</div>
<div class="list-group-item reed"><span class="btn btn-info btn-xs">3</span>操你妈
</div>
<div class="list-group-item reed"><span class="btn btn-danger btn-xs">4</span>操你妈 </div>
<div class="list-group-item reed"><span class="btn btn-success btn-xs">5</span>白新QQ2372607683</div>');
INSERT INTO `shua_config` VALUES ('kaurl', '');
INSERT INTO `shua_config` VALUES ('modal', '欢迎使用');
INSERT INTO `shua_config` VALUES ('bottom', '<table class="table table-bordered">
<tbody>
<tr height="50">
<td><button type="button" class="btn btn-block btn-warning"><a href="./" target="_blank"><span style="color:#ffffff">♚友链♚</span></a></button></td>
<td><button type="button" class="btn btn-block btn-warning"><a href="./" target="_blank"><span style="color:#ffffff">♚友链♚</span></a></button></td>
</tr>
<tr height="50">
<td><button type="button" class="btn btn-block btn-success"><a href="./" target="_blank"><span style="color:#ffffff">♚友链♚</span></a></button></td>
<td><button type="button" class="btn btn-block btn-success"><a href="./" target="_blank"><span style="color:#ffffff">♚友链♚</span></a></button></td>
</tr></tbody>
</table>');

DROP TABLE IF EXISTS `shua_tools`;
CREATE TABLE `shua_tools` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '10',
  `name` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `input` varchar(20) DEFAULT NULL,
  `inputs` varchar(80) DEFAULT NULL,
  `alert` text DEFAULT NULL,
  `is_curl` tinyint(2) NOT NULL DEFAULT '0',
  `curl` varchar(100) DEFAULT NULL,
  `repeat` tinyint(2) NOT NULL DEFAULT '0',
  `active` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shua_orders`;
CREATE TABLE `shua_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `zid` int(11) NOT NULL DEFAULT '1',
  `input` varchar(64) NOT NULL,
  `input2` varchar(64) DEFAULT NULL,
  `input3` varchar(64) DEFAULT NULL,
  `input4` varchar(64) DEFAULT NULL,
  `input5` varchar(64) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `url` varchar(32) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shua_kms`;
CREATE TABLE `shua_kms` (
  `kid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `km` varchar(255) NOT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `addtime` timestamp NULL DEFAULT NULL,
  `user` varchar(20) NOT NULL DEFAULT '0',
  `usetime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shua_pay`;
CREATE TABLE `shua_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) NULL,
  `tid` int(11) NOT NULL,
  `input` text NOT NULL,
  `addtime` datetime NULL,
  `ip` varchar(15) NULL,
  `endtime` datetime NULL,
  `name` varchar(64) NULL,
  `money` varchar(32) NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;