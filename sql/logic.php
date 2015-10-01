<?php

function user_insert($user)
{
	$res=mysql_query("SELECT * FROM user WHERE user='".$user."'");
	if(mysql_num_rows($res) == 0)
	$res=(mysql_query("INSERT INTO user (`id`,`user`) VALUES('','".$user."')"));
}


function total_questions()
{
	$res=mysql_query("SELECT * FROM questions");
	$j=mysql_num_rows($res);
	return ($j-1);

}


function get_all_question()
{

	$res=mysql_query("SELECT * FROM questions");
	while($row=mysql_fetch_assoc($res))
	{
		$ques[]=$row['ques'];
	
	}
	return $ques;
}


function question_submit($user,$question)
{	
	include('appname.php');
	$ques=mysql_real_escape_string($question);
	$res=mysql_query("SELECT * FROM questions WHERE ques='".$ques."'");
	if(mysql_num_rows($res) == 0)
	{
			// Push code to send developer   send $user(question submitter) to hash=e51d9271-9881-4e7d-9be9-6dd08ddacee6
			// hash2=ff11f6db-e836-4cef-bbdb-47f6b72425ef
		$final_mes="@".$appname. ".app ".$question.",".$user;
		$message="<html><head><title>App Title</title>
		<meta name=txtweb-appkey content='".$appkey."' />
		</head><body>". $final_mes."<br><br></body></html>";
		
	
		
			$fields = array(
			'txtweb-mobile'=>"e51d9271-9881-4e7d-9be9-6dd08ddacee6",
			'txtweb-pubkey'=>"b3f54555-0f11-4428-99ee-148212237a0b",
			'txtweb-message'=>$message);
			
			$url="http://api.txtweb.com/v1/push";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST,count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($fields));
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
			
			$result = curl_exec($ch);
			curl_close($ch);
				
			
			
			
			
		$final= "Thanks !! your question is sent for approval to the developer <br> U will  recieve confirmation soon";		
	}
	else    
	
	$final= "Sorry this question is already submitted by someone else";
return $final;
}


function question_approve($user,$question)
{	
include('appname.php');	
	$ques=mysql_real_escape_string($question);
	$res=mysql_query("SELECT * FROM questions WHERE ques='".$ques."'");
	if(mysql_num_rows($res) == 0)
	{
		$result=mysql_query("INSERT INTO questions (`qid`,`user`,`ques`) VALUES('','".$user."','".$ques."')");
		$final= "Thanks ur question <br>'". $question . "' <br><br> is approved and is LIVE !! visit ". $appname.".stats for statics of ur questions ";		
	}
	else    
	
	$final= "Your question  $question  <br><br> cannot be approved or it is subbmited by someone else pls visit @$appname.help for more help";
return $final;
}


function get_user_questions($user)
{

$res=mysql_query("SELECT ques
FROM questions
WHERE user='".$user."'");
	while($row=mysql_fetch_assoc($res))
	{	
		
		 $ques[]=$row['ques'];
				
	}
	
		 
 return (@$ques);

}


function get_uid($user)
{	
	
	$res=mysql_query("SELECT id FROM user WHERE user='".$user."'");
	$row=mysql_fetch_assoc($res);
	$id=$row['id'];
	return (@$id);
}

function get_user($id)
{	
	
	$res=mysql_query("SELECT user FROM user WHERE id='".$id."'");
	$row=mysql_fetch_assoc($res);
	$id=$row['id'];
	return (@$id);
}


function get_qid($que)
{	
	
	$res=mysql_query("SELECT qid FROM questions WHERE ques='".$que."'");
	$row=mysql_fetch_assoc($res);
	$qid=$row['qid'];
	return (@$qid);
}

function get_question($qid)
{
	$res=mysql_query("SELECT ques FROM questions WHERE qid='".$qid."'");
	$row=mysql_fetch_assoc($res);
	$ques=$row['ques'];
	return (@$ques);
	
	}

function vote_yes_percentage($qid)
{
	$res=mysql_query("SELECT * FROM votes WHERE qid='".$qid."' AND vote='1'");
	$total_yes=mysql_num_rows($res);
	$res=mysql_query("SELECT * FROM votes WHERE qid='".$qid."'");
	$total_votes=mysql_num_rows($res);
	$yes=(@($total_yes/$total_votes)*100);
	return round($yes);
}


function vote_no_percentage($qid)
{
	$res=mysql_query("SELECT * FROM votes WHERE qid='".$qid."' AND vote='0'");
	$total_no=mysql_num_rows($res);
	$res=mysql_query("SELECT * FROM votes WHERE qid='".$qid."'");
	$total_votes=mysql_num_rows($res);
	$no=(@($total_no/$total_votes)*100);
	
	return round($no);
}

function vote_yes_total($qid)
{
	$res=mysql_query("SELECT * FROM votes WHERE qid='".$qid."' AND vote='1'");
	$total_yes=mysql_num_rows($res);
	return $total_yes;
}

function vote_no_total($qid)
{

	$res=mysql_query("SELECT * FROM votes WHERE qid='".$qid."' AND vote='0'");
	$total_no=mysql_num_rows($res);
	return $total_no;
}
function add_vote($vote,$id,$qid)

{	

	$res=mysql_query("SELECT * FROM votes WHERE id='".$id."' AND qid='".$qid."'");
	if(mysql_num_rows($res) ==1 )
	$res=mysql_query("UPDATE votes SET vote='".$vote."' WHERE id='".$id."' AND qid='".$qid."'");
	
	else
	
	$res=mysql_query("INSERT INTO votes (`id`,`qid`,`vote`) VALUES ('".$id."','".$qid."','".$vote."') ");
	
	
	
if($res)
return 'Voted Successfully';
else return "Failed !! pls contect developer";
}


function get_user_name($id)
{

	$res=mysql_query("SELECT * FROM user WHERE id='".$id."'");
	$row=mysql_fetch_assoc($res);
	$user=$row['user'];
	return $user;

}



function get_user_stats_qid($mobile)
{	
	
	$res=mysql_query("SELECT * FROM questions WHERE user='".$mobile."'");
	while($row=mysql_fetch_array($res))
		{
			 $qid[]=$row['qid'];
		
			
			}
		if(!empty($qid))
			return $qid;
	}
	
	
	function get_user_stats_echo($stats,$user)
	{
		$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		if(!empty($stats))
		{
		echo "Your Questions are" . '<br>';
		foreach($stats as $qid)
		{
			echo get_question($qid);
			echo '<br> YES--';
			echo vote_yes_percentage($qid) . '%';
			echo '<br> NO--';
			echo vote_no_percentage($qid). '%';
			echo '<br>';
			}
		}
	else echo 'You havent posted any questions <br><br>pls submit ur question <br>
			  <form action='.$path.'/submit_question.php? method=get class=txtweb-form>
			  your Question<input type=text name=txtweb-message />
			  
			  <input type=hidden name=user value='.$user.'></input>
			  <input type=submit value= Submit></input>
			  </form>';
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Aditya</title>
</head>
<body>

</body>
</html>