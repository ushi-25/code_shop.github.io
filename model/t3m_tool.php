<?php
// ステータスチェック
function status_check($value){
    if(($value==='1')||($value==='0')){
        return 'TRUE';
    }else{
        return '不正な操作です';
    }
}

// 商品新規登録
function insert_item($link,$upfile_name,$new_name,$new_price,$time,$new_status,$new_stock){
    $sql= "INSERT INTO t3_item_table(`image`,`name`, `price`, `item_created_date`, `item_updated_date`, `status`) 
            VALUES('$upfile_name','$new_name','$new_price','$time','$time','$new_status')";
    $result=mysqli_query($link, $sql);
    if($result===true){
        $item_id = mysqli_insert_id($link);
        $sql="INSERT INTO `t3_stock_table`(`item_id`, `stock`, `stock_created_date`, `stock_updated_date`)
                VALUES ('$item_id','$new_stock','$time','$time')";
        $result=mysqli_query($link, $sql);
        if(($result===false)){
            return '商品追加1に失敗しました管理者へ連絡してください';
        }
    }else{
        return '商品追加2に失敗しました管理者へ連絡してください';
    }
    return 'TRUE';
}

// 在庫変更登録
function update_stock($link,$update_stock,$time,$item_id){
    $sql="UPDATE t3_stock_table SET stock='$update_stock',stock_updated_date='$time' 
            WHERE item_id= '$item_id'";
        $result = mysqli_query($link,$sql);
        if(($result===false)){
        return '在庫変更に失敗しました管理者へ連絡してください';
        }
        return 'TRUE';
}

// 状態変更登録
function update_status($link,$time,$item_id,$update_status){
    switch($update_status){
    case '0':
        $sql="UPDATE t3_item_table SET status='1',item_updated_date='$time' WHERE item_id= '$item_id'";
        $result = mysqli_query($link,$sql);
        if($result===false){
            return '状態変更に失敗しました管理者へ連絡してください';
        }
        return 'TRUE';
    break;

    case '1';
        $sql="UPDATE t3_item_table SET status='0',item_updated_date='$time' WHERE item_id= '$item_id'";
        $result = mysqli_query($link,$sql);
        if($result===false){
            return '状態変更に失敗しました管理者へ連絡してください';
        }
        return 'TRUE';
    break;
    }
}

// 画像削除
function delete_image($link,$item_id){
    $sql="SELECT image FROM t3_item_table WHERE item_id=".$item_id;
    if ($result = mysqli_query($link, $sql)) {
        if($row = mysqli_fetch_assoc($result)){
            $image= htmlspecialchars($row['image'], ENT_QUOTES, HTML_CHARACTER_SET);
        }
    } else {
        return 'FALSE';
    }
    return $image;
}

// 削除
function delete_item($link,$item_id){
    $sql="DELETE FROM t3_item_table WHERE item_id=".$item_id;
    $result=mysqli_query($link,$sql);
    if($result===true){
        $sql="DELETE FROM t3_stock_table WHERE item_id=".$item_id;
        $result=mysqli_query($link, $sql);
        if($result===false){
            return '削除1に失敗しました管理者へ連絡してください';
        }
    }else{
        return '削除2に失敗しました管理者へ連絡してください';
    }
    return 'TRUE';
}

// 商品の一覧を取得する
function item_list($link) {
    // SQL生成
    $sql="SELECT t3_item_table.item_id,t3_item_table.image,t3_item_table.name,t3_item_table.price,t3_item_table.status,t3_stock_table.stock FROM t3_item_table 
            JOIN t3_stock_table ON t3_item_table.item_id = t3_stock_table.item_id";
    // クエリ実行
    return get_as_array($link, $sql);
}

