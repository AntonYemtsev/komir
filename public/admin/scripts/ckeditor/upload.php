<?php
    $callback = $_GET['CKEditorFuncNum'];
    $file_name = $_FILES['upload']['name'];
    $file_name_tmp = $_FILES['upload']['tmp_name'];
    $extension = pathinfo($file_name, PATHINFO_EXTENSION); 
    $file_new_name = $_SERVER['DOCUMENT_ROOT'] . '/upload_text_photo/';
    $full_path = $file_new_name.time().'__'.md5($file_name).'.'.$extension;
    $http_path = '/upload_text_photo/'.time().'__'.md5($file_name).'.'.$extension;
    $error = '';
	if( move_uploaded_file($file_name_tmp, $full_path) ) {
    } else {
     $error = 'Some error occured please try again later';
	 $error = var_dump(move_uploaded_file($file_name_tmp, $full_path) );
     $http_path = '';
    }
    echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";

    ?>