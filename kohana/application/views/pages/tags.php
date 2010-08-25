<?php
    $connection = new Mongo();
    $db = $connection->selectDB('nicolas');
    $collection = $db->selectCollection('blog');

	$idG = (isset($_REQUEST['value']))?strip_tags($_REQUEST['value']):'';
	$submitted = (isset($_REQUEST['sub']))?strip_tags($_REQUEST['sub']):''; 
	$tag = (isset($_POST['tag']))?strip_tags($_POST['tag']):'';

    $blog = $collection->findOne(array('_id'=>new MongoId($idG)));
	 
echo"<form method='POST' action='".$_SERVER["PHP_SELF"]."?value=$idG&sub=tag'>";
echo"<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
if(isset($idG)&&(!empty($idG))&&(isset($submitted))&&(!empty($submitted)) &&($tag!='') )
{
  $uname = $blog['author']['username'] ;
  $fname = $blog['author']['firstname'];
  $lname = $blog['author']['lastname'];
  $email = $blog['author']['email'];
  $box = $blog['author']['box'];
  $zip = $blog['author']['zip'];
  $street = $blog['author']['streetname'];
  $house = $blog['author']['housenumber'];
  $town = $blog['author']['town'];
  $city = $blog['author']['city'];
  $title = $blog['post']['title'];
  $content = $blog['post']['content'];
  
  $timeStamp = $blog['time'];
  $collection->update(array( "author"=>array("username"=>"$uname","firstname"=>"$fname","lastname"=>"$lname","email"=>"$email","box"=>"$box","zip"=>"$zip","streetname"=>"$street","housenumber"=>"$house","town"=>"$town","city"=>"$city"),
  "post"=>array("title"=>"$title","content"=>"$content"),
  "time"=>"$timeStamp" 
  ),array('$push'=>array("tag"=>"$tag")));
  
  echo "You have successfully added a.<br />to view your comment go to the <a href='blog'>Home </a>page";
  }
else 
{
echo"<tr>";
echo"<td colspan='2' style='font-family:times new roman;font-size:15px' bgcolor='lightblue'>";
echo"<div style='font-family:times new roman;font-size:22px;color:black'>Add a tag to ".strtoupper($blog['post']['title'])." POST</div> ";
echo"<br />You can only add one tag at a time!";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='1' bgcolor='gray'>";
echo"Tag";
echo"</td>";
echo"<td colspan='1' bgcolor='gray'>";
echo"<input type='text' name='tag' id='tag'>";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='2' style='border-bottom:1px solid gray' bgcolor='gray'>";
echo"<input type='submit' name='sub' id='sub' value='Enter'>";
echo"</td>";
echo"</tr>";
}
echo"</table>";
echo"</form>";
?>