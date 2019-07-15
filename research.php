<?php
@session_start();
require_once 'includes/functions.php';
require_once 'includes/smarty.php';
require_once 'includes/work.php';

// 1. 檢查是否已登入
ensure_login();

// 2. 決定頁面類別與名稱
$type_mapping = [
  'journal' => '期刊論文',
  'conference' => '研討會論文',
  'project' => '各項計畫',
  'other' => '其他著作',
];
$type_enum = (isset($_GET['type']) && array_key_exists($_GET['type'], $type_mapping)) ? $_GET['type'] : 'journal';
$smarty->assign('type', $type_mapping[$type_enum]);

// 3. 若使用者送表單上來，則處理表單請求
if (isset($_POST['create'])) {
  if ($error_msg = work_create($_POST['title'], $_POST['author'], $_POST['publication'], $_POST['category'], $_POST['date'], $_POST['keywords'], $type_enum, $_SESSION['usr_id'])) {
    $msg = [
      'class' => 'danger',
      'status' => '錯誤',
      'body' => $error_msg,
    ];
  } else {
    $msg = [
      'class' => 'success',
      'status' => '成功',
      'body' => '新增成功',
    ];
  }
  $smarty->assign('msg', $msg);
} elseif (isset($_POST['approve'])) {

  // 4. 審核資料
  work_approve($_POST['id']);
}

// 5. 查詢資料
$works = is_admin() ? work_select($type_enum) : work_select($type_enum, $_SESSION['usr_id']);
$smarty->assign('works', $works);

// 6. 結合樣板輸出畫面
$smarty->display('research.html');
