<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 2:27 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator;

class MessageBag {

	protected $failures = [];

	public function addResult($field, $rule, $success, $message) {

		if (!$success) {
			$this->failures[$field][$rule][] = $message;
		}

	}

	public function passes() {
		return empty($this->failures);
	}

	public function fails() {
		return !empty($this->failures);
	}

	public function isEmpty() {
		return empty($this->failures);
	}

	public function hasErrors() {
		return !$this->isEmpty();
	}

	public function has($key) {
		return isset($this->failures[$key]);
	}

	public function first($key) {
		if (!$this->has($key))
			return null;

		$result = array_reduce(array_slice($this->failures[$key], 0, 1, true), function($carry, $item) {
			return $item;
		});

		return $result[0];
	}

	public function get($key) {
		return $this->failures[$key];
	}

}