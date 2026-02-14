# 🤬🤭 Laravel Offensive Validation Rule

This package provides a Laravel validation rule that checks if a string is offensive. It can be useful
to check user supplied data that may be publicly displayed, such as usernames or comments. 

<p align="center"><img src="assets/images/laravel-offensive-validation-rule-usage.png" alt="Laravel Offensive Validation Rule usage"></p>

<p align="center">
    <a href="https://travis-ci.org/Jord-JD/laravel-offensive-validation-rule">
        <img src="https://travis-ci.org/Jord-JD/laravel-offensive-validation-rule.svg?branch=master">
    </a>
    <a href='https://coveralls.io/github/Jord-JD/laravel-offensive-validation-rule?branch=master'>
        <img src='https://coveralls.io/repos/github/Jord-JD/laravel-offensive-validation-rule/badge.svg?branch=master' alt='Coverage Status' />
    </a>
    <a href="https://styleci.io/repos/132460621">
        <img src="https://styleci.io/repos/132460621/shield?branch=master" alt="StyleCI">
    </a>
</p>

## Installation

To install, just run the following Composer command.

```
composer require jord-jd/laravel-offensive-validation-rule
```

Please note that this package requires Laravel 5.5 or above.

## Usage

The following code snippet shows an example of how to use the offensive validation rule.

```php
use JordJD\LaravelOffensiveValidationRule\Offensive;

$request->validate([
    'username' => ['required', new Offensive],
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

$request->validate([
    'username' => ['required', new Offensive(new OffensiveChecker($blacklist, $whitelist))],
]);
```
