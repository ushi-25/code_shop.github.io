<?php
// リクエストメソッドを取得
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}

// ログインチェック
function login_check(){
    if (isset($_SESSION['user_id']) === TRUE){
        $user_id=$_SESSION['user_id'];
        if($user_id==="1"){
            // ログイン済みの場合、ホームページへリダイレクト
            header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_tool.php');
            exit;
        }else{
            header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_shop.php');
            exit;
        }
    }
}

// shopログインチェック
function shop_logined_check(){
    if(isset($_SESSION['user_id']) === TRUE){
        if(isset($_SESSION['user_name'])===TRUE){
            return 'TRUE';
        }
    }else{
        header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_login.php');
        exit;
    }
}

// adminログインチェック
function admin_logined_check(){
    if(isset($_SESSION['user_id']) === TRUE){
        if(isset($_SESSION['user_name'])===TRUE){
            $user_id=$_SESSION['user_id'];
            if($user_id!=="1"){
                header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_shop.php');
                exit;
            }else{
                return 'TRUE';
            }
        }
    }else{
        header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_login.php');
        exit;
    }
}

// ボタンチェック
function btn_check($kye){
    if(isset($_POST[$kye])===TRUE&&($_POST[$kye])!==''){
        return 'TRUE';
    }else{
        return 'FALSE';
    }
}

// POSTデータ.空欄チェック
function get_post($kye1,$kye2){
    if(isset($_POST[$kye1])&&($_POST[$kye1]!=='')){
        $receive=$_POST[$kye1];
        $receive=(ctype_space(mb_convert_kana($receive,"s")));
        if($receive===TRUE){
            return $kye2.'を入力して下さい';;
        }
    }else{
        return $kye2.'を入力して下さい';
    }
    return "TRUE";
}

// 整数チェック
function int_check($kye1,$kye2){
    if(ctype_digit($kye1)&&$kye1>=0){
        return 'TRUE';
    }else{
        return $kye2.'は正の整数値を入力してください';
    }
}

// トランザクション開始
function db_commit_start($link,$mode) {
    mysqli_autocommit($link, $mode);
}

// トランザクション終了
function db_commit_end($link){
    mysqli_commit($link);
}

// ロールバック
function db_rollback($link){
    mysqli_rollback($link);
}

// 特殊文字をHTMLエンティティに変換する
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

// 特殊文字をHTMLエンティティに変換する(2次元配列の値)
function entity_assoc_array($assoc_array) {
    foreach ($assoc_array as $key => $value) {
        foreach ($value as $keys => $values) {
            // 特殊文字をHTMLエンティティに変換
            $assoc_array[$key][$keys] = entity_str($values);
        }
    }
    return $assoc_array;
}

// DBハンドルを取得
function get_db_connect() {
    // コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}
 
//  DBとのコネクション切断
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

// クエリを実行しその結果を配列で取得する
function get_as_array($link, $sql) {
    // 返却用配列
    $data = array();
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
        
            // １件ずつ取り出す
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        // 結果セットを開放
        mysqli_free_result($result);
    }
    }
    
    return $data;
}

// 数量チェック
function value_total_check($link,$sql,$kye){
    if ($result=mysqli_query($link,$sql)){
        $row = mysqli_fetch_assoc($result);
        if (isset($row[$kye]) === true) {
            $result = $row[$kye];
            }
        } else{
            return 'FALSE';
        }
    return $result;
}

// エラーチェック
function error_check($value,&$error){
   if($value!=='TRUE'){
        $error[]=$value;
    }
}

// 合計金額
function total_cost($link,$user_id){
    $sql='SELECT COALESCE(sum(t3_item_table.price*t3_cart_table.amount),0) AS TOTAL 
            FROM t3_cart_table JOIN t3_user_table 
            ON t3_cart_table.user_id = t3_user_table.user_id 
            JOIN t3_item_table ON t3_cart_table.item_id=t3_item_table.item_id 
            where t3_cart_table.user_id='.$user_id;
    $result=value_total_check($link,$sql,'TOTAL');
    if($result!=='FALSE'){
        $total= value_total_check($link,$sql,'TOTAL');
    }else{
        return 'FALSE';
    }
    return $total;
}

