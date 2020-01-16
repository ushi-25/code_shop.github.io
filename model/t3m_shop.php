<?php
// 公開状態の商品の一覧を取得する
function release_item_list($link) {
    // SQL生成
    $sql="SELECT t3_item_table.item_id,t3_item_table.image,t3_item_table.name,t3_item_table.price,t3_item_table.status,t3_stock_table.stock 
            FROM t3_item_table 
            JOIN t3_stock_table ON t3_item_table.item_id = t3_stock_table.item_id
            WHERE t3_item_table.status=1";
    // クエリ実行
    return get_as_array($link, $sql);
}

