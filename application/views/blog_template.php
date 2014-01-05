<html>
<head>
	<meta charset="utf-8">
	<title>{blog_title}</title>
<meta http-equiv="pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate"> 
<meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=3" >

<style>
	.blog_body {
		display:block!important;
		margin-left:3%;
		width: 94%;
		padding-top: 2%;
		margin-bottom:20px;
		background: #ff7a4d;
		color: white;
		border: 1px solid #ff7549;
		white-space: pre-wrap;
	}
	html,body,ul,li,p,h1,div,a,img,i,span,input,em
	{
		margin-left:3%;
		padding: 0;
		font-size: 16px;
		font-family: "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", "sans-serif";
		font-weight: normal;
		line-height: 1.5; 
		width: 94%;
	}
	h1 {display:block; font-size: 20px; line-height: 2; color: black; font-weight: bold;}
	a,label, :focus {outline: 0 none;}
	a,img {border: 0 none;}
	a {color: blue;}
	a:hover {color: red;}
</style>
</head>
<body>

<h3>{blog_heading}</h3>

{blog_entries}
<div class='blog_body'>
<h5>{title}</h5>
<p>{body}</p>
</div>
{/blog_entries}
</body>
</html>
