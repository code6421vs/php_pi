<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
include "php_serial.class.php";

if(empty($_GET)){
  echo "<p><a href=\"example.php?data=0002000055000000\">Red</a>";
  echo "<p><a href=\"example.php?data=0002000000550000\">Green</a>";
  echo "<p><a href=\"example.php?data=0002000000005500\">Blue</a>";
  exit;
}
// Let's start the class
$serial = new phpSerial;

// First we must specify the device. This works on both linux and windows (if
// your linux serial device is /dev/ttyS0 for COM1, etc)
$serial->deviceSet("/dev/ttyAMA0");

// We can change the baud rate, parity, length, stop bits, flow control
$serial->confBaudRate(19200);
$serial->confParity("none");
$serial->confCharacterLength(8);
$serial->confStopBits(1);
$serial->confFlowControl("none");

// Then we need to open it
$serial->deviceOpen();

$rawstr = $_GET["data"];

$c1 = "FF33";
$c1 .= $rawstr;
$c1 .="FF";
$str = pack("H*", $c1);


// To write into
$serial->sendMessage($str);

// If you want to change the configuration, the device must be closed
$serial->deviceClose();

echo "<p><a href=\"example.php?data=0002000055000000\">Red</a>";
echo "<p><a href=\"example.php?data=0002000000550000\">Green</a>";
echo "<p><a href=\"example.php?data=0002000000005500\">Blue</a>";


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
