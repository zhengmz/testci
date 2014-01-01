<!DOCTYPE html>
<html>
<head>
<title>欢迎绑定微信</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2, user-scalable=no">
<style>
	.form_area {display:block!important; margin-left:5%; width: 90%; padding-top: 2%; height:100%; overflow: hidden;}
	.input_item {background: white; width: 95%; display: block; height: 30px; line-height: 1.5; padding: 1% 1%; border: 1px solid #e6e6e6; border-radius: 6px; color: #333; font-size: 18px; font-weight: bold;}
	.input_item:focus {box-shadow: inset 0 0 8px #eaeaea; background: #fdfdfd;}
	.top_input_item {border-radius: 6px 6px 0 0;}
	.bottom_input_item { border-radius: 0 0 6px 6px; margin-top:-1px; _margin-top: -3px;}
	.title_text {display:block; font-size: 20px; line-height: 2; color: #000;}
	.normal_text {color: #999; vertical-align: middle; }
	.button {background: #fff; border: 1px solid #e5e5e5; border-radius: 6px; color: white; display:block; font-size: 18px; height: 44px; line-height: 2; text-align: center; width: 97%;}
	.button:hover {color: #333;}
	.orange {background: #ff7a4d; color: #fff; border: 1px solid #ff7549;}
	.orange:hover {color:white; background: #ff936a; border: 1px solid #ff936a;}
	.orange:active {color:white; background: #f6683b; border: 1px solid #f6683b;}
	</style>
	<style>
	html,body,ul,li,p,h1,div,a,img,i,span,input,em {padding: 0; margin: 0;}
	html,body {line-height: 1.5; color: #333; font-size: 16px;}
	body {background: transparent; overflow: hidden;}
	body,input{font-family: "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;}
	a,label, :focus {outline: 0 none;}
	a,img {border: 0 none;}
	a {color: blue;}
	a:hover {color: red;}
</style>
<script>
	function set_html(name,value){
		document.getElementById(name).innerHTML=value;
	}
	
	function valid_form(form){
		with(form) {
			var flag = true;
			if(login.value == "" || login.value == "邮箱地址/手机号码/mifi ID"){
				set_html("txtinfo", "账号不能为空");
				flag = false;
			}else{
				set_html("txtinfo", "");
			} 

			if(pwd.value == "" || pwd.value == "账号密码"){
				set_html("txtpwd", "密码不能为空");
				flag = false;
			}else{
				set_html("txtpwd", "");
			}
		}
		return flag;
	}
</script>
</head>

<body>
<div class="form_area">
<form action="<?=$action?>" method="post"  onsubmit="return valid_form(this)">
	<p class="title_text">请输入您的账号进行绑定 </p>
	<input class="input_item top_input_item" name="login" type="text" onFocus="if(value==default_login){value='';this.style.color='#000'}" onBlur="if(value==''){value=default_login;this.style.color='#999'}" />
	<span id="txtinfo" style="color:red;" ></span>
	<input class="input_item bottom_input_item" type="text" name="pwd" onFocus="if(value==default_pwd){value='';this.style.color='#000'}" onBlur="if(value==''){value=default_pwd;this.style.color='#999'}" />
	<span id="txtpwd" style="color:red;" ></span>
	<div align="left" class="normal_text">
		登录即表示您同意遵守MIFI助手账户的<br/><a href="#">用户协议</a>和<a href="#">隐私设置</a>
	</div>
      	<input class="button orange" type="submit" value="绑定" />
	<div align="right" class="normal_text">
		<a href="/wx_home/action">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">忘记密码</a>
	</div>
</form>
</div>
<script>
	var default_login="邮箱地址/手机号码/mifi ID";
	var default_pwd="账号密码";
	document.getElementById("login").value=default_login;
	document.getElementById("pwd").value=default_pwd;
</script>
</body>
</html>
