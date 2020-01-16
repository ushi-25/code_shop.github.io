<?php
require_once '../conf/t3_const.php';

// 関数ファイル読み込み
require_once '../model/t3m_common.php';
require_once '../model/t3m_tool.php';

// セッション開始
session_start();

// ログインチェック
if(admin_logined_check()==='TRUE'){
    $user_id=$_SESSION['user_id'];
    $user_name=$_SESSION['user_name'];
}

// リクエストメソッド取得
$request_method = get_request_method();
if ($request_method === 'POST'){
    if(btn_check('form_btn')==='TRUE'){
        // 名前チェック
        $result=get_post('new_name','品名');
        if($result=='TRUE'){
            $new_name=preg_replace('/\A[　\s]*|[　\s]*\z/u','',$_POST['new_name']);
        }
        error_check($result,$error);
    
        // 値段チェック
        $result=get_post('new_price','値段');
        error_check($result,$error);
        if($result=='TRUE'){
            $new_price=$_POST['new_price'];
            $result=int_check($new_price,'値段');
            error_check($result,$error);
        }
        
    
        // 在庫チェック
        $result=get_post('new_stock','在庫');
        error_check($result,$error);
        if($result=='TRUE'){
            $new_stock=$_POST['new_stock'];
            $result=int_check($new_stock,'在庫');
            error_check($result,$error);
        }
       
        
       // 画像登録チェック
        if(isset($_FILES['upfile'])){
            if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
                $upfile_name=($time.$_FILES['upfile']['name']);
                if(preg_match('/\.PNG$|\.JPG$|\.JPEG$/i',$upfile_name)===1){
                    //MIMEタイプの取得
                    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES['upfile']['tmp_name']);
                    finfo_close($finfo);
                    if(($mime_type === "image/png")||($mime_type==="image/jpeg")){
                        // // 出力
                        $upfile_test=move_uploaded_file($_FILES['upfile']['tmp_name'], $uploaddir.$upfile_name);
                    }else{
                        $error[]='画像はファイル形式JPEG又はPNGで追加して下さい';  
                }
                }else{
                    $error[]='画像はファイル形式JPEG又はPNGで追加して下さい';
                }   
            }else{
                $error[]='画像を入力して下さい';
            } 
        }else{
            $error[]='画像を入力して下さい';
        } 
    
        // 状態チェック
        $result=get_post('new_status','状態');
        if($result==='TRUE'){
            $new_status=$_POST['new_status'];
            $result=status_check($new_status);
            error_check($result,$error);
        }else{
             $error[]='不正な操作です';
        }
    }
        
    // 在庫変更チェック
    if(btn_check('stock_btn')==='TRUE'){
        $result=get_post('update_stock','在庫');
        error_check($result,$error);
        if($result==='TRUE'){
            $item_id=$_POST['item_id'];
            $update_stock=$_POST['update_stock'];
            $result=int_check($update_stock,'在庫');
            error_check($result,$error);
        }

     }

    // 状態変更チェック
    if(btn_check('status_btn')==='TRUE'){
        $result=get_post('update_status','状態');
        if($result==='TRUE'){
            $update_status=$_POST['update_status'];
            $item_id=$_POST['item_id'];
            $result=status_check($update_status);
            error_check($result,$error);
        }else{
            $error[]='不正な操作です';
        }
    }
}

// DB接続
$link = get_db_connect();
 
//  トランザクション開始
db_commit_start($link, false);

// 商品新規登録
if((btn_check('form_btn')==='TRUE')&&(count($error) === 0)){
    $result=insert_item($link,$upfile_name,$new_name,$new_price,$time,$new_status,$new_stock,$time);
    error_check($result,$error);
    if($result === 'TRUE'){
        $success[]='追加成功';
    }
}

// 在庫変更登録
if((btn_check('stock_btn')==='TRUE')&&(count($error) === 0)){
    $result=update_stock($link,$update_stock,$time,$item_id);
    error_check($result,$error);
    if($result === 'TRUE'){
      $success[]='在庫数を変更しました';
    }
} 

// 状態変更登録
if((btn_check('status_btn')==='TRUE')&&(count($error) === 0)){
    $result=update_status($link,$time,$item_id,$update_status);
    error_check($result,$error);
    if($result === 'TRUE'){
        $success[]='状態を変更しました';
    }
}
// 商品削除
if(btn_check('delete_btn')==='TRUE'){
    $item_id=$_POST['item_id'];
    // 商品の写真をフォルダから削除
    $image=delete_image($link,$item_id);
    unlink('./image/'.$image);
    // データ削除
    $result=delete_item($link,$item_id);
    error_check($result,$error);
    if($result === 'TRUE'){
      $success[]='商品を削除しました';
    }
}

if (count($error) === 0) {
    // 処理確定
    db_commit_end($link);
} else {
    // 処理取消
    db_rollback($link);
}
    
// 商品一覧
$item_list= item_list($link);
$item_list = entity_assoc_array($item_list);

// DB切断
close_db_connect($link);

// 商品一覧テンプレートファイル読み込み
include_once '../view/t3v_tool.php';
