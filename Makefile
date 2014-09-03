# PHP code sniffer.
phpcs:
	vendor/bin/phpcs --standard=PSR2 --extensions=php src/ public/

# PHP mess detector.
phpmd:
	vendor/bin/phpmd src/,public/ text codesize,unusedcode,naming

# Runs tools for code quality assurance.
check: phpmd phpcs

# Installation for production only.
install: composer.phar
	# Install dependencies.
	php composer.phar install --no-dev --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DB_NAME=\n" >> .env
	printf "DB_USER=\n" >> .env
	printf "DB_PASS=\n" >> .env
	printf "DB_HOST=\n" >> .env

# Installation for development only.
dev-install: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DEBUG=true\n" > .env
	# Run database migrations.
	vendor/bin/phinx migrate -c src/databases/config.php

# Update for production only.
update: composer.phar
	git pull
	php composer.phar update --no-dev
	vendor/bin/phinx migrate -c src/databases/config.php

# Installation and preparation for CodeShip only.
codeship: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Run database migrations.
	vendor/bin/phinx migrate -c src/databases/config.php -e codeship

# Installation and preparation for Travis only.
travis: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Run database migrations.
	vendor/bin/phinx migrate -c src/databases/config.php -e travis-${DB}

composer.phar:
	curl -sS https://getcomposer.org/installer | php
