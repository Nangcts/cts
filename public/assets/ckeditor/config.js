/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
var baseUrl = document.location.origin;

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'vi';
	// config.uiColor = '#AADC6E';
		config.removeButtons = 'Underline,Subscript,Superscript';
		config.filebrowserBrowseUrl = baseUrl+'/assets/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
		 
		config.filebrowserImageBrowseUrl = baseUrl+'/assets/filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
		 
		config.filebrowserFlashBrowseUrl = baseUrl+'/assets/ckfinder/ckfinder.html?type=Flash';
		 
		config.filebrowserUploadUrl = baseUrl+'/assets/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
		 
		config.filebrowserImageUploadUrl = baseUrl+'/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		 
		config.filebrowserFlashUploadUrl = baseUrl+'/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
		CKEDITOR.config.allowedContent = true;

};
