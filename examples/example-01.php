<?php

require("../XML-Simple.php");

$file = "list_users.xml";
$hash = \scottchiefbaker\xml::XMLin($file);

print_r($hash);
