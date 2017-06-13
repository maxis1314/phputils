<?php
class Validate {
	var $msg;
	function check() {

	}
}

class IntValidate extends Validate {
	function __construct() {

	}
	function check($value) {
		if (!preg_match('/^\d+$/', $value)) {
			$this->msg = "must be a number";
			return false;
		} else {
			return true;
		}
	}
}

class AuthPicValidate extends Validate {
	function __construct() {

	}
	function check($value) {
		if ($value != $_SESSION["authcode"]) {
			$this->msg = "input the right code in the picture";
			return false;
		} else {
			return true;
		}
	}
}

class EngValidate extends Validate {
	function __construct() {

	}
	function check($value) {
		if (!preg_match('/^\w+$/', $value)) {
			$this->msg = "should only contail english characters and numbers";
			return false;
		} else {
			return true;
		}
	}
}

class NotNullValidate extends Validate {
	function __construct() {

	}
	function check($value) {
		if ($value && $value != "") {
			return true;
		} else {
			$this->msg = "need to be filled";
			return false;
		}
	}
}

class EmailValidate extends Validate {
	function __construct() {

	}
	function check($value) {
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $value)) {
			$this->msg = "not a valid email";
			return false;
		} else {
			return true;
		}
	}
}

class LengthValidate extends Validate {
	var $min;
	var $max;
	function __construct($min, $max) {
		$this->min = $min;
		$this->max = $max;
		$this->msg = "length should between $min and $max";
	}
	function check($value) {
		if (strlen($value) >= $this->min && strlen($value) <= $this->max) {
			return true;
		} else {
			return false;
		}
	}
}

class RangeValidate extends Validate {
	var $min;
	var $max;
	function __construct($min, $max) {
		$this->min = $min;
		$this->max = $max;
		$this->msg = "not in the range ($min,$max)";
	}
	function check($value) {
		if ($value >= $this->min && $value <= $this->max) {
			return true;
		} else {
			return false;
		}
	}
}

class RegexValidate extends Validate {
	var $regex;

	function __construct($regex) {
		$this->regex = $regex;
		$this->msg = "format is wrong";
	}
	function check($value) {
		if (!preg_match($this->regex, $value)) {
			return false;
		} else {
			return true;
		}
	}
}

class YMDValidate extends Validate {
	function __construct() {
		$this->msg = "need to be filled correctly";
	}
	function check($value) {
		if (!checkdate($value[1], $value[2], $value[0])) {
			return false;
		} else {
			return true;
		}
	}
}

class PasswordValidate extends Validate {
	function __construct() {
		$this->msg = "password are not the same";
	}
	function check($value) {
		if (!is_array($value)) {
			$value = explode(",", $value);
		}
		if (!$value[0]) {
			$this->msg = "password should not be empty";
			return false;
		}
		if ($value[0] != $value[1]) {
			return false;
		} else {
			return true;
		}
	}
}
?>