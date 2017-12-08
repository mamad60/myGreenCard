<?php
header('Content-Type: text/plain; charset=utf-8');
if (!is_ajax()) { // If it is real Ajax Request}
die('NO Ajax Request!');
}
$target_dir = "../uploads/";
$fileName=$_POST['fileName'];
$sourcePath = $_FILES[$fileName]['tmp_name'];
$output=[];
$maxFileSize=240000; // Maxium file size allowed (bytes)
// Check for Errors
try { 
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES[$fileName]['error']) ||
        is_array($_FILES[$fileName]['error'])
    ) {
        throw new RuntimeException('ورودی ها نامعتبر است.');
    }

    // Check $_FILES[$fileName]['error'] value.
    switch ($_FILES[$fileName]['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('فایلی برای آپلود ارسال نشده است.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('ابعاد فایل ارسالی بیش از حد مجاز است.');
        default:
            throw new RuntimeException('خطای ناشناخته در فرآیند آپلود فایل روی داده است.');
    }

    // You should also check filesize here. 
    if ($_FILES[$fileName]['size'] > $maxFileSize) {
        throw new RuntimeException('اندازه فایل بیش از حد تعیین شده است.');
    }

    // DO NOT TRUST $_FILES[$fileName]['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($sourcePath),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('فرمت فایل ارسال شده غیرمجاز است.');
    }
    // check image size
    $size = getimagesize($sourcePath);
    if(($size[0]<=590 || $size[0]>=610 ) || ($size[1]<=590 || $size[1]>=610)){
        throw new RuntimeException('ابعاد فایل آپلود شده باید 600 در 600 پیکسل باشد.');        
    }
    // You should name it uniquely.
    // DO NOT USE $_FILES[$fileName]['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $targetFileName=sprintf($target_dir.$fileName.'%s.%s',
sha1_file($sourcePath),$ext);

if(file_exists($targetFileName)){
    throw new RuntimeException('این فایل قبلا آپلود شده است.');    
}
    if (!move_uploaded_file(
        $sourcePath,$targetFileName))
         {
        throw new RuntimeException('آپلود فایل به سرور ناموفق بود.');
    }  
   // Do somshing on successful upload
$output['imageURL']=str_replace('..\\','',$targetFileName);
//$img='<img src='.$targetFileName.' class="file-preview-image" alt="Desert" title="Desert">';
//$output=['initialPreview'=> $img ];
   
} catch (RuntimeException $e) {
    $err= $e->getMessage();
    $output = ['error'=> $err];   
}
//Return Message to client
echo json_encode($output); 

function is_ajax() //Function to check if the request is an AJAX request
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
