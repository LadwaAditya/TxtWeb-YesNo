<?php
$host = $_SERVER["HTTP_HOST"];                         
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
include('logic.php');
include('../common/key.php');
include('appname.php');
echo '<html>
<head>
<meta http-equiv=\'Content-Type\' content=\'text/html; charset=UTF-8\' />
<meta name=\'txtweb-appkey\' content="'. $appkey .'">
<title> PJ</title>
</head><body>';

?>
<?php
if(isset($_GET['txtweb-message']) && !empty($_GET['txtweb-message']))
{	
		$db=db_connect();
		$pieces = explode(",",$_GET['txtweb-message']);
		$text=$pieces[0]; 
		$pass=$pieces[1]; 
		
		if($text=="push" && $pass=="adi123")
		{
		
			$res=mysql_query("SELECT * FROM user");
			while($row=mysql_fetch_assoc($res))
			{
				$user=$row['user'];
				$res2=mysql_query("SELECT * FROM questions WHERE user='$user'");
				if(mysql_num_rows($res2) > 0)
				{				
				$mobile=$user;
				$stats=get_user_stats_qid($mobile);
				$ques='';
						$yes='';
						$no='';
						$final='';
				foreach($stats as $qid)
					{
						$final .=get_question($qid) . '<br> YES--' . vote_yes_percentage($qid) . '%'. '<br>NO--' . vote_no_percentage($qid). '%'. '<br>';
						$ques .=get_question($qid) . '<br>';
						$yes .=vote_yes_percentage($qid) . '%'. '<br>';
						$no .=vote_no_percentage($qid). '%'. '<br>';
					}
							
			
				 echo $message="<html><head><title>App Title</title>
				<meta name=txtweb-appkey content=$appkey />
			</head><body>Progress  of ur asked questions <br><br>$final <br><br>Any other Question U have .Feel free to ask <br></body></html>";
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
				
				else 
				continue;
			}
			
					
		}

exit;
}



if(isset($_GET['txtweb-mobile']))
{	

	$db=db_connect();
	$mobile=$_GET['txtweb-mobile'];
	$stats=get_user_stats_qid($mobile);
	
	get_user_stats_echo($stats,$mobile);
}
	
	
else echo 'visit from txtweb';



?>
<?php


echo '</body></html>';

?>