<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connsql.php");  //�t�J�s����Ʈw�ɮ�
	$seldb = @mysql_select_db("orderdrink");  //�s����Ʈw
	if (!$seldb) die("��Ʈw��ܥ��ѡI");
	
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