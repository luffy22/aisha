/* jce - 2.6.31 | 2018-06-21 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2018 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function(){var Event=tinymce.dom.Event,DOM=(tinymce.each,tinymce.DOM);tinymce.create("tinymce.plugins.ContextMenu",{init:function(ed){function hide(ed,e){return realCtrlKey=0,e&&2==e.button?void(realCtrlKey=e.ctrlKey):void(t._menu&&(t._menu.removeAll(),t._menu.destroy(),Event.remove(ed.getDoc(),"click",hideMenu),t._menu=null))}var showMenu,contextmenuNeverUseNative,realCtrlKey,hideMenu,t=this;t.editor=ed,contextmenuNeverUseNative=ed.settings.contextmenu_never_use_native;var isNativeOverrideKeyEvent=function(e){return e.ctrlKey&&!contextmenuNeverUseNative},isMacWebKit=function(){return tinymce.isMac&&tinymce.isWebKit};t.onContextMenu=new tinymce.util.Dispatcher(this),hideMenu=function(e){hide(ed,e)},showMenu=ed.onContextMenu.add(function(ed,e){(0!==realCtrlKey?realCtrlKey:e.ctrlKey)&&!contextmenuNeverUseNative||(Event.cancel(e),isMacWebKit()&&2===e.button&&!isNativeOverrideKeyEvent(e)&&ed.selection.isCollapsed()&&ed.selection.placeCaretAt(e.clientX,e.clientY),"IMG"==e.target.nodeName&&ed.selection.select(e.target),t._getMenu(ed).showMenu(e.clientX||e.pageX,e.clientY||e.pageY),Event.add(ed.getDoc(),"click",hideMenu),ed.nodeChanged())}),ed.onRemove.add(function(){t._menu&&t._menu.removeAll()}),ed.onMouseDown.add(hide),ed.onKeyDown.add(hide),ed.onKeyDown.add(function(ed,e){!e.shiftKey||e.ctrlKey||e.altKey||121!==e.keyCode||(Event.cancel(e),showMenu(ed,e))})},getInfo:function(){return{longname:"Contextmenu",author:"Moxiecode Systems AB",authorurl:"http://tinymce.moxiecode.com",infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/contextmenu",version:tinymce.majorVersion+"."+tinymce.minorVersion}},_getMenu:function(ed){var am,p,t=this,m=t._menu,se=ed.selection,col=se.isCollapsed(),el=se.getNode()||ed.getBody();return m&&(m.removeAll(),m.destroy()),p=DOM.getPos(ed.getContentAreaContainer()),m=ed.controlManager.createDropMenu("contextmenu",{offset_x:p.x+ed.getParam("contextmenu_offset_x",0),offset_y:p.y+ed.getParam("contextmenu_offset_y",0),constrain:1,keyboard_focus:!0}),t._menu=m,m.addSeparator(),am=m.addMenu({title:"contextmenu.align"}),am.add({title:"contextmenu.left",icon:"justifyleft",cmd:"JustifyLeft"}),am.add({title:"contextmenu.center",icon:"justifycenter",cmd:"JustifyCenter"}),am.add({title:"contextmenu.right",icon:"justifyright",cmd:"JustifyRight"}),am.add({title:"contextmenu.full",icon:"justifyfull",cmd:"JustifyFull"}),t.onContextMenu.dispatch(t,m,el,col),m}}),tinymce.PluginManager.add("contextmenu",tinymce.plugins.ContextMenu)}();