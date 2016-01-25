<?php

$file = __DIR__ . "/../XML-Simple.php";
require($file);

if (!$argv[1]) {
	print "Usage: $argv[0] [XML String or file.xml]\n";
	exit;
}

$data = $argv[1];

$i = \scottchiefbaker\xml::XMLin($data);
print json_encode($i);
