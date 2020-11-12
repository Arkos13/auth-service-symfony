docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

php-fpm-container:
	docker exec -ti auth-service-php-fpm bash

cache-clear-symfony:
	docker exec auth-service-php-fpm php bin/console cache:clear

composer-dump-autoload:
	docker exec auth-service-php-fpm composer dump-autoload --classmap-authoritative

generate-rsa-private-key:
	openssl genrsa -passout pass:_passphrase_ -out private.key 2048

generate-rsa-public-key:
	openssl rsa -in private.key -passin pass:_passphrase_ -pubout -out public.key

generate-encryption-key:
	docker exec auth-service-php-fpm php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'

add-oauth-client:
	docker exec auth-service-php-fpm php bin/console trikoder:oauth2:create-client --grant-type password --grant-type refresh_token

load-fixtures:
	docker exec auth-service-php-fpm php bin/console doctrine:fixtures:load -n

schema-drop:
	docker exec auth-service-php-fpm php bin/console doctrine:schema:drop --force

migrate:
	docker exec auth-service-php-fpm php bin/console doctrine:migration:migrate -n

delete-migrations:
	docker exec auth-service-php-fpm php bin/console doctrine:migrations:version --delete --all -n

setup-db-test: schema-drop delete-migrations migrate load-fixtures

docker-analyse-phpstan:
	docker exec auth-service-php-fpm php vendor/bin/phpstan analyse -c phpstan.neon

docker-analyse-psalm:
	docker exec auth-service-php-fpm php vendor/bin/psalm

docker-run-test:
	docker exec auth-service-php-fpm php bin/phpunit

docker-run-test-and-analyse-code: setup-db-test docker-run-test docker-analyse-phpstan docker-analyse-psalm

docker-messenger-consume:
	docker exec auth-service-php-fpm php bin/console messenger:consume event -vv --time-limit=3600