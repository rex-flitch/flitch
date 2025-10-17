<?php

 require_once('../../dbconn.php');

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


  $sql = "update listitems set archive = '1' where archive = '0'";
  

  $conn->query($sql);
    
  $conn->close();

  //send a JSON encded array to client
   
  echo json_encode(array('success'=>1));