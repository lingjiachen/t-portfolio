<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/smarty.php';
require_once 'includes/work.php';

// 1. 檢查是否已登入
ensure_login();

// 2. 決定頁面類別與名稱
$type_mapping_teaching = [
  'hourlyStatistic' => '教師終點統計',
  'previousCourse' => '歷年開課資料',
];
$type_enum_teaching = (isset($_GET['type']) && array_key_exists($_GET['type'], $type_mapping_teaching)) ? $_GET['type'] : 'journal';
$smarty->assign('type', $type_mapping_teaching[$type_enum_teaching]);

// 3. 若使用者送表單上來，則處理表單請求
if (isset($_POST['create'])) {
  if ($error_msg = work_create($_POST['title'], $_POST['author'], $_POST['publication'], $_POST['category'], $_POST['date'], $_POST['keywords'], $type_enum_teaching, $_SESSION['usr_id'])) {
    $msg = array(
      'class' => 'danger',
      'status' => '錯誤',
      'body' => $error_msg,
    );
  } else {
    $msg = array(
      'class' => 'success',
      'status' => '成功',
      'body' => '新增成功',
    );
  }
  $smarty->assign('msg', $msg);
}

// 4. 查詢資料
$works = is_admin() ? work_select($type_enum_teaching) : work_select($type_enum_teaching, $_SESSION['usr_id']);
$smarty->assign('works', $works);

// 5. 審核資料
if (isset($_POST['approve'])) {
  work_approve(資料ID);
}

// 6. 結合樣板輸出畫面
$smarty->display('research.html');
