<DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショップ</title>
<!--  <link rel="stylesheet" href="./t3v_css.css">-->
<style>
    body{
        margin: 0 auto;
        font-family: Times New Roman;
    }
    .flex {
        margin-left : auto ;
        margin-right : auto ;
        width: 960px;
    }
    .flex .menu {
        border: solid 1px;
        width: 130px;
        height:170px;
        text-align: center;
        margin: 10px;
        float: left; 
    }
    .flex span {
        display: block;
        margin: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
        
    .item_list{
        float: left;
        text-align: center;
        margin:30px 20px 0px 20px;
        padding:30px 0px;
        width: 280px;
        background-color:#d6ecfa;
        border-radius: 100%;
        font-weight: 900;
           
    }
    .btn,.sold-out{
        margin:2px 0px;
    }
    
    .cart_item_img{
        width:170px;
        height:130px;
    }
</style>
</head>

<body>
    <div class="flex">
<?php foreach ($item_list as $data) { ?>
        <div class='item_list'>
            <img class="cart_item_img" src="./image/<?php print ($data['image']); ?>"　width="160px" height="130px">
            <div class='item_info'>
                <span class="item_name"><?php print $data['name']; ?></span>
                <span class="item_price"><?php print number_format($data['price']); ?>円</span>
            </div>
    <?php if($data['stock']==="0"){ ?>
            <p class="sold-out">売り切れ</p>
    <?php }else{ ?>
            <form method="post" action="t3_cart.php">
                <input type="hidden" name="item_id" value="<?php print ($data['item_id']); ?>">
                <input type="hidden" name="status" value="<?php print ($data['status']); ?>">
                <input type="hidden" name="stock" value="<?php print ($data['stock']); ?>">
                <input type="submit"  name="cart_btn" value="カートへ">
            </form>
    <?php } ?>
        </div>
<?PHP } ?>
  </div>
</body>
</html>