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
    header{
        background-color:#a5dff9;
        padding-top: 10px;
        height: 60px;
    }
    .header_flam{
         margin-left : auto ;
         margin-right : auto ;
         width: 960px;
    }
    .header_left{
        float: left;
        display:block;
        padding-left: 10px;
    }
    .header_right{
        float:right;
        display: flex;
    }
    .user_name{
        color: blue;
        margin:20px 5px 0px 5px;
    }
    .logout{
        margin-top: 19px;
        color: blue;
        margin-top: 20px;
    }
    .cart{
        float: right;
        display: block;
        width: 50px;
        height: 50px;
        background-repeat: no-repeat;
    }
    #cart_logo{
        width: 45px;
    }
</style>
</head>
<body>
    <header>
        <div class="header_flam">
        <div class="header_left">
            <a href="t3_shop.php" class="cart"><img src="../challenge/image/logo.jpg" alt="" id="item_logo"></a>
        </div>
        <div class="header_right">
            <a class="user_name">ユーザー名:</a>
            <a class="user_name"><?php print $user_name; ?></a>
            <a href="t3_cart.php" class="cart"><img src="../challenge/image/cart.jpeg" alt="" id="cart_logo"></a>
            <form method="post" action="t3_logout_process.php" class="logout">
            <a href="t3_logout_process.php">ログアウト</a>
            </form>
        </div>
        </div>
    </header>