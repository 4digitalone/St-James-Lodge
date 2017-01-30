<?php
/*
  VERSION 0.4
*/    
  
    // Server Set-up
    if($COMPRESS_OUTPUT) {
        ini_set('zlib.output_compression', 'On');
        ini_set('zlib.output_compression_level', '-1');
    }
    
    // Session Set-up
    session_start();
    $_SESSION = array();
    
    $_SESSION['NO_JAVASCRIPT'] = true;	// see checkJavascript function for more info
    $_SESSION['LOGGED_IN'] = false; // set the logged in flag to false
    
    $dir_array = getDirList();
    if (!isset($_SESSION['albums'])) {
        $_SESSION['albums'] = $dir_array;
    }
    
    if (!isset($_SESSION['current_album'])) {
        if(isset($START_ALBUM)) {
            $_SESSION['current_album'] = $START_ALBUM;
        }
        else {
            $_SESSION['current_album'] = $_SESSION['albums'][1];
        }
    }
    
    if (!isset($_SESSION['image_list'])) {
        foreach($_SESSION['albums'] as $album) {
            $img_array = getImageArray("$FFGALLERY_ROOT/$album");
            checkThumbnails($album, $img_array);
            $_SESSION['image_list'][$album] = $img_array;
        }
    }
    
    if (!isset($_SESSION['descriptions'])) {
        foreach($_SESSION['albums'] as $album) {
            $desc_array = readIni("$FFGALLERY_ROOT/$album");
            $_SESSION['descriptions'][$album] = $desc_array;
        }
    }
    //*****************************************
    // Internal functions
    function getDirList() {
    // Read the directories in the current directory and output an array
    	global $FFGALLERY_ROOT;
        $d_arr = Array();
        $d = dir($FFGALLERY_ROOT);
        $i = 1;
        while(false !== ($entry = $d->read())) {
            if(is_dir($entry) && $entry != '.' && $entry != '..' && $entry{0} != '_'){
                $d_arr[$i] = $entry;
                $i = $i + 1;
            }
        }
        $d->close();
        return $d_arr;
    }
    
    function printDirList($dir_arr) {
    // Print the list of directories with specific format
    	global $FFGALLERY_ROOT;
        $d = dir($FFGALLERY_ROOT);
        $i=1;
        foreach($dir_arr as $iter => $value) {
            $title = returnAlbumTitle($value);
           	echo "<div class='album' onMouseDown=\"loadAlbum('$value',1); return false\">$title</div>";
        }
        $d->close();
    }
    
    function printExtrasList() {
        global $EXTRA_PAGES;
        foreach($EXTRA_PAGES as $name) {
            	echo "<div class='album' onMouseDown=\"loadExtra('$name'); return false\">$name</div>";
        }
    }
    
    function getImageArray($directory) {
    // Read the files from a directory and output an array
    	global $SORT_IMAGES;
        $img_arr = array();
        $d = dir($directory);
        $i = 1;
        while(false !== ($entry = $d->read())) {
            if(preg_match('/^thumb/i',$entry)) continue; // skip the thumbnails
            $path = "$directory/$entry";
            if(is_file($path) && preg_match('/[\w-]+\.(jpeg|jpg)/i',$path)){	// make sure it's a jpeg
                $img_arr[$i] = $entry;
                $i = $i + 1;
            }
        }
        $d->close();
        if ($SORT_IMAGES == 'desc') {
        	arsort($img_arr);		// sort images descending
        }
        else {
        	asort($img_arr);		// sort images ascending
        }
        return $img_arr;
    }
    
    function readIni($directory) {
    // Read the ini file in a directory and output an associative array
        $desc_arr = array();
        $d = dir($directory);
        while(false !== ($entry = $d->read())) {
            if(strpos($entry,'.ini')) {
                $path = "$directory/$entry";
                break;
            }
            else {
                $path = null;
            }
        }
        $d->close();
        if(!is_file($path)){
            return false;
        }
        else{
            return parse_ini_file($path, true);
        }
    }
    
    function checkThumbnails($album, $img_array) {
        // Check for proper thumbnails
        global $THUMBNAIL_SIZES, $FFGALLERY_ROOT;
        foreach($img_array as $img) {
            foreach($THUMBNAIL_SIZES as $size) {
                $path = "$FFGALLERY_ROOT/$album/thumb{$size}_{$img}";
                if(!is_file($path)) {
                    // create thumbnails for size
                    generateThumbnail("$FFGALLERY_ROOT/$album",$size,$img);
                }
            }
        }
    }

    function generateThumbnail($directory,$size,$img) {
        $path = "$directory/$img";
        if(is_file($path)){
            $img_main = imagecreatefromjpeg($path);
            $width=imagesx($img_main);
            $height=imagesy($img_main);
            if($width > $height) {
                $new_w = $size;
                $new_h = $height * ($size/$width);
            }
            else {
                $new_h = $size;
                $new_w = $width * ($size/$height);
            }
            $dest_img = imagecreatetruecolor($new_w,$new_h);
            imagecopyresampled($dest_img,$img_main,0,0,0,0,$new_w,$new_h,imagesx($img_main),imagesy($img_main));
            $img_name = "thumb{$size}_{$img}";
            imagejpeg($dest_img, "$directory/$img_name");
        }
        return true;
    }    
    //*****************************************
    // Sajax functions
    function checkJavascript($token) {
    	// when the page loaded this function should be called with
    	// a true value for $token if javascript is enabled
    		if($token == 'true'){
    			$_SESSION["NO_JAVASCRIPT"] = false;
    		}
    		
    		return;
    }
    
    function getNumPages($album) {
        $image_array_count = count($_SESSION['image_list'][$album]);
        $num_pages = ceil($image_array_count/9.0);
        
        return intval($num_pages);
    }
    
    
    function returnImageHtml($iter,$page,$album,$size) {
        global $FFGALLERY_LOCATION, $THUMBNAIL_SIZES;
        
        $pos = (($page-1)*9) + $iter;
        $image_array_count = count($_SESSION['image_list'][$album]);
        if($pos <= $image_array_count) {
            $image = $_SESSION['image_list'][$album][$pos];
            if(strstr($size,'small')) {
                $image_name = "thumb{$THUMBNAIL_SIZES[0]}_{$image}";
                list($width, $height, $type, $attr) = getimagesize("./$album/$image_name");
                $img_txt = "<img class='imgSmall' src='$FFGALLERY_LOCATION/$album/$image_name' $attr onMouseDown=\"loadZoomImage($page,$iter)\" onMouseover=\"mouseOver(this);\" onMouseout=\"mouseOut(this);\" />";
            }
            else {
                $image_name = "thumb{$THUMBNAIL_SIZES[1]}_{$image}";
                list($width, $height, $type, $attr) = getimagesize("./$album/$image_name");
                $img_txt = "<img src='$FFGALLERY_LOCATION/$album/$image_name' $attr class='z_img' />";
            }
        }
        else {
            $img_txt = "&nbsp;";
        }
        
        return $img_txt;
    }
    
    function returnExtraText($name) {
    	global $FFGALLERY_ROOT;
        return file_get_contents("$FFGALLERY_ROOT/_extras/$name.txt");
    }
    
    function returnAlbumTitle($album) {
        if(@array_key_exists('Title',$_SESSION['descriptions'][$album]['Album Info'])){
            return $_SESSION['descriptions'][$album]['Album Info']['Title'];
        }
        else{
            return $album;
        }
    }
    
    function returnAlbumDescription($album) {
        if(@array_key_exists('Description',$_SESSION['descriptions'][$album]['Album Info'])){
            return $_SESSION['descriptions'][$album]['Album Info']['Description'];
        }
    }
    
    function returnImageTitle($iter,$page,$album) {
        $pos = (($page-1)*9) + $iter;
        $image_array_count = count($_SESSION['image_list'][$album]);
        if($pos <= $image_array_count) {
        $image = $_SESSION['image_list'][$album][$pos];
            if(@array_key_exists($image,$_SESSION['descriptions'][$album])){
                return $_SESSION['descriptions'][$album][$image]['Title'];
            }
            else{
                return $image;
            }
        }
    }
    
    function returnImageDescription($iter,$page,$album) {
        $pos = (($page-1)*9) + $iter;
        $image_array_count = count($_SESSION['image_list'][$album]);
        if($pos <= $image_array_count) {
        $image = $_SESSION['image_list'][$album][$pos];
            if(@array_key_exists($image,$_SESSION['descriptions'][$album])){
                return $_SESSION['descriptions'][$album][$image]['Description'];
            }
            else {
                return '&nbsp;';
            }
        }
    }
    
    function returnImageLink($iter,$page,$album) {
        global $FFGALLERY_LOCATION;
        
        $pos = (($page-1)*9) + $iter;
        $image_array_count = count($_SESSION['image_list'][$album]);
        if($pos <= $image_array_count) {
            $image = $_SESSION['image_list'][$album][$pos];
            $txt = "<a href=\"javascript:openNewWindow('$FFGALLERY_LOCATION/$album/$image');\">" . FULL_SIZED_IMAGE . "</a>";
        }
        else {
            $txt = "&nbsp;";
        }
        return $txt;
    }
    
    function stopSession() {
        session_destroy();
    }
	function returnImagesize($url) { //the easiest way of finding an image size which is not loaded
		list($width, $height, $type, $attr) = getimagesize($url);
		return "new Array(".$width.",".$height.")";
	}
?>