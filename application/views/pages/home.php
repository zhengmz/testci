<!--
<p>This is a Home Page.</p>
<p>site_url = <?php echo $site_url; ?></p>
<p>base_url = <?php echo $base_url; ?></p>
<p>system_url = <?php echo $system_url; ?></p>
<p>calendar </p>
<p> <?php echo $calendar; ?></p>
<p>table </p>
<p> <?php echo $table; ?></p>
-->
<p>Hello World! This is home page.</p>

<p>Output the data:</p>
<ul>
<?php foreach ($data_arr as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>
