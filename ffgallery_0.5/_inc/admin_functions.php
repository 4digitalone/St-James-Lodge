<?php
/*
  VERSION 0.3
*/

	function checkLogin($username, $password) {
		global $ADMIN_NAME, $ADMIN_PASSWD;
		if(($username == $ADMIN_NAME) && ($password == $ADMIN_PASSWD)){
			return true;
			$_SESSION['LOGGED_IN'] = true;
		}
		else {
			return false;	
			$_SESSION['LOGGED_IN'] = false;
		}
	}

	function getLoginForm() {
		global $LANGUAGE;
		return file_get_contents("./_lang/{$LANGUAGE}/login.txt");	
	}

	function saveImageData($album, $page, $iter, $newtitle, $newDescription) {
		$pos = (($page-1)*9) + $iter;
		$image = $_SESSION['image_list'][$album][$pos];
		// set the new title
		$_SESSION['descriptions'][$album][$image]['Title'] = $newtitle;
		// set the new description
		$_SESSION['descriptions'][$album][$image]['Description'] = $newDescription;
		saveINIFile($album);
	}
	
	function saveINIFile($album) {
		global $FFGALLERY_ROOT;
		foreach(array_keys($_SESSION['descriptions'][$album]) as $image){
			$imageKey = $image;
			$imageTitle = $_SESSION['descriptions'][$album][$image]['Title'];
			$imageDescription = $_SESSION['descriptions'][$album][$image]['Description'];
			$iniText .= "[$imageKey]\n" .
					    "Title = \"$imageTitle\"\n" .
					    "Description = \"$imageDescription\"\n" .
					    "\n";	
		}
		$fp = fopen("$FFGALLERY_ROOT/$album/$album.ini",'w');
		fwrite($fp,$iniText);
		fclose($fp);
	}
?>