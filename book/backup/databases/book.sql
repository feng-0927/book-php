/*
 Navicat Premium Data Transfer

 Source Server         : h1902
 Source Server Type    : MySQL
 Source Server Version : 50547
 Source Host           : h1902.com:3306
 Source Schema         : book

 Target Server Type    : MySQL
 Target Server Version : 50547
 File Encoding         : 65001

 Date: 03/09/2019 19:54:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pre_admin
-- ----------------------------
DROP TABLE IF EXISTS `pre_admin`;
CREATE TABLE `pre_admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `salt` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码盐',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `register_time` int(11) NULL DEFAULT NULL COMMENT '时间戳',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pre_admin
-- ----------------------------
INSERT INTO `pre_admin` VALUES (1, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (2, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (3, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (8, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (9, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (10, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (11, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (12, '123', '5ad59220346be6d2d36b762aab754153', 'qwertqwert', NULL, NULL, 1231231);
INSERT INTO `pre_admin` VALUES (16, 'sd', 'sds', 'sdf', '/uploads/20190825173730cdknvwACLVXYZ89.png', 'sd@sdd', 1567209600);

-- ----------------------------
-- Table structure for pre_book
-- ----------------------------
DROP TABLE IF EXISTS `pre_book`;
CREATE TABLE `pre_book`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小说标题',
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  `register_time` int(11) NULL DEFAULT NULL COMMENT '时间',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '描述内容',
  `thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片封面',
  `cateid` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '分类外键',
  `flag` enum('top','new','hot') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'new' COMMENT '书籍标签',
  `recycle` enum('show','hide') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'show' COMMENT '是否被回收',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `key_book_cateid`(`cateid`) USING BTREE,
  CONSTRAINT `foreign_book_cateid` FOREIGN KEY (`cateid`) REFERENCES `pre_cate` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '书籍表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pre_book
-- ----------------------------
INSERT INTO `pre_book` VALUES (1, '山海梦', '若木召南', 123123123, '传说文明是一个轮回，一代文明的毁灭就是下一代文明的起始。谁也不知道宇宙到底存在了多久，只是在九州开始之前，已经有一代代文明陨灭更替。黄尘清水三山下，变更千年如走马，未来生生不息，人立于天地之间也不过匆忙一瞬，而即便结局已知，每个人心中的希望却不曾断绝。', NULL, 1, 'new', 'show');
INSERT INTO `pre_book` VALUES (16, '似懂非懂', '收到', 1565107200, '第三方', '/uploads/20190826202154adimzADHQX13458.png', 3, 'hot', 'show');
INSERT INTO `pre_book` VALUES (19, '饿哦金佛', '二热', 1565366400, '当事人个人&nbsp;', '/uploads/20190826184417aghknqxyzDEFMOX.png', 2, 'top', 'show');
INSERT INTO `pre_book` VALUES (27, '宝石时代', '都市', 1534867200, '冯水电费', '/uploads/20190827000036chijuAIKNOQUY04.png', 4, 'hot', 'show');

-- ----------------------------
-- Table structure for pre_cate
-- ----------------------------
DROP TABLE IF EXISTS `pre_cate`;
CREATE TABLE `pre_cate`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pre_cate
-- ----------------------------
INSERT INTO `pre_cate` VALUES (1, '武侠仙侠');
INSERT INTO `pre_cate` VALUES (2, '言情');
INSERT INTO `pre_cate` VALUES (3, '奇幻玄幻');
INSERT INTO `pre_cate` VALUES (4, '都市娱乐');

-- ----------------------------
-- Table structure for pre_chapter
-- ----------------------------
DROP TABLE IF EXISTS `pre_chapter`;
CREATE TABLE `pre_chapter`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `register_time` int(11) NULL DEFAULT NULL COMMENT '章节更新时间',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '章节标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '章节的内容是一个路径',
  `bookid` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '书籍外键',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `key_chapter_bookid`(`bookid`) USING BTREE,
  CONSTRAINT `foreign_chapter_bookid` FOREIGN KEY (`bookid`) REFERENCES `pre_book` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 277 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '章节表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pre_chapter
-- ----------------------------
INSERT INTO `pre_chapter` VALUES (144, 1566806162, '引言', '/book/20190826/adgprvxzDEGHKMOSUZ02.json', 1);
INSERT INTO `pre_chapter` VALUES (145, 1566806163, '第一章 狩猎奇遇', '/book/20190826/cfjkmpstvyACLTUVZ157.json', 1);
INSERT INTO `pre_chapter` VALUES (146, 1566806163, '第二章 再遇意外', '/book/20190826/deflqrswyJLOTVWZ3479.json', 1);
INSERT INTO `pre_chapter` VALUES (147, 1566806163, '第三章 接二连三', '/book/20190826/egopuvzCDILOPQRX1257.json', 1);
INSERT INTO `pre_chapter` VALUES (148, 1566806164, '第四章 生死之间', '/book/20190826/dghknyzBDEJKMNORZ139.json', 1);
INSERT INTO `pre_chapter` VALUES (149, 1566806164, '第五章 秦楚瑜英', '/book/20190826/adgilsyzAEGKNRT03789.json', 1);
INSERT INTO `pre_chapter` VALUES (150, 1566806164, '第六章 冉羽村寨', '/book/20190826/bdeklmruxBMOPQTUW018.json', 1);
INSERT INTO `pre_chapter` VALUES (151, 1566806165, '第七章 告别村寨', '/book/20190826/acefjkoqrBGIKOPRTVXY.json', 1);
INSERT INTO `pre_chapter` VALUES (152, 1566806165, '第八章 路途结交', '/book/20190826/aimnprvACJPUVXYZ5789.json', 1);
INSERT INTO `pre_chapter` VALUES (153, 1566806165, '第九章 古老传闻', '/book/20190826/bjlotuvABCEIJLQUWY12.json', 1);
INSERT INTO `pre_chapter` VALUES (154, 1566806166, '第十章 夜半遇袭', '/book/20190826/eprstuvwxyCEHLOPQTVX.json', 1);
INSERT INTO `pre_chapter` VALUES (155, 1566806166, '第十一章 护营之战', '/book/20190826/dfjmsvwzABFGJKNRT125.json', 1);
INSERT INTO `pre_chapter` VALUES (156, 1566806166, '第十二章 得悉阴谋', '/book/20190826/fghjkopqsuBCEIJKLUY2.json', 1);
INSERT INTO `pre_chapter` VALUES (157, 1566806167, '第十三章 再闻噩耗', '/book/20190826/eglmnoqtABCDFMNU1347.json', 1);
INSERT INTO `pre_chapter` VALUES (158, 1566806167, '第十四章 将计就计', '/book/20190826/abceijkqvwzBCDQT0347.json', 1);
INSERT INTO `pre_chapter` VALUES (159, 1566806167, '第十五章 营中激战', '/book/20190826/defijkmnuvEKLPWXZ269.json', 1);
INSERT INTO `pre_chapter` VALUES (160, 1566806168, '第十六章 颠覆认知', '/book/20190826/adehnqtuwxFMNQR02789.json', 1);
INSERT INTO `pre_chapter` VALUES (161, 1566806168, '第十七章 战局危矣', '/book/20190826/abehmopABEILSX024789.json', 1);
INSERT INTO `pre_chapter` VALUES (162, 1566806168, '第十八章 迷茫犹疑', '/book/20190826/ceimquACFKNPRVY13457.json', 1);
INSERT INTO `pre_chapter` VALUES (163, 1566806169, '第十九章 诡异情况', '/book/20190826/cfgijmnzAGHLOQVY0249.json', 1);
INSERT INTO `pre_chapter` VALUES (164, 1566806169, '第二十章 夸父三击', '/book/20190826/ghjoprtvCFLORUVX0569.json', 1);
INSERT INTO `pre_chapter` VALUES (165, 1566806170, '第二十一章 诡异黑影', '/book/20190826/beghkmtvwBCFGKNQVY89.json', 1);
INSERT INTO `pre_chapter` VALUES (166, 1566806170, '第二十二章 形势逆转', '/book/20190826/cdmpsuvxzAHJLOQW1279.json', 1);
INSERT INTO `pre_chapter` VALUES (167, 1566806170, '第二十三章 终得胜利', '/book/20190826/fhjptDEGHIJLORSZ0129.json', 1);
INSERT INTO `pre_chapter` VALUES (168, 1566806171, '第二十四章 路途闲话', '/book/20190826/acfgmozEFJKOQSVYZ356.json', 1);
INSERT INTO `pre_chapter` VALUES (169, 1566806171, '第二十五章 兰特旧闻', '/book/20190826/bfghjmorsxBMRUVXZ568.json', 1);
INSERT INTO `pre_chapter` VALUES (170, 1566806171, '第二十六章 大陆形势', '/book/20190826/ghilmoquCEFIKLNOSTV0.json', 1);
INSERT INTO `pre_chapter` VALUES (171, 1566806172, '第二十七章 进化潜能', '/book/20190826/gpsuvwxBFJLMNQVXZ489.json', 1);
INSERT INTO `pre_chapter` VALUES (172, 1566806172, '第二十八章 生命原液', '/book/20190826/abcehprvzBCHPRUVZ348.json', 1);
INSERT INTO `pre_chapter` VALUES (173, 1566806173, '第二十九章 惊鸿一瞥', '/book/20190826/aghklmqrsxzAEKRV1479.json', 1);
INSERT INTO `pre_chapter` VALUES (174, 1566806173, '第三十章 遭遇陷害', '/book/20190826/bhjmortvACDJNORSVWY9.json', 1);
INSERT INTO `pre_chapter` VALUES (233, 1566835254, '楔子', '/book/20190826/cgjkmnsvwBEJKOPVZ347.json', 27);
INSERT INTO `pre_chapter` VALUES (234, 1566835255, '第一卷：水宝石篇 1：清明时节雨纷纷', '/book/20190826/abhjlouyAJKQRTUWYZ59.json', 27);
INSERT INTO `pre_chapter` VALUES (235, 1566835255, '2：水宝石异变', '/book/20190826/acfijlmpzBFJMPRT3679.json', 27);
INSERT INTO `pre_chapter` VALUES (236, 1566835255, '3：真相', '/book/20190826/foprsuwxyzBGLMNTW046.json', 27);
INSERT INTO `pre_chapter` VALUES (237, 1566835255, '4：宝石时代——降临', '/book/20190826/gpuwzBDEHIKNRSWZ0123.json', 27);
INSERT INTO `pre_chapter` VALUES (238, 1566835256, '5：身体的变化', '/book/20190826/dfgjlmwyzBFIKLNTVWX6.json', 27);
INSERT INTO `pre_chapter` VALUES (239, 1566835256, '6：道路', '/book/20190826/adghlostCEJNOPQVWY13.json', 27);
INSERT INTO `pre_chapter` VALUES (240, 1566835256, '7：海边旅游', '/book/20190826/bmnruxyzABENORUX2479.json', 27);
INSERT INTO `pre_chapter` VALUES (241, 1566835256, '8：怒火', '/book/20190826/bcemopqrtuvxyAFKMPTW.json', 27);
INSERT INTO `pre_chapter` VALUES (242, 1566835257, '9：长城的态度', '/book/20190826/cdfgimprtuzBGJQY0358.json', 27);
INSERT INTO `pre_chapter` VALUES (243, 1566835257, '10：哭泣', '/book/20190826/hknyDIJKMNPRSXY24567.json', 27);
INSERT INTO `pre_chapter` VALUES (244, 1566835257, '11：火场救人', '/book/20190826/dfjklopBFHKLNOTX0169.json', 27);
INSERT INTO `pre_chapter` VALUES (245, 1566835257, '12：朱家', '/book/20190826/cdfjprxCIKMNORU03589.json', 27);
INSERT INTO `pre_chapter` VALUES (246, 1566835258, '13：沉船', '/book/20190826/bfhjltuzBFJMRY145679.json', 27);
INSERT INTO `pre_chapter` VALUES (247, 1566835258, '14：五行宝石', '/book/20190826/ajosuvwyzDHKLSWY4589.json', 27);
INSERT INTO `pre_chapter` VALUES (248, 1566835258, '15：道歉', '/book/20190826/adjlmnvACIJOTYZ02567.json', 27);
INSERT INTO `pre_chapter` VALUES (249, 1566835259, '16：分崩离散', '/book/20190826/acfhjkpuBFGINPQRTX07.json', 27);
INSERT INTO `pre_chapter` VALUES (250, 1566835259, '17：初次了解', '/book/20190826/eghinopuvyBCIJMNY045.json', 27);
INSERT INTO `pre_chapter` VALUES (251, 1566835259, '18：担忧', '/book/20190826/befghjzADFJLRTUVWZ36.json', 27);
INSERT INTO `pre_chapter` VALUES (252, 1566835259, '19：隐秘', '/book/20190826/cefijlpqstuwGRWXZ357.json', 27);
INSERT INTO `pre_chapter` VALUES (253, 1566835260, '20：舍友的诡异', '/book/20190826/aejkqwyADGIJOPQTU468.json', 27);
INSERT INTO `pre_chapter` VALUES (254, 1566835260, '21：断绝关系', '/book/20190826/cjnopqrsuzACJNRV2378.json', 27);
INSERT INTO `pre_chapter` VALUES (255, 1566835260, '22：天才？', '/book/20190826/demsuwxABCKOPQRVX015.json', 27);
INSERT INTO `pre_chapter` VALUES (256, 1566835260, '23：意外来客', '/book/20190826/deitwxBEHJLQRSX01259.json', 27);
INSERT INTO `pre_chapter` VALUES (257, 1566835261, '24：出手', '/book/20190826/fgklmnuwzAEKLNWY0138.json', 27);
INSERT INTO `pre_chapter` VALUES (258, 1566835261, '25：碾压', '/book/20190826/cgknpqruzABFHMRW3458.json', 27);
INSERT INTO `pre_chapter` VALUES (259, 1566835261, '26：水髓', '/book/20190826/dfghmqyBDIKMQRSTUWX4.json', 27);
INSERT INTO `pre_chapter` VALUES (260, 1566835261, '27：重聚', '/book/20190826/acefipqszFRYZ0134679.json', 27);
INSERT INTO `pre_chapter` VALUES (261, 1566835262, '28：特招', '/book/20190826/ceghkrstzDFGQSTYZ078.json', 27);
INSERT INTO `pre_chapter` VALUES (262, 1566835262, '29:承诺', '/book/20190826/acepwHIJNOPRSUWX0349.json', 27);
INSERT INTO `pre_chapter` VALUES (263, 1566835262, '30：尘埃落定', '/book/20190826/bdfjlxCEHMQRSVWXYZ13.json', 27);
INSERT INTO `pre_chapter` VALUES (264, 1566835262, '31：梦', '/book/20190826/bceghmopqvwCJPUWY125.json', 27);
INSERT INTO `pre_chapter` VALUES (265, 1566835263, '32：学院报到', '/book/20190826/acfmnopqrtvzIJMQU367.json', 27);
INSERT INTO `pre_chapter` VALUES (266, 1566835263, '33：种子', '/book/20190826/ehiltwyCEHLNOQY02679.json', 27);
INSERT INTO `pre_chapter` VALUES (267, 1566835263, '34：令人尊敬的存在', '/book/20190826/cdfgijvxzGHJLQW01568.json', 27);
INSERT INTO `pre_chapter` VALUES (268, 1566835263, '35：彪悍的女疯子', '/book/20190826/bdfjlqyBCEGHOUXZ0346.json', 27);
INSERT INTO `pre_chapter` VALUES (269, 1566835264, '36：异类（二合一）', '/book/20190826/bchioprwxyFJQRUVZ459.json', 27);
INSERT INTO `pre_chapter` VALUES (270, 1566835264, '37：第一人', '/book/20190826/abcgjmvyAEFGIJMNSW35.json', 27);
INSERT INTO `pre_chapter` VALUES (271, 1566835264, '38：选择导师', '/book/20190826/adinqrwzFJKNSTU14578.json', 27);
INSERT INTO `pre_chapter` VALUES (272, 1566835264, '39：金主', '/book/20190826/acinqyzAIOPRUXYZ0278.json', 27);
INSERT INTO `pre_chapter` VALUES (273, 1566835265, '40：疑问', '/book/20190826/acejlnqvwACGHKSTXZ25.json', 27);
INSERT INTO `pre_chapter` VALUES (274, 1566835265, '41：突如其来的报复', '/book/20190826/bcektuvxABDGHRSUVX09.json', 27);
INSERT INTO `pre_chapter` VALUES (275, 1566835265, '42：药剂', '/book/20190826/deflruwxCGJKMQWX1589.json', 27);
INSERT INTO `pre_chapter` VALUES (276, 1566835266, '43：獠牙', '/book/20190826/bcjkmnotuwBJOQU01789.json', 27);

-- ----------------------------
-- Table structure for pre_setting
-- ----------------------------
DROP TABLE IF EXISTS `pre_setting`;
CREATE TABLE `pre_setting`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `valuess` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网站设置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pre_setting
-- ----------------------------
INSERT INTO `pre_setting` VALUES (1, '网站版权', 'Copyrigty © m.baidu.com', 'copy');
INSERT INTO `pre_setting` VALUES (2, '网站关键字搜索', '武侠仙侠,言情,奇幻玄幻,都市娱乐', 'keywords');
INSERT INTO `pre_setting` VALUES (3, '网站名称', '小说网', 'webname');
INSERT INTO `pre_setting` VALUES (4, '网站LOGO', '/uploads/20190902175727dijnxEFHMORUVZ9.ico', 'logo');

-- ----------------------------
-- Table structure for pre_website
-- ----------------------------
DROP TABLE IF EXISTS `pre_website`;
CREATE TABLE `pre_website`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '节点标题',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '节点的程序文件路径',
  `register_time` int(11) NULL DEFAULT NULL COMMENT '执行时间点',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '采集网站的节点表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pre_website
-- ----------------------------
INSERT INTO `pre_website` VALUES (1, '小说网-纵横中文网', '../assets/nodeurl/zhurl.php', 1566526345);
INSERT INTO `pre_website` VALUES (2, '爱阅小说', '../assets/nodeurl/ayurl.php', 1566526345);
INSERT INTO `pre_website` VALUES (3, '起点', '../assets/nodeurl/qdurl.php', 1566526345);

SET FOREIGN_KEY_CHECKS = 1;
