<?php
// 新規に追加する商品のステータス,在庫,購入予定数量の確認
function new_item_check($link,$item_id,$value){
    $sql='SELECT t3_item_table.status,t3_stock_table.stock 
        FROM t3_item_table JOIN t3_stock_table 
        ON t3_item_table.item_id=t3_stock_table.item_id 
        where t3_item_table.item_id='.$item_id;
  if ($result = mysqli_query($link, $sql)) {
        if($row = mysqli_fetch_assoc($result)){
            $item_data= $row[$value];
        }
    } else {
        return 'FALSE';
    }
    return $item_data;
}
    
// カートへの追加
function insert_cart($link,$user_id,$item_id,$amount,$time){
    $sql="SELECT count(user_id='$user_id' AND item_id='$item_id') AS TOTAL FROM t3_cart_table 
        where user_id='$user_id' AND item_id='$item_id'";
        $result=value_total_check($link,$sql,'TOTAL');
    if($result!=='FALSE'){
        $total= value_total_check($link,$sql,'TOTAL');
    }else{
        return 'FALSE';
    }
    
    if($total==='1'){
        $sql="UPDATE t3_cart_table 
            SET amount=amount+1,cart_updated_date='$time'
            WHERE user_id='$user_id' AND item_id='$item_id'" ;
        $result = mysqli_query($link,$sql);
        if($result===false){
            return '商品の追加に失敗しました管理者へ連絡して下さい';
        }
        return 'TRUE';
    }else{
        $sql="INSERT INTO `t3_cart_table` ( `user_id`, `item_id`, `amount`, `cart_created_date`, `cart_updated_date`)
            VALUES ('$user_id','$item_id','$amount','$time','$time')";
        $result = mysqli_query($link,$sql);
        if($result===false){
            return '商品の追加に失敗しました管理者へ連絡して下さい';
        }
        return 'TRUE';
    }
   
}

// 商品の一覧を取得する
function cart_list($link,$user_id) {
    $sql='SELECT t3_cart_table.item_id,t3_cart_table.amount,t3_cart_table.cart_id,t3_item_table.image,t3_item_table.name,t3_item_table.price,t3_stock_table.stock
            FROM t3_cart_table 
            JOIN t3_user_table
            ON t3_cart_table.user_id = t3_user_table.user_id 
            JOIN t3_item_table 
            ON t3_cart_table.item_id = t3_item_table.item_id
            JOIN t3_stock_table
            ON t3_cart_table.item_id=t3_stock_table.item_id
            where t3_cart_table.user_id='.$user_id;
    return get_as_array($link, $sql);
}

// 数量を変更する商品の在庫数チェック
function amount_check($link,$item_id){
    $sql="SELECT t3_stock_table.stock FROM t3_cart_table JOIN t3_stock_table 
        ON t3_cart_table.item_id=t3_stock_table.item_id where t3_cart_table.item_id='$item_id'";
        $result=value_total_check($link,$sql,'stock');
    if($result!=='FALSE'){
        $stock= value_total_check($link,$sql,'stock');
    }else{
        return 'FALSE';
    }
    return $stock;
}

// 数量変更
function update_amount($link,$amount,$time,$cart_id){
    $sql="UPDATE t3_cart_table SET amount='$amount',cart_updated_date='$time' 
        WHERE cart_id= '$cart_id'";
        $result = mysqli_query($link,$sql);
    if($result===false){
        return '商品数の変更に失敗しました管理者へ連絡してください';
    }
    return 'TRUE';
}

// カート商品削除
function delete_cart_item($link,$cart_id){
    $sql="DELETE FROM t3_cart_table WHERE cart_id=".$cart_id;
     $result = mysqli_query($link,$sql);
    if($result===false){
        return '商品の削除に失敗しました管理者へ連絡してください';
    }
    return 'TRUE';
}