<?php
error_reporting(E_ALL);
ini_set('display_errors','1');

$rawstr = $_GET["data"];

$c1 = "33";
$c1 .= $rawstr;

$str = "";

$length = strlen($c1);
if($length < 4) {
   echo "bad request";
   exit;
}

$i = 0;
for ($i = 0; $i < $length; $i++) {
   if(($i % 2) == 0)
      $str .= "\\x";
   $str .=$c1[$i];
}

$cmd  = "printf \"";
$cmd .= $str;
$cmd .= "\"";

exec("stty -F /dev/ttyAMA0 19200");
exec($cmd);

echo $cmd;

//
//
/* Notes from Jim :
> Also, one last thing that would be good to document, maybe in example.php:
>  The actual device to be opened caused me a lot of confusion, I was
> attempting to open a tty.* device on my system and was having no luck at
> all, until I found that I should actually be opening a cu.* device instead!
>  The following link was very helpful in figuring this out, my USB/Serial
> adapter (as most probably do) lacked DTR, so trying to use the tty.* device
> just caused the code to hang and never return, it took a lot of googling to
> realize what was going wrong and how to fix it.
>
> http://lists.apple.com/archives/darwin-dev/2009/Nov/msg00099.html

Riz comment : I've definately had a device that didn't work well when using cu., but worked fine with tty. Either way, a good thing to note and keep for reference when debugging.
 */ 
?>
