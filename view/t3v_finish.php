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
        padding: 30px;
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
<?php if(count($error)!==0):?>
    <h1 class="title">購入失敗</h1>
    <?php foreach($error as $data){ ?>
    <p><?php print $data; ?></p>
    <?php } ?>
<?php else : ?>
    <h1 class="title">購入完了</h1>
    <?php if($total==="0"):?>
        <p>商品はありません</p>        
 <?php else: ?>
    <p>購入できました</p>
<?php endif;?>
    <table>
        <tr> 
            <th>画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>数量</th>
        </tr>
    <?php foreach ($cart_list as $data) { ?>
        <tr>
            <td><img class="cart_item_img" src="./image/<?php print ($data['image']); ?>"　width="193" height="130"></td>
            <td><span class="cart-item-name"><?php print ($data['name']); ?></span></td>
            <td><span class="cart-item-price"><?php print ($data['price']); ?></span></td>
        <form method="post">
            <td><span class="cart-item-name"><?php print ($data['amount']); ?></span></td>
        </form>
        </tr>
    <?php } ?>
<?php endif; ?>
    </table>
    <div class="buy-sum-box">
      <span class="buy-sum-title">合計</span>
      <span class="buy-sum-price"><?php print $total; ?>円</span>
    </div>
</body>
</htm