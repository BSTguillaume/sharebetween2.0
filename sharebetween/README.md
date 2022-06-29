## Share Content Module

Share content between spaces

You need this table:

CREATE TABLE `sharebetween_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_content` (`content_id`),
  CONSTRAINT `fk_content` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
