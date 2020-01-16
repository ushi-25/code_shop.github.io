<?php
require_once '../conf/t3_const.php';
// 関数ファイル読み込み
require_once '../model/t3m_common.php';
require_once '../model/t3m_shop.php';

// セッション開始
session_start();

// ログインチェック
if(shop_logined_check()==='TRUE'){
    $user_id=$_SESSION['user_id'];
    $user_name=$_SESSION['user_name'];
}

// データベース接続
$link = get_db_connect();

// 商品一覧
$item_list=release_item_list($link);
$item_list = entity_assoc_array($item_list);

// データベース切断
close_db_connect($link);

// ショップページ
include_once '../view/t3v_shop_logo.php';
include_once '../view/t3v_shop.php';


