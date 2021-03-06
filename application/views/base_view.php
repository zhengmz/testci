<!DOCTYPE html>
<html>
<head>
<title><?php echo isset($title)? $title : '结果显示界面' ?></title>
<meta charset="UTF-8">
<meta http-equiv="pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate"> 
<meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=3" >
<style>
	.contents {
		display:block!important;
		margin-left:3%;
		width: 94%;
		padding-top: 2%;
	}

@media handheld 
{
	.contents {
		display:block!important;
		margin-left:3%;
		width: 94%;
		padding-top: 2%;
	}
}

	body
	{
		padding: 0;
		margin: 0;
		font-size: 125%;
		font-family: "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", "sans-serif";
		font-weight: normal;
		line-height: 1.5; 
		width: 100%;
	}
	pre {white-space: pre-wrap; word-wrap:break-word;}
	h1 {display:block; font-size: 1.2em; line-height: 2; color: black; font-weight: bold;}
	a,label, :focus {outline: 0 none;}
	a,img {border: 0 none;}
	a {color: blue;}
	a:hover {color: red;}
</style>
</head>

<body>
<div class="contents">
<h1>Hello <?php echo isset($title)? $title : '结果显示界面' ?>!</h1>
<hr style="width:100%;"/>

<table width=100%><tr>
<td align="left">Output is:</td>
<td align="right">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></td>
</tr></table>

<ul>
<?php foreach ($output as $item => $value):?>
<li><?php echo $item;?>: <br><pre><?php print_r($value)?></pre></li>
<?php endforeach; ?>
</ul>
</div>
</body>
</html>
