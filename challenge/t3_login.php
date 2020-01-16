<?php
require_once '../conf/t3_const.php';
// 関数ファイル読み込み
require_once '../model/t3m_tool.php';
require_once '../model/t3m_common.php';

// セッション開始
session_start();

// セッション変数からログイン済みか確認
login_check();

// セッション変数からログインエラーフラグを確認
if (isset($_SESSION['login_err_flag']) === TRUE) {
  // ログインエラーフラグ取得
  $login_err_flag = $_SESSION['login_err_flag'];
  // エラー表示は1度だけのため、フラグをFALSEへ変更
  $_SESSION['login_err_flag'] = FALSE;
} else {
  // セッション変数が存在しなければエラーフラグはFALSE
  $login_err_flag = FALSE;
}

// Cookie情報を取得
if (isset($_COOKIE['name']) === TRUE) {
  $user_name = $_COOKIE['name'];
} else {
  $user_name = '';
}

// 特殊文字をHTMLエンティティに変換
$name = entity_str($name);

include_once '../view/t3v_login_logo.php';
include_once '../view/t3v_login.php';



