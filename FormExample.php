<?php
/**
@author (Developed by) : Ugurkan (Kingofseo)
@date  : 21.11.2014 Friday
List questions with the answers powered by Question2answer should work with all with no much at all big changes on the theme.
**/
ob_start();
header("Content-type:text/html; charset=utf8");
require("Q2A.php");
$page=!empty($_GET["page"]) && is_numeric($_GET["page"]) ? trim($_GET["page"]) : "1";
$order=!empty($_GET["order"]) ? trim($_GET["order"]) : "recent";
$kingofseo=new q2a(["site" => "http://www.question2answer.org/qa", "page" => $page]);
if($_GET)
{
$questions=$kingofseo->list_questions($order, true);
if($questions["ugurkan"])
{
echo "Found total : <strong>{$questions["ugurkan"]["count"]} </strong> question(s) <br />";
foreach($questions["ugurkan"] as $question)
{
echo $question["title"]."<br />";
}
$_GET["page"]=$_GET["page"]+1;
echo '<a href="Example.php?'.http_build_query($_GET).'"> Jump to page : '.$_GET["page"]."</a>";
}else
{
exit("Couldn't receive the questions");
}
die();
}
?>

<form action="Example.php" method="GET">
<strong> Sort question(s) by </strong> :
<select name="order" size="1">
<?php
foreach(array_keys($kingofseo->_uri_routes) as $key) : 
?>
<option value="<?php echo $key;?>"> <?php echo ucfirst($key);?> </option>
<?php endforeach; ?>
</select>

<strong> Page </strong> :
<select name="page" size="1">
<?php
for($u=1; $u<=40; $u++) : 
?>
<option value="<?php echo $u;?>"> <?php echo $u;?> </option>
<?php endfor; ?>
</select>

<input type="submit" value="Go ahead">

</form>
