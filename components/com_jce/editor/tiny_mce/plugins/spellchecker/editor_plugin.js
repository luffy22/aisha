/* jce - 2.6.31 | 2018-06-21 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2018 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function(){var each=tinymce.each,DOM=tinymce.DOM;tinymce.create("tinymce.plugins.SpellcheckerPlugin",{getInfo:function(){return{longname:"Spellchecker",author:"Moxiecode Systems AB",authorurl:"http://tinymce.moxiecode.com",infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/spellchecker",version:tinymce.majorVersion+"."+tinymce.minorVersion}},init:function(ed,url){var t=this;if(t.url=url,t.editor=ed,t.rpcUrl=ed.getParam("site_url")+"index.php?option=com_jce&view=editor&plugin=spellchecker",t.native_spellchecker=""==t.rpcUrl||"browser"==ed.getParam("spellchecker_engine","browser"),t.native_spellchecker){if(tinymce.isIE&&/MSIE [56789]/.test(navigator.userAgent)){if(""==t.rpcUrl)return;t.native_spellchecker=!1}t.hasSupport=!0,ed.getParam("spellchecker_suggestions",!0)&&ed.onContextMenu.addToTop(function(ed,e){if(t.active)return!1})}ed.addCommand("mceSpellCheck",function(){if(t.native_spellchecker){var body=ed.getBody();return body.spellcheck=t.active=!t.active,void ed.focus()}t.active?t._done():(ed.setProgressState(1),t._sendRPC("checkWords",[t.selectedLang,t._getWords()],function(r){r.length>0?(t.active=1,t._markWords(r),ed.setProgressState(0),ed.nodeChanged()):(ed.setProgressState(0),ed.getParam("spellchecker_report_no_misspellings",!0)&&ed.windowManager.alert("spellchecker.no_mpell"))}))}),ed.settings.content_css!==!1&&ed.contentCSS.push(url+"/css/content.css"),ed.getParam("spellchecker_suggestions",!0)&&(ed.onClick.add(t._showMenu,t),ed.onContextMenu.add(t._showMenu,t)),ed.onBeforeGetContent.add(function(){t.active&&t._removeWords()}),ed.onNodeChange.add(function(ed,cm){cm.setActive("spellchecker",!!t.active)}),ed.onSetContent.add(function(){t._done()}),ed.onBeforeGetContent.add(function(){t._done()}),ed.onBeforeExecCommand.add(function(ed,cmd){"mceFullScreen"==cmd&&t._done()}),t.languages={},each(ed.getParam("spellchecker_languages","+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv","hash"),function(v,k){0===k.indexOf("+")&&(k=k.substring(1),t.selectedLang=v),t.languages[k]=v}),ed.onInit.add(function(){if(t.native_spellchecker&&ed.getParam("spellchecker_browser_state",0)){var body=ed.getBody();body.spellcheck=t.active=!t.active}})},createControl:function(n,cm){var c,t=this;t.editor;if("spellchecker"==n)return t.native_spellchecker?(t.hasSupport&&(c=cm.createButton(n,{title:"spellchecker.desc",cmd:"mceSpellCheck",scope:t})),c):(c=cm.createSplitButton(n,{title:"spellchecker.desc",cmd:"mceSpellCheck",scope:t}),c.onRenderMenu.add(function(c,m){m.add({title:"spellchecker.langs",class:"mceMenuItemTitle"}).setDisabled(1),t.menuItems={},each(t.languages,function(v,k){var mi,o={icon:1};o.onclick=function(){v!=t.selectedLang&&(t._updateMenu(mi),t.selectedLang=v)},o.title=k,mi=m.add(o),mi.setSelected(v==t.selectedLang),t.menuItems[v]=mi,v==t.selectedLang&&(t.selectedItem=mi)})}),c)},setLanguage:function(lang){var t=this;if(lang!=t.selectedLang){if(0===tinymce.grep(t.languages,function(v){return v===lang}).length)throw"Unknown language: "+lang;t.selectedLang=lang,t.menuItems&&t._updateMenu(t.menuItems[lang]),t.active&&t._done()}},_updateMenu:function(mi){mi.setSelected(1),this.selectedItem.setSelected(0),this.selectedItem=mi},_walk:function(n,f){var w,d=this.editor.getDoc();if(d.createTreeWalker)for(w=d.createTreeWalker(n,NodeFilter.SHOW_TEXT,null,!1);null!=(n=w.nextNode());)f.call(this,n);else tinymce.walk(n,f,"childNodes")},_getSeparators:function(){var i,re="",str=this.editor.getParam("spellchecker_word_separator_chars",'\\s!"#$%&()*+,-./:;<=>?@[]^_{|}ß©´Æ±∂∑∏ªºΩæø◊˜§”“');for(i=0;i<str.length;i++)re+="\\"+str.charAt(i);return re},_getWords:function(){var ed=this.editor,wl=[],tx="",lo={},rawWords=[];return this._walk(ed.getBody(),function(n){3==n.nodeType&&(tx+=n.nodeValue+" ")}),ed.getParam("spellchecker_word_pattern")?rawWords=tx.match("("+ed.getParam("spellchecker_word_pattern")+")","gi"):(tx=tx.replace(new RegExp("([0-9]|["+this._getSeparators()+"])","g")," "),tx=tinymce.trim(tx.replace(/(\s+)/g," ")),rawWords=tx.split(" ")),each(rawWords,function(v){lo[v]||(wl.push(v),lo[v]=1)}),wl},_removeWords:function(w){var ed=this.editor,dom=ed.dom,se=ed.selection,r=se.getRng(!0);each(dom.select("span").reverse(),function(n){n&&(dom.hasClass(n,"mce-item-hiddenspellword")||dom.hasClass(n,"mce-item-hidden"))&&(w&&dom.decode(n.innerHTML)!=w||dom.remove(n,1))}),se.setRng(r)},_markWords:function(wl){var ed=this.editor,dom=ed.dom,doc=ed.getDoc(),se=ed.selection,r=se.getRng(!0),nl=[],w=wl.join("|"),re=this._getSeparators(),rx=new RegExp("(^|["+re+"])("+w+")(?=["+re+"]|$)","g");this._walk(ed.getBody(),function(n){3==n.nodeType&&nl.push(n)}),each(nl,function(n){var node,elem,txt,pos,v=n.nodeValue;if(rx.lastIndex=0,rx.test(v)){if(v=dom.encode(v),elem=dom.create("span",{class:"mce-item-hidden"}),tinymce.isIE){for(v=v.replace(rx,"$1<mcespell>$2</mcespell>");(pos=v.indexOf("<mcespell>"))!=-1;)txt=v.substring(0,pos),txt.length&&(node=doc.createTextNode(dom.decode(txt)),elem.appendChild(node)),v=v.substring(pos+10),pos=v.indexOf("</mcespell>"),txt=v.substring(0,pos),v=v.substring(pos+11),elem.appendChild(dom.create("span",{class:"mce-item-hiddenspellword"},txt));v.length&&(node=doc.createTextNode(dom.decode(v)),elem.appendChild(node))}else elem.innerHTML=v.replace(rx,'$1<span class="mce-item-hiddenspellword">$2</span>');dom.replace(elem,n)}}),se.setRng(r)},_showMenu:function(ed,e){var p1,t=this,ed=t.editor,m=t._menu,dom=ed.dom,vp=dom.getViewPort(ed.getWin()),wordSpan=e.target;return e=0,m||(m=ed.controlManager.createDropMenu("spellcheckermenu",{class:"mceNoIcons"}),t._menu=m),dom.hasClass(wordSpan,"mce-item-hiddenspellword")?(m.removeAll(),m.add({title:"spellchecker.wait",class:"mceMenuItemTitle"}).setDisabled(1),t._sendRPC("getSuggestions",[t.selectedLang,dom.decode(wordSpan.innerHTML)],function(r){var ignoreRpc;m.removeAll(),r.length>0?(m.add({title:"spellchecker.sug",class:"mceMenuItemTitle"}).setDisabled(1),each(r,function(v){m.add({title:v,onclick:function(){dom.replace(ed.getDoc().createTextNode(v),wordSpan),t._checkDone()}})}),m.addSeparator()):m.add({title:"spellchecker.no_sug",class:"mceMenuItemTitle"}).setDisabled(1),ed.getParam("show_ignore_words",!0)&&(ignoreRpc=t.editor.getParam("spellchecker_enable_ignore_rpc",""),m.add({title:"spellchecker.ignore_word",onclick:function(){var word=wordSpan.innerHTML;dom.remove(wordSpan,1),t._checkDone(),ignoreRpc&&(ed.setProgressState(1),t._sendRPC("ignoreWord",[t.selectedLang,word],function(r){ed.setProgressState(0)}))}}),m.add({title:"spellchecker.ignore_words",onclick:function(){var word=wordSpan.innerHTML;t._removeWords(dom.decode(word)),t._checkDone(),ignoreRpc&&(ed.setProgressState(1),t._sendRPC("ignoreWords",[t.selectedLang,word],function(r){ed.setProgressState(0)}))}})),t.editor.getParam("spellchecker_enable_learn_rpc")&&m.add({title:"spellchecker.learn_word",onclick:function(){var word=wordSpan.innerHTML;dom.remove(wordSpan,1),t._checkDone(),ed.setProgressState(1),t._sendRPC("learnWord",[t.selectedLang,word],function(r){ed.setProgressState(0)})}}),m.update()}),p1=DOM.getPos(ed.getContentAreaContainer()),m.settings.offset_x=p1.x,m.settings.offset_y=p1.y,ed.selection.select(wordSpan),p1=dom.getPos(wordSpan),m.showMenu(p1.x,p1.y+wordSpan.offsetHeight-vp.y),tinymce.dom.Event.cancel(e)):void m.hideMenu()},_checkDone:function(){var o,t=this,ed=t.editor,dom=ed.dom;each(dom.select("span"),function(n){if(n&&dom.hasClass(n,"mce-item-hiddenspellword"))return o=!0,!1}),o||t._done()},_done:function(){var t=this,la=t.active;t.active&&(t.active=!!t.native_spellchecker,t._removeWords(),t._menu&&t._menu.hideMenu(),la&&t.editor.nodeChanged())},_sendRPC:function(m,p,cb){var t=this,ed=t.editor,query="",args={format:"raw"};args[ed.settings.token]=1;for(k in args)query+="&"+k+"="+encodeURIComponent(args[k]);var data=JSON.stringify({id:"spellcheck",method:m,params:p});tinymce.util.XHR.send({url:t.rpcUrl,content_type:"application/x-www-form-urlencoded",data:"json="+data+query,success:function(o){var c;try{c=JSON.parse(o)}catch(e){c={error:"JSON Parse error"}}if(!c||c.error){ed.setProgressState(0);var e=c.error||"JSON Parse error";ed.windowManager.alert(e.errstr||"Error response: "+e)}else cb.call(t,c.result||"")},error:function(x){ed.setProgressState(0),ed.windowManager.alert("Error response: "+x)}})}}),tinymce.PluginManager.add("spellchecker",tinymce.plugins.SpellcheckerPlugin)}();