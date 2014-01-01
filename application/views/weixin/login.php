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
input::-ms-clear{display:none;}
input::-ms-reveal{display:none;}
</style>
  </head>
  
  <body>
	<form action="<?=$action?>" method="post">
	<table width="95%" border="0" align="center">
	<tr align="center"><td style="height: 40px;">
		<font size="14px">请输入您的账号进行绑定</font>
	</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr align="center"><td style="height: 40px;">
		<input class="login" name="login" type="text" value="邮箱地址/手机号码/mifi ID">
	</td></tr>
	<tr align="center"><td style="height: 40px;">
		<input class="pwd" type="text" value="账号密码" name="pwd" >
	</td></tr>
        <tr><td style="height: 40px;">
		<div style="padding-top: 10px; padding-left: 3%; ">
                登录即表示您同意遵守MIFI助手账户的<br/><a href="#">用户协议</a>和<a href="#">隐私设置</a>
		</div>
	</td></tr>
	<tr align="center"><td style="height: 40px;">
        	<input class="btn" type="submist" value="绑定">
        </td></tr>
	<tr><td>
		<div align="right" style="padding-top: 10px; padding-right: 3%;">
		<a href="/wx_home/action">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">忘记密码</a>
		</div>
	</td></tr>
	</table>
	</form>
  </body>
</html>
