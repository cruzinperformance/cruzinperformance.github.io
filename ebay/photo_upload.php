<html>
<head><title>Upload Photo Utility</title></head>
<body>
<?php

/**
 * sids_photos.php
 * 
 * Photo viewing/editing section of SUIDIRSystem.
 * 
 * Adam Jensen <ajensen@linuxguy.org>
 * 2/22/2005 10:58
 *
 * @version $Id$
 * @copyright 2005 
 **/
 
 require_once("photo.php");
 
 // Are we uploading?
 if ($_POST["submit"] == "Upload Photo")
 {
	// Grab the file_name.
	//$file_name = $_FILES["upload"]["name"];
	$file_name = $_POST["filename"];
	// Reformat the file_name--remove slashes, quotes, etc.
	$file_name = stripslashes($file_name);
	$file_name = str_replace("'", "", $file_name);
	
	// Convert to lowercase (case-sensitive filesystem)
	$file_name = strtolower($file_name);
	
	// Write the file to disk.
	$status = copy($_FILES["upload"]["tmp_name"], "./" . $file_name);
	
	if ($status)
	{
		echo "<P><b>Status</b>: Upload succeeded for http://www.cruzinperformance.com/ebay/" . $file_name . "<P>";
		Photo::builduploadtile();
	}
	else
	{
		// Upload failed.
		echo "Image upload failed!";
	}
 }
 else
 { 
	// Give the option to load another photo.
	Photo::builduploadtile();
	
	echo "</table><P>";
 }
 
?>
</body>
</html>
