.PHONY : main build-image build-container start test shell stop clean
main: build-image build-container

build-image:
	docker build -t calculator .

build-container:
	docker run -dt --name calculator -v .:/540/Calculator calculator
	docker exec calculator composer install

start:
	docker start calculator

test: start
	docker exec calculator ./vendor/bin/phpunit tests/$(target)

shell: start
	docker exec -it calculator /bin/bash

stop:
	docker stop calculator

clean: stop
	docker rm calculator
	rm -rf vendor