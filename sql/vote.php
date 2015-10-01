<?php 

include('logic.php');
include('../common/key.php');
include('appname.php');

echo '<html>
<head>
<meta http-equiv=\Content-Type\' content=\'text/html; charset=UTF-8\' />
<meta name=\'txtweb-appkey\' content="'. $appkey .'">
<title> Home</title>
</head><body>';


$db=db_connect();
$vote=$_GET['vote'];
$id=$_GET['id'];
$qid=$_GET['qid'];
echo $vote=add_vote($vote,$id,$qid);



echo '</body></html>';

?>