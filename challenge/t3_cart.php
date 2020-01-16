<?php
require_once '../conf/t3_const.php';

// 関数ファイル読み込み
require_once '../model/t3m_common.php';
require_once '../model/t3m_cart.php';

// セッション開始
session_start();

// ログインチェック
if(shop_logined_check()==='TRUE'){
    $user_id=$_SESSION['user_id'];
    $user_name=$_SESSION['user_name'];
}

// リクエストメソッド取得
$request_method = get_request_method();
if ($request_method === 'POST') {
    // 選択した商品ＩＤをチェック
    if((isset($_POST['item_id'])===TRUE)&&($_POST['item_id']) !== ''){
        $item_id=$_POST['item_id'];
    }
    
    // 数量を変更する商品情報チェック
    if(btn_check('change_btn')==='TRUE'){
        $result=get_post('amount','数量');
        if(strpos($result,'入力')  !== false){
            $error[]=$result;
        }else{
            $cart_id=$_POST['cart_id'];
            $amount=$_POST['amount'];
            $item_id=$_POST['item_id'];
            $result=int_check($amount,'数量');
            error_check($result,$error);
        }
    }
}
// データベース接続
$link = get_db_connect();

// 処理スタート
db_commit_start($link, false);

// カートへ商品追加
if((btn_check('cart_btn')==='TRUE')&&(count($error) === 0)){
    // 選択した商品のステータスと在庫を取得
    $status=new_item_check($link,$item_id,'status');
    $stock=new_item_check($link,$item_id,'stock');
    if($status==='FALSE'){
        $error==='追加する商品状態が確認できません管理者へ連絡連絡してください';
    }else if($stock==='FALSE'){
        $error==='追加する商品在庫が確認できません管理者へ連絡連絡してください';
    }

    //カートへ追加する商品の状態と在庫数チェック
    if($stock>0){
        if($status==="1"){
            $result=insert_cart($link,$user_id,$item_id,$amount,$time,$time);
            error_check($result,$error);
        }else{
            $error[]='非公開の商品です';
        }
    }else{
        $error[]='売り切れです';
    }
}

// カートの商品を削除
if((btn_check('delete_btn')==='TRUE')&&(count($error) === 0)){
    $cart_id=$_POST['cart_id'];
    $result=delete_cart_item($link,$cart_id);
    error_check($result,$error);
    if($result==='TRUE'){
        $success[]='商品を削除しました';
    }
}
    
// 数量変更
if((btn_check('change_btn')==='TRUE')&&(count($error) === 0)){
    //数量を変更する又は追加する商品の在庫数チェック
    $stock=amount_check($link,$item_id);
    if($stock>=$amount){
        if($amount!=='0'){
            $result=update_amount($link,$amount,$time,$cart_id);
            error_check($result,$error);
            if($result === 'TRUE'){
                $success[]='数量を変更しました';
            }
        }else{
            $error[]='0より大きい正の整数値を入力してください';
        }
    }else{
        $error[]='在庫が足りません';
    }
}

// 合計金額
$result=total_cost($link,$user_id);
if($result!=='FALSE'){
    $total=total_cost($link,$user_id);
}
    
if (count($error) === 0) {
    // 処理確定
    db_commit_end($link);
} else {
    //処理取消
    db_rollback($link);
}

// 商品一覧
$cart_list= cart_list($link,$user_id);
$cart_list = entity_assoc_array($cart_list);

// DB切断
close_db_connect($link);

// 商品一覧テンプレートファイル読み込み
include_once '../view/t3v_shop_logo.php';
include_once '../view/t3v_cart.php';