<?
/*
  	Version 0.4
*/ 
    require("../config.php");
    require_once("./functions.php");
	

?>

    var current_album = '';
    var current_page = 0;  

    // check to see if javascript is enabled
   	x_checkJavascript('true', checkJavascript_cb);
    
    function checkJavascript_cb(result){
    	//do nothing	
    }
    
    // pre-load the first three thumbnails from each album
<?
/*
        $album_num = 0;
        foreach($_SESSION['albums'] as $album){
            for ($iter = 1; $iter <= 3; $iter += 1){
                $num = $iter + $album_num;
                $image = $_SESSION['image_list'][$album][$iter];
                $image_name = "thumb{$THUMBNAIL_SIZES[0]}_{$image}";
                if(is_file("./$album/$image_name")){
	                echo "        pic$num = new Image();\n";
	                echo "        pic$num.src = './$album/$image_name'\n";
                }
            }
            $album_num = $album_num + 1;
        }
*/
?>
    
    function mouseOver(id){
        id.style.opacity = '1.0';
        id.style.filter = 'alpha(opacity=100)';
        return;
    }
    
    function mouseOut(id){
        id.style.opacity = '0.60';
        id.style.filter = 'alpha(opacity=60)';
        return;
    }
    
    function flipVisibility(id){
        visibility = id.style.visibility;
        id.style.visibility = (!visibility || visibility == 'visible') ? 'hidden' : 'visible';
        return;
    }
    
    function showPage(){
        pageid = document.getElementById('overlay');
        tableid = document.getElementById('pic_tbl');
        pageid.style.visibility = 'visible';
        tableid.style.visibility = 'hidden';
    }
    
    function hidePage(){
        pageid = document.getElementById('overlay');
        tableid = document.getElementById('pic_tbl');
        pageid.style.visibility = 'hidden';
        tableid.style.visibility = 'visible';
    }
	function init()
	{
		var objoverlay_f = document.getElementById('overlay_f');
		objoverlay_f.style.display = 'none'; //hide it of course
		objoverlay_f.style.height = (xClientHeight() + 'px'); //size of the screen
	}
	function x_returnImagesize_cb(z) {
		eval("var ImsizeWH = "+z);
		var objoverlay_f = document.getElementById('overlay_f');
		objoverlay_f.style.display = 'block';
		var reduc = 1;
		if ( ImsizeWH[0] > xWidth(overlay_f) || ImsizeWH[1] > xHeight(overlay_f)) {
			reduc = Math.min(xWidth(overlay_f)/ImsizeWH[0],xHeight(overlay_f)/ImsizeWH[1]);
			reduc = Math.min(reduc,1);
			reduc -= 0.01; //get the min reductin coef between width to height then minor it of 1% 
		}
		ImsizeWH[0] *= reduc;
		ImsizeWH[1] *= reduc;
<?
if($FULL_IMAGE_RESIZED_TO_SCREEN){ //resize image only if set to true
    echo "            xTop(im,(xHeight(overlay_f)-ImsizeWH[1])/2);\n"; //centered
    echo "            xLeft(im,(xWidth(overlay_f)-ImsizeWH[0])/2);\n"; //centered
	echo "            xWidth(im,ImsizeWH[0]);\n";
    echo "            xHeight(im,ImsizeWH[1]);\n";
}
?>
	}
    function openNewWindow(url){
		var im = document.getElementById('im');
		im.src = url;
		x_returnImagesize(url,x_returnImagesize_cb);
    }
    function loadAlbum(name,page){
        hidePage();
        current_album = name;
        current_page = parseInt(page);
        x_returnAlbumTitle(name, '#current_viewing');
        x_getNumPages(name,getNumPages_cb);
        for (i= 1; i <= 9; i++) {
            img_str = '#img' + i;
            x_returnImageHtml(i,page,current_album,'small',img_str);
        }
    }
    
    function loadExtra(name){
        fillSpan('current_viewing','&nbsp;');
        fillSpan('pageList','&nbsp;');
        page_str = '#overlay';
        x_returnExtraText(name,page_str);
        showPage();
    }
    
    function loadZoomImage(page,image_num){
        //clear zoom layer
        fillSpan('zimg','&nbsp;');
        fillSpan('zimg_desc','&nbsp;');
        fillSpan('zimg_title','&nbsp;');
        //fill zoom layer
        zimg_str = '#zimg';
        zimg_desc_str = zimg_str + '_desc';
        zimg_title_str = zimg_str + '_title';
        x_returnImageHtml(image_num,page,current_album,'large',zimg_str);
        x_returnImageDescription(image_num,page,current_album,zimg_desc_str);
        x_returnImageTitle(image_num,page,current_album,zimg_title_str);
<?
if($LINK_TO_FULL_IMAGE){
    echo "            zimg_link_str = '#z_full';\n";
    echo "            x_returnImageLink(image_num,page,current_album,zimg_link_str);\n";
}
?>
        //show zoom layer
        document.getElementById('zoom').style.visibility='visible';
    }
    
    function getNumPages_cb(result){
        //num_pages = result;
        //fillSpan('totalPages',result);
        html_out = "";
        num_pages = parseInt(result);
        for(i=1; i<=num_pages; i++){
            if(i == current_page){
                html_out = html_out + "<span class='pageList' onMouseDown=\"loadAlbum('" + current_album + "'," + i + "); return false\"><u>" + i + "</u></span>";
            }
            else{
                html_out = html_out + "<span class='pageList' onMouseDown=\"loadAlbum('" + current_album + "'," + i + "); return false\">" + i + "</span>";
            }
        }
        fillSpan('pageList',html_out);
    }
    
    function unLoadPage(){
        x_stopSession(stopSession_cb)
    }
    
    function stopSession_cb(result){
        //do nothing
    }
    
    function fillSpan(spanid,filltxt){
    	if(document.all) {
            x = document.all[spanid];
           	x.innerHTML = filltxt;
    	}
    	else {
    		// from here: http://www.javascriptkit.com/javatutors/dynamiccontent4.shtml
			rng = document.createRange();
			el = document.getElementById(spanid);
			rng.setStartBefore(el);
			htmlFrag = rng.createContextualFragment(filltxt);
			while (el.hasChildNodes())
			el.removeChild(el.lastChild);
			el.appendChild(htmlFrag);
    	}
    }
    
    function getSpan(spanid){
        if (document.getElementById) {
            x = document.getElementById(spanid);
            return x.innerHTML;
        }
        else {
            x = document.all[spanid];
            return x.innerHTML;
        }
    }
////////////////////////////////// X FUNCTIONS ///////////////////////////////////////////////
// Copyright 2001-2005 Michael Foster (Cross-Browser.com) Part of X, a Cross-Browser Javascript Library, Distributed under the terms of the GNU LGPL
var xOp7Up,xOp6Dn,xIE4Up,xIE4,xIE5,xNN4,xUA=navigator.userAgent.toLowerCase();
if(window.opera){var i=xUA.indexOf('opera');if(i!=-1){var v=parseInt(xUA.charAt(i+6));xOp7Up=v>=7;xOp6Dn=v<7;}}
function xDef()
{
  for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])=='undefined') return false;}
  return true;
}
function xClientHeight()
{
  var h=0;
  if(xOp6Dn) h=window.innerHeight;
  else if(document.compatMode == 'CSS1Compat' && !window.opera && document.documentElement && document.documentElement.clientHeight)
    h=document.documentElement.clientHeight;
  else if(document.body && document.body.clientHeight)
    h=document.body.clientHeight;
  else if(xDef(window.innerWidth,window.innerHeight,document.width)) {
    h=window.innerHeight;
    if(document.width>window.innerWidth) h-=16;
  }
  return h;
}
function xClientWidth()
{
  var w=0;
  if(xOp6Dn) w=window.innerWidth;
  else if(document.compatMode == 'CSS1Compat' && !window.opera && document.documentElement && document.documentElement.clientWidth)
    w=document.documentElement.clientWidth;
  else if(document.body && document.body.clientWidth)
    w=document.body.clientWidth;
  else if(xDef(window.innerWidth,window.innerHeight,document.height)) {
    w=window.innerWidth;
    if(document.height>window.innerHeight) w-=16;
  }
  return w;
}
function xGetElementById(e)
{
  if(typeof(e)!='string') return e;
  if(document.getElementById) e=document.getElementById(e);
  else if(document.all) e=document.all[e];
  else e=null;
  return e;
}
function xStr(s)
{
  for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])!='string') return false;}
  return true;
}
function xNum()
{
  for(var i=0; i<arguments.length; ++i){if(isNaN(arguments[i]) || typeof(arguments[i])!='number') return false;}
  return true;
}
function xGetComputedStyle(oEle, sProp, bInt)
{
  var s, p = 'undefined';
  var dv = document.defaultView;
  if(dv && dv.getComputedStyle){
    s = dv.getComputedStyle(oEle,'');
    if (s) p = s.getPropertyValue(sProp);
  }
  else if(oEle.currentStyle) {
    // convert css property name to object property name for IE
    var a = sProp.split('-');
    sProp = a[0];
    for (var i=1; i<a.length; ++i) {
      c = a[i].charAt(0);
      sProp += a[i].replace(c, c.toUpperCase());
    }   
    p = oEle.currentStyle[sProp];
  }
  else return null;
  return bInt ? (parseInt(p) || 0) : p;
}
function xHeight(e,h)
{
  if(!(e=xGetElementById(e))) return 0;
  if (xNum(h)) {
    if (h<0) h = 0;
    else h=Math.round(h);
  }
  else h=-1;
  var css=xDef(e.style);
  if (e == document || e.tagName.toLowerCase() == 'html' || e.tagName.toLowerCase() == 'body') {
    h = xClientHeight();
  }
  else if(css && xDef(e.offsetHeight) && xStr(e.style.height)) {
    if(h>=0) {
      var pt=0,pb=0,bt=0,bb=0;
      if (document.compatMode=='CSS1Compat') {
        var gcs = xGetComputedStyle;
        pt=gcs(e,'padding-top',1);
        if (pt !== null) {
          pb=gcs(e,'padding-bottom',1);
          bt=gcs(e,'border-top-width',1);
          bb=gcs(e,'border-bottom-width',1);
        }
        // Should we try this as a last resort?
        // At this point getComputedStyle and currentStyle do not exist.
        else if(xDef(e.offsetHeight,e.style.height)){
          e.style.height=h+'px';
          pt=e.offsetHeight-h;
        }
      }
      h-=(pt+pb+bt+bb);
      if(isNaN(h)||h<0) return;
      else e.style.height=h+'px';
    }
    h=e.offsetHeight;
  }
  else if(css && xDef(e.style.pixelHeight)) {
    if(h>=0) e.style.pixelHeight=h;
    h=e.style.pixelHeight;
  }
  return h;
}
function xWidth(e,w)
{
  if(!(e=xGetElementById(e))) return 0;
  if (xNum(w)) {
    if (w<0) w = 0;
    else w=Math.round(w);
  }
  else w=-1;
  var css=xDef(e.style);
  if (e == document || e.tagName.toLowerCase() == 'html' || e.tagName.toLowerCase() == 'body') {
    w = xClientWidth();
  }
  else if(css && xDef(e.offsetWidth) && xStr(e.style.width)) {
    if(w>=0) {
      var pl=0,pr=0,bl=0,br=0;
      if (document.compatMode=='CSS1Compat') {
        var gcs = xGetComputedStyle;
        pl=gcs(e,'padding-left',1);
        if (pl !== null) {
          pr=gcs(e,'padding-right',1);
          bl=gcs(e,'border-left-width',1);
          br=gcs(e,'border-right-width',1);
        }
        // Should we try this as a last resort?
        // At this point getComputedStyle and currentStyle do not exist.
        else if(xDef(e.offsetWidth,e.style.width)){
          e.style.width=w+'px';
          pl=e.offsetWidth-w;
        }
      }
      w-=(pl+pr+bl+br);
      if(isNaN(w)||w<0) return;
      else e.style.width=w+'px';
    }
    w=e.offsetWidth;
  }
  else if(css && xDef(e.style.pixelWidth)) {
    if(w>=0) e.style.pixelWidth=w;
    w=e.style.pixelWidth;
  }
  return w;
}
function xTop(e, iY)
{
  if(!(e=xGetElementById(e))) return 0;
  var css=xDef(e.style);
  if(css && xStr(e.style.top)) {
    if(xNum(iY)) e.style.top=iY+'px';
    else {
      iY=parseInt(e.style.top);
      if(isNaN(iY)) iY=0;
    }
  }
  else if(css && xDef(e.style.pixelTop)) {
    if(xNum(iY)) e.style.pixelTop=iY;
    else iY=e.style.pixelTop;
  }
  return iY;
}
function xLeft(e, iX)
{
  if(!(e=xGetElementById(e))) return 0;
  var css=xDef(e.style);
  if (css && xStr(e.style.left)) {
    if(xNum(iX)) e.style.left=iX+'px';
    else {
      iX=parseInt(e.style.left);
      if(isNaN(iX)) iX=0;
    }
  }
  else if(css && xDef(e.style.pixelLeft)) {
    if(xNum(iX)) e.style.pixelLeft=iX;
    else iX=e.style.pixelLeft;
  }
  return iX;
}
//////////////////////////////////END X FUNCTION ////////////////////////////////////