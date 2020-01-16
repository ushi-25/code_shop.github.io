<?php
require_once '../conf/t3_const.php';

// 関数ファイル読み込み
require_once '../model/t3m_regist.php';
require_once '../model/t3m_common.php';

// セッション開始
session_start();

// セッション変数からログイン済みか確認
login_check();

// リクエストメソッド取得
$request_method = get_request_method();
if ($request_method === 'POST') {
    if(btn_check('regist_btn')==='TRUE'){
        // nameチェック
        $result=get_post('name','名前');
        error_check($result,$error);
        if($result=='TRUE'){
            $name=$_POST['name'];
            $result=user_check($name,'名前');
            error_check($result,$error);
        }
        
        // passチェック
        $result=get_post('pass','パスワード');
        error_check($result,$error);
        if($result=='TRUE'){
            $pass=$_POST['pass'];
            $result=user_check($pass,'パスワード');
            error_check($result,$error);
        }
    }
}

// DB接続
 $link = get_db_connect();
//  トランザクション開始
db_commit_start($link, false);
if(btn_check('regist_btn')==='TRUE'){
    // 同じ名前がないかチェック
    if(same_name_check($link,$name)==='0'){
         // 商品新規登録
        $result=insert_user($link,$name,$pass,$time);
        error_check($result,$error);
        if($result==='TRUE'){
            $success[]='ユーザー登録しました';
        }
    }else{
        $error[]='この名前はすでに使用中です';
    }
}

if(count($error)===0){
    // 処理確定
    db_commit_end($link);
} else {
    // 処理取消
    db_rollback($link);
}

//  DBとのコネクション切断
close_db_connect($link);

// 商品一覧テンプレートファイル読み込み
include_once '../view/t3v_login_logo.php';
include_once '../view/t3v_regist.php';