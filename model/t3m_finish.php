<?php
// 購入する商品の在庫が存在するかチェック
function finish_stock_check($link,$user_id){
$sql='SELECT COUNT(stock) AS TOTAL 
    FROM t3_cart_table JOIN t3_stock_table 
    ON t3_cart_table.item_id=t3_stock_table.item_id 
    WHERE t3_stock_table.stock= 0 AND t3_cart_table.user_id='.$user_id;
    $result=value_total_check($link,$sql,'TOTAL');
    if($result!=='FALSE'){
        $stock= value_total_check($link,$sql,'TOTAL');
    }else{
        return 'FALSE';
    }
    return $stock;
}

// 購入する商品が在庫数を上回ってないかチェック
function finish_amount_check($link,$user_id){
$sql='SELECT COUNT(amount) AS TOTAL 
    FROM t3_cart_table JOIN t3_stock_table 
    ON t3_cart_table.item_id=t3_stock_table.item_id 
    WHERE t3_cart_table.amount>t3_stock_table.stock AND t3_cart_table.user_id='.$user_id;
    $result=value_total_check($link,$sql,'TOTAL');
    if($result!=='FALSE'){
        $amount= value_total_check($link,$sql,'TOTAL');
    }else{
        return 'FALSE';
    }
    return $amount;
}

// 購入する商品のステータスチェック
function finish_status_check($link,$user_id){
$sql='SELECT COUNT(status) AS TOTAL 
    FROM t3_cart_table JOIN t3_item_table 
    ON t3_cart_table.item_id=t3_item_table.item_id 
    WHERE t3_item_table.status= 0 AND t3_cart_table.user_id='.$user_id;
    $result=value_total_check($link,$sql,'TOTAL');
    if($result!=='FALSE'){
        $amount= value_total_check($link,$sql,'TOTAL');
    }else{
        return 'FALSE';
    }
    return $amount;
}

// // 購入数した分の在庫を減らす
function update_buy_amount($link,$time,$user_id){
    $sql="UPDATE t3_stock_table 
        JOIN t3_cart_table ON t3_stock_table.item_id = t3_cart_table.item_id 
        SET t3_stock_table.stock=(t3_stock_table.stock-t3_cart_table.amount), 
        t3_stock_table.stock_updated_date='$time' 
        WHERE t3_cart_table.user_id='$user_id'";
    $result = mysqli_query($link,$sql);
    if($result==false){
        return '購入処理1ができません管理者へ連絡してください';
    }
    return 'TRUE';
}

// カート内をクリアにする
function delete_cart($link,$user_id){
    $sql='DELETE FROM `t3_cart_table` WHERE user_id='.$user_id;
    $result = mysqli_query($link,$sql);
    if($result===false){
        return '購入処理2ができません管理者へ連絡してください';
    }
    return 'TRUE';
}

