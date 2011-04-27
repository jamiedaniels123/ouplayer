/** * OU player javascript. (NDF, 2011-04-08/-04-27) * Copyright 2011 The Open University. *///The OU player object.var OUP = OUP || {};(function(){  var player_id= 'ouplayer',      div_id   = 'ouplayer-div',	  script_btn = 'script',      controls_id= 'oup-controls',      controls_class= ("play,back,forward,quieter,louder,mute,script,popout,related,more").split(',');  //Utilities.  OUP.log=function(o) {    window.console && console.log      && console.log("OUP: "+o);  }  function byClass(name) {    var wrap = wrap ? wrap : document;    var els = wrap.getElementsByTagName("*");		    var re = new RegExp("(^|\\s)" + name + "(\\s|$)");    for (var i = 0; i < els.length; i++) {      if (re.test(els[i].className)) {        return els[i];	  }    }  }  //http://snipplr.com/view/3561/addclass-removeclass-hasclass/  function hasClass(ele,cls) {    return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));  }  function addClass(ele,cls) {    if (!hasClass(ele,cls)) ele.className += " "+cls;    ele.className.replace(/ +/g,' '); //+  }  function removeClass(ele,cls) {    if (hasClass(ele,cls)) {      var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');      ele.className=ele.className.replace(reg,''); //+-    }  }  function attachTooltip(name) {	  var btn = byClass(name);	  var tip = btn.getAttribute('aria-label');	  btn.onmouseover=function(){ OUP.fixedtooltip(tip, btn, {type:'mouseover'}); }	  btn.onmouseout =function(){ OUP.delayhidetip(); }	  //Hmm, spoofing an event?! {type:"X"}      btn.onfocus    =function(){OUP.fixedtooltip(this.getAttribute('aria-label'), this, {type:'focus'});}      btn.onblur     =function(){OUP.delayhidetip();}  }  OUP.initialize=function() {    var ply = document.getElementById(player_id);    var div = document.getElementById(div_id);    var controls_div = document.getElementById(controls_id);    div.style.display='block';    controls_div.style.display='block';    setTimeout("document.getElementById('ouplayer').style.cursor='default';", 2000);    var wrap = controls_div; //document.getElementById('oup-controls');    for (var ctl in controls_class) {	  attachTooltip(controls_class[ctl]);    }	//Transcript button.	byClass(script_btn).onclick = function() {	  //var panel = document.getElementById('ouplayer-panel');	  if (hasClass(ply, 'hide-script')) {	    removeClass(ply, 'hide-script');		addClass(ply, 'show-script');		OUP.log('show');	  } else {	    removeClass(ply, 'show-script');		addClass(ply, 'hide-script');		OUP.log('hide');      }	}  }//OUP.init;})();