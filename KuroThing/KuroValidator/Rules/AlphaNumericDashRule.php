<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 12:53 PM
 * Copyright � Nikey646, 2015-2015.
 *           � Alex Garrett, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class AlphaNumericDashRule implements IRule {

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "alphanumericdash";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s contains non Alpha/Numeric/Dash character(s).";
	}

	/**
	 * Can this rule be safely skipped? Is it important that validation stops here?
	 *
	 * @return boolean
	 */
	public function getCanSkip() {
		return true;
	}

	// Credits: https://github.com/alexgarrett/violin/blob/master/src/Rules/AlnumDashRule.php
	public function __invoke(\stdClass $conditions = null, $value, $inputData) {
		return (bool) preg_match('/^[\pL\pM\pN_-]+$/u', $value);
	}
}