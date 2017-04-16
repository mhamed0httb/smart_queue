<?php
require_once("connect.php");

$sql = "SELECT count(id) FROM tickets where status = 'served' ORDER by id DESC";
$result = mysqli_query($con,$sql);
if ($result){
  
 while($row=mysqli_fetch_array($result))
{
	$number=$row["count(id)"] + 1;
	echo $number;
}
}else{
  echo 0;
}
?>