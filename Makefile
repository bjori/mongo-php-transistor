PHP=$(shell which php)
TMPDIR=$(shell php -r 'echo sys_get_temp_dir();')
EXTDIR=$(shell php -i | grep extension_dir | cut -d' ' -f 3 | head -n1)


test: OK
	@TEST_PHP_EXECUTABLE=$(PHP) REPORT_EXIT_STATUS=1 TEST_PHP_ARGS="-q -x -l failed.txt --show-diff" php run-tests.php tests/


run-tests.php:
	wget -O run-tests.php "http://git.php.net/?p=php-src.git;a=blob_plain;f=run-tests.php;hb=HEAD"


OK: run-tests.php failed.txt $(EXTDIR)/mongodb.so $(TMPDIR)/PHONGO-SERVERS.json


failed.txt:
	touch failed.txt


$(EXTDIR)/mongodb.so:
	pecl install mongodb-alpha


$(TMPDIR)/PHONGO-SERVERS.json:
	echo '{"STANDALONE": "mongodb:\/\/127.0.0.1:27017"}' > $(TMPDIR)/PHONGO-SERVERS.json


