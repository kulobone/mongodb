<?php
    $connection = new Mongo();
    $db = $connection->selectDB('nicolas');
    $collection = $db->selectCollection('blog');
	
	$idG = (isset($_REQUEST['value']))?strip_tags($_REQUEST['value']):'';
	$submitted = (isset($_REQUEST['sub']))?strip_tags($_REQUEST['sub']):''; 
	$username = (isset($_POST['username']))?strip_tags($_POST['username']):'';
	$contents = (isset($_POST['comment']))?strip_tags($_POST['comment']):'';

    $blog = $collection->findOne(array('_id'=>new MongoId($idG)));
	 
echo"<form method='POST' action='".$_SERVER["PHP_SELF"]."?value=$idG&sub=comment'>";
echo"<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
if((isset($idG)&&(!empty($idG))&&(isset($submitted))&&(!empty($submitted)) &&($username!='')&&($contents!='')) )
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
  $tags = $blog['tag'][0];
  $tag1 = $blog['tag'][1];
  $timeStamp = $blog['time'];
  $collection->update(array(
  "author"=>array("username"=>"$uname","firstname"=>"$fname","lastname"=>"$lname","email"=>"$email","box"=>"$box","zip"=>"$zip","streetname"=>"$street","housenumber"=>"$house","town"=>"$town","city"=>"$city"),
  "post"=>array("title"=>"$title","content"=>"$content"),
  "tag"=>array("$tags","$tag1"),"time"=>"$timeStamp" 
  ),array('$push'=>array("comments"=>array("name"=>"$username","comment"=>"$contents"))));
  echo "You have successfully added a comment.<br />By:$username <br />Comment:$contents <br />go to the <a href='blog'>Home </a>page";
  }
else 
{
echo"<tr>";
echo"<td colspan='2' style='font-family:times new roman;font-size:15px' bgcolor='lightblue'>";
echo"<div style='font-family:times new roman;font-size:22px;color:black'>Add a comment to ".strtoupper($blog['post']['title'])." POST</div> ";
echo"<br />ALL FIELDS ARE REQUIRED!";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='1' bgcolor='gray'>";
echo"Username";
echo"</td>";
echo"<td colspan='1' bgcolor='gray'>";
echo"<input type='text' name='username' id='username'>";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='1' valign='top' bgcolor='gray'>";
echo"Content";
echo"</td>";
echo"<td colspan='1' bgcolor='gray'>";
echo"<textarea rows='10' cols='18' name='comment' id='comment'>";
echo"</textarea>";
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