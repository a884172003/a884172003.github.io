<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connsql.php");  //含入連結資料庫檔案
	$seldb = @mysql_select_db("orderdrink");  //連結資料庫
	if (!$seldb) die("資料庫選擇失敗！");
	
	if (isset($_GET["update"])) {
		$order = $_GET["update"];
		$sql_query = "UPDATE `orders` SET `finish`=1 WHERE `orderid`='" . $order . "'";
		$result = mysql_query($sql_query);
		header("Location: index.php");
	}

	$row_detail = array();
	$order = $_GET["order"];
	$sql_query = "SELECT * FROM `orders` WHERE `orderid`='" . $order . "'";
	$result = mysql_query($sql_query);
	$numorder = 0;
	$numorder = mysql_num_rows($result);
	if($numorder>0) {
		$row_order = mysql_fetch_array($result, MYSQL_ASSOC);
		$sql_query = "SELECT * FROM `productdetail` WHERE `orderid`='" . $order . "'";
		$result = mysql_query($sql_query);
		$numdetail = mysql_num_rows($result);
		$i = 0;
		while($row_detail[$i] = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$i++;
		}
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
<style type="text/css">
	.subject {
		font-size: 12pt;
		font-weight: bold;
		color: #FF0000;
		margin-bottom: 10px;
		background-image: url(images/icon_grean.gif);
		background-repeat: no-repeat;
		background-position: left center;
		padding-left: 16px;
	}
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
<div data-role="page" id="showOrder">
	<div data-role="header" data-position="fixed" data-theme="b">
		<h1>訂單查詢-顯示訂單</h1>
	</div>
	<div data-role="content">
		<?php if($numorder>0) { ?>
		<div id="orderMessage"> 
			<h4>客戶資訊 </h4>
			<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="datatable">
			<tr>
				<th width="70" align="center">資訊</th>
				<th>內容</th>
			</tr>
			<tr>
				<td align="center"><strong>訂單號碼</strong></td>
				<td><?php echo $row_order["orderid"]; ?></td>
			</tr>
			<tr>
				<td align="center"><strong>姓名</strong></td>
				<td><?php echo $row_order["name"]; ?></td>
			</tr>
			<tr>
				<td align="center"><strong>聯絡電話</strong></td>
				<td><a href="tel:<?php echo $row_order['phone']; ?>"><?php echo $row_order["phone"]; ?></a></td>
			</tr>
			<tr>
				<td align="center"><strong>地址</strong></td>
				<td><?php echo $row_order["address"]; ?></td>
			</tr>
			<tr>
				<td align="center"><strong>訂貨時間</strong></td>
				<td><?php echo $row_order["ordertime"]; ?></td>
			</tr>
			<tr>
				<td align="center"><strong>製作狀況</strong></td>
				<td><?php if($row_order["finish"]==0) { echo "未處理"; } else { echo "已處理"; } ?></td>
			</tr>
			</table>
			<h4>訂單內容 </h4>
			<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="datatable">
			<tr>
				<th width="50" align="center">編號</th>
				<th align="center">名稱</th>
				<th width="50" align="center">單價</th>
				<th width="50" align="center">數量</th>
				<th width="60" align="center">金額</th>
			</tr>
			<?php for($i=0; $i<$numdetail; $i++) { ?>
			<tr>
				<td align="center"><?php echo $row_detail[$i]["productnumber"]; ?></td>
				<td align="center"><?php echo $row_detail[$i]["productname"]; ?></td>
				<td align="center">$<?php echo $row_detail[$i]["productprice"]; ?></td>
				<td align="center"><?php echo $row_detail[$i]["productquantity"]; ?></td>
				<td align="center"><strong>$ <?php echo $row_detail[$i]["productprice"]*$row_detail[$i]["productquantity"]; ?> </strong></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="4" align="left">總計</td>
				<td align="center"><strong>$ <?php echo $row_order["totalmoney"]; ?> </strong></td>
			</tr>
			</table>
		</div>
		<div>
			<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr>
				<td><a href="?update=<?php echo $order; ?>" data-role="button" data-ajax="false">完成處理</a></td>
				<td><a href="index.php" data-role="button" data-ajax="false">回首頁</a></td>
			</tr>
			</table>
		</div>
		<?php } else {?>
		<div style="font-size:28px; text-align:center; color:#FF0000;">此訂單號碼不存在！</div>
		<div>
			<table width="90%" border="0" align="center" cellpadding="4" cellspacing="0">
			<tr>
				<td><a href="index.php" data-role="button" data-ajax="false">回首頁</a></td>
			</tr>
			</table>
		</div>
		<?php } ?>
	</div>
</div>
</body>
</html>
