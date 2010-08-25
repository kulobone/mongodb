<?php
    $connection = new Mongo();
    $db = $connection->selectDB('nicolas');
    $collection = $db->selectCollection('blog');
	
	//$idG = (isset($_REQUEST['value']))?strip_tags($_REQUEST['value']):'';
	//$submitted = (isset($_REQUEST['sub']))?strip_tags($_REQUEST['sub']):''; 
	$author = (isset($_POST['author']))?strip_tags($_POST['author']):'';
	
echo"<form method='POST' action='".$_SERVER["PHP_SELF"]."'>";
echo"<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
echo"<tr>";
echo"<td colspan='1' width='65%' bgcolor='lightblue'>";
echo"Enter the USER NAME of the author in order to view all posts posted by that author:";
echo"</td>";
echo"<td colspan='1' style='font-family:times new roman;font-size:14px'>";
echo"<input type='text' id='author' name='author'>";
echo"<input type='submit' value='Search'>";
echo"</td>";
echo"</tr>";
if(isset($author)&&(!empty($author)))
{
$authorBlogs = $collection->find();
//$authorBlogs = $collection->find(array("author"=>array("username"=>$author)));
echo"<tr>";
echo"<td colspan='2' width='35%' style='font-family:times new roman;font-size:24px'>";
echo"<br />";
echo"Viewing all posts by:";
echo strtoupper($author);
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan='2'>";
echo"<table border='0' cellspacing='0' cellpadding='0' width='100%'>";   
foreach($authorBlogs as $value)
{
if($value['author']['username']==$author)
 {
   
    echo"<tr>";
	echo"<td colspan='6'>";
	echo "<div style='font-family:times new roman;font-size:22px;color:black;border-bottom:1px solid gray;text-align:center'>Title: ".$value['post']['title']."</div>";
	echo"<div style='font-family:times new roman;font-size:18px;color:black;'>";
	echo"Published: ".$value['time'];
	echo"</div>";
	echo"</td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td colspan='6' >";
	echo"<span style='font=family:times new roman;font-size:18px;color:black'>Author Information</span>";
	echo"</td>";
	echo"<tr>";
	echo"<td colspan='2' valign='top' style='font=family:times new roman;font-size:15px;color:blue'>";
	echo "Username:".$value['author']['username'].'<br />';
	echo "Last Name:".$value['author']['lastname'].'<br />';
	echo "First Name:".$value['author']['firstname'].'<br />';
	echo "Email:".$value['author']['email'];
	echo"</td>";
	echo"<td colspan='2' valign='top' style='font=family:times new roman;font-size:15px;color:blue'>";
	echo "Postal Address:<br />";
	echo "P.O.Box:".$value['author']['box'].'<br />';
	echo "Zip Code:".$value['author']['zip'];
	echo"</td>";
	echo"<td colspan='2' valign='top' style='font=family:times new roman;font-size:15px;color:blue'>";
	echo "Residential Address:<br />";
	echo $value['author']['streetname'].'<br />';
	echo "House Number:".$value['author']['housenumber'].'<br />';
	echo "Town:".$value['author']['town'].'<br />';
	echo "City:".$value['author']['city'];
	echo"</td>";
	echo"<tr>";
	echo"<td colspan='6' align='right' style='font=family:times new roman;font-size:15px;color:black'>";
	echo "<div style='background:gray;text-align:center'>".$value['post']['content']."</div>";
	echo"<br />";
	echo"<input type='hidden' name='values' id='values' value='".$value['_id']."'>";
	echo"<a href='blog?value=".$value['_id']."&delete=delete'>DELETE</a>";
	echo"</td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td colspan='4' style='font=family:times new roman;font-size:15px;color:blue'>";
	$num = count($value['tag']);
	$lin = --$num;
	$i=0;
	echo"Tags[ ";
    do
	{
	  echo $value['tag'][$i];
	  $i++;
	 if($lin==$i||$lin>$i)
	  {
	   echo" | ";
	  }
	 }while($i<=$num);
     echo" ]";
	echo"</td>";
	echo"<td colspan='2' align='left'>";
	echo"<a href='tags?value=".$value['_id']."'>Add a tag</a>";
	echo"<br />";
	echo"<a href='altags?value=".$value['_id']."'>View All Tags</a>";
	echo"</td>";
	echo"<tr>";
	echo"<td colspan='6'>";
	echo"<table border='0' width='100%' cellspacing='0' cellpadding='0'>";
	echo"<tr>";
	echo"<td colspan='4' style='font=family:times new roman;font-size:20px;color:black'>";
	echo"Comments";
	echo"</td>";
	echo"<td colspan='2' align='right'>";
	echo"<a href='addcomments?value=".$value['_id']."'>Add a comment</a>";
	echo"<br />";
	echo"<a href='alcom?value=".$value['_id']."'>View All Comments</a>";
	echo"</td>";
	echo"</tr>";
	    $j=0;
	echo"<tr>";
	echo"<td colspan='2'>";
if(!empty($value['comments'][0]))
	{
      echo "By: ".$value['comments'][0]['name'];
	  echo"</td>";
	  echo"<td colspan='4'>";	
     echo $value['comments'][0]['comment'];
	  echo"</td>";  
	 }
	 else
	 {
	    echo"&nbsp";
        echo"</td>";
	    echo"<td colspan='4'>";
	    echo"No comments";
	    echo"</td>";
	 }
	echo"</tr>";
	echo"</table>";
	echo"</td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td colspan='6' style='border-bottom:1px solid gray;'>";
   	echo"</td>";
	echo"</tr>";
	}
 }

}

echo"</table>";
echo"</td>";
echo"</tr>";
echo"</table>";
echo"</form>";
?>