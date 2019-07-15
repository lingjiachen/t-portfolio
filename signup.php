<?php
// 引入常用工具函式
require_once 'includes/functions.php';
// 引入使用者操作相關函式
require_once 'includes/user.php';
// 引入 smarty 樣版引擎 (全域變數：$smarty)
require_once 'includes/smarty.php';

// 如果表單 post 上來，表示要進行註冊：
if (isset($_POST['register'])) {

  // 帳號註冊，若有訊息表示註冊失敗
  if ($error_msg = user_register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['cpassword'])) {
    $msg = array(
      'class' => 'danger',
      'status' => '註冊失敗',
      'body' => $error_msg,
    );
  } else {
    $msg = array(
      'class' => 'success',
      'status' => '註冊成功',
      'body' => '',
    );
  }

  // 提供 $msg 物件，給前端顯示訊息使用
  $smarty->assign('msg', $msg);
}

// 最後選擇使用的樣板，將資料與畫面進行綁定，顯示出來
$smarty->display('signup.html');
