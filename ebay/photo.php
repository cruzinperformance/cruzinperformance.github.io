<?php

/**
 * Image.php
 * 
 * Class definition for photo-related routines.
 * 
 * Adam Jensen <ajensen@linuxguy.org>
 * 2/22/2005 09:24
 *
 * @version $Id$
 * @copyright 2005 
 **/

 class Photo
 {
	// Constructs "Image Tile" using the given case, file, and caption.
	function builduploadtile()
	{							
			echo '<form enctype="multipart/form-data" method="post" action="photo_upload.php">
				<tr><td style="border-top:1px dashed black" colspan="3" valign="top"><strong>Add New Photo</strong></tr><tr><td>
				</td>
			</tr>
			<tr>
				<td colspan="2" valign="top">
					<input type="file" name="upload" size="22"> named <input type="text" name="filename"> 	<input type="submit" name="submit" value="Upload Photo">
					</form>
				</td>
			</tr>';
	}
	
	
	// thumbnail()
	// 
	// Automatically thumbnail (original image size-->100xShortDim) and display photo.
	//
	// Takes a filename as its argument.  Will be checked for validity.
	//
	function thumbnail($photo)
	{		
		// File name and new size
		$filename = $photo;
		
		// First, make sure it's a valid file.
		if (!file_exists($filename))
		{
		    return imagejpeg(imagecreatefromjpeg("images/photonotfound.jpg"));
			
		}
		
		// Determine the greatest dimension; we're flexible.
		list($width, $height) = getimagesize($filename);
		
		// Use this for the rare square (width == height) case as well.
		if ($width > $height || $width == $height)
		{
			// Determine scale
			$scale = (90 / $width);
			
			// Rescale
			$newwidth = 90;
			$newheight = ($height * $scale);
			
			// Build thumbnail
			$thumb = imagecreate($newwidth, $newheight);
			$source = imagecreatefromjpeg($photo);
			
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			
			// Send it!
			return imagejpeg($thumb);
		}
		else if ($height > $width)
		{
		 	// Determine scale
			$scale = (90 / $height);
			
			// Rescale
			$newheight = 90;
			$newwidth = ($width * $scale);
			
			// Build thumbnail
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$source = imagecreatefromjpeg($filename);
			
			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			
			// Send it!
			return imagejpeg($thumb);
		}
	}
 }
 
 if ($_GET["photo"])
 {
	header("Content-type: image/jpeg");
 	echo Photo::thumbnail($_GET["photo"]); 
 }
?>
