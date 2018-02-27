<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comment System</title>

<link rel="stylesheet" type="text/css" href="<?php echo APP_URL;?>/includes/styles.css" />

</head>

<body>

<div id="main">

<?php
if(!isset($noPost)):
?>
		
<h2>
	<?php echo $message;?>
	<div style='font-size:10px; color:gray; padding-bottom:20px;'>Published on <?php echo $date;?> by <?php echo $name;?></div>
</h2>


<div id="comment_show">
<strong style='color:gray;'>Comments:</strong>
<?php

/*
/	Output the comment one by one:
*/
if(!empty($comment_list)):
foreach($comment_list as $arr):
	echo '<div class="comment">
		<div>'.$arr['message'].'</div>
		<div class="postedby">Published on '.$arr['date'].' by '.$arr['name'].'</div>
		</div>';

	endforeach;
else:
	echo "<div id='not_exist'>No comment exists</div>";
endif;
?>
<div>

<div id="Container">
	<p>Write a Comment</p>
	<form id="addCommentForm" method="post" action="">
    	<div>
        	<label for="name">Name</label>
        	<input type="text" name="name" id="name" />
            <label for="email">Email</label>
            <input type="text" name="email" id="email" />
            <label for="message">Message</label>
            <textarea name="message" id="message" cols="40" rows="5"></textarea>
			<input id="website" name="website" type="text" value=""  />
			<input id="url" name="url" type="hidden" value="<?php echo APP_URL;?>"  />
			<input type='hidden' name='post_id' id="post_id" value="<?php echo $post_id;?>" />
            <input type="submit" id="submit" value="Submit" />
        </div>
    </form>
</div>
<?php
 else:
?>
			<div id='not_exist'><strong>There is no Post.</strong></div>
<?php endif; ?>
</div>
<script type="text/javascript" src="<?php echo APP_URL;?>/includes/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo APP_URL;?>/includes/script.js"></script>

</body>
</html>
