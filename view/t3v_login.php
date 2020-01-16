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
    label{
       display: block;
    }
    #login_btn{
        margin-right:20px;
    }
    .error_box{
        text-align: center;
    }
</style>
</head>
<body>
    <form action="t3_login_process.php" method="post" class="text_box">
        <p>ユーザー名：<input type="text" name="name"></p>
        <p>パスワード：<input type="password" name="pass"></p>
        <input type="submit" value="ログイン" id="login_btn" name="login_btn">
        <a href="./t3_regist.php">新規登録</a>
    </form>
<div class='error_box'>
<?php if(count($error)!==0){ ?>
    <?php foreach($error as $data){ ?>
        <p><?php print $data; ?></p>
    <?php } ?>
<?php }else if($login_err_flag === true){ ?>
        <p>名前又はパスワードが違います</p>
<?php } ?>
</div>
</body>
</html>