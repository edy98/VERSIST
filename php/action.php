<?php
$fn = (isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : false);
$targetDir = 'tmp/';

if ($fn) {
            if (isFileValid($fn)) {
              // AJAX call
              file_put_contents(
                $targetDir . $fn,
                file_get_contents('php://input')
              );
              removeFile($fn);
            }
}

function removeFile($file) {
  unlink($targetDir . $file);
}
?>
