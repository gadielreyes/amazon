make.PHONY:
start:
	docker-compose up -d

.PHONY:
stop:
	docker-compose stop

.PHONY:
init:
	docker-compose build
	docker-compose up -d
.PHONY:
rebuild:
	docker-compose up --build --force-recreate -d