<?PHP
require_once '../conf/t3_const.php';
// 関数ファイル読み込み
require_once '../model/t3m_common.php';
require_once '../model/t3m_regist.php';

// リクエストメソッド取得
$request_method = get_request_method();
if ($request_method !== 'POST') {
  header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_login.php');
  exit;
}

// セッション開始
session_start();

// 名前とパスワードのポストチェック;
if(btn_check('login_btn')==='TRUE'){
    // nameチェック
    $result=get_post('name','名前');
    error_check($result,$error);
    if($result=='TRUE'){
        $user_name=$_POST['name'];
    }
    // passチェック
    $result=get_post('pass','パスワード');
    error_check($result,$error);
    if($result=='TRUE'){
        $pass=$_POST['pass'];
    }
}

if(count($error)===0){
    // 名前をCookieへ保存
    setcookie('name', $user_name, time() + 60 * 60 * 24 * 365);
    
    // データベース接続
    $link = get_db_connect();
    
    // 名前とパスワードからuser_idを取得するSQL
    $sql = "SELECT user_id,user_name FROM t3_user_table
          WHERE user_name ='$user_name' AND pass='$pass'";
    var_dump($sql);
    
    // SQL実行し登録データを配列で取得
    $data = get_as_array($link, $sql);
    var_dump($data);
    // データベース切断
    close_db_connect($link);
    
    // 登録データを取得できた確認
    if((isset($data[0]['user_id']))&&(isset($data[0]['user_name']))){
         // セッション変数にuser_id,user_nameを保存
        $_SESSION['user_id'] = $data[0]['user_id'];
        $_SESSION['user_name'] = $data[0]['user_name'];
        if(($user_name==='admin')&&($pass==='admin')){
            // 管理ページへリダイレクト
            header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_tool.php');
            exit;
      }else{
        // ログイン済みユーザのホームページへリダイレクト
        header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_shop.php');
        exit;
      }
    } else {
        // セッション変数にログインのエラーフラグを保存
        $_SESSION['login_err_flag'] = TRUE;
        $login_err_flag = $_SESSION['login_err_flag'];
        //   ログインページへリダイレクト
        header('Location: http://codecamp24596.lesson10.codecamp.jp//challenge/t3_login.php');
        exit;
    }
}

include_once '../view/t3v_login_logo.php';
include_once '../view/t3v_login.php';






