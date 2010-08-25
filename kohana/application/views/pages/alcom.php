<?php
    $connection = new Mongo();
    $db = $connection->selectDB('nicolas');
    $collection = $db->selectCollection('blog');
	$idG = (isset($_REQUEST['value']))?strip_tags($_REQUEST['value']):'';
	$blog = $collection->findOne(array('_id'=>new MongoId($idG)));
	
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

echo"<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
echo"<tr>";
echo"<td colspan='2' style='font-family:times new roman;font-size:14px' bgcolor='lightblue'>";
echo"Viewing all comments for <div style='font-family:times new roman;font-size:22px;color:black'> ".strtoupper($blog['post']['title'])." </div>post ";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='2'>";
echo $content;
echo"</td>";
echo"</tr>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='2' bgcolor='gray' style='font-family:times new roman;font-size:22px;color:white'>";
echo"All comments ";
echo"</td>";
echo"</tr>";
for($i=0;$i<count($blog['comments']);$i++)
{
      echo"<tr>";
	  echo"<td colspan='1' width='20%' bgcolor='lightblue' style='border-left:1px solid gray;border-top:1px solid gray;border-bottom:1px solid gray'>";
	  echo "By: ".$blog['comments'][$i]['name'];
	  echo"</td>";
	  echo"<td colspan='1'  bgcolor='lightblue' style='border-top:1px solid gray;border-bottom:1px solid gray;border-right:1px solid gray'>";	
      echo $blog['comments'][$i]['comment'];
	  echo"</td>";
	  echo"</tr>";
}  

echo"</table>";
?>