<p>Hello World! This is home page.</p>

<p>Output the data:</p>
<ul>
<?php foreach ($data_arr as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>
