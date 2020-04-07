build:
	docker-compose up --build -d

test:
	docker-compose run app ./vendor/bin/phpunit tests

setup:
	docker-compose run app composer install --optimize-autoloader
	docker-compose run app php create-database
	docker-compose run app php vendor/bin/doctrine orm:schema-tool:update --force
	docker-compose run app php create-user

end:
	docker-compose down --volumes --rmi local