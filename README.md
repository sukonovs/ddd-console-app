## Reqs
Docker, Docker compose, Makefile, Git (for git clone)

## Installation
1) Clone/Download repo
2) run ``make build`` to build containers
3) run ``make setup`` to setup project
4) experiment with commands
5) run ``make test`` to test domain logic
6) run ``make end`` for cleanup

## Commands
1) ADD
``docker-compose run app php console add [user-uuid] [country-name] [city-name] [zip-code] [street name]``

Example:
``docker-compose run app php console add e648dbc6-9a48-4df3-a750-b60fdd708679 Latvia Riga "LV-1064", "Murjanu 01-11"``

2) UPDATE
``docker-compose run app php console update [user-uuid] [address-uuid] [field-name:value] ...``

Example:
``docker-compose run app php console update e648dbc6-9a48-4df3-a750-b60fdd708679 aeceebb7-bf42-4b36-8e97-87b0b4c49d6b "country:U S A" "default:true"``

3) REMOVE
``docker-compose run app php console remove [user-uuid] [address-uuid]``

Example:
``docker-compose run app php console remove e648dbc6-9a48-4df3-a750-b60fdd708679 3ede0891-d017-491c-85b3-6f1f5a2fd19b``