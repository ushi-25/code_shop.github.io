<?php
require_once '../conf/t3_const.php';

// 関数ファイル読み込み
require_once '../model/t3m_common.php';
require_once '../model/t3m_user.php';

// セッション開始
session_start();

// ログインチェック
if(admin_logined_check()==='TRUE'){
    $user_id=$_SESSION['user_id'];
    $user_name=$_SESSION['user_name'];
}

// DB接続
 $link = get_db_connect();
 
// ユーザー一覧
$user_list= user_list($link);
$user_list = entity_assoc_array($user_list);

// DB切断
close_db_connect($link);


// 商品一覧テンプレートファイル読み込み
include_once '../view/t3v_user.php';