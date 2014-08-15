phpcs:
	vendor/bin/phpcs --standard=PSR2 migrations/ src/ public/ doctrine

phpmd:
	vendor/bin/phpmd src/,public/,doctrine text codesize,unusedcode,naming