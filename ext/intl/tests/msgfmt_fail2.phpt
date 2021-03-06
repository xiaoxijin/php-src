--TEST--
msgfmt creation failures icu >= 4.8
--SKIPIF--
<?php if( !extension_loaded( 'intl' ) ) print 'skip intl extension not loaded'; ?>
--FILE--
<?php

function err($fmt) {
    if(!$fmt) {
        echo var_export(intl_get_error_message(), true)."\n";
    }
}

function print_exception($e) {
    echo "\n" . get_class($e) . ": " . $e->getMessage()
       . " in " . $e->getFile() . " on line " . $e->getLine() . "\n";
}

function crt($t, $l, $s) {
    switch(true) {
        case $t == "O":
            try {
                return new MessageFormatter($l, $s);
            } catch (Throwable $e) {
                print_exception($e);
                return null;
            }
            break;
        case $t == "C":
            try {
                return MessageFormatter::create($l, $s);
            } catch (Throwable $e) {
                print_exception($e);
                return null;
            }
            break;
        case $t == "P":
            try {
                return msgfmt_create($l, $s);
            } catch (Throwable $e) {
                print_exception($e);
                return null;
            }
            break;
    }
}

$args = array(
    array(null, null),
    array("whatever", "{0,whatever}"),
    array(array(), array()),
    array("en", "{0,choice}"),
    array("fr", "{0,"),
    array("en_US", "\xD0"),
);

try {
    $fmt = new MessageFormatter();
} catch (TypeError $e) {
    print_exception($e);
    $fmt = null;
}
err($fmt);
try {
    $fmt = msgfmt_create();
} catch (TypeError $e) {
    print_exception($e);
    $fmt = null;
}
err($fmt);
try {
    $fmt = MessageFormatter::create();
} catch (TypeError $e) {
    print_exception($e);
    $fmt = null;
}
err($fmt);
try {
    $fmt = new MessageFormatter('en');
} catch (TypeError $e) {
    print_exception($e);
    $fmt = null;
}
err($fmt);
try {
    $fmt = msgfmt_create('en');
} catch (TypeError $e) {
    print_exception($e);
    $fmt = null;
}
err($fmt);
try {
    $fmt = MessageFormatter::create('en');
} catch (TypeError $e) {
    print_exception($e);
    $fmt = null;
}
err($fmt);

foreach($args as $arg) {
    $fmt = crt("O", $arg[0], $arg[1]);
    err($fmt);
    $fmt = crt("C", $arg[0], $arg[1]);
    err($fmt);
    $fmt = crt("P", $arg[0], $arg[1]);
    err($fmt);
}

?>
--EXPECTF--
ArgumentCountError: MessageFormatter::__construct() expects exactly 2 parameters, 0 given in %s on line %d
'U_ZERO_ERROR'

ArgumentCountError: msgfmt_create() expects exactly 2 parameters, 0 given in %s on line %d
'U_ZERO_ERROR'

ArgumentCountError: MessageFormatter::create() expects exactly 2 parameters, 0 given in %s on line %d
'U_ZERO_ERROR'

ArgumentCountError: MessageFormatter::__construct() expects exactly 2 parameters, 1 given in %s on line %d
'U_ZERO_ERROR'

ArgumentCountError: msgfmt_create() expects exactly 2 parameters, 1 given in %s on line %d
'U_ZERO_ERROR'

ArgumentCountError: MessageFormatter::create() expects exactly 2 parameters, 1 given in %s on line %d
'U_ZERO_ERROR'

IntlException: Constructor failed in %s on line %d
'msgfmt_create: message formatter creation failed: U_ILLEGAL_ARGUMENT_ERROR'
'msgfmt_create: message formatter creation failed: U_ILLEGAL_ARGUMENT_ERROR'
'msgfmt_create: message formatter creation failed: U_ILLEGAL_ARGUMENT_ERROR'

IntlException: Constructor failed in %s on line %d
'msgfmt_create: message formatter creation failed: U_ILLEGAL_ARGUMENT_ERROR'
'msgfmt_create: message formatter creation failed: U_ILLEGAL_ARGUMENT_ERROR'
'msgfmt_create: message formatter creation failed: U_ILLEGAL_ARGUMENT_ERROR'

TypeError: MessageFormatter::__construct() expects argument #1 ($locale) to be of type string, array given in %s on line %d
'U_ZERO_ERROR'

TypeError: MessageFormatter::create() expects argument #1 ($locale) to be of type string, array given in %s on line %d
'U_ZERO_ERROR'

TypeError: msgfmt_create() expects argument #1 ($locale) to be of type string, array given in %s on line %d
'U_ZERO_ERROR'

IntlException: Constructor failed in %s on line %d
'msgfmt_create: message formatter creation failed: U_PATTERN_SYNTAX_ERROR'
'msgfmt_create: message formatter creation failed: U_PATTERN_SYNTAX_ERROR'
'msgfmt_create: message formatter creation failed: U_PATTERN_SYNTAX_ERROR'

IntlException: Constructor failed in %s on line %d
'msgfmt_create: message formatter creation failed: U_UNMATCHED_BRACES'
'msgfmt_create: message formatter creation failed: U_UNMATCHED_BRACES'
'msgfmt_create: message formatter creation failed: U_UNMATCHED_BRACES'

IntlException: Constructor failed in %s on line %d
'msgfmt_create: error converting pattern to UTF-16: U_INVALID_CHAR_FOUND'
'msgfmt_create: error converting pattern to UTF-16: U_INVALID_CHAR_FOUND'
'msgfmt_create: error converting pattern to UTF-16: U_INVALID_CHAR_FOUND'
