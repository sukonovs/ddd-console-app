build:
	docker-compose up --build -d

setup:
	docker-compose run php composer install --optimize-autoloader
	docker-compose run app php vendor/bin/doctrine orm:schema-tool:update --force
	docker-compose run app php create-user

end:
	docker-compose down --volumes --rmi local