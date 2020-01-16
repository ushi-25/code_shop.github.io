<DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ユーザー管理</title>
<!--<link rel="stylesheet" href="t3v_css.css">-->
<style>
    header a{
        float:left;
    }
    
    .logout{
        margin-right: 31px;
    }

    table,tr, th, td {
        border: solid 1px;
        padding: 10px;
        text-align: center;
    }
</style>

<body>

<header>
  <h1>ユーザー管理ページ</h1>
    <form method="post" action="t3_logout_process.php">
    <a class="logout" href="t3_logout_process.php">ログアウト</a>
    </form>
　  <a href="t3_tool.php">商品管理ページ</a>
</header>

<section>
  <h2>ユーザー情報の一覧</h2>
  <table>
    <tr>
        <th>ユーザーＩＤ</th>
        <th>登録日</th>
    </tr>

<?php foreach ($user_list as $data) { ?>
    <tr>
        <td>      
<?php print $data['user_name']; ?>
        </td>
        <td>
<?php print $data['user_created_date']?>
        </td>
    </tr>
<?php } ?>
</table>
</body>