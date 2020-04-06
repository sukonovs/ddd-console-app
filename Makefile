build:
	docker-compose up --build -d

end:
	docker-compose down --volumes --rmi local