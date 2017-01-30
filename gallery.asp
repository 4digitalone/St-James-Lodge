<%@LANGUAGE="VBSCRIPT"%>
<!--#include file="Connections/connPictures.asp" -->
<%
Dim rsPictures
Dim rsPictures_cmd
Dim rsPictures_numRows

Set rsPictures_cmd = Server.CreateObject ("ADODB.Command")
rsPictures_cmd.ActiveConnection = MM_connPictures_STRING
rsPictures_cmd.CommandText = "SELECT * FROM Photographs" 
rsPictures_cmd.Prepared = true

Set rsPictures = rsPictures_cmd.Execute
rsPictures_numRows = 0
%><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>St. James Lodge Number 80 What Is FreeMasonry</title>

<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css" />
<![endif]-->
<link href="css/Validate flyout.css" rel="stylesheet" type="text/css">
<link href="css/stjamessite.css" rel="stylesheet" type="text/css">
</head>

<body id="section-marker">
<div id="wrapper">
<div id="banner">
<div id="breadcrumbs">
<a href="index.html">Home</a> &gt; Gallery</div>
</div>
<div id="menucontent">
<div class="menu">
<ul>
<li><a href="index.html">HOME<!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<li><a href="whatismasonry.html">FREEMASONRY?<!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<li><a href="stjameshistory.html">LODGE HISTORY<!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<li><a href="archives.html">ARCHIVES<!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul>
		<li><a href="notices.html" title="a coded list of spies">notices</a></li>
		<li><a href="bulletins.html" title="a horizontal vertical menu">bulletins</a></li>
		<li><a href="onthelevel.html" title="an enlarging unordered list">on the level</a></li>
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<li><a href="gallery.html">GALLERY<!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<!--<ul>
		<li><a href="../mozilla/dropdown.html" title="A drop down menu">drop down menu</a></li>
		<li><a href="../mozilla/cascade.html" title="A cascading menu">cascading menu</a></li>
		<li><a href="../mozilla/content.html" title="Using content:">content:</a></li>
		<li><a href="../mozilla/moxbox.html" title=":hover applied to a div">mozzie box</a></li>
		<li><a href="../mozilla/rainbow.html" title="I can build a rainbow">rainbow box</a></li>
		<li><a href="../mozilla/snooker.html" title="Snooker cue">snooker cue</a></li>
		<li><a href="../mozilla/target.html" title="Target Practise">target practise</a></li>
	</ul>-->
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
<li><a href="contactus.html">CONTACT<!--[if IE 7]><!--></a><!--<![endif]-->
	<!--[if lte IE 6]><table><tr><td><![endif]-->
	<!--<ul class="right_side">
		<li><a href="../ie/exampleone.html" title="Example one">example one</a></li>
		<li><a href="../ie/weft.html" title="Weft fonts">weft fonts</a></li>
		<li><a href="../ie/exampletwo.html" title="Vertical align">vertical align</a></li>
	</ul>-->
	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>

	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
</li>
</ul>
</div>
</div>

<div id="content">
<div class="container">
<h1>Picture Gallery</h1>
  
  <p>The following galleries should give you an idea of the kinds of activities
    that St. James is involved in about the district. It will be updated as new
    events arise so check back on a regular bases.</p>
    <h3>
    Choose from the following. 
    </h3>
    <ul id="pictures">
    <li><a href="#">Christmas 2005</a></li>
    <li><a href="#">Christmas 2007</a></li>
    </ul>
  </div>
</div>
<div id="rightcontainer">
<div class="content">
<h1>Famous Masons in History</h1>
<h2>Born August 11, 1950</h2>
<p><img src="images/wozniak_s.jpg" alt="A Picture of a famous mason Johann Sebastian Bach" width="200" height="274" class="imgright">
<p>Co-founder of Apple Computers with Steve Jobs, Wozniak continues to be a major donor to numerous needy goups and students. He has received uncountable awards from technology and community groups.</p>
<h3>Charity Lodge No. 362, Campbell, CA:</h3>
<ul>
<li>Initiated:1980</li>
</ul>
<p class="source">Source: www.woz.org [accessed 2007/05/14].</p>
<h2>September 18, 1895 - August 16, 1979</h2>
<p><img src="images/diefenbaker_j.jpg" alt="A Famous Mason in History Henry Ford" width="200" height="274" class="imgright">	
<p>A sucessful lawyer, and Conservative Member of Parliament from 1940 until his death in 1979, Diefenbaker was Canadian Prime Minister from June 21, 1957 to April of 1963. He was Chancellor of the University of Saskatchewan from 1969 until his death.</p>
<ul>
<li>Initiated: September 11, 1922</li>
<li>Passed: October 9, 1922</li>
<li>Raised: November 7, 1922</li>
</ul>
<h3>Wakaw Lodge No. 166, Wakaw, Saskatchewan Affiliated:</h3>
<h3>Kinistino Lodge No. 1, Saskatchewan Member:</h3>
<p>Active with concordant and appendant bodies </p>
</div>
</div>
<div id="footer"> 
 <div class="footercontainer">
   <p>Copyright &copy; St. James Lodge 80 White Rock BC Canada</p>
<p><a href="#">Privacy Policy</a> | All Rights Reserved</p>
 <ul> 
 <li><a href="#" onFocus="if(this.blur)this.blur()">Home</a></li>
 <li><a href="#" onFocus="if(this.blur)this.blur()">What is Freemasonry</a></li>
 <li><a href="#" onFocus="if(this.blur)this.blur()">St. James History</a></li>
 <li><a href="#" onFocus="if(this.blur)this.blur()">Archives</a></li>
 <li><a href="#" onFocus="if(this.blur)this.blur()">Gallery</a></li>
 <li><a href="#" onFocus="if(this.blur)this.blur()">Contact</a></li>
 </ul>
 
 </div>
 </div>
</div></body>
</html>
<%
rsPictures.Close()
Set rsPictures = Nothing
%>
