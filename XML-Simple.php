<?php

namespace scottchiefbaker;

class xml {
	static function XMLin($str) {
		if (is_file($str) && is_readable($str)) {
			$xml = file_get_contents($str);
			$obj = @simplexml_load_string($xml);

			return self::xml_to_hash($obj);
		} elseif (is_string($str)) {
			$obj = @simplexml_load_string($str);

			return self::xml_to_hash($obj);
		} else {
			return null;
		}
	}

	static function XMLout($array, $rootElement = null, $xml = null) {
		// @param array $array the array to be converted
		// @param string? $rootElement if specified will be taken as root element, otherwise defaults to
		//               <root>
		// @param SimpleXMLElement? if specified content will be appended, used for recursion
		// @return string XML version of $array
		$_xml = $xml;

		if ($_xml === null) {
			$_xml = new \SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
		}

		foreach ($array as $k => $v) {
			$k = preg_replace("/\s+/","_",$k);

			if (is_array($v)) { //nested array
				// Numeric array
				if (isset($v[0]) && !is_string($v)) {
						foreach ($v as $i) {
							if (is_array($i)) {
								self::XMLout($i, $v, $_xml->addChild($k));
							} else {
								$_xml->addChild($k, $i);
							}
						}
				// Assoc array
				} else {
					//print "v: $k\n";
					self::XMLout($v, $k, $_xml->addChild($k));
				}
			} else {
				$_xml->addChild($k, $v);
			}
		}

		return $_xml->asXML();
	}

	static function xml_to_hash($xml_obj) {
		if (is_object($xml_obj) && get_class($xml_obj) == 'SimpleXMLElement') {
			$has_children   = ($xml_obj->count() > 0);
			$has_attributes = ($xml_obj->attributes());
			$node_name      = $xml_obj->getName();
			$attrs          = $xml_obj->attributes();
			$r              = array();

			// Simple element: <foo>bar</foo>
			if (!$has_children && !$has_attributes) {
				return (string)$xml_obj;
				// Simple element with attribute: <foo class="baz">bar</foo>
			} elseif (!$has_children && $has_attributes) {
				$new_array["content"] = (string)$xml_obj;

				foreach ($attrs as $ak => $av) {
					$new_array[$ak] = (string)$av;
				}

				return $new_array;
				// Array of elements (there IS a child node)
			} else {
				foreach($xml_obj as $key => $value) {
					// Island node (no children)
					if (!$value->children()) {
						if (isset($r[$key][0]) && is_array($r[$key])) {
							$r[$key] = array_merge($r[$key],array((string)$value));
						} elseif (isset($r[$key])) {
							$r[$key] = array($r[$key],(string)$value);
						} else {
							$r[$key] = (string)$value;
						}
						// It's a brand new node
					} elseif (!isset($r[$key])) {
						$r[$key] = self::xml_to_hash($value);
						// It's a single element
					} elseif (!isset($r[$key][0]) || is_string($r[$key])) {
						$r[$key]   = array_values($r);
						$r[$key][] = self::xml_to_hash($value);
						// It's already an array
					} else {
						$r[$key][] = self::xml_to_hash($value);
					}
				}

				// Add the original attritubtes back as root level elements
				foreach($attrs as $k => $v) {
					$r[$k] = (string)$v;
				}

				return $r;
			}
		} elseif (empty($xml_obj)) {
			return false;
		}
	}

} // End of class
