<?php
// 引入 smarty 樣版引擎 (全域變數：$smarty)
require_once 'includes/smarty.php';
// 引入使用者操作相關函式
require_once 'includes/user.php';

// 如果表單 post 上來，表示要進行登入：
if (isset($_POST['login'])) {

  // 登入，若有訊息表示登入失敗
  if ($error_msg = user_login($_POST['email'], $_POST['password'])) {
    $msg = array(
      'class' => 'danger',
      'status' => '登入失敗',
      'body' => $error_msg,
    );

    // 提供 $msg 物件，給前端顯示訊息使用
    $smarty->assign('msg', $msg);
  } else {

    // 登入成功則轉導至預設頁面 (research.php)
    header("Location: research.php");
  }
}

// 選擇使用的樣板，將資料與畫面進行綁定，顯示出來
$smarty->display('signin.html');
