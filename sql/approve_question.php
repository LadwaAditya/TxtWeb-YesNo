<?php 
include('logic.php');
include('../common/key.php');
include('appname.php');
echo '<html>
<head>
<meta http-equiv=\'Content-Type\' content=\'text/html; charset=UTF-8\' />
<meta name=\'txtweb-appkey\' content="'. $appkey .'">
<title> Home</title>
</head><body>';



if( isset($_GET['txtweb-message']) && !empty($_GET['txtweb-message']))
{
		$db=db_connect();
		$input=explode(",",$_GET['txtweb-message']);
		 $question=$input[0];
		 $user=$input[1];
		 $app=strtoupper($input[2]);
	
		if($app == 'YES')
		{
			$final_mes=question_approve($user,$question);
	
		}	
		else if($app == 'NO')
		{
			$final_mes= "Your question '".$question."' cannot be approved or it is subbmited by someone else pls visit @".$appname.'.'."help for more help";
	
	
		}	
		

	
	$message="<html><head><title>App Title</title>
		<meta name=txtweb-appkey content='".$appkey."' />
		</head><body>". $final_mes."</body></html>";
		
	
		
			$fields = array(
			'txtweb-mobile'=>$user,
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

else echo "APP under development";


echo '</body></html>';

?>