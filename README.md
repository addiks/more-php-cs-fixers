[![Travis Build Status][1]][2]
[![Scrutinizer Build Status][3]][4]
[![Scrutinizer Code Quality][5]][6]
[![Code Coverage][7]][8]

# More PHP-CS-Fixer's

This repository contains a few additional fixers for the [PHP-CS-Fixer][9] project:

* Add a blank line before doc-comments
* Add a blank line before else- and elseif-codeblocks
* Add a blank line before catch- and finally-codeblocks

## Setup

### 1. Install package via composer:
```bash
composer require addiks/more-php-cs-fixers
```

### 2. Register fixers in PHP-CS-Fixer configuration (file `.php_cs`).:
```diff
<?php

+use Addiks\MorePhpCsFixers\Whitespace\BlankLineBeforeCatchBlockFixer;
+use Addiks\MorePhpCsFixers\Whitespace\BlankLineBeforeElseBlockFixer;
+use Addiks\MorePhpCsFixers\Whitespace\BlankLineBeforeDocCommentFixer;

$config = PhpCsFixer\Config::create();
+$config->registerCustomFixers([
+    new BlankLineBeforeCatchBlockFixer(),
+    new BlankLineBeforeElseBlockFixer(),
+    new BlankLineBeforeDocCommentFixer(),
+]);
+$config->setRules([
+    'Addiks/blank_line_before_catch_block': true,
+    'Addiks/blank_line_before_else_block': true,
+    'Addiks/blank_line_before_doccomment': true,
+]);
return $config;
```

## The fixers

### Addiks/blank_line_before_catch_block
```diff
<?php

try {
    foo();
+
} catch (\Exception $b) {
    bar();
+
} finally {
    baz();
}
```

### Addiks/blank_line_before_else_block
```diff
<?php
if ($a) {
    foo();
+
} elseif ($b) {
    bar();
+
} else {
    baz();
}
```

### Addiks/blank_line_before_doccomment
```diff
<?php
/** @var string $foo */
$foo = "Lorem ipsum";
+
/** @var string $bar */
$bar = "dolor sit amet";
```

### Addiks/correct_order_in_var_doccomment
```diff
<?php
-/** @var $foo string */
+/** @var string $foo */
```

### Addiks/nullable_in_doccomment
```diff
<?php
-/** @var ?string $foo */
+/** @var string|null $foo */
```

### Addiks/array_in_doccomment
```diff
<?php
-/** @var string[] $foo */
+/** @var array<string> $foo */
```


[1]: https://travis-ci.com/addiks/more-php-cs-fixers
[2]: https://travis-ci.com/addiks/more-php-cs-fixers.svg?branch=master
[3]: https://scrutinizer-ci.com/g/addiks/more-php-cs-fixers/badges/build.png?b=master
[4]: https://scrutinizer-ci.com/g/addiks/more-php-cs-fixers/build-status/master
[5]: https://scrutinizer-ci.com/g/addiks/more-php-cs-fixers/badges/quality-score.png?b=master
[6]: https://scrutinizer-ci.com/g/addiks/more-php-cs-fixers/?branch=master
[7]: https://scrutinizer-ci.com/g/addiks/more-php-cs-fixers/badges/coverage.png?b=master
[8]: https://scrutinizer-ci.com/g/addiks/more-php-cs-fixers/?branch=master
[9]: https://github.com/FriendsOfPHP/PHP-CS-Fixer/
