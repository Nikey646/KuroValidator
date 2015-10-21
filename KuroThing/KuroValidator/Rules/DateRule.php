<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 12:59 PM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class DateRule implements IRule {

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "date";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s is not a valid Date.";
	}

	/**
	 * Can this rule be safely skipped? Is it important that validation stops here?
	 *
	 * @return boolean
	 */
	public function getCanSkip() {
		return true;
	}

	// Credits: https://github.com/alexgarrett/violin/blob/master/src/Rules/DateRule.php
	public function __invoke(\stdClass $conditions = null, $value, $inputData) {
		if ($value instanceof DateTime)
			return true;

		if (!is_string($value))
			return false;

		if (!strtotime($value))
			return false;

		$date = date_parse($value);
		return checkdate($date["month"], $date["day"], $date["year"]);
	}
}