<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connsql.php");  //含入連結資料庫檔案
	$seldb = @mysql_select_db("orderdrink");  //連結資料庫
	if (!$seldb) die("資料庫選擇失敗！");

	$sql_query = "SELECT * FROM `product` WHERE `totalquantity`>0 ORDER BY `totalquantity` DESC LIMIT 5";
	$result = mysql_query($sql_query);
	$numrow = mysql_num_rows($result);
	$row_result = array();
	$i = 0;
	while($row_result[$i] = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$i++;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=yes, maximum-scale=1, minimum-scale=1, width=device-width" />
<title>雲端訂購系統</title>
<link href="jquery-mobile/jquery.mobile-1.0.min.css" rel="stylesheet" type="text/css">
<script src="jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
<style>
	.datatable {
		border-collapse:collapse;
		border:1px solid black;
		background-color:#FFF;
	}	
	.datatable td{
		border:1px solid #CCC;
	}
	.datatable th{
		color:#FFF;				
		background-color:#39C;
		border:1px solid #CCC;
	}
</style>
</head>
<body>
<div data-role="page" id="listOrder">
	<div data-role="header" data-position="fixed" data-theme="b">
		<h1>銷售排行榜</h1>
	</div>
	<div data-role="content">
		<div>
			<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="datatable">
			<tr>
				<th width="20%" align="center">名次</th>
				<th width="20%" align="center">編號</th>
				<th align="center">名稱</th>
				<th width="30%" align="center">銷售總量</th>
			</tr>
			<?php for($i=0; $i<$numrow; $i++) { ?>
			<tr>
				<td align="center"><?php echo $i+1; ?></td>
				<td align="center"><?php echo $row_result[$i]["productnumber"]; ?></td>
				<td align="center"><?php echo $row_result[$i]["productname"]; ?></td>
				<td align="center"><?php echo $row_result[$i]["totalquantity"]; ?></td>
			</tr>
			<?php } ?>
			</table>
		</div>
		<div>
			<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr>
				<td><a href="index.php" data-role="button" data-ajax="false">回首頁</a></td>
			</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>
