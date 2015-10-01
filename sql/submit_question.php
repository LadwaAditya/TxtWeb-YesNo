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




if(isset($_GET['txtweb-message']) && strlen($_GET['txtweb-message']) > 7)
{
$question=$_GET['txtweb-message'];
$db=db_connect();
$user=$_GET['user'];

$result=question_submit($user,$question);

echo $result;
}
else echo "Sorry its a spam... visit @$appname.help";


echo '</body></html>';

?>