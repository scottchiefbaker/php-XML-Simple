<?php

$file = __DIR__ . "/../XML-Simple.php";
require($file);

use PHPUnit\Framework\TestCase;

class Core extends TestCase
{
    public function test_XML_Simple() {
		$xml = "";
		$this->assertEquals(\scottchiefbaker\xml::XMLin($xml),false);

		$xml = "<foo>bar</foo>";
		$this->assertEquals(\scottchiefbaker\xml::XMLin($xml),"bar");

		$xml = '<foo class="root">bar</foo>';
		$this->assertEquals(\scottchiefbaker\xml::XMLin($xml),array("content" => "bar", "class" => "root"));

		$xml = '<i><foo class="root">bar</foo></i>';
		$this->assertEquals(\scottchiefbaker\xml::XMLin($xml),array("foo" => array("content" => "bar", "class" => "root")));

		$xml = '<i><foo class="root">bar</foo><foo class="root">bar</foo></i>';
		$result = json_decode('{"foo":[{"content":"bar","class":"root"},{"content":"bar","class":"root"}]}',true);
		$this->assertEquals(\scottchiefbaker\xml::XMLin($xml),$result);

		$result = json_decode('{"code":"1","message":"Success","user_list":{"mailbox":[{"content":"bstrunk@domain.com","status":"active","modtime":"20150528222906Z"},{"content":"sstauss@domain.com","status":"active","modtime":"20150818150143Z"},{"content":"shenkes@domain.com","status":"active","modtime":"20151026164155Z"},{"content":"mjones@domain.com","status":"active","modtime":"20150818172450Z","nugent":"awesome"}],"retro":"cool"},"version":"1.9"}',true);
		$file = __DIR__ . "/list_users.xml";
		$this->assertEquals(\scottchiefbaker\xml::XMLin($file),$result);

		$this->assertEquals(\scottchiefbaker\xml::XMLin("empty.xml"),false);
    }

} // End of class
