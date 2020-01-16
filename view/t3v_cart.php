<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>カート</title>
<!--  <link type="text/css" rel="stylesheet" href="./css/common.css">-->
<style>
    .content{
        margin-left : auto ;
        margin-right : auto ;
        width:960px;
    }
    table,tr,td {
        border-top: solid 1px;
        border-bottom: solid 1px;
        padding: 10px;
        text-align: center;
    }
    .cart_item_img{
        width:170px;
        height:130px;
    }
</style>
</head>
<body>
    <div class="content">
        <h1 class="title">ショッピングカート</h1>
<?php if(count($error)!==0):?>
    <?php foreach($error as $data){ ?>
            <p><?php print $data; ?></p>
  <?php } ?>
<?php else : ?>
  <?php foreach($success as $data){ ?>
            <p><?php print $data; ?></p>
  <?php } ?>
<?php endif; ?>
    <table>
        <tr> 
            <th>画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>数量</th>
            <th>操作</th>
        </tr>
 
<?php foreach ($cart_list as $data) { ?>
        <tr>
            <td>
                <img class="cart_item_img" src="./image/<?php print ($data['image']); ?>">
            <td>
                <span class="cart-item-name"><?php print ($data['name']); ?></span>
            </td>
            <td>
                <span class="cart-item-price"><?php print ($data['price']); ?></span>
            </td>
    <form method="post">
            <td>
                <input type="text" name="amount" value="<?php print ($data['amount']); ?>">個
                <input type="hidden" name="cart_id" value="<?php print ($data['cart_id']); ?>">
                <input type="hidden" name="item_id" value="<?php print ($data['item_id']); ?>">
                <input type="submit" name="change_btn" value="変更">
            </td>
    </form>
            <td>      
    <form method="post">
                <input type="hidden" name="cart_id" value="<?php print ($data['cart_id']); ?>">
                <input type="submit" name="delete_btn" value="削除">
    </form>
            </td>   
        </tr>
<?php } ?>
    </table>
    <div class="buy-sum-box">
      <span class="buy-sum-title">合計</span>
      <span class="buy-sum-price"><?php print $total; ?>円</span>
    </div>
    <?php if($total==="0"):?>
    <p>商品がありません</p>
    <?php else : ?>
    <form method="post" action="t3_finish.php">
        <input type="submit" name="purchase_btn" href="t3_finish.php" value="購入">
    </form>
    <?php endif; ?>
</body>
</htm