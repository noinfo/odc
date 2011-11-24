<?php
/*************************************************************************************************
						Welcome to ODC: On Demand CMS version 0.3
						
			It is meant to be a quick, simple and highly adaptable solution to add 
			editable regions to existing webpages.
			
	This version makes use of nicedit (www.nicedit.com) to provide a more user-friendly way
	to edit content. ODC was written by Fabian Meyer (www.noinfo.de) on the 5th and 6th of 
	december 2010. 
	
	Disclaimer: This software is provided as-is and I will not be held responsible for any 
	damages that come from using this software.
	
	This software is written and meant to be in the back-end of a webpage, ideally behind a
	.htaccess to restrict access only to authorized parties. As such no sanitation of strings 
	has been made when connecting to the database as it is assumed that only authorized persons 
	can access the back-end (and that those won't try SQL-injection attacks, as they could 
	simply delete all content using the edit functions).
*************************************************************************************************/

/************  general configuration  ************/

$GLOBALS['simple_text_area'] 	= FALSE;	// use a simple text area instead of nicedit

$GLOBALS['deletable']			= TRUE;		// is it possible to delete stubs?

$GLOBALS['edit_link']			= "edit_content.php";	// link to the edit-script
$GLOBALS['manage_link'] 		= "manage_content.php";	// link to the management-script
											// HINT: may be the same script
											
$GLOBALS['odc_dir']				= "odc/";	// directory containing the ODC files											
											
$GLOBALS['basedir']				= "";		// basedir if there needs to be an offset to provide 
											// correct links in the management-list
											
/************  markdown configuration  ************/

$GLOBALS['enable_markdown']		= TRUE;				// determines whether markdown should be 
													// enabled 

$GLOBALS['MD_file']				= "php-markdown/markdown.php";	// path to the markdown interpreter
											
/************    nicEdit related    ************/


$NCE_script_path 		= "http://js.nicedit.com/nicEdit-latest.js"; // latest version from official website 
//$NCE_script_path 		= "odc/nicedit/nicEdit.js"; 				// alternatively you can specify a path to
																	// your local installation here (relative to working site)

$NCE_editor_options 	= "{iconsPath : 'odc/nicedit/nicEditorIcons.gif', fullPanel : true, uploadURI : 'http://exp.noinfo.de/ondemandcms/odc/nicedit/nicUpload.php'}";

/*
If you use the button list here are all supported config options 
EXAMPLE: buttonList : ['bold','italic','underline']

'bold'
'italic'
'underline'
'left'
'center'
'right'
'justify'
'ol'
'ul'
'subscript'
'superscript'
'strikethrough'
'removeformat'
'indent'
'outdent'
'hr'
'image'
'upload' * requires nicUpload
'forecolor'
'bgcolor'
'link' * requires nicLink
'unlink' * requires nicLink
'fontSize' * requires nicSelect
'fontFamily' * requires nicSelect
'fontFormat' * requires nicSelect
'xhtml' * required nicCode
*/

/*
	If you use NicUpload, remember to set the options in the first lines of nicUpload.php
	and remember that the upload-directory must be chmod 777 !
*/

function odc_db_connect(){ // do not change this line!
/************ database configuration ************/
	$db_host 		= "localhost";
	$db_user	 	= "tester";
	$db_name 		= "testing";
	$db_passwort 	= "testing";

/************   configuration END   ************/	
/*************************************************************************************************/
/*             ! leave the rest untouched unless you know what you're doing !                    */
/*************************************************************************************************/

	$connection = mysql_connect($db_host, $db_user, $db_passwort);

	if($connection){
		// choose database
		mysql_query("USE $db_name", $connection);
		// use utf-8
		mysql_query("SET NAMES 'utf8';"); 
		return ($connection);
	}else{
		return(NULL);
	}
}


?>