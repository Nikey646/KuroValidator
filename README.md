# KuroValidator
A simple, and easy to use Validation Library for PHP.

Define Rules to check user input automatically based on a simple to use configuration.

# Installing
Only composer is directly supported.
```json
{
	"require": {
		"kurothing/kurovalidator": "0.1.*"
	}
}
```

or run the command `composer require kurothing/kurovalidator 0.1.*`

# Usage
KuroValidator was designed with ease of use in mind, as such it takes 2 Parameters, Input Data and Configuration Data.

The Input Data is simple and easy to understand, just pass your information source. The Configuration Data is slightly more complex, but easy to understand once you get the gist of what is going on. Lets look at a basic example of validating the $_GET.

```php

use KuroThing\KuroValidator\Validator;

$validator = new Validator();

$result = $validator->validate($_GET, [
	"field" => [
		"rules" => [
			"rule"	=> "rule setting",
			"rule2"	=> [
				"MultiValue"	=> "settings",
				"AreSupported"	=> true,
			],
		],
	],
]);

if ($result->passes()) {
	// Passes
} else {
	// Fails
}

// Or the reverse
if ($result->fails()) {
	// Fails
} else {
	// Passes
}
```

Most of the code is self-explaining, but lets look over the second parameter of the `validate()` function.

The top level value, "field" is what we are validating against in the $_GET super global. So if we wanted to validate the `id` query parameter, then we would replace "field" with "id".

The value of "field" is an array, which defines the rules, the name and allows you to override the `canSkip` and `message` values of a rule. We'll look into overriding those later and setting the name later, lets focus on explaining how the rules are defined.

As you can see, the "rules" element is an array containing all the rules we will use. Each rule is defined by `"name" => "settings"`, and rules with no settings do not require any value. Single Setting and Multi-Setting rules are both supported, and shown. With multi-setting rules, they require an associate array, with the key being the name of the setting, and the value being the value of the setting.

# Preexisting Rules
Rule Class | Name | Options | Option Names | Description
-----------|------|---------|--------------|------------
AlphaNumericDashRule | alphanumericdash | 0 | | Ensures only A-Z (ci), 0-9, and -/_ is in the string
AlphaNumericRule | alphanumeric | 0 | | Ensures only A-Z (ci) and 0-9 is in the string
AlphaRule | alpha | 0 | | Ensures only A-Z (ci) is in the string
ArrayRule | array | 0 | | Ensures that the value is an Array
BetweenRule | between | 2 | lower, higher | Checks to make sure the number is between the provided values
BooleanRule | bool | 0 | | Checks to make sure the value is a Boolean. Does not work on strings, which Forms provide by default.
CheckedRule | checked | 0 | | Checks to see if the value is "true", "1", "yes", or "on".
DateRule | date | 0 | | Checks to see if a value is a valid date.
EmailRule | email | 0 | | Checks to see if the email is a valid [RFC 822](https://www.ietf.org/rfc/rfc0822.txt) email address
IpRule | ip | 0 | | Ensures the value is an ip
MatchesRule | matches | 2 | field, fieldName | Checks to see if the current Field matches Another
MaxRule | max | 1 | max | Checks to see if the string is longer than the setting, or if a number is larger.
MinRule | min | 1 | min | Checks to see if the string is shorter than the setting, or if a number is smaller.
NumericRule | number | 0 | | Ensures that the value is a number.
RegexRule | regex | 1 | pattern | Checks the value against the supplied pattern
RequiredRule | required | 0 | | Ensures the value is provided.
UrlRule | url | 0 | | Ensures the value is a valid [RFC 2396](https://www.ietf.org/rfc/rfc2396.txt) uri.

# More Information
I'll provide more examples and documentation (such as creating new rules) at a later date.

# Credits
* Original Concept and Implementation - [Violin](https://github.com/alexgarrett/violin).
	* Some rules are based off of the Implementation for them in Violin, and as such marked with "Credits: " and a link to the file on Github. These rules are AlphaNumericDash, AlphaNumeric, Alpha, Date, and Required. Some rules may match or be similar to Violin, however Violin's implementation was not used.
* AnonymousClass - [Mihailoff](https://gist.github.com/Mihailoff/3700483)
	* Used to dynamically create (lazy) rules at run time, rather than using the Class/Interface based implementation.

# Copyrights
Copyright (c) 2015 [Nikey646] (https://github.com/Nikey646)
              2015 [Alex Garrett] (https://github.com/alexgarrett)