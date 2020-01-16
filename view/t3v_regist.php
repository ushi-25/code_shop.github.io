<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ユーザ登録ページ</title>
<!--  <link type="text/css" rel="stylesheet" href="./css/common.css">-->
<style>
    .text_box{
        text-align: center;
        width: 960px;
        margin:  0 auto;  
    }
    .content{
        text-align: center;
        width: 960px;
        margin:  0 auto;  
    }
</style>
</head>
<body>
    <div class="content">
        <form method="post" action="t3_regist.php" class="text_box">
            <p>ユーザー名：<input type="text" name="name" placeholder="ユーザー名"></p>
            <p>パスワード：<input type="password" name="pass"  placeholder="パスワード"></p>
            <input type="submit" value="ユーザーを新規作成する" name="regist_btn">
      </form>
      <a href="./t3_login.php">ログインページに移動する</a>
  </div>
  <div class="text_box">
<?php if(count($error)!==0):?>
    <?php foreach($error as $data){ ?>
    <p><?php print $data; ?></p>
  <?php } ?>
<?php else : ?>
    <?php foreach($success as $data){ ?>
    <p><?php print $data; ?></p>
    <?php } ?>
<?php endif; ?>
    </div>
</body>
</html>