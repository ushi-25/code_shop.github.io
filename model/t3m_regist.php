<?php
//ユーザー入力値チェック
function user_check($value1,$value2){
    if(ctype_alnum($value1)===true){
        if(mb_strlen($value1)>=6){
             return 'TRUE';
        }else{
            return $value2.'は6文字以上で入力して下さい';
        }
    }else{
         return $value2.'は英数字で入力して下さい';
    }
}

// 同一名のチェック
function same_name_check($link,$name) {
    $sql = "SELECT COUNT(user_name) AS total FROM t3_user_table WHERE user_name='$name'";
    return value_total_check($link,$sql,'total');
}

// ユーザ登録
function insert_user($link,$name,$pass,$time){
    $sql="INSERT INTO `t3_user_table`(`user_name`, `pass`, `user_created_date`, `user_updated_date`)
            VALUE('$name','$pass','$time','$time')";
    $result = mysqli_query($link,$sql);
    if($result!==TRUE){
        return 'ユーザー登録に失敗しました管理者へ連絡してください';
    }
    return 'TRUE';
}


