<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 1:39 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator;

use KuroThing\KuroValidator\Interfaces\IRule;

class Validator {

	protected $rules		= [];
	protected $callbacks	= [];

	public function __construct() {
		$names = [
			"alphanumericdash", "alphanumeric", "alpha", "array", "between", "bool",
			"checked", "date", "email", "ip", "matches", "max", "min",
			"number", "regex", "required", "url"
		];
		$classes = [
			"\\KuroThing\\KuroValidator\\Rules\\AlphaNumericDashRule",
			"\\KuroThing\\KuroValidator\\Rules\\AlphaNumericRule",
			"\\KuroThing\\KuroValidator\\Rules\\AlphaRule",
			"\\KuroThing\\KuroValidator\\Rules\\ArrayRule",
			"\\KuroThing\\KuroValidator\\Rules\\BetweenRule",
			"\\KuroThing\\KuroValidator\\Rules\\BooleanRule",
			"\\KuroThing\\KuroValidator\\Rules\\CheckedRule",
			"\\KuroThing\\KuroValidator\\Rules\\DateRule",
			"\\KuroThing\\KuroValidator\\Rules\\EmailRule",
			"\\KuroThing\\KuroValidator\\Rules\\IpRule",
			"\\KuroThing\\KuroValidator\\Rules\\MatchesRule",
			"\\KuroThing\\KuroValidator\\Rules\\MaxRule",
			"\\KuroThing\\KuroValidator\\Rules\\MinRule",
			"\\KuroThing\\KuroValidator\\Rules\\NumericRule",
			"\\KuroThing\\KuroValidator\\Rules\\RegexRule",
			"\\KuroThing\\KuroValidator\\Rules\\RequiredRule",
			"\\KuroThing\\KuroValidator\\Rules\\UrlRule",
		];
		$this->addLazyRules($names, $classes);
	}

	public function addRule(IRule $rule) {
		if (!($rule instanceof IRule)) {
			throw new Exception("The provided rule does not implement IRule");
		}

		if (isset($this->rules[$rule->getName()])) {
			throw new \Exception("Rule already Exists.");
		}

		$this->rules[$rule->getName()] = $rule;
	}

	public function addRules(array $rules) {
		array_map([$this, "addRule"], $rules);
	}

	public function addLazyRule($name, $class) {
		if (isset($this->rules[$name])) {
			throw new \Exception("Rule already Exists.");
		}

		if (is_string($class)) {
			$this->rules[$name] = $class;
		} else {
			return $this->addRule($class);
		}
	}

	public function addLazyRules(array $names, array $classes) {
		array_map([$this, "addLazyRule"], $names, $classes);
	}

	public function addAnonymousRule($name, $message, $canSkip, callable $callback) {
		if (isset($this->rules[$name])) {
			throw new \Exception("Rule already exists.");
		}

		$obj = new AnonymousClass([
			"getName"			=> function() use($name) {
				return $name;
			},
			"getFailureMessage"	=> function() use($message) {
				return $message;
			},
			"getCanSkip"		=> function() use($canSkip) {
				return $canSkip;
			}
		]);

		$this->rules[$name]		= $obj;
		$this->callbacks[$name] = $callback;
	}

	public function validate($data, $rules) {

		$bag = new MessageBag();

		foreach($rules as $field => $value) {
			$name	= (isset($value["name"])) ? $value["name"] : $field;

			if (!isset($value["rules"])) {
				throw new \Exception("No rules provided.");
			}

			if (!is_array($value["rules"])) {
				throw new \Exception("Invalid rules data provided.");
			}

			foreach($value["rules"] as $rule => $conditions) {

				if (is_int($rule)) {
					$rule		= $conditions;
					$conditions	= null;
				} else {
					if (!is_array($conditions)) {
						$conditions = ["data"	=> $conditions];
					}
				}

				if (!isset($this->rules[$rule])) {
					$bag->addResult($field, $rule, false, "No such rule as \"{$rule}\"");
					continue;
				}

				$overrides	= (isset($value[$rule])) ? $value[$rule] : null;
				$value		= (isset($data[$field])) ? $data[$field] : null;
				$callable	= $this->rules[$rule];
				$conditions = ($conditions === null) ? null : $this->arrayToObject($conditions);

				if (is_string($callable)) {
					$callable = new $callable();
				}

				if ($callable instanceof AnonymousClass) {
					$rulePasses = $this->callbacks[$rule]($conditions, $value, $data);
				} else {
					$rulePasses = $callable($conditions, $value, $data);
				}

				$message	= (isset($overrides["message"])) ? $overrides["message"] : $callable->getFailureMessage();
				$canSkip	= (isset($overrides["canSkip"])) ? $overrides["canSkip"] : $callable->getCanSkip();
				$bag->addResult($field, $rule, $rulePasses, sprintf($message, $name, $value));

				if (!$rulePasses && !$canSkip) {
					break;
				}

			}

		}

		return $bag;
	}

	private function arrayToObject(array $input) {
		$obj = new \stdClass();

		foreach ($input as $key => $value) {
			if (is_array($value))
				$value = $this->arrayToObject($value);
			$obj->$key = $value;
		}

		return $obj;
	}

}