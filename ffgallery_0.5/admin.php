<?php
/*
  VERSION 0.3
*/
    require("./config.php");
    require("./_inc/Sajax.php");
    require("./_inc/functions.php");
    require("./_inc/admin_functions.php");
    require("./_lang/{$LANGUAGE}/lang.php");
    
    //setup sajax
    sajax_init();
    $sajax_debug_mode = 0;
    sajax_export("getNumPages");
    sajax_export("returnImageHtml");
    sajax_export("returnExtraText");
    sajax_export("returnAlbumTitle");
    sajax_export("returnAlbumDescription");
    sajax_export("returnImageTitle");
    sajax_export("returnImageDescription");
    sajax_export("stopSession");
    sajax_export("returnImageLink");
    sajax_export("checkJavascript");
    sajax_export("saveImageData");
    // admin functions
    sajax_export("getLoginForm");
    sajax_export("checkLogin");
    
    sajax_handle_client_request();
?>
<html>
<head>
    <link rel='stylesheet' href='./main.css' type='text/css'>
    <link rel='stylesheet' href='./admin.css' type='text/css'>
    <script type="text/javascript">
<?
	// output SAJAX code
    sajax_show_javascript();
?>
    </script>
    <script language="JavaScript" type="text/javascript" src="./_inc/ffgallery_admin.js.php"></script>
</head>
<body onLoad="isLoggedIn(); <? 
// Address bar onLoad options:
//    gallery=		load a gallery other than the default
//    page=  		load the page number for the above gallery
//					defaults to page 1
//    img=			show the zoomed image for the image number
//					of the above page and gallery
if(isset($_GET['gallery'])){
    $gallery = $_GET['gallery'];
    if(isset($_GET['page'])){
    	$page = $_GET['page'];
    }
    else{
    	$page = 1;
    }
    if(in_array($gallery,$EXTRA_PAGES)) {
        echo "loadExtra('$gallery')";
    }
    elseif(in_array($gallery,$_SESSION['albums'])) {
        echo "loadAlbum('$gallery','$page')";
	    if(isset($_GET['img'])){
	    	$img = $_GET['img'];
	    	echo "; loadZoomImage('$page','$img')";
	    }
    }
}
elseif(isset($_GET['extra'])){
	$extra = $_GET['extra'];
	echo "loadExtra($extra)";
}
elseif($START_ALBUM != ""){
    echo "loadAlbum('$START_ALBUM',1)";
}
else{
    echo "loadExtra('$START_EXTRA')";
}
?>" onUnload="unLoadPage()">
    <div class='main' id='main'>
    <?
    //debug code
    
    ?>
    <span id="help"></span>
    <table class='main_tbl'>
    <tr>
        <td class='title_block' colspan='3'>
            <? echo $TITLE_BLOCK; ?>
        </td>
    </tr>
    <tr>
        <td rowspan='3' class='album_lst'>
           <? 
           echo $ALBUM_HEADER . "<br \><br \>";
            printExtrasList(); 
            printDirList($_SESSION['albums']); 
            echo "<br \><br \>" . $ALBUM_FOOTER;
        ?>
        </td>
        <td colspan='2'>
                <table id='pic_tbl' class='pic_tbl'>
                <tr>
                    <td class='img_td'><span id='img1'>&nbsp;</span></td>
                    <td class='img_td'><span id='img2'>&nbsp;</span></td>
                    <td class='img_td'><span id='img3'>&nbsp;</span></td>
                </tr>
                <tr>
                    <td class='img_td'><span id='img4'>&nbsp;</span></td>
                    <td class='img_td'><span id='img5'>&nbsp;</span></td>
                    <td class='img_td'><span id='img6'>&nbsp;</span></td>
                </tr>
                <tr>
                    <td class='img_td'><span id='img7'>&nbsp;</span></td>
                    <td class='img_td'><span id='img8'>&nbsp;</span></td>
                    <td class='img_td'><span id='img9'>&nbsp;</span></td>
                </tr>
                </table>
            </td>
    <tr>
        <td> &nbsp;</td>
        <td class='navigate'>
            <div id='current_viewing'></div>
            <span id='pageList'></span>
        </td>
        <td class='about'><div class='aboutLink' onMouseDown="document.getElementById('about').style.visibility='visible';">?</div></td>
    </tr>
    </table>
    </div>
    
    <div id='overlay' class='overlay'></div>
    
    <div class='about' id='about' onClick="flipVisibility(this);">
    <table class='a_tbl'>
    <tr>
        <td class='a_td' colspan='2'>
        <? 
        if(strlen($ABOUT_ME_IMG) > 0) echo $ABOUT_ME_IMG;
        echo $ABOUT_ME; 
       ?>
        </td>
    </tr>
    <tr>
        <td class='a_td_au'>Gallery software <a href='http://ffgallery.sourceforge.net/'>ffGallery</a> &copy; 2005</td><td class='a_td_close'><div class='close'>X</div></td>
    </tr>
    </table>
    </div>
    
    <div class='zoom' id='zoom'>
    <table class='z_tbl'>
    <tr>
        <td class='z_td_tr'> 
        	<? echo $DEFAULT_IMAGE_HEADER; ?>
        	<form name='img_data_form'>
        	Image Name<br />
  			<input type="text" id="zimg_title" value="You must be logged in" size="25" maxlength="40"/><br />
  			Image Description<br />
  			<textarea id="zimg_desc" rows="10" cols="25">You must be logged in to edit values</textarea>
  			<span class='save_btn' onMouseDown="saveImgData();">Save</span>
        	</form>
        	<br />
        	<? echo $DEFAULT_IMAGE_FOOTER; ?>
        	<div class='z_full' id='z_full'></div></td>
        <td class='z_td'><div id='zimg'><? echo getLoginForm(); ?></div><div class='close' onMouseDown="document.getElementById('zoom').style.visibility='hidden';"><? echo CLICK_TO_CLOSE; ?> X</div></td>
    </tr>
    </table>
    </div>
</body>
</html>