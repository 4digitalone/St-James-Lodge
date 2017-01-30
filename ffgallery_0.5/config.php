<?php
/* User Config
Change the values in this section to personalize your gallery.
These are all php string variable so you can use HTML tags with proper quoting.
*/
    
    $FFGALLERY_LOCATION = "http://localhost/ffgallery/ffgallery_devel";    // the location of ffGallery e.g. http://www.example.com/ffGallery (no trailing slash)
    
    $EXTRA_PAGES = array('home',);          // list of extra pages you want displayed these are text files located in the _extras directory
    
    $START_ALBUM = "";       // what album directory to display when the page loads, leave blank if using START_EXTRA
    $START_EXTRA = "home";                  // what page to display when the page loads, leave blank if using START_ALBUM
    $TITLE_BLOCK = "ffGallery";     // text or image above the gallery
    
    $ABOUT_ME = "<A href='http://sourceforge.net'> <IMG src='http://sourceforge.net/sflogo.php?group_id=140947&amp;type=5' width='210' height='62' border='0' alt='SourceForge.net Logo' /></A>";                 // text to display on the about page
    $ABOUT_ME_IMG = "";             // put an HTML IMG tag here if you want an image on the about page

    $ALBUM_HEADER = "";             // text printed above the album list
    $ALBUM_FOOTER = "";             // text printed below the album list
    
    $DEFAULT_IMAGE_HEADER = "";     // text printed above the image name in the image description section
    $DEFAULT_IMAGE_FOOTER = "";     // text printed below the image name in the image description section
    
    $THUMBNAIL_SIZES = Array(100,400);  // a two number array giving the size in pixels of the long sides of the thumbnails,
                                        // these are assumed to be in the order smallest to largest
    
    $LINK_TO_FULL_IMAGE = true;    // set to true if you want a link to the full size image
	$FULL_IMAGE_RESIZED_TO_SCREEN = false;    // set to true if you want the full size image to be resized to the screen size (false will display the real size)
    
    $SORT_IMAGES = 'asc';		// images for each gallery are sorted by filename in either ascending (asc) or descending (desc) order
    
    $LANGUAGE = "en";           // which language file to load, see the '_lang' folder for options
    
    $ADMIN_NAME = "admin";      // administrator username
    $ADMIN_PASSWD = "admin";    // administrator password
/**************************************************************************************************/
    
    
/* Advanced Config
Change these values only if you know what you are doing.
The defaults should be good enough for most everyone.
*/
    $COMPRESS_OUTPUT = true;        		// change to false if your server doesn't support zlib compression
    $FFGALLERY_ROOT = dirname(__FILE__);	// root location of ffGallery
    
?>