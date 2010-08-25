<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo html::stylesheet(
    array
    (
        'media/css/site',
    ),
    array
    (
        'screen',
    )
);
?>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $title ?></title>
</head>
<body>
<table border='0' width='70%' cellspacing='0' align='center' cellspadding='0'>
<tr>
<td>
    <h3>Mongodb Project</h3>
</td>
</tr>
<tr>
<td>
    <ul>
        <?php foreach ($links as $link => $url): ?>
        <?php echo html::anchor($url, $link) ?> &nbsp 
        <?php endforeach ?>
    </ul>
</td>
</tr>
<tr>
<td>
    <?php echo $content ?>
</td>
</tr>
</body>
</html>

