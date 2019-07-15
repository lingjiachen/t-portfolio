<?php
// 與使用者登入狀態相關均會用到 session，因此需呼叫 session_start()
@session_start();

// 引入常用工具函式
require_once 'includes/functions.php';
// 引入 smarty 樣版引擎 (全域變數：$smarty)
require_once 'includes/smarty.php';
// 引入資料庫 (全域變數：$database)
require_once 'includes/database.php';

// 確定為已登入狀態，否則轉導至登入頁面
ensure_login();

// 從網址 (query string) 拿取使用者要操作的表格名稱
$table = urldecode(trim($_GET['table']));

// 透過 SQL 查詢，取得所有欄位資訊
// ex:
// Array
// (
//   [0] => Array
//       (
//           [Field] => id
//           [Type] => int(11)
//           ...
//       )

//   [1] => Array
//       (
//           [Field] => 開始日期
//           [Type] => date
//           ...
//       )
//   ...
// )
$columns = $database->query("SHOW FULL COLUMNS FROM {$table}")->fetchAll();

// 如果查詢不到任何欄位資訊，表示該表格不存在，否則就設定 $title 變數
// 前端也可藉由此變數知道該表格是否存在
if (count($columns) === 0) {
  $msg = [
    'class' => 'danger',
    'status' => '錯誤',
    'body' => '指定的表格不存在',
  ];
  $smarty->assign('msg', $msg);
} else {
  $title = str_replace('_', ' | ', $table);
  $smarty->assign('title', $title);
}

// 由於前端表單 input 跟後端資料庫欄位型態名稱並不一致，在這邊先做一次轉換，
// 在前端就能以較簡單的 number, date, or string 來判斷要用哪種 input
// ex:
// Array
// (
//     [0] => Array
//         (
//             [type] => number
//             [column] => id
//         )

//     [1] => Array
//         (
//             [type] => date
//             [column] => 開始日期
//         )
// )
$columns = convertColumns($columns);

// 如果表單 post 上來，表示使用者新增資料：
if (isset($_POST['create'])) {

  // 如果上傳的資料沒有使用者 ID，就從 session 取得，因為資料庫中可能會有此欄位
  if (!isset($_POST['userId'])) {
    $_POST['userId'] = $_SESSION['usr_id'];
  }

  // 使用者上傳的表單資料中，如果有資料庫中不存在該欄位的，就把它過濾掉，避免 insert 時發生錯誤
  $postData = filterPostData($_POST, $columns);

  // 新增到資料庫
  $database->insert($table, $postData);

  // 若操作資料庫有錯誤，可透過 error() 取得
  $error_msg = $database->error()[2];

  // 提供 $msg 物件，給前端顯示訊息使用
  $msg = [
    'class' => $error_msg ? 'danger' : 'success',
    'status' => $error_msg ? '錯誤' : '成功',
    'body' => $error_msg ? $error_msg : '新增成功',
  ];
  $smarty->assign('msg', $msg);
}

// 不需要顯示 id 欄位，因此過濾掉，如果不是管理員，也把 userId 欄位過濾掉
if (is_admin()) {
  $columns = filterColumns($columns, ['id']);
} else {
  $columns = filterColumns($columns, ['id', 'userId']);
}

// 提供欄位資訊給前端
$smarty->assign('columns', $columns);

// 查詢資料，如果不是管理員，只能顯示自己的資料
if (is_admin()) {
  $rows = $database->select($table, '*');
} else {
  $rows = $database->select($table, '*', ['userId' => $_SESSION['usr_id']]);
}

// 提供查詢到的資料給前端
$smarty->assign('rows', $rows);

// 最後選擇使用的樣板，將資料與畫面進行綁定，顯示出來
$smarty->display('other.html');

function convertColumns($cols)
{
  return array_map(function ($col) {
    $arr = [];

    if (substr($col['Type'], 0, 5) === 'enum(') {
      $arr['type'] = 'enum';
      $arr['values'] = json_decode('[' . str_replace("'", '"', substr($col['Type'], 5, -1)) . ']');
    } else if (substr($col['Type'], 0, 4) === 'set(') {
      $arr['type'] = 'set';
      $arr['values'] = json_decode('[' . str_replace("'", '"', substr($col['Type'], 4, -1)) . ']');
    } elseif (substr($col['Type'], 0, 4) === 'int(') {
      $arr['type'] = 'number';
    } elseif ($col['Type'] === 'date' || $col['Type'] === 'timestamp') {
      $arr['type'] = 'date';
    } else {
      $arr['type'] = 'string';
    }

    $arr['column'] = $col['Field'];
    $arr['placeholder'] = $col['Comment'];
    return $arr;
  }, $cols);
}

function filterColumns($columns, $filters)
{
  return array_filter($columns, function ($col) use ($filters) {
    return !in_array($col['column'], $filters);
  });
}

function filterPostData($data, $columns)
{
  $cols = array_map(function ($col) {
    return $col['column'];
  }, $columns);

  foreach ($data as $key => $value) {
    if (gettype($value) === 'array') {
      $data[$key] = implode(',', $value);
    }
  }

  return array_filter($data, function ($val, $key) use ($cols) {
    return in_array($key, $cols);
  }, ARRAY_FILTER_USE_BOTH);
}
