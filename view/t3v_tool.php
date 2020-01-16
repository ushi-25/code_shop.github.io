<DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品管理</title>
<!--<link rel="stylesheet" href="t3v_css.css">-->
<style>
    table,tr, th, td {
        border: solid 1px;
        padding: 10px;
        text-align: center;
    }
    #form_btn{
        margin-left:10px;
    }
    .status_false{
        background-color:#a3a1a1;
    }
    header{
        border-bottom:1px solid #664433
    }
    .new_item{
        display: block;
        padding-bottom: 33px;
        border-bottom:1px solid #664433
    }
    .cart_item_img{
        width:170px;
        height:130px;
    }
</style>
<body>

<header>
  <?php if(count($error)!==0):?>
  <?php foreach($error as $data){ ?>
  <p>
    <?php print $data; ?>
  </p>
  <?php } ?>
  <?php else : ?>
  <?php foreach($success as $data){ ?>
  <p>
    <?php print $data; ?>
  </p>
  <?php } ?>
  <?php endif; ?>
  <h1>商品管理ページ</h1>
  <a href="t3_logout_process.php">ログアウト</a>
　<a href="t3_user.php">ユーザー管理ページ</a>
</header>

  <section class="new_item">
    <h2>新規商品追加</h2>
    <form  method="post" enctype="multipart/form-data">
      <p>
        <label>名前: 
          <input type="text" name="new_name" value="">
        </label>
      </p>
      <p>
        <label>値段: 
          <input type="text" name="new_price" value="">
        </label>
      </p>
      <p>
        <label>個数: 
          <input type="text" name="new_stock" value="">
        </label>
      </p>
      <input type="file" name="upfile">
      <select name="new_status">
      <option value='1'>公開</option>
      <option value='0'>非公開</option>
    </section>
    <input type="submit" id="form_btn" name="form_btn" value="■□■□■商品追加■□■□■">

  </form>
</section>
<section>
  <h2>商品情報の一覧・変更</h2>
  <table>
    <tr>
    <th>画像</th>
    <th>商品名</th>
    <th>価格</th>
    <th>在庫数</th>
    <th>ステータス</th>
    <th>操作</th>
    </tr>
    <?php foreach ($item_list as $data) { ?>
    <form method="post" >
      <input type="hidden" name="item_id" value="">
      <?php if(($data['status'])==='0'): ?>
      <tr class='status_false' >
      <?php elseif(($data['status'])==='1') : ?>
      <tr>
      <?php endif; ?>
      <td>
        <img class="cart_item_img" src="./image/<?php print ($data['image']); ?>">
      </td>
      <td>
        <?php print $data['name']; ?>
      </td>
      <td>
        <?php print number_format($data['price']); ?>
      </td>
    </form>
    <form method="post">
      <td>
        <input type="text" name="update_stock" value="<?php print ($data['stock']); ?>">個
        <input type="hidden" name="item_id" value="<?php print ($data['item_id']); ?>">
        <input type="submit" name="stock_btn" value="変更">
      </td>
    </form>
    <form method="post" >
      <td>
        <input type="hidden" name="item_id" value="<?php print ($data['item_id']); ?>">
        <?php if(($data['status'])==='1') : ?>
        <input type="hidden" name="update_status" value="1">
        <input type="submit" name="status_btn" value="公開→非公開">
        <?php elseif(($data['status'])==='0') :  ?>
        <input type="hidden" name="update_status" value="0">
        <input type="submit" name="status_btn" value="非公開→公開">
        <?php endif; ?>
      </td>
    </form>
    <form method="post">
      <td>
        <input type="hidden" name="item_id" value="<?php print ($data['item_id']); ?>">
        <input type="submit" name="delete_btn" value="削除">
      </td>
    </form>
    </tr>
    <?php } ?>
  </table>
</body>