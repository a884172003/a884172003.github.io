<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connsql.php");  //含入連結資料庫檔案
	$seldb = mysql_select_db("orderdrink");  //連結資料庫
	if (!$seldb) die("資料庫選擇失敗！");

	$echostr = "";
	$items = array();
	$itemnumber = array();	
	$itemname = array();
	$itemprice = array();
	$itemqty = array();
	$temarray = array();
	$name = $_GET["name"];
	$phone = $_GET["phone"];
	$address = $_GET["address"];
	$totalmoney = $_GET["total"];
	$product = $_GET["product"];
	$items = explode("|", $product);
	for($i=0; $i<count($items); $i++) {
		$temarray = explode(",", $items[$i]);
		$itemnumber[$i] = $temarray[0];
		$itemname[$i] = $temarray[1];
		$itemprice[$i] = $temarray[2];
		$itemqty[$i] = $temarray[3];
	}
	
	$sql_query = "INSERT INTO `orders` (`totalmoney`, `name`, `phone`, `address`) VALUES (" . $totalmoney . ", '" . $name . "', '" . $phone . "', '" . $address . "')";	
	$result = mysql_query($sql_query);
	$max_id = mysql_insert_id();  //取得最新的訂單編號
	
	for($i=0; $i<count($items); $i++) {
		$sql_query = "INSERT INTO `productdetail` (`orderid`, `productnumber`, `productname`, `productprice`, `productquantity`) VALUES (" . $max_id . ", '" . $itemnumber[$i] . "', '" . $itemname[$i] . "', '" . $itemprice[$i] . "', '" . $itemqty[$i] . "')";
		$result = mysql_query($sql_query);
		$sql_query = "UPDATE `product` SET `totalquantity`=`totalquantity`+" . $itemqty[$i] . " WHERE `productnumber`='" . $itemnumber[$i] . "'";
		$result = mysql_query($sql_query);
	}

	$mailtype='Content-Type:text/html;charset=utf-8';
	$mailFrom="線上訂單系統 <e-happy@e-happy.com.tw>"; 
	$mailTo="tsjeng@e-happy.com.tw";
	$mailSubject="=?utf-8?B?".base64_encode("線上訂單通知")."?=";
	$mailContent = "<p>顧客的訂單編號為：" . $max_id . "。<br>您可以使用這個編號 <a href='http://www.e-happy.com.tw/webapp/orderdrink/showorder.php?order=". $max_id . "'>連結</a> 網頁中查詢訂單的詳細內容。";
	$maildata = "From:$mailFrom\r\n";
	$maildata .= $mailtype;	
	mail($mailTo,$mailSubject,$mailContent,$maildata);
?>