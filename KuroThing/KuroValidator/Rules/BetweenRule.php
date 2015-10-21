<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 12:55 PM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class BetweenRule implements IRule {

	private $lower	= -1,
			$higher	= -1;

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "between";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s is not between {$this->lower} and {$this->higher}";
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
		if ($conditions === null || isset($conditions->data))
			return false;

		if (!isset($conditions->lower) || !isset($conditions->higher))
			return false;

		$this->lower	= $lower	= $conditions->lower;
		$this->higher	= $higher	= $conditions->higher;

		return ($value >= $lower && $value <= $higher) ? true : false;
	}
}