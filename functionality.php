<?php
error_reporting(0);
$conn = mysql_connect('localhost','root','');
$db= mysql_select_db('avengers');

$action = $_GET['action'];
if($action == 'delete'){
	$rowId = $_POST['rowId'];
	$qry = "DELETE FROM demo where id=$rowId";	
	$result = mysql_query($qry);
	if($result) die('1');
	else die('2');
}else if($action == 'update'){
	$qry = "SELECT id,userName,mobileNo,email,dob from demo";
	$result = mysql_query($qry);
	$temp = array();
	$i = 0;
	while($row = mysql_fetch_array($result))
	{
		$temp[$i] = array('id'=>$row['id'],'userName'=>$row['userName'],'mobileNo'=>$row['mobileNo'],'email'=>$row['email'],'dob'=>$row['dob']);
		//$temp['mobileNo'][$i] = $row['mobileNo'];
		$i++;
	}
	echo json_encode($temp);
}
else if($action == 'rowset'){
	$rowId = $_POST['row_id'];
	$qry = "SELECT userName,mobileNo,email,dob FROM demo where id=$rowId";
	$result = mysql_query($qry);
	$row = mysql_fetch_row($result);
	$temp = array(
		'userName'=>$row[0],
		'mobileNo'=>$row[1],
		'email'=>$row[2],
		'dob'=>$row[3]
	);
	echo json_encode($temp);
}else{
	if(isset($_POST)){
		$userName = $_POST['userName'];
		$mobileNo = $_POST['mobileNo'];
		$email = $_POST['email'];
		$dob = $_POST['dob']; 
		$hidden_row_id= $_POST['hidden_row_id'];
		if($hidden_row_id > 0){
			echo "update record Processing !!!";
		}else{
			$qry = "INSERT INTO demo(userName,mobileNo,email,dob) values('".$userName."',".$mobileNo.",'".$email."','".$dob."')";
			$result = mysql_query($qry);
			if($result){
				die('1');
			}else{
				die('2');
			}
		}
	}	
}

?>