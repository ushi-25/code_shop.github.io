<?php
define('DB_HOST',   ''); // データベースのホスト名又はIPアドレス
define('DB_USER',   '');// MySQLのパスワード
define('DB_NAME',   '');    // データベース名
define('HTML_CHARACTER_SET', 'UTF-8');  // HTML文字エンコーディング
define('DB_CHARACTER_SET',   'UTF8');   // DB文字エンコーディング

$new_name='';
$new_price='';
$new_stock='';
$new_status='';
$upfile_name='';
$success=array();
$uploaddir="./image/";
$time=date("Y-m-d H:i:s");
$error=array();
$update_stock='';
$item_id='';
$name='';
$pass='';
$change='';

$amount=1;
$total=0;

