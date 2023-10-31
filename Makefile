#
# Catch-all rules
#
.PHONY: all
all: $(composer)

# Installs and updates the composer dependencies.
.PHONY: composer
composer:
	composer install
	composer update

##------------
## Tests
##------------

.PHONY: test-php-style
test-php-style:            ## Run phpcs and check code-style
test-php-style: vendor/bin/phpcs
	vendor/bin/phpcs --ignore=vendor/* .

.PHONY: test-php-style-fix
test-php-style-fix:        ## Run phpcbf and fix code-style
test-php-style-fix: vendor/bin/phpcbf
	vendor/bin/phpcbf --ignore=vendor/* .


#
# Dependency management
#--------------------------------------

composer.lock: composer.json
	@echo composer.lock is not up to date.

vendor: composer.lock
	composer install --no-dev

vendor/bin/phpcs: composer.lock
	composer install

vendor/bin/phpcbf: composer.lock
	composer install
