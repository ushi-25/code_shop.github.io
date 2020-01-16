<?php
require_once '../../include/conf/t3_const.php';

// 関数ファイル読み込み
require_once '../model/t3m_tool.php';
require_once '../model/t3m_cart.php';
require_once '../model/t3m_finish.php';
require_once '../model/t3m_common.php';

// セッション開始
session_start();

// ログインチェック
if(shop_logined_check()==='TRUE'){
    $user_id=$_SESSION['user_id'];
    $user_name=$_SESSION['user_name'];
}

// データベース接続
$link = get_db_connect();

// 購入する商品の在庫が存在するかチェック
$stock=finish_stock_check($link,$user_id);
if($stock==='FALSE'){
    $error[]='購入予定の商品について在庫確認できません管理者へ連絡して下さい';
}else if($stock!=='0'){
     $error[]='在庫のない商品があります商品を減らして下さい';
}else{
    // 購入する商品が在庫数を上回ってないかチェック
    $amount=finish_amount_check($link,$user_id);
    if($amount=='FALSE'){
        $error[]='購入予定の商品について数量確認できません管理者へ連絡して下さい';
    }else if($amount!=='0'){
        $error[]='購入予定の商品の在庫が足りません数量を減らしてください';
    } 
}

// 購入する商品のステータスチェック
$status=finish_status_check($link,$user_id);
if($status=='FALSE'){
    $error[]='購入予定の商品について状態確認できません管理者へ連絡して下さい';
}else if($status!=='0'){
    $error[]='非公開の商品が含まれています商品を減らしてください';
} 

// 商品一覧
$cart_list= cart_list($link,$user_id);
$cart_list = entity_assoc_array($cart_list);

// 処理スタート
db_commit_start($link, false);
if((btn_check('purchase_btn')==='TRUE')&&(count($error)===0)){
    // 購入した商品分の在庫減
    $result=update_buy_amount($link,$time,$user_id);
    error_check($result,$error);
    
    // 購入合計金額
    $result=total_cost($link,$user_id);
    if($result!=='FALSE'){
        $total=total_cost($link,$user_id);
    }
    
    // カート内削除
    $result=delete_cart($link,$user_id);
    error_check($result,$error);
}

// 処理確定
if(count($error)===0){
    db_commit_end($link);
} else {
    // 処理取消
    db_rollback($link);
}

// DB切断
close_db_connect($link);

// 商品一覧テンプレートファイル読み込み
include_once '../view/t3v_shop_logo.php';
include_once '../view/t3v_finish.php';


