<html>
<head>
<title>My Form</title>
</head>
<body>

<?php echo form_open('cache_test'); ?>

<h5>Username</h5>
<input type="text" name="user" value="<?=$user?>" size="50" />

<h5>Password</h5>
<input type="text" name="pwd" value="<?=$pwd?>" size="50" />

<h5>Email Address</h5>
<input type="text" name="email" value="<?=$email?>" size="50" />

<h5>only cache username</h5>

<div><input type="submit" value="Submit" /></div>

<?php echo form_close(); ?>

</body>
</html>
