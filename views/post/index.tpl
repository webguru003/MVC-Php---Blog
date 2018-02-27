<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comment System</title>

<link rel="stylesheet" type="text/css" href="<?php echo APP_URL;?>/includes/styles.css" />

</head>

<body>

<div id="main">
<div id="Container">
	<h2>Add Post</h2>
	<form id="addPostForm" method="post" action="">
    	<div>
        	<label for="name">Name</label>
        	<input type="text" name="name" id="name" />
            <label for="email">Email</label>
            <input type="text" name="email" id="email" />
			<input id="website" name="website" type="text" value=""  />
			<input id="url" name="url" type="hidden" value="<?php echo APP_URL;?>"  />
            <label for="message">Description</label>
            <textarea name="message" id="message" cols="50" rows="7"></textarea>
            <input type="submit" id="submit" value="Submit" />
        </div>
    </form>
</div>
<div id="comments">
<?php

/*
*	Output the posts one by one:
*/

if (!isset($noPost)):
			foreach($posts as $arr):
			echo '<div class="comment">
					<div><?php echo APP_URL;?><a href="'.APP_URL.'/post/details/'.$arr['id'].'">'.$arr['message'].'</a></div>
					<div class="postedby">Published on '.$arr['date'].' by '.$arr['name'].'</div>
				 </div>';
			endforeach;  
		 else:
		  ?>
			<div id='not_exist'><strong>There is no Post.</strong></div>
<?php endif; ?>
		
<div>


</div>


<script type="text/javascript" src="<?php echo APP_URL;?>/includes/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo APP_URL;?>/includes/script.js"></script>

</body>
</html>
