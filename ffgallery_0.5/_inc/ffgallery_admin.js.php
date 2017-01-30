<?
    require("../config.php");
    require_once("./functions.php");
    require_once("$FFGALLERY_ROOT/_lang/{$LANGUAGE}/lang.php");
    

?>
    var current_album = '';
    var current_page = 0;
    var current_image_num = 0;
    
    var logged_in = false;
    
    // check to see if javascript is enabled
   	x_checkJavascript('true', checkJavascript_cb);
    
    function checkJavascript_cb(result){
    	//do nothing	
    }
    
    // pre-load the first three thumbnails from each album
<?
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
    
    var newwindow;
    function openNewWindow(url){
        newwindow=window.open(url,'full');
        if (window.focus) {newwindow.focus()}
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
    	// set current image number
    	current_image_num = image_num;
    	//check the login status
    	if(!logged_in) {
    		loginSystem();
    		return;
    	}
        //clear zoom image
        fillSpan('zimg','&nbsp;');
        //fill zoom layer
        zimg_str = '#zimg';
        //zimg_desc_str = zimg_str + '_desc';
        zimg_title_str = zimg_str + '_title';
        x_returnImageHtml(image_num,page,current_album,'large',zimg_str);
        x_returnImageDescription(image_num,page,current_album,fillZoomTextArea_cb);
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
    	if (document.all) {
            x = document.all[spanid];
            return x.innerHTML;	
    	}
    	else {
            x = document.getElementById(spanid);
            return x.innerHTML;
    	}
    }
    
    //
    // Admin functions 
    //

    function getFormValue(valueid){
    		eval("filltxt = document.img_data_form." + valueid + ".value");
    		return filltxt.replace(/(\r\n|\r|\n)/g, "<br />");
    }
    
    function saveImgData(){
    	// get the data from zimg_title and zimg_desc, set the $_SESSION
    	// values for this picture and save them to the appropriate .ini
    	newtitle = getFormValue('zimg_title');
    	newdescription = getFormValue('zimg_desc');
    	x_saveImageData(current_album, current_page, current_image_num, newtitle, newdescription, saveImageData_cb);
    	loadZoomImage(current_page, current_image_num);
    }
    
    function saveImageData_cb(result){
    	// do nothing	
    }
    function loginSystem(){
    	//clear zoom layer
        //fillSpan('zimg','&nbsp;');
        //fill zoom layer with login form
        x_getLoginForm('#zimg');
        //show zoom layer
        document.getElementById('zoom').style.visibility='visible';
    }
    
    function logoutSystem(){
    	 window.location = "<? echo $FFGALLERY_LOCATION; ?>";
    }
    
    function checkLogin(){
    	username_field = getInputValue('login_username');	
    	password_field = getInputValue('login_password');
    	x_checkLogin(username_field, password_field, checkLogin_cb);
    }
    
    function checkLogin_cb(result){
    	if(result) {
    		logged_in = true;
    		txt = "<? echo LOGGED_IN; ?>"; 
    		fillSpan('help',txt);
    		if(current_album == '') {
    			document.getElementById('zoom').style.visibility='hidden'	
    		}
    		else {
    			loadZoomImage(current_page,current_image_num);
    		}
    	}
    	else {
    		logged_in = false;
    		loadZoomImage(current_page,current_image_num);
    	}	
    }
    
    function isLoggedIn(){
    	if(!logged_in) {
    		txt = "<? echo NOT_LOGGED_IN; ?>";
    		fillSpan('help',txt);
    	}	
    }
    
    function getInputValue(id){
        if (document.getElementById) {
            x = document.getElementById(id);
            return x.value;
        }
        else {
            x = document.all[id];
            return x.value;
        }
    }
    
    function fillZoomTextArea_cb(result){
        if (document.getElementById) {
            x = document.getElementById('zimg_desc');
            //x.value = '';
           	x.value = result.replace(/<br>|<br \/>/gi,"\n");
        }
        else {
            x = document.all['zimg_desc'];
           	x.value = result.replace(/<br>|<br \/>/gi,"\r\n");
        }
    }