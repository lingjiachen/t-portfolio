<?php
// 與使用者登入狀態相關均會用到 session，因此需呼叫 session_start()
@session_start();
// 刪除此 session 所有資料
session_destroy();
// 轉導至登入頁面
header('Location: signin.php');
