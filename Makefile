PHP := docker-compose exec php

up:
	docker-compose up -d

down:
	docker-compose down

shell:
	${PHP} sh
