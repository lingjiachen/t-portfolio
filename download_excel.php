<?php
require_once 'includes/dbconnect.php';

$type = isset($_GET["type"]) ? $_GET["type"] : 'journal';

header("Content-Type:application;");
header("Content-Disposition:attachment; filename=works_{$type}.xls"); //產生word檔
header("Pragma:no-cache ");
header("Expires: 0 ");
?>

<table border="0">

<tr>
<?php
$sql = "select * from `works` where type ='{$type}'";
$sql2 = $con->query($sql);
$rows = $sql2->num_rows;
if ($rows == "") {
  ?><td><?php echo "查無資料！<br>"; ?></td>
<?php
} else {
  ?><td><?php echo "共儲存 " . $rows . " 筆資料。"; ?></td>
</tr>

<tr>
<td bgcolor="#e6e6fa" align="center">項次</td>
<td bgcolor="#e6e6fa" align="center">審核狀態</td>
<td bgcolor="#e6e6fa" align="center">論文名稱</td>
<td bgcolor="#e6e6fa" align="center">作者</td>
<td bgcolor="#e6e6fa" align="center">期刊出處</td>
<td bgcolor="#e6e6fa" align="center">期刊分類</td>
<td bgcolor="#e6e6fa" align="center">發表日期</td>
<td bgcolor="#e6e6fa" align="center">關鍵字查詢</td>
</tr>

<tr>
<td bgcolor="#e6e6fa" align="center">id</td>
<td bgcolor="#e6e6fa" align="center">Status</td>
<td bgcolor="#e6e6fa" align="center">Title</td>
<td bgcolor="#e6e6fa" align="center">Author</td>
<td bgcolor="#e6e6fa" align="center">Publication</td>
<td bgcolor="#e6e6fa" align="center">Category</td>
<td bgcolor="#e6e6fa" align="center">Date</td>
<td bgcolor="#e6e6fa" align="center">Keywords</td>
</tr>
<?php
}
for ($i = 1; $i <= $rows; $i++) {
  $list3 = $sql2->fetch_object();
  ?>
	<tr>
	<td align="center"><?php echo $i; ?></td>
	<td align="center"><?php echo $list3->status; ?></td>
	<td align="center"><?php echo $list3->title; ?></td>
	<td align="center"><?php echo $list3->author; ?></td>
	<td align="center"><?php echo $list3->publication; ?></td>
	<td align="center"><?php echo $list3->category; ?></td>
	<td align="center"><?php echo $list3->date; ?></td>
	<td align="center"><?php echo $list3->keywords; ?></td>
	</tr>
<?php
}
$sql2->close();
?>

</table>