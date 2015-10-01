<?php 
include('logic.php');
include('../common/key.php');
include('appname.php');
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
$host = $_SERVER["HTTP_HOST"];
$serv= "http://$host$path";
echo
'<html>
<head>
<meta http-equiv=\'Content-Type\' content=\'text/html\'; charset=\'UTF-8\' />
<meta name=\'txtweb-appkey\' content="'. $appkey .'">
<title> Home</title>
</head><body>';




if(isset($_GET['txtweb-mobile']) && isset($_GET['txtweb-message']))
{
$db=db_connect();
$input=explode(",",$_GET['txtweb-message']);
$que=$input[0];
$pass=$input[1];
$limt_low=$input[2];
$limit_high=$input[3];
if($pass == 'adi123')
{
 $qid=get_qid($que); 
 $yes_percentage=vote_yes_percentage($qid);
 $no_percentage=vote_no_percentage($qid);
 // SELECT * FROM  `user`  LIMIT 30 , 70
 // SELECT * FROM  `yesno_user_push` LIMIT $limit_low , $limit_high
 
		$sql=mysql_query("SELECT * FROM  `yesno_user_push` LIMIT ".$limit_low." , ".$limit_high." ");
		while($row=mysql_fetch_assoc($sql))
		{
			$id=$row['id'];
			$mobile=$row['user_hash'];
		$head="Question from @".$appname.'<br>';		
		$body="$que<br>
		<a href='".$serv."/index.php?vote=1&qid=".$qid."&id=".$id."'>YES</a>
		(".$yes_percentage." %)<br>
		<a href='".$serv."/index.php?vote=0&qid=".$qid."&id=".$id."'>NO</a>
		(".$no_percentage." %)";	
				
				
				
		$message='<html><head><title>Yes NO</title>
		<meta name="txtweb-appkey" content="'.$appkey.'" />
		</head><body>Question from @'.$appname.'<br><br>'.$body.'<br><br>Please Send ur answer</body></html>';
			$fields = array(
			'txtweb-mobile'=>$mobile,
			'txtweb-pubkey'=>"b3f54555-0f11-4428-99ee-148212237a0b",
			'txtweb-message'=>$message);
		 $url="http://api.txtweb.com/v1/push";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST,count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($fields));
			$result = curl_exec($ch);
			curl_close($ch);
		
		 
		}
}


}

else
 echo "Visit from txtweb";
 


echo '</body></html>';

?>