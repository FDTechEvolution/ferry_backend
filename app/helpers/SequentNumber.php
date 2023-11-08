<?php

/**
  CREATE TABLE `sequencenumbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(45) NOT NULL,
  `prefix` varchar(45) DEFAULT NULL,
  `running` int(11) NOT NULL DEFAULT '0',
  `running_digit` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 */
/*https://medium.com/teknomuslim/how-to-create-helper-functions-in-laravel-d769d12218d4
*/


class SequentNumber{

    public static function newNumber($type) { 

    }
}