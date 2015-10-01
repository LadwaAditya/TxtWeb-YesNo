<?php 
include('logic.php');
include('../common/key.php');
include('appname.php');
//Get the path of the file dynamically
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

echo '<html>
<head>
<meta http-equiv=\Content-Type\' content=\'text/html; charset=UTF-8\' />
<meta name=\'txtweb-appkey\' content="'. $appkey .'">
<title> Home</title>
</head><body>';




if(isset($_GET['txtweb-mobile']))
{			

	
		if(isset($_GET['vote']) &&  isset($_GET['id']) && isset($_GET['qid']))
		{
			$db=db_connect();
			$vote=$_GET['vote'];
			$id=$_GET['id'];
			$qid=$_GET['qid'];
			echo $vote=add_vote($vote,$id,$qid);
			echo "<br><br>";
		}
		$db=db_connect();  // connect database
		$user=$_GET['txtweb-mobile'];
		user_insert($user);
		$id=get_uid($user); // get user id
		$j=total_questions(); // get total no of questons
		$ques=get_all_question(); // get all questions
				     // generate a random no within total number of questions
		$a=rand('0',$j);
		
		$que=$ques[$a];
		$qid=get_qid($que);  // get question id
		$yes_percentage=vote_yes_percentage($qid);
		$no_percentage=vote_no_percentage($qid);
		$yes_total=vote_yes_total($qid) + 500;
		$no_total=vote_no_total($qid) + 500;
		echo $que;        // echo random question
		echo '<br><br>';
		echo '<a href=' . $path . '/index.php?vote=1&qid='.$qid.'&id='.$id.'>YES</a>
		('.$yes_percentage.'%)('.$yes_total.'Votes)';
		echo '<br>';
		echo '<a href=' . $path . '/index.php?vote=0&qid='.$qid.'&id='.$id.'>NO</a>
		('.$no_percentage.'%)('.$no_total.'Votes)';
		echo '<br>';
		echo '<a href='.$path.'/index.php>SKIP</a>';
		
		echo '<br><br>Pls submit ur question <br>
			  <form action='.$path.'/submit_question.php? method=get class=txtweb-form>
			  Your Question<input type=text name=txtweb-message />
			  
			  <input type=hidden name=user value='.$user.'></input>
			  <input type=submit value= Submit></input>
			  </form>';
			 

	}

else
 echo "Visit from txtweb";
 


echo '</body></html>';

?>