# Takes the first target as command
Command := $(firstword $(MAKECMDGOALS))
# Skips the first word
Arguments := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

run:
	docker-compose up -d
run-cmd:
	docker-compose run app-php-cli php bin/console $(Arguments)

cache-clear:
	docker-compose run app-php-cli php bin/console doctrine:cache:clear-metadata
	docker-compose run app-php-cli php bin/console doctrine:cache:clear-result
	docker-compose run app-php-cli php bin/console cache:clear
	#docker exec tms-backend php bin/console redis:query flushall

