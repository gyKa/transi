# PHP code sniffer.
phpcs:
	vendor/bin/phpcs --standard=PSR2 --extensions=php migrations/ src/ public/ doctrine

# PHP mess detector.
phpmd:
	vendor/bin/phpmd src/,public/,doctrine text codesize,unusedcode,naming

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
	# Set doctrine as executable file.
	chmod +x doctrine

# Installation for development only.
dev-install: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DB_NAME=transi\n" >> .env
	printf "DB_USER=root\n" >> .env
	printf "DB_PASS=\n" >> .env
	printf "DB_HOST=\n" >> .env
	printf "DEBUG=true\n" >> .env
	# Set doctrine as executable file.
	chmod +x doctrine
	# Run database migrations.
	./doctrine migrations:migrate --no-interaction

# Update for production only.
update: composer.phar
	git pull
	php composer.phar update --no-dev
	./doctrine migrations:migrate --no-interaction

# Installation and preparation for CodeShip only.
codeship: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DB_NAME=development${TEST_ENV_NUMBER}\n" >> .env
	printf "DB_USER=${MYSQL_USER}\n" >> .env
	printf "DB_PASS=${MYSQL_PASSWORD}\n" >> .env
	printf "DB_HOST=\n" >> .env
	printf "DEBUG=true\n" >> .env
	# Set doctrine as executable file.
	chmod +x doctrine
	# Run database migrations.
	./doctrine migrations:migrate --no-interaction

# Installation and preparation for Travis only.
travis: composer.phar
	# Install dependencies.
	php composer.phar install --prefer-source --no-interaction
	# Create environment file.
	touch .env
	# Prepare environment variables.
	printf "DB_NAME=transi\n" >> .env
	printf "DB_USER=travis\n" >> .env
	printf "DB_PASS=\n" >> .env
	printf "DB_HOST=127.0.0.1\n" >> .env
	printf "DEBUG=true\n" >> .env
	# Set doctrine as executable file.
	chmod +x doctrine
	# Run database migrations.
	./doctrine migrations:migrate --no-interaction

composer.phar:
	curl -sS https://getcomposer.org/installer | php
