<html>
<head>
<title>My Form</title>
</head>
<body>

<!-- <?php echo validation_errors(); ?> -->

<?php echo form_open('form'); ?>

<h5>Captcha</h5>
<?php echo form_error('captcha', '<div class="error">', '</div>'); ?>
<input type="text" name="captcha" value="<?php echo set_value('captcha'); ?>" size="50" />
<?php echo $cap['image']; ?>

<h5>Username</h5>
<?php echo form_error('username', '<div class="error">', '</div>'); ?>
<input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" />

<h5>Password</h5>
<?php echo form_error('password'); ?>
<input type="text" name="password" value="<?php echo set_value('password'); ?>" size="50" />

<h5>Password Confirm</h5>
<?php echo form_error('passconf'); ?>
<input type="text" name="passconf" value="<?php echo set_value('passconf'); ?>" size="50" />

<h5>Email Address</h5>
<?php echo form_error('email'); ?>
<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" />

<h5>Checkbox</h5>
<?php echo form_error('mycheck[]'); ?>
<input type="checkbox" name="mycheck[]" value="1" <?php echo set_checkbox('mycheck[]', '1'); ?> />
<input type="checkbox" name="mycheck[]" value="2" <?php echo set_checkbox('mycheck[]', '2'); ?> />

<h5>Radio</h5>
<?php echo form_error('myradio'); ?>
<input type="radio" name="myradio" value="1" <?php echo set_radio('myradio', '1'); ?> />
<input type="radio" name="myradio" value="2" <?php echo set_radio('myradio', '2'); ?> />

<h5>Selects</h5>
<?php echo form_error('myselects'); ?>
<select name="myselect">
<option value="one" <?php echo set_select('myselect', 'one'); ?> >One</option>
<option value="two" <?php echo set_select('myselect', 'two'); ?> >Two</option>
<option value="three" <?php echo set_select('myselect', 'three'); ?> >Three</option>
</select>

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
