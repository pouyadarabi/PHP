<?php

/* Tutorial by AwesomePHP.com -> www.AwesomePHP.com */
/* Function: download with resume/speed/stream options */

/*
 * Parametrs: downloadFile(File Location, File Name,
 * max speed, is streaming
 * If streaming - movies will show as movies, images as images
 * instead of download prompt
 */
function downloadFile($fileLocation, $fileName, $maxSpeed = 13, $doStream = false)
{
    if (connection_status() != 0)
        return (false);
    $array = explode('.', $fileName);
    $extension = strtolower(end($array));
    
    /* List of File Types */
    $fileTypes['swf'] = 'application/x-shockwave-flash';
    $fileTypes['pdf'] = 'application/pdf';
    $fileTypes['exe'] = 'application/octet-stream';
    $fileTypes['zip'] = 'application/zip';
    $fileTypes['doc'] = 'application/msword';
    $fileTypes['xls'] = 'application/vnd.ms-excel';
    $fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
    $fileTypes['gif'] = 'image/gif';
    $fileTypes['png'] = 'image/png';
    $fileTypes['jpeg'] = 'image/jpg';
    $fileTypes['jpg'] = 'image/jpg';
    $fileTypes['rar'] = 'application/rar';
    
    $fileTypes['ra'] = 'audio/x-pn-realaudio';
    $fileTypes['ram'] = 'audio/x-pn-realaudio';
    $fileTypes['ogg'] = 'audio/x-pn-realaudio';
    
    $fileTypes['wav'] = 'video/x-msvideo';
    $fileTypes['wmv'] = 'video/x-msvideo';
    $fileTypes['avi'] = 'video/x-msvideo';
    $fileTypes['asf'] = 'video/x-msvideo';
    $fileTypes['divx'] = 'video/x-msvideo';
    
    $fileTypes['mp3'] = 'audio/mpeg';
    $fileTypes['mp4'] = 'audio/mpeg';
    $fileTypes['mpeg'] = 'video/mpeg';
    $fileTypes['mpg'] = 'video/mpeg';
    $fileTypes['mpe'] = 'video/mpeg';
    $fileTypes['mov'] = 'video/quicktime';
    $fileTypes['swf'] = 'video/quicktime';
    $fileTypes['3gp'] = 'video/quicktime';
    $fileTypes['m4a'] = 'video/quicktime';
    $fileTypes['aac'] = 'video/quicktime';
    $fileTypes['m3u'] = 'video/quicktime';
    
    $contentType = $fileTypes[$extension];
    
    header("Cache-Control: public");
    header("Content-Transfer-Encoding: binary\n");
    header("Content-Type: $contentType");
    
    $contentDisposition = 'attachment';
    
    if ($doStream == true) {
        /* extensions to stream */
        $array_listen = array(
            'mp3',
            'm3u',
            'm4a',
            'mid',
            'ogg',
            'ra',
            'ram',
            'wm',
            'wav',
            'wma',
            'aac',
            '3gp',
            'avi',
            'mov',
            'mp4',
            'mpeg',
            'mpg',
            'swf',
            'wmv',
            'divx',
            'asf'
        );
        if (in_array($extension, $array_listen)) {
            $contentDisposition = 'inline';
        }
    }
    
    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
        $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
        header("Content-Disposition: $contentDisposition; filename=" . $fileName);
    } else {
        header("Content-Disposition: $contentDisposition; filename=" . $fileName);
    }
    
    header("Accept-Ranges: bytes");
    $range = 0;
    
    $fileLocation = $fileLocation . $fileName;
    
    $size = filesize($fileLocation);
    
    if (isset($_SERVER['HTTP_RANGE'])) {
        list ($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);
        
        $range = str_replace($range, "-", $range);
        $size2 = $size - 1;
        $new_length = $size - $range;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range$size2/$size");
    } else {
        $size2 = $size - 1;
        header("Content-Range: bytes 0-$size2/$size");
        header("Content-Length: " . $size);
    }
    
    if ($size == 0) {
        die('Zero byte file! Aborting download');
    }   
    if(get_magic_quotes_runtime()){
      set_magic_quotes_runtime(0);
    }
    $fp = fopen("$fileLocation", "rb");
    
    fseek($fp, $range);
    
    while (! feof($fp) and (connection_status() == 0)) {
        set_time_limit(0);
        print(fread($fp, 1024 * $maxSpeed));
        flush();
        ob_flush();
        sleep(1);
    }
    fclose($fp);
    
    return ((connection_status() == 0) and ! connection_aborted());
}

/* Implementation */

downloadFile('file/', 'test.zip', 900, false); 
