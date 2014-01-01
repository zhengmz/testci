<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>欢迎绑定微信</title>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=2,user-scalable=no">
<style>
/*.loading-img{display: none!important;}*/
.ng-form-area {display:block!important; margin-left:5%; width: 90%; padding-top: 2%; height:100%; overflow: hidden;}
.shake-area{position: relative;}
.enter-area {position: relative;}
.enter-item {background: #fff; width: 95%; display: block; height: 20px; line-height: 20px; padding: 12px 10px; border: 1px solid #e6e6e6; border-radius: 6px; color: #333; font-size: 14px; font-weight: bold;}
.enter-item:focus {box-shadow: inset 0 0 8px #eaeaea; background: #fdfdfd;}
.first-enter-item {border-radius: 6px 6px 0 0;}
.last-enter-item { border-radius: 0 0 6px 6px; margin-top:-1px; _margin-top: -3px;}
.code-enter-item {width: 104px; display: inline-block; *display: inline; zoom: 1; vertical-align: top;}
.code-img {display: inline-block; *display: inline; zoom: 1; margin-right: 10px; width: 180px; height: 60px; border-radius: 6px; background: #ccc; vertical-align: top;}
.error-ico {display: inline-block; *display: inline; zoom: 1; width: 14px; height: 14px; vertical-align: middle; margin-right: 6px; background: -60px -39px no-repeat;}
.error-msg {color: #ff7448; vertical-align: middle; font-size: 14px;}
.placeholder {font-style: normal; color: #c2c2c2; font-size: 14px; line-height: 20px; display: inline-block; *display: inline; zoom: 1;}
.placeholder,
.error-tip {position: absolute; top: 14px; left: 10px;}
.error-tip{display: none;}
.error .error-tip{display: block; width: 300px; background:#fff;}
.error .placeholder{display: none;}
.img-code-area .placeholder,
.img-code-area .error-tip{left:204px;}
.ng-foot{height: 18px; margin-top: 16px;}
.ng-link-area {text-align: right; color: #999; position: relative; float: right; width: 95%; text-align: right;}
.ng-link-area a {color: #999;}
.ng-link-area a:hover {color: #ff7e00;}
.third-area,
.button {cursor:pointer; background: #fff; border: 1px solid #e5e5e5; border-radius: 6px; color: #7c7c7c; display: block; font-size: 16px; height: 44px; line-height: 44px; text-align: center; width: 97%;}
.button:hover {color: #333;}
.orange {background: #ff7a4d; color: #fff; border: 1px solid #ff7549;}
.orange:hover {color:#fff; background: #ff936a; border: 1px solid #ff936a;}
.orange:active {color:#fff; background: #f6683b; border: 1px solid #f6683b;}
.third-area {line-height: 60px; _line-height: 45px; position: absolute; right:2px; top: 34px; _top:35px;}
.third-area a {display: inline-block; *display: inline; zoom: 1; width: 28px; height: 28px; font-size: 0; overflow: hidden; margin: 0 4px;}
.ta-qq {background: 0 0 no-repeat;}
.ta-weibo {background: -30px 0 no-repeat;}
.ta-alipay {background: 0 -30px no-repeat;}
.ta-facebook{background: -30px -30px no-repeat;}
.third-area a.ta-facebook{display: none;}
.corner,
.corner-inner {width: 0; height: 0; border: 10px dotted transparent; overflow: hidden; position: absolute; top: -20px; right: 80px;}
.corner {border-bottom: 10px solid #d6d6d6;}
.corner-inner {border-width: 9px; border-bottom: 9px solid #fff; top: -18px; right: 81px;}
.ng-cookie-area {color: #999; vertical-align: middle; width: 100%; float: left; cursor: pointer;}
.checkbox {display: inline-block; *display: inline; zoom: 1; width: 15px; height: 15px; overflow: hidden; vertical-align: middle; margin-right: 6px; cursor: pointer; background: -60px -20px no-repeat;}
.checked {background: -60px 0 no-repeat; zoom:1;}
.shake-area,
.code-enter-item {margin-bottom: 16px;}
.button {margin: 16px 0 0 0;}
.ta-qq,.ta-weibo,.ta-alipay,.ta-facebook,.checkbox,.checked,.error-ico{background-image: url(/static/img/passport/sprite_all2.png); 
	_background-image: url(/static/img/passport/sprite_all_82.png)}
/* 第三方存在的时候支付宝不出现 */
.has_third .ta-alipay{display: none;}
.en .ng-cookie-area{width: 110px;}
.en .ng-link-area{width: 210px;}
.en a.ta-facebook,
.zh_tw a.ta-facebook{display: inline-block; *display: inline; zoom: 1;}
</style>
<style>
html,body,ul,li,p,h1,div,a,img,i,span,input,em {padding: 0; margin: 0;}
html,body {line-height: 1.5; color: #333; font-size: 14px;}
body {background: transparent; overflow: hidden;}
body,input{font-family: "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;}
a,label, :focus {outline: 0 none;}
a,img {border: 0 none;}
a {text-decoration: none;}
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {a {background-color: transparent;}}
::-ms-clear{display:none;}
::-ms-reveal{display:none;}
input::-ms-clear{display:none;}
input::-ms-reveal{display:none;}
.clearfix:after{display: block; content: "\20"; height: 0; clear: both; overflow: hidden; visibility: hidden;}/*ie8以上*/
.clearfix{*zoom:1;}/*ie6、7*/
.hide {visibility: hidden !important;}
.ng-form-area{display: none;}

</style>
  </head>
  
  <body>
  <div class="ng-form-area">
	<form action="<?=$action?>" method="post">
		<h1 class="nl-login-title">请输入您的账号进行绑定 </h1>
      <div class="shake-area" id="shake_area">
        <div class="enter-area">
		<input class="enter-item first-enter-item" name="login" type="text" value="邮箱地址/手机号码/mifi ID" />
        </div>
        <div class="enter-area">
		<input class="enter-item last-enter-item" type="text" value="账号密码" name="pwd" />
        </div>
      </div>
<div align="left" class="ng-cookie-area">登录即表示您同意遵守MIFI助手账户的<br/><a href="#">用户协议</a>和<a href="#">隐私设置</a></div>
      		<input class="button orange" type="submit" value="绑定" />
        <div align="right" class="ng-link-area">
		<a href="/wx_home/action">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">忘记密码</a>
	</div>
	</form>
  </div>
  </body>
</html>
