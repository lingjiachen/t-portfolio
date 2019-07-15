<?php
session_start();
require_once 'includes/dbconnect.php';
require_once "includes/PHPExcel/IOFactory.php";

$filename = $_FILES['inputExcel']['name']; //獲取上傳的文件名$_FILES["file"]["name"]上傳檔案的原始名稱
$tmp_name = $_FILES['inputExcel']['tmp_name']; //上傳到服務器上的臨時文件名$_FILES["file"]["tmp_name"]上傳檔案後的暫存資料夾位置
$msg = uploadFile($filename, $tmp_name);

//導入Excel文件
function uploadFile($file, $filetempname)
{
   global $con;

    $filePath = 'upload/'; //自己設置的上傳文件存放路徑
    $str = "";
    $che = $_POST["che"]; //上傳全篇或單筆

    

    $filename = explode(".", $file); //把上傳的文件名以「.」號為準做一個數組
    $time = date("y-m-d-H-i-s"); //去當前上傳的時間
    $filename[0] = $time; //取文件名t替換
    $name = implode(".", $filename); //上傳後的文件名
    $uploadfile = $filePath . $name; //上傳後的文件名地址

    //move_uploaded_file(要移動的文件,文件的新位置)將上傳的文件移動到新位置。若成功，則返回 true，否則返回 false
    $result = move_uploaded_file($filetempname, $uploadfile); //假如上傳到當前目錄下

    if ($result) { //如果上傳文件成功，就執行導入excel操作
      print_r($uploadfile);
        // $objPHPExcel = PHPExcel_IOFactory::load($uploadfile);
        
        $inputFileType = 'HTML';
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Advise the Reader that we only want to load cell data  **/
        $objReader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  **/
        $objPHPExcel = $objReader->load($uploadfile);

        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $highestRow = $sheet->getHighestRow(); // 取得總行數(直列橫行

        $colString = $sheet->getHighestColumn(); //最大欄位的英文代號
        $highestColumn = PHPExcel_Cell::columnIndexFromString($colString); //最大欄位的數字編號。A=0, B=1, C=2....

        if ($che == 1) { //如果是全筆重匯
            $rs = "DROP TABLE IF EXISTS works"; //刪除表格
            $con->query('set names utf8');
            $con->query($rs);
        }

        $fs2 = '';
        $fs3 = 'userId,';

        //循環讀取excel文件,讀取一條,插入一條 (全篇重匯
        for ($j = 3; $j <= 3; $j++) { //行(代表欄位名稱
            for ($k = 0; $k < $highestColumn; $k++) { //列(代表ID
                //讀取單元格
                $value = $sheet->getCellByColumnAndRow($k, $j)->getValue();

                $new5 = iconv("BIG5", "UTF-8", $value);

                if ($k == $highestColumn - 1) {
                    $fs2 .= $new5 . " text";
                    $fs3 .= $new5;
                    $fs4[$k] = $new5;
                } else if ($k == 0) {
                    $fs2 .= "id int PRIMARY KEY AUTO_INCREMENT,";
                    $fs3 .= "id,";
                    $fs4[$k] = "id";
                } else {
                    $fs2 .= $new5 . " text,";
                    $fs3 .= $new5 . ",";
                    $fs4[$k] = $new5;
                }
            }

            $sql = $con->query("create table works(" . $fs2 . ")"); //建立表格
            $fs2 = "";
        }

        $fs = $_SESSION["usr_id"].',';
        $fs5 = "userId='".$_SESSION["usr_id"].'",';

        //循環讀取excel文件,讀取一條,插入一條 (單筆匯
        for ($j = 4; $j <= $highestRow; $j++) { //行
            $str2 = $sheet->getCellByColumnAndRow(0, $j)->getValue(); //取id
            for ($k = 0; $k < $highestColumn; $k++) { //列
                $str3 = $sheet->getCellByColumnAndRow($k, $j)->getValue();
                $str = iconv("UTF-8", "BIG5", $str3);

                if ($k == $highestColumn - 1) {
                    $fs .= "'" . $str . "'";
                    $fs5 .= $fs4[$k] . "='" . $str . "'"; //抓EXCEL建物編號，不用照順序匯入
                } else {
                    $fs .= "'" . $str . "',";
                    $fs5 .= $fs4[$k] . "='" . $str . "',";
                }
            }

            if ($che == 1) { //如果是全筆重匯
                $query = "insert into works (" . $fs3 . ") values (" . $fs . ")";
                $result3 = $con->query($query);
            } else { //如果是單筆重匯
                $query = "select * from works where id = '$str2'";
                $rs2 = $con->query($query);
                $total = mysqli_num_rows($rs2); //計算資料庫是否有此筆資料

                if ($total > 0) {
                    $query = "update works set " . $fs5 . " where id = '$str2'";
                    $result3 = $con->query($query);
                } else {
                    $query = "insert into works (" . $fs3 . ") values (" . $fs . ")";
                    $result3 = $con->query($query);
                }

            }
            $fs = $_SESSION["usr_id"].',';
            $fs5 = "userId='".$_SESSION["usr_id"].'",';
        }

        unlink($uploadfile); //刪除上傳的excel文件
    }
}
