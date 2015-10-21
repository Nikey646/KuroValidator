<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 11:17 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator\Rules;

use KuroThing\KuroValidator\Interfaces\IRule;

class MatchesRule implements IRule {

	private $matchesField = "***UNINITIALIZED***";

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName() {
		return "matches";
	}

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage() {
		return "%1\$s must match the \"{$this->matchesField}\" field.";
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
		if ($conditions === null)
			return false;
		$this->matchesField = $matchingField = (isset($conditions->data)) ? $conditions->data : $conditions->field;
		if (isset($conditions->fieldName))
			$this->matchesField = $conditions->fieldName;

		if (!isset($inputData[$matchingField]))
			return false;

		return $inputData[$matchingField] === $value;
	}
}