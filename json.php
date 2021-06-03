<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connsql.php");  //含入連結資料庫檔案
	$seldb = @mysql_select_db("orderdrink");  //連結資料庫
	if (!$seldb) die("資料庫選擇失敗！");
	
	$sql = "select * from product";
	$result = mysql_query($sql);
	$json = array();
	if(mysql_num_rows($result)){
		while($obj=mysql_fetch_object($result)){
			$json[]=$obj;
		}
	}
	echo json_encode($json); 
?>