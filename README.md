PHP XML Simple
==============

Namespaced libary to parse XML into a hash data structure. Other implementations also do this, but ignore attributes. This library handles attributes correctly.

This library is based on the Perl library: [XML::Simple](https://metacpan.org/pod/XML::Simple). Much care was taken to make the output of this PHP library mimic [XML::Simple](https://metacpan.org/pod/XML::Simple).

Usage:
------
```PHP
require("/path/to/XML-Simple.php");

$hash = \scottchiefbaker\xml\XMLin($filename);
$hash = \scottchiefbaker\xml\XMLin($xml_string);
```
