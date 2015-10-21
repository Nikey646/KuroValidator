<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 1:42 AM
 * Copyright © Nikey646, 2015-2015. All rights reserved.
 */

namespace KuroThing\KuroValidator\Interfaces;

interface IRule {

	/**
	 * The name of the rule.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * The sprintf formatted string
	 * %1, Field
	 * %2, Value
	 *
	 * @return string
	 */
	public function getFailureMessage();

	/**
	 * Can this rule be safely skipped? Is it important that validation stops here?
	 *
	 * @return boolean
	 */
	public function getCanSkip();

	public function __invoke(\stdClass  $conditions = null, $value, $inputData);

}