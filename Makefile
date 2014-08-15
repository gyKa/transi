phpcs:
	vendor/bin/phpcs --standard=PSR2 migrations/ src/ doctrine

phpmd:
	vendor/bin/phpmd src/,doctrine text codesize,unusedcode,naming