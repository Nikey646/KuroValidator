<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 11:00 AM
 * Copyright © Nikey646, 2015-2015.
 *           © Alex Garrett, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class RequiredRule implements IRule {

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "required";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s is required.";
	}

	/**
	 * Can this rule be safely skipped? Is it important that validation stops here?
	 *
	 * @return boolean
	 */
	public function getCanSkip() {
		return false;
	}

	// Credits: https://github.com/alexgarrett/violin/blob/master/src/Rules/RequiredRule.php
	public function __invoke(\stdClass $conditions = null, $value, $inputData) {
		if ($value === 0) {
			return true;
		}

		$value = trim($value);
		$value = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $value);

		return !empty($value);
	}
}