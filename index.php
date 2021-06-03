<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connsql.php");  //含入連結資料庫檔案
	$seldb = @mysql_select_db("orderdrink");  //連結資料庫
	if (!$seldb) die("資料庫選擇失敗！");

	$sql_query = "SELECT `orderid`,`phone`,`name` FROM `orders` WHERE `finish`=0 ORDER BY `orderid` DESC";
	$result = mysql_query($sql_query);
	$numrow = mysql_num_rows($result);
	$row_result = array();
	$i = 0;
	while($row_result[$i] = mysql_fetch_array($result, MYSQL_ASSOC)){
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
</head>
<body>
<div data-role="page" id="listOrder">
	<div data-role="header" data-position="fixed" data-theme="b">
		<h1>訂單查詢-選擇訂單</h1>
		<div data-role="navbar" data-theme="e">
			<ul>
				<li><a href="#listOrder" class="ui-btn-active">查詢未處理訂單</a></li>
				<li><a href="#inputOrder">查詢歷史訂單</a></li>
				<li><a href="itemSort.php">銷售排行榜</a></li>
			</ul>
		</div>
	</div>
	<div data-role="content">
		<ul data-role="listview" data-inset="true" id="lstOrder" data-filter="true" data-filter-placeholder="輸入訂單號碼、電話或姓名">
			<?php for($i=0; $i<$numrow; $i++) { ?>
			<li><a href='showorder.php?order=<?php echo $row_result[$i]["orderid"]; ?>' data-ajax='false'>
			<?php echo $row_result[$i]["orderid"]; ?>　　
			<?php echo $row_result[$i]["phone"]; ?>　　
			<?php echo $row_result[$i]["name"]; ?>
			</a></li>
			<?php } ?>
		</ul>
	</div>
</div>

<div data-role="page" id="inputOrder">
	<div data-role="header" data-position="fixed" data-theme="b">
		<h1>訂單查詢-輸入訂單</h1>
		<div data-role="navbar" data-theme="e">
			<ul>
				<li><a href="#listOrder">查詢未處理訂單</a></li>
				<li><a href="#inputOrder" class="ui-btn-active">查詢歷史訂單</a></li>
				<li><a href="itemSort.php">銷售排行榜</a></li>
			</ul>
		</div>
	</div>
	<div data-role="content">
		<div data-role="fieldcontain">
			<label for="textinput">輸入訂單號碼：</label>
			<input type="text" name="txtOrder" id="txtOrder" value=""  />
		</div>
		<a href="#" data-role="button" onClick="javascript: if(txtOrder.value=='') {alert('必須輸入訂單號碼！');} else { window.location.href='showorder.php?order=' + txtOrder.value; }">查詢</a>
	</div>
</div>
</body>
</html>