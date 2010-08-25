<?php
echo"All Blogs";
    $connection = new Mongo();
    $db = $connection->selectDB('nicolas');
    $collection = $db->selectCollection('blog');
	$blogs = $collection->find();
	echo"<form method='POST'  action='blog'>";

echo"<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
$idG = (isset($_REQUEST['value']))?strip_tags($_REQUEST['value']):''; 
$delete = (isset($_REQUEST['delete']))?strip_tags($_REQUEST['delete']):'';
if((isset($idG)&&(!empty($idG)))&&(isset($delete)&&(!empty($delete))))
{
    $collection->remove(array('_id'=>new MongoId($idG)), true);
  echo"You have succesfully deleted the post.";
  echo"<br /> <a href='blog'>View All Blogs</a>";
	
}
else
{
		foreach($blogs as $blog) 
	{
	echo"<tr>";
	echo"<td colspan='6'>";
	echo "<div style='font-family:times new roman;font-size:22px;color:black;border-bottom:1px solid gray;text-align:center'>Title: ".$blog['post']['title']."</div>";
	echo"<div style='font-family:times new roman;font-size:18px;color:black;'>";
	echo"Published: ".$blog['time'];
	echo"</div>";
	echo"</td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td colspan='6' >";
	echo"<span style='font=family:times new roman;font-size:18px;color:black'>Author Information</span>";
	echo"</td>";
	echo"<tr>";
	echo"<td colspan='2' valign='top' style='font=family:times new roman;font-size:15px;color:blue'>";
	echo "Username:".$blog['author']['username'].'<br />';
	echo "Last Name:".$blog['author']['lastname'].'<br />';
	echo "First Name:".$blog['author']['firstname'].'<br />';
	echo "Email:".$blog['author']['email'];
	echo"</td>";
	echo"<td colspan='2' valign='top' style='font=family:times new roman;font-size:15px;color:blue'>";
	echo "Postal Address:<br />";
	echo "P.O.Box:".$blog['author']['box'].'<br />';
	echo "Zip Code:".$blog['author']['zip'];
	echo"</td>";
	echo"<td colspan='2' valign='top' style='font=family:times new roman;font-size:15px;color:blue'>";
	echo "Residential Address:<br />";
	echo $blog['author']['streetname'].'<br />';
	echo "House Number:".$blog['author']['housenumber'].'<br />';
	echo "Town:".$blog['author']['town'].'<br />';
	echo "City:".$blog['author']['city'];
	echo"</td>";
	echo"<tr>";
	echo"<td colspan='6' align='right' style='font=family:times new roman;font-size:15px;color:black'>";
	echo "<div style='background:gray;text-align:center'>".$blog['post']['content']."</div>";
	echo"<br />";
	echo"<input type='hidden' name='values' id='values' value='".$blog['_id']."'>";
	echo"<a href='blog?value=".$blog['_id']."&delete=delete'>DELETE</a>";
	echo"</td>";
	echo"</tr>";
	echo"<tr>";
	echo"<td colspan='4' style='font=family:times new roman;font-size:15px;color:blue'>";
	$num = count($blog['tag']);
	$lin = --$num;
	$i=0;
	echo"Tags[ ";
    do
	{
	  echo $blog['tag'][$i];
	  $i++;
	 if($lin==$i||$lin>$i)
	  {
	   echo" | ";
	  }
	 }while($i<=$num);
     echo" ]";
	echo"</td>";
	echo"<td colspan='2' align='left'>";
	echo"<a href='tags?value=".$blog['_id']."'>Add a tag</a>";
	echo"<br />";
	echo"<a href='altags?value=".$blog['_id']."'>View All Tags</a>";
	echo"</td>";
	echo"<tr>";
	echo"<td colspan='6'>";
	echo"<table border='0' width='100%' cellspacing='0' cellpadding='0'>";
	echo"<tr>";
	echo"<td colspan='4' style='font=family:times new roman;font-size:20px;color:black'>";
	echo"Comments";
	echo"</td>";
	echo"<td colspan='2' align='right'>";
	echo"<a href='addcomments?value=".$blog['_id']."'>Add a comment</a>";
	echo"<br />";
	echo"<a href='alcom?value=".$blog['_id']."'>View All Comments</a>";
	echo"</td>";
	echo"</tr>";
	    $j=0;
	echo"<tr>";
	echo"<td colspan='2'>";
if(!empty($blog['comments'][0]))
	{
      echo "By: ".$blog['comments'][0]['name'];
	  echo"</td>";
	  echo"<td colspan='4'>";	
     echo $blog['comments'][0]['comment'];
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
	echo"</table>";
	echo"</form>";
?>