PHP=$(shell which php)

test: run-tests.php
	@TEST_PHP_EXECUTABLE=$(PHP) TEST_PHP_ARGS="-q -x -l failed.txt" php run-tests.php tests/

run-tests.php:
	wget -O run-tests.php "http://git.php.net/?p=php-src.git;a=blob_plain;f=run-tests.php;hb=HEAD"

