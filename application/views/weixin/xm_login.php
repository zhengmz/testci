<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>小米帐户 - 登录</title>
<style>
/*.loading-img{display: none!important;}*/
.ng-form-area {display:block!important; margin-left:40px; width: 324px; padding-top: 10px; height:330px; overflow: hidden;}
.shake-area{position: relative;}
.enter-area {position: relative;}
.enter-item {background: #fff; width: 298px; display: block; height: 20px; line-height: 20px; padding: 12px 10px; border: 1px solid #e6e6e6; border-radius: 6px; color: #333; font-size: 14px; font-weight: bold;}
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
.ng-link-area {text-align: right; color: #999; position: relative; float: right; width: 180px; text-align: right;}
.ng-link-area a {color: #999;}
.ng-link-area a:hover {color: #ff7e00;}
.third-area,
.button {cursor:pointer; background: #fff; border: 1px solid #e5e5e5; border-radius: 6px; color: #7c7c7c; display: block; font-size: 16px; height: 44px; line-height: 44px; text-align: center; width: 320px;}
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
.ng-cookie-area {color: #999; vertical-align: middle; width: 120px; float: left; cursor: pointer;}
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
html,body {line-height: 1.5; color: #333; font-size: 12px;}
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
  <div class="ng-form-area show-place" id="form-area">
    <form method="post" action="/pass/serviceLoginAuth2" id="miniLogin" onsubmit="return MiniLogin.validateForm();">
      <div class="shake-area" id="shake_area">
        <div class="enter-area">
          <input type="text" class="enter-item first-enter-item" id="miniLogin_username" data-rule="(^[\w.\-]+@(?:[a-z0-9]+(?:-[a-z0-9]+)*\.)+[a-z]{2,6}$)|(^1[3|4|5|8]\d{9}$)|(^\d{3,}$)|(^\++\d{2,}$)" autocomplete="off"/>
          <i class="placeholder hide" id="message_INPUT_IDENTITY">邮箱/手机号码/小米ID</i>
          <span class="error-tip"><em class="error-ico"></em><span class="error-msg"></span></span>
        </div>
        <div class="enter-area">
          <input type="password" class="enter-item last-enter-item" id="miniLogin_pwd" autocomplete="off" data-rule="" />
          <i class="placeholder hide" id="message_INPUT_PASSWORD">密码</i>
          <span class="error-tip"><em class="error-ico"></em><span class="error-msg"></span></span>
        </div>
      </div>
      <div class="enter-area img-code-area" id="img_code_area" style="display:none;">
        <img src="" class="code-img" id="code_img" />
        <input type="text" class="enter-item code-enter-item" id="miniLogin_captCode" autocomplete="off" />
        <i class="placeholder hide" id="message_INPUT_CONFIRM">验证码</i>
        <span class="error-tip"><em class="error-ico"></em><span class="error-msg" id="code_error_tips"></span></span>
      </div>

      <input class="button orange" type="submit" id="message_LOGIN_IMMEDIATELY" value="立即登录" />
      <div class="ng-foot clearfix">
        <div class="ng-cookie-area" id="cookie_area">
          <input type="hidden" id="auto" /><em class="checkbox" id="checkbox_item"></em><span id="message_AUTOLOGIN_TWOWEEKS">两周内自动登录</span>
        </div>
        <div class="ng-link-area">
          <a href="javascript:void(0);" id="other_method">其他方式登录</a> | <a href="/pass/forgetPassword" id="message_FORGET_PASSWORD" target="_blank">忘记密码?</a>
          <div class="third-area hide" id="third_area">
            <a class="ta-qq" href="" id="miniLogin_third_qq" target="_blank" title="QQ">QQ</a>
            <a class="ta-weibo" href="" id="miniLogin_third_sina" target="_blank" title="weibo">weibo</a>
            <a class="ta-alipay" href="" id="miniLogin_third_alipay" target="_blank" title="alipay">alipay</a>
            <a class="ta-facebook" href="" id="miniLogin_third_facebook" target="_blank" title="facebook">facebook</a>
            <em class="corner"></em>
            <em class="corner-inner"></em>
          </div>
        </div>
      </div>
      <a href="/pass/register" class="button" id="message_REGISTER" target="_blank">注册小米帐户</a>
      <a style="display:none" id="redirectLink" href="" target="_top"></a>
      <a style="display:none" id="redirectTwoPhraseLoginLink" href=""></a>
    </form>
  </div>
</body>
<script>

  if (location.host.indexOf('preview') < 0) {
      document.domain = "xiaomi.com";
  }
    
  var MDom = {

    getID : function(id) {
        return document.getElementById(id);
    },
    hasClass : function(ele, cls) {
      var classes = ele.className.split(/\s+/);
      for(var i = 0; i <classes.length; i++){
        if(classes[i] == cls){
          return true;
        }
      }
      return false;
    },
    addClass : function(ele, cls) {
      if(!this.hasClass(ele, cls)){
        var classes = MDom.trim( ele.className );
        classes = classes.replace(/\s+/,' ');
        ele.className = classes + ' ' +cls;
      }
    },
    removeClass : function(ele, cls) {
      if(this.hasClass(ele, cls)){
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)','g');
        var classes = ele.className.replace(reg,' ');
        classes = MDom.trim( classes );
        ele.className = classes.replace(/\s+/,' ');
      }      
    },
    className : function(n) {
        var el = [], _el = document.getElementsByTagName('*');
        for (var i = 0; i < _el.length; i++) {
            if (_el[i].className == n) {
                el[el.length] = _el[i];
            }
        }
        return el;
    },
    trim : function(str) {
        return str.replace(/(^\s*)|(\s*$)/g, "");
    },
    bind : function(oTarget, sEventType, fnHandler) {
        if (oTarget.addEventListener) {//firefox
            oTarget.addEventListener(sEventType, fnHandler, false);
        } else if (oTarget.attachEvent) {//IE
            oTarget.attachEvent("on" + sEventType, fnHandler);
        } else {
            oTarget["on" + sEventType] = fnHandler;
        }
    },
    unbind : function(oTarget, sEventType, fnHandler) {
        if (oTarget.removeEventListener) {//firefox
            oTarget.removeEventListener(sEventType, fnHandler, false);
        } else if (oTarget.detachEvent) {//IE
            oTarget.detachEvent("on" + sEventType, fnHandler);
        } else {
            oTarget["on" + sEventType] = null;
        }
    },
    json2str : function(o) {
        var arr = [];
        var fmt = function(s) {
            if ( typeof s == 'object' && s != null)
                return json2str(s);
            //return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s;
            return s;
        };
        //for (var i in o) arr.push("'" + i + "'=" + fmt(o[i]));
        for (var i in o)
        arr.push(i + "=" + fmt(o[i]));
        //return '{' + arr.join(',') + '}';
        return arr.join('&');
    },
    /* 在规定的父级里面查找某个对应class的元素。这里的class在某个父级里面不能存在有多个。 */
    findEle : function(dom,element,cls){
     var collect = dom.getElementsByTagName(element);
     for(var i = 0; i < collect.length; i++){
       if( MDom.hasClass(collect[i],cls) ){
         return collect[i];
       }
      }
    },
    funPlaceholder : function(element) {
      var father = element.parentNode,
          placeItem = MDom.findEle(father,'i','placeholder');
      var _this =this;
      MDom.bind( placeItem,'click', function(){
        element.focus();
      });
      element.onfocus = function(){
        MDom.addClass( placeItem, 'hide');
      };
      //这里的值要做trim
      element.onblur = function(){  
        var Value = _this.trim(this.value);  
        if (Value == "") {
          MDom.removeClass( placeItem, 'hide');          
        }
      };
      //这里的两个值是不同的。
      var eleValue = _this.trim(element.value);
      if (eleValue == "") {
        MDom.removeClass( placeItem, 'hide');          
      }
    },
    ajax : {
      _xmlHttp : function() {
        return new (window.XMLHttpRequest || window.ActiveXObject)("Microsoft.XMLHTTP");
      },
      _AddEventToXHP : function(xhp, fun, isxml) {
        xhp.onreadystatechange = function() {
            if (xhp.readyState == 4 && xhp.status == 200) {
                var headers = xhp.getAllResponseHeaders().toLowerCase();
                fun( isxml ? xhp.responseXML : xhp.responseText);
            }
        };
      },
      post : function(url, data, fun, isxml, bool) {
        var _xhp = this._xmlHttp();
        this._AddEventToXHP(_xhp, fun ||
        function() {
        }, isxml);
        _xhp.open("POST", url, bool);
        _xhp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        _xhp.send(data);
      }
    },
    
    setCookie : function(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) + ((expires) ? "; expires=" + expires : "") + ((path) ? "; path=" + path : "") + ((domain) ? "; domain=" + domain : "") + ((secure) ? "; secure" : "");
    },
    
    getCookie : function(name) {
        var key = name + '=', klen = key.length, carr = document.cookie.split(';');
        for (var i = 0, tmp; tmp = carr[i++]; ) {
          tmp = tmp.trim();
          if (key == tmp.substring(0, klen)) {
            return unescape(tmp.substring(klen));
          }
        }
        return '';
     }
  };

  function prepareDataAttribute(data, paramName, attributeName) {
   if (getParam(paramName)) {
      if(getParam("onetimeEncode")) {
        data[attributeName] = getParam(paramName);
      } else {
        data[attributeName] = decodeURIComponent(getParam(paramName));
      }
    }
  };
  // 原地抖动函数
  function shakeForm(dom) {
    var p = "5 10 5 0 -5 -10 -5 0".split(" ");
    var set = function(n){
        var delay = 20;
        setTimeout(function() {
          dom.style.left = p[n] + "px";
        }, delay*n);
    }
    for(var i = 0; i < p.length; i++){
        set(i);
    }
  };
  //start of i18n message section
  window.messages = {};

  function setupMessages(data) {
    window.messages = data;
  } 
  
  function getLocalizedMessage(messageKey) {
    if (window.messages[messageKey]) {
      return window.messages[messageKey];
    } else {
      return messageKey;
    }
  }        
  //now we will have to load the message files
  if (!getParam("_locale") || getParam("_locale") === 'zh_CN') {
    document.write('<script src="./messages/minilogin_message_zh_cn2.js"><\/script>');
  } else if (getParam("_locale") === 'zh_TW') {
    document.body.className="zh_tw";
    document.write('<script src="./messages/minilogin_message_zh_tw2.js"><\/script>');
  } else if (getParam("_locale") === 'en') {
    document.body.className="en";
    document.write('<script src="./messages/minilogin_message2.js"><\/script>');
  }
  //end of i18n message section
  var shake_area = MDom.getID('shake_area');
  var sid = getParam("sid");
  var subItem = MDom.getID('message_LOGIN_IMMEDIATELY');
  var pwdArea = MDom.getID("miniLogin_pwd");
  var MiniLogin = {
      TIPSTRING : {
        //信息放到后面去加载了。
      },
      getValue : function(obj) {
          return MDom.trim(obj.value);
      },
      clearTips : function() {
        var input = document.getElementsByTagName("input"), 
            mgsTips = MDom.className("error-msg");
        for (var i = 0; i < input.length; i++) {
            var father = input[i].parentNode;
            MDom.removeClass(father, "error");
        }
        for (var n = 0; n < mgsTips.length; n++) {
            mgsTips[n].innerHTML = "";
        }
      },
      checkInput : function(objArr) {
        var _this = this, 
            obj = objArr[0], 
            objVal = _this.getValue(obj),
            objRule = new RegExp(obj.getAttribute("data-rule")), 
            objResult = objRule.test(objVal),
            father = objArr[0].parentNode,
            textArea = MDom.findEle(father,'span','error-msg');//找到放文字的容器。
        _this.clearTips();
        if (objVal === "") {
            shakeForm(shake_area);//这里为空的时候就直接抖动，不做提示。   
            return false;
        } else if (!objResult) {
            MDom.addClass( father, "error" );
            textArea.innerHTML = objArr[1];
            obj.value = '';
            //3秒消失提示
            setTimeout(function() {
              MDom.removeClass( father, "error" );
              obj.focus();
            },500);
            shakeForm(shake_area);
            return false;
        } else {
            textArea.innerHTML = "";
            return true;
        }
      },
      postData : function(u, p) {
        var _this = this;

        var postStr = {
            user : encodeURIComponent(u),
            _json : true
        };
        
        if (p) {
          postStr.pwd = encodeURIComponent(p);
        }
        
        prepareDataAttribute(postStr, "sid", "sid");
        prepareDataAttribute(postStr, "sign", "_sign");
        prepareDataAttribute(postStr, "callback", "callback");
        prepareDataAttribute(postStr, "qs", "qs");
        prepareDataAttribute(postStr, "hidden", "hidden");
        prepareDataAttribute(postStr, "redirectTarget", "redirectTarget");

        if (MDom.getID("img_code_area").style.display === "block") {
            postStr.captCode = _this.getValue(MDom.getID("miniLogin_captCode"));
        }
        
        if (MDom.getID("auto").checked) {  //这里对两周自动登录做处理
            postStr.auto = "true";
        }
        return postStr;
      },
      captCodeShow : function(json) {
        var _this = this;
        if (json.captchaUrl) {
          var captCodeBox = MDom.getID("img_code_area"), 
              captCode = MDom.getID("miniLogin_captCode"), 
              codeImg = MDom.getID("miniLogin_codeimg"), 
              orginSrc = _this.TIPSTRING.host + json.captchaUrl;

          if (codeImg !== null) {
              codeImg.src = orginSrc;
          } else {
              var captImg = MDom.getID('code_img');
              captImg.src = orginSrc;
              captImg.id = "miniLogin_codeimg";
              captImg.title = getLocalizedMessage("IMG_TIP");
              MDom.bind(captImg,'click',function(){
                var target = this;
                captImg.src = captImg.src + "&" + Math.random();
              });
              //captCodeBox.insertBefore(captImg, captCode);
          }

          
          MDom.getID("img_code_area").style.display = "block";
          if(json.code ===87001){
            var captCode = MDom.getID("miniLogin_captCode"),
                father = captCode.parentNode;
            MDom.addClass(captCodeBox, "error");
            setTimeout(function() {
              MDom.removeClass( father, "error" );
              captCode.focus();
            },500);
            MDom.getID("code_error_tips").innerHTML = getLocalizedMessage("IMG_CODE_ERROR");
          }
        }
      },
      setLogin : function(u, p) {
        var _this = this;
        var sendData = MDom.json2str(_this.postData(u, p));
        //do login
        MDom.ajax.post(_this.TIPSTRING.postUrl, sendData, function(data) {

          var data = data.replace('&&&START&&&', '');
          var json = eval('(' + data + ')');
          var father = _this.TIPSTRING.name[0].parentNode;
          var textArea = MDom.findEle(father,'span','error-msg');

          if (json.code !== 0) {
            MDom.removeClass(subItem,'sub-loading');
            MDom.removeClass(pwdArea,'change-interface');
            if (json.code === 81003) {
              var redirectTwoPhraseLoginLink = document.getElementById("redirectTwoPhraseLoginLink");
              var queryObj = _this.postData(u);
              if(json.qs) {
                queryObj.qs = window.encodeURIComponent(json.qs);
              }                              
              
              if(json.userId) {
                queryObj.userId = window.encodeURIComponent(json.userId);
              } 
              
              if(json.phone) {
                queryObj.phoneHint = window.encodeURIComponent(json.phone);
              }  

              queryObj._sign = window.encodeURIComponent(json._sign);
              queryObj.callback = window.encodeURIComponent(json.callback);
              
              var authenticationPageURL = "/pass/static/authenticationcode.html?" + MDom.json2str(queryObj);
              
              var localeValue = getParam("_locale");
              if (localeValue) {
                authenticationPageURL = authenticationPageURL + "&_locale=" + localeValue;
              }
              
              redirectTwoPhraseLoginLink.href = authenticationPageURL;

              try {
                var evObj = document.createEvent('MouseEvents');
                evObj.initMouseEvent('click', true, true, window);
                redirectTwoPhraseLoginLink.dispatchEvent(evObj);
              } catch (ignore) {
                redirectTwoPhraseLoginLink.click();
              }
              return;
            } else if (json.code === 70016) {
              _this.clearTips();
              var obj = _this.TIPSTRING.pwd[0];
              MDom.addClass( father, "error" );
              //3秒消失提示
              setTimeout(function() { 
                MDom.removeClass( father, "error" );
                  obj.value = '';
                  obj.focus();
              },500);
              shakeForm(shake_area);
              textArea.innerHTML = getLocalizedMessage("AJAX_USER_ERROR");
            } else if (json.code ===87001) {
              _this.captCodeShow(json);
            } else{
              _this.clearTips();
              var obj = _this.TIPSTRING.pwd[0];
              MDom.addClass( father, "error" );
              
              setTimeout(function() {
                MDom.removeClass( father, "error" );
                  obj.value = '';
                  obj.focus();
              },500);
              shakeForm(shake_area);
              textArea.innerHTML = getLocalizedMessage("AJAX_USER_LOGIN_ERROR");
            }

          } else {
     
              var expire=new Date( new Date().getTime() +10*365*24*60*60000 );
              //更换cookie名字，realloginname信息有误已经被污染。
              MDom.setCookie("userName", u, expire, "/", ".xiaomi.com");
              var redirectLink = document.getElementById("redirectLink");
              redirectLink.href = json.location;

              try {
                  var evObj = document.createEvent('MouseEvents');
                  evObj.initMouseEvent('click', true, true, window);
                  redirectLink.dispatchEvent(evObj);
              } catch (ignore) {
                  redirectLink.click();
              }
            }
          }, false, true);
        },
        //在提交时做验证
        validateForm : function() {
          var _this = this, 
              uName = _this.TIPSTRING.name, 
              uPwd = _this.TIPSTRING.pwd;
          try {
            if (!_this.checkInput(uName) || !_this.checkInput(uPwd)) {
                return false;
            } else {
                //这里是给micloud加的一个修改视觉的入口
                MDom.addClass(pwdArea,'change-interface');
                MDom.addClass(subItem,'sub-loading');
                var u = _this.getValue(uName[0]), p = _this.getValue(uPwd[0]);
                _this.setLogin(u, p);
                return false;
            }
          } catch (ignore) {
              return false;
          }
        },
        creatJs : function(src, elemid) {
          var Scrip = document.createElement("script");
          Scrip.src = src;
          if (!!elemid) {
              Scrip.id = elemid;
              if (MDom.getID(elemid)) {
                  document.body.removeChild(MDom.getID(elemid));
              }
          }
          document.body.appendChild(Scrip);
        }
      };
      function getCookie(key) {
        var cookie = document.cookie;
        var cookieArray = cookie.split(';');
        var val = "";
        for (var i = 0; i < cookieArray.length; i++) {
            if (MDom.trim(cookieArray[i]).substr(0, key.length) == key) {
                val = MDom.trim(cookieArray[i]).substr(key.length + 1);
                break;
            }
        }
        return unescape(val);
      };
      function hasAlipayCookie() {
        if (getCookie("sns_type") === "alipay" || getParam("alipay")) {
          return true;
        }
        return false;
      };

      window.onload = function() {
        
        //we will firstly show correct messages
        document.title = getLocalizedMessage("TITLE");
        MDom.getID("message_INPUT_IDENTITY").innerHTML = getLocalizedMessage("INPUT_IDENTITY");
        MDom.getID("message_INPUT_PASSWORD").innerHTML = getLocalizedMessage("INPUT_PASSWORD");
        MDom.getID("message_INPUT_CONFIRM").innerHTML = getLocalizedMessage("INPUT_CONFIRM");
        MDom.getID("message_AUTOLOGIN_TWOWEEKS").innerHTML = getLocalizedMessage("AUTOLOGIN_TWOWEEKS");
        MDom.getID("other_method").innerHTML = getLocalizedMessage("INPUT_OTHER_METHOD");
        MDom.getID("message_FORGET_PASSWORD").innerHTML = getLocalizedMessage("FORGET_PASSWORD");
        MDom.getID("message_LOGIN_IMMEDIATELY").value = getLocalizedMessage("LOGIN_IMMEDIATELY");
        MDom.getID("message_REGISTER").innerHTML = getLocalizedMessage("REGISTER");
        
        //this is to avoid FOUC
        MDom.getID("form-area").style.display = "";
        
        MiniLogin.TIPSTRING = {
          "name" : [MDom.getID("miniLogin_username"), getLocalizedMessage("INPUT_WRONG_USER_NAME_HINT")],
          "pwd" : [pwdArea, getLocalizedMessage("INPUT_WRONG_PASSWORD_HINT")],
          "host" : "https://account.xiaomi.com",
          "callback" : "http%3A%2F%2Forder.xiaomi.com%2Flogin%2Fcallback%3Ffollowup%3Djson%26sign%3DMjU1NzY4ODVjM2U3MWI0OTdhOTEyOWNjNjhkZmM2NmQ1MTZmYmFlYw%2C%2C",
          "postUrl" : "/pass/serviceLoginAuth2",
          "qq" : (sid !== "passport") ? "https://hd.account.xiaomi.com/pass/sns/login/auth?appid=100284651&callback=" : "https://account.xiaomi.com/pass/sns/login/auth?appid=100284651&callback=",
          "sina" : (sid !== "passport") ? "https://hd.account.xiaomi.com/pass/sns/login/auth?appid=2996826273&callback=" : "https://account.xiaomi.com/pass/sns/login/auth?appid=2996826273&callback=",
          "alipay" : (sid !== "passport") ? "https://hd.account.xiaomi.com/pass/sns/login/auth?appid=2088011127562160&callback=" : "https://account.xiaomi.com/pass/sns/login/auth?appid=2088011127562160&callback=",
          "facebook" : (sid !== "passport") ? "https://account.xiaomi.com/pass/sns/login/auth?appid=222161937813280&callback=" : "https://account.xiaomi.com/pass/sns/login/auth?appid=222161937813280&callback="
        };
        
        var redirectLinkTarget = getParam("redirectTarget");
        if (redirectLinkTarget === "0") {
          MDom.getID("redirectLink").target = "_self";
        }

        var bodyNode = window.document.getElementsByTagName("body")[0], inframe = getParam("inframe");
        //这里还要根据cookie来看是否有默认选中
        MDom.bind(MDom.getID('cookie_area'),'click', function(){
          var checkbox_item = MDom.getID('checkbox_item'),
              checkbox = MDom.getID('auto');
          if(MDom.hasClass(checkbox_item,'checked')){
            MDom.removeClass(checkbox_item,'checked');
            checkbox.checked = false;
          }else{
            MDom.addClass(checkbox_item,'checked');
            checkbox.checked = true;
          }
        });
        MDom.bind(MDom.getID("other_method"), "click", function() {
          var link_area = MDom.getID("third_area");
          if(MDom.hasClass(link_area,"hide")){
            MDom.removeClass(link_area, "hide");
          }else{
            MDom.addClass(link_area, "hide");
          }
        });
       
        //this page will be used by iframe and also by standalone page
        //only show alipay quick link when it is in frame and has the cookie
        if (hasAlipayCookie() && inframe) {
            //if (true) {
            MDom.addClass(bodyNode, "has_third");                    
        } else {
            //make sure the alipay quick login link show up
            MDom.removeClass(bodyNode, "has_third");
            MDom.removeClass(MDom.getID("miniLogin_third_alipay"), "hide");
        }

        var urlFollowup = decodeURIComponent(getParam("third"));
        
        //this is for the case of not jumping from xiaomi.com
        if (!urlFollowup) {
          urlFollowup = getParam("callback") + "&sid=" + getParam("sid");
        }
        
        var urlQq = MiniLogin.TIPSTRING.qq + urlFollowup, 
            urlAlipay = MiniLogin.TIPSTRING.alipay + urlFollowup, 
            urlSina = MiniLogin.TIPSTRING.sina + urlFollowup,
            urlFacebook = MiniLogin.TIPSTRING.facebook + urlFollowup;

        MDom.getID("miniLogin_third_qq").href = urlQq;
        MDom.getID("miniLogin_third_sina").href = urlSina;
        MDom.getID("miniLogin_third_alipay").href = urlAlipay;
        MDom.getID("miniLogin_third_facebook").href = urlFacebook;

        if (getCookie("userName")) {
          MDom.getID("miniLogin_username").value = getCookie("userName");
        }
        MDom.funPlaceholder(MDom.getID("miniLogin_username"));
        MDom.funPlaceholder(pwdArea);
        MDom.funPlaceholder(MDom.getID("miniLogin_captCode"));

      };       
</script>    
</html>
