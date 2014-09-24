# PHP code sniffer.
phpcs:
	vendor/bin/phpcs --standard=PSR2 --extensions=php src/ public/

# PHP mess detector.
phpmd:
	vendor/bin/phpmd src/,public/ text codesize,unusedcode,naming

# PHP copy/paste detector.
phpcpd:
	vendor/bin/phpcpd src/ public/

phploc:
	vendor/bin/phploc src/ public/

# Runs tools for code quality assurance.
check: phpmd phpcs phpcpd

# Installation for production only.
install: composer.phar
	# Install dependencies.
	php composer.phar install --no-dev --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DB_ADAPTER=mysql\n" > .env
	printf "DB_PORT=3306\n" >> .env
	printf "DB_NAME=\n" >> .env
	printf "DB_USER=\n" >> .env
	printf "DB_PASS=\n" >> .env
	printf "DB_HOST=\n" >> .env
	printf "APP_ENV=production\n" >> .env

# Installation for development only.
dev-install: composer.phar
	# Install Composer dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DEBUG=true\n" > .env
	# Run database migrations.
	vendor/bin/phinx migrate -c src/databases/config.php
	# Install pre-commit hook.
	cp pre-commit.sh .git/hooks/pre-commit

# Update for production only.
update: composer.phar
	git pull
	php composer.phar update --no-dev
	vendor/bin/phinx migrate -c src/databases/config.php -e production

# Installation and preparation for CodeShip only.
codeship: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Run database migrations.
	vendor/bin/phinx migrate -c src/databases/config.php -e codeship

# Installation and preparation for Travis only.
travis: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Run database migrations.
	vendor/bin/phinx migrate -c src/databases/config.php -e travis-${DB}

# Installation and preparation for Heroku only.
heroku:
	vendor/bin/phinx migrate -c src/databases/config.php -e heroku-cleardb


composer.phar:
	curl -sS https://getcomposer.org/installer | php
