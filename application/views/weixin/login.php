<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>欢迎绑定微信</title>
<style>
html,body,ul,li,p,h1,div,a,img{padding: 0; margin: 0;}
html,body{background:#f9f9f9; line-height: 1.5; color: #333; font-size: 14px;}
body,input{font-family: "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;}
.button {cursor:pointer; background: #fff; border: 1px solid #e5e5e5; border-radius: 6px; color: #7c7c7c; display: block; font-size: 16px; height: 44px; line-height: 44px; text-align: center; width: 320px;}
.button:hover {color: #333;}
.button {margin: 16px 0 0 0;}
input::-ms-clear{display:none;}
input::-ms-reveal{display:none;}
.orange {background: #ff7a4d; color: #fff; border: 1px solid #ff7549;}
.orange:hover {color:#fff; background: #ff936a; border: 1px solid #ff936a;}
.orange:active {color:#fff; background: #f6683b; border: 1px solid #f6683b;}
.enter-item {background: #fff; width: 298px; display: block; height: 20px; line-height: 20px; padding: 12px 10px; border: 1px solid #e6e6e6; border-radius: 6px; color: #333; font-size: 14px; font-weight: bold;}
.enter-item:focus {box-shadow: inset 0 0 8px #eaeaea; background: #fdfdfd;}
.first-enter-item {border-radius: 6px 6px 0 0;}
.last-enter-item { border-radius: 0 0 6px 6px; margin-top:-1px; _margin-top: -3px;}
.ng-form-area {display:block!important; margin-left:40px; width: 324px; padding-top: 10px; height:330px; overflow: hidden;}
.ng-form-area{display: none;}
</style>
  </head>
  
  <body>
  <div class="ng-form-area">
	<form action="<?=$action?>" method="post">
	<table width="95%" border="0" align="center">
	<tr align="center"><td style="height: 40px;">
		请输入您的账号进行绑定
	</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr align="center"><td style="height: 40px;">
		<input class="enter-item first-enter-item" name="login" type="text" value="邮箱地址/手机号码/mifi ID" />
	</td></tr>
	<tr align="center"><td style="height: 40px;">
		<input class="enter-item last-enter-item" type="text" value="账号密码" name="pwd" />
	</td></tr>
        <tr><td style="height: 40px;">
		<div style="padding-top: 10px; padding-left: 3%; ">
                登录即表示您同意遵守MIFI助手账户的<br/><a href="#">用户协议</a>和<a href="#">隐私设置</a>
		</div>
	</td></tr>
	<tr align="center"><td style="height: 40px;">
      		<input class="button orange" type="submit" value="绑定" />
        </td></tr>
	<tr><td>
		<div align="right" style="padding-top: 10px; padding-right: 3%;">
		<a href="/wx_home/action">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">忘记密码</a>
		</div>
	</td></tr>
	</table>
	</form>
  </div>
  </body>
</html>
