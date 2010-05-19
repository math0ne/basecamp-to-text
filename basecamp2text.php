<?php

/**
  ##############################################################################
  # Copyright © 2010 Aidan McQuay
  #
  # This work is licenced under the Creative Commons BSD License License. To
  # view a copy of this licence, visit http://creativecommons.org/licenses/BSD/
  # or send a letter to Creative Commons, 171 Second Street, Suite 300,
  # San Francisco, California 94105, USA.
  ##############################################################################
*/



$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'FEEDURL');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_USERPWD, "NAME:PASS");

curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$file_contents = curl_exec($ch);
curl_close($ch);


$mydata = simplexml_load_string($file_contents);

$output = "Basecamp Feed\n\n";

$count = 0;

if($mydata->channel->item){
  
  foreach($mydata->channel->item as $item){
    
    if($count < 10){
     
      $tmp = ereg_replace("/\n\r|\r\n/", "", $item->title);  
      
      $tmp = str_replace(chr(10), '', $tmp);
      
      $length = strlen($tmp);
      
      $output .= "* ".$tmp."\n";
    
      
    }
    $count++;
  }
  
  $myFile = "basecamp.txt";
  $fh = fopen($myFile, 'w') or die("can't open file");
  $stringData = $output;
  fwrite($fh, $stringData);
  fclose($fh);

}