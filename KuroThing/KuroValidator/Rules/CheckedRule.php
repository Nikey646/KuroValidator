<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 12:15 PM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class CheckedRule implements IRule {

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "checked";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s is not checked.";
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
		if (function_exists("mb_strtolower"))
			return in_array(mb_strtolower($value), ["true", "yes", "on", "1", true, 1], true);
		return in_array(strtolower($value), ["true", "yes", "on", "1", true, 1], true);
	}
}