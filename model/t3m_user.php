<?php
function user_list($link) {
    // SQL生成
    $sql='SELECT user_name,user_created_date FROM t3_user_table';
    // クエリ実行
    return get_as_array($link, $sql);
}