<?php

require("../XML-Simple.php");

$i = array(
	"first" => "Scott",
	"last"  => "Baker",
	"phone" => array("aaa","bbb","ccc",array("zzz","qqqq","rrr")),
	"likes" => array("animal" => "kitten", "ice cream" => "cherry"),
	"age"   => 36,
);

$a = \scottchiefbaker\xml::XMLout($i);

print_r($a);

$b = \scottchiefbaker\xml::XMLin($a);

var_dump($b);
