<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 11:30 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class MaxRule implements IRule {

	private $maximum = -1;

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "max";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s cannot be longer than {$this->maximum}";
	}

	/**
	 * Can this rule be safely skipped? Is it important that validation stops here?
	 *
	 * @return boolean
	 */
	public function getCanSkip() {
		return true;
	}

	public function __invoke(\stdClass $conditions = null, $value, $inputData) {
		if ($conditions === null)
			return false;
		$this->maximum = $max = (isset($conditions->data)) ? $conditions->data : $conditions->max;

		if (is_string($value)) {
			if (function_exists("mb_strlen"))
				return mb_strlen($value) <= $max;
			return strlen($value) <= $max;
		}

		return !($value >= $max);
	}
}