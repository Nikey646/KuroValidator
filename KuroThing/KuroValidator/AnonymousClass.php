<?php
/**
 * Created for KuroValidator, by Nikey646.
 * On Date: 19/10/2015
 * At Time: 3:22 AM
 * Copyright © Nikey646, 2015-2015.
 */

namespace KuroThing\KuroValidator;

// Credits: https://gist.github.com/Mihailoff/3700483
final class AnonymousClass {

	private $methods = [];

	public function __construct(array $funcs) {
		$this->methods = $funcs;
	}

	public function __call($name, $args) {
		$callable = null;
		if (array_key_exists($name, $this->methods))
			$callable = $this->methods[$name];
		elseif (isset($this->$name))
			$callable = $this->$name;

		if (!is_callable($callable))
			throw new \BadMethodCallException("Method {$name} does not exist");

		return call_user_func_array($callable, $args);
	}

}