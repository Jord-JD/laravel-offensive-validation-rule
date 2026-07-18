# 🤬🤭 Laravel Offensive Validation Rule

This package provides a Laravel validation rule that checks if a string is offensive. It can be useful
to check user supplied data that may be publicly displayed, such as usernames or comments. 

<p align="center"><img src="assets/images/laravel-offensive-validation-rule-usage.png" alt="Laravel Offensive Validation Rule usage"></p>

[![Tests](https://github.com/Jord-JD/laravel-offensive-validation-rule/actions/workflows/tests.yml/badge.svg)](https://github.com/Jord-JD/laravel-offensive-validation-rule/actions/workflows/tests.yml)

## Installation

To install, just run the following Composer command.

```
composer require jord-jd/laravel-offensive-validation-rule
```

The package supports Illuminate/Laravel 5.5 through 13 and PHP 7.1 through
current PHP 8.x releases.

## Usage

The following code snippet shows an example of how to use the offensive validation rule.

```php
use JordJD\LaravelOffensiveValidationRule\Offensive;

$request->validate([
    'username' => ['required', new Offensive],
]);
```

This rule only decides whether string content is offensive. Non-string values
pass so Laravel rules such as `string`, `array`, or `integer` can report the
appropriate type error. Objects with `__toString()` are checked as strings.

### Custom validation message

Pass an optional message as the second constructor argument. Laravel replaces
`:attribute` as usual.

```php
$request->validate([
    'username' => [
        'required',
        'string',
        new Offensive(null, 'Please choose a different :attribute.'),
    ],
]);
```

### Custom word lists

If the defaults are too strict (or not strict enough), you can optionally specify a custom list 
of offensive words and custom whitelist. Below is an example of using a custom blacklist and whitelist.

```php
use JordJD\LaravelOffensiveValidationRule\Offensive;
use JordJD\IsOffensive\OffensiveChecker;

$blacklist = ['moist', 'stinky', 'poo'];
$whitelist = ['poop'];

$rule = new Offensive(
    new OffensiveChecker($blacklist, $whitelist),
    'Please choose a different :attribute.'
);

$request->validate(['username' => ['required', 'string', $rule]]);
```
