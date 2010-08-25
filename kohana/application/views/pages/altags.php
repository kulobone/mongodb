<?php
    $connection = new Mongo();
    $db = $connection->selectDB('nicolas');
    $collection = $db->selectCollection('blog');
	
	$idG = (isset($_REQUEST['value']))?strip_tags($_REQUEST['value']):'';
	//$submitted = (isset($_REQUEST['sub']))?strip_tags($_REQUEST['sub']):''; 
	//$tag = (isset($_POST['tag']))?strip_tags($_POST['tag']):'';

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
echo"<span style='color:red'>Viewing all tags:</span> attached to <div style='font-family:times new roman;font-size:22px;color:black'> ".strtoupper($blog['post']['title'])." </div>post ";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='2'>";
echo $content;
echo"</td>";
echo"</tr>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='1' bgcolor='gray' style='font-family:times new roman;font-size:22px;color:white'>";
echo"<span style='color:red'>All tags:</span> ";
$num = count($blog['tag']);
$lin = --$num;
$i = 0;
  do
	{
	  echo $blog['tag'][$i];
	  $i++;
	 if($lin==$i||$lin>$i)
	  {
	   echo" | ";
	  }
	 }while($i<=$num);
  
echo"</td>";
echo"<td colspan='1' bgcolor='gray'>";
echo"";
echo"</td>";
echo"</tr>";
echo"</table>";
?>