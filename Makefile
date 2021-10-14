install:
	chmod -R 777 ./
	docker-compose -f ./docker/docker-compose.yaml up -d --build
	chmod -R 777 ./
	docker exec -it webserver composer install
	chmod -R 777 ./
status:
	docker ps -a
	docker images
	docker volume ls
up:
	docker-compose -f ./docker/docker-compose.yaml up -d
down:
	docker-compose -f ./docker/docker-compose.yaml down
restart:
	docker-compose -f ./docker/docker-compose.yaml restart
kill:
	docker container rm -f webserver
clean:
	docker system prune -a --volumes