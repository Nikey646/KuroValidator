<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 11:24 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class MinRule implements IRule {

	protected $minimum = -1;

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "min";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s must be a minimum of \"{$this->minimum}\"";
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
		$this->minimum = $min = (int) isset($conditions->data) ? $conditions->data : $conditions->min;

		if (is_string($value)) {
			if (function_exists("mb_strlen"))
				return mb_strlen($value) >= $min;
			return strlen($value) >= $min;
		}

		return !($value <= $min);
	}
}