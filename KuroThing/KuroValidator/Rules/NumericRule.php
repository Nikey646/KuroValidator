<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 11:39 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class NumericRule implements  IRule {

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "number";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s is not a valid number.";
	}

	/**
	 * Can this rule be safely skipped? Is it important that validation stops here?
	 *
	 * @return boolean
	 */
	public function getCanSkip() {
		return false;
	}

	public function __invoke(\stdClass $conditions = null, $value, $inputData) {
		return is_numeric($value);
	}
}