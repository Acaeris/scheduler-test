# Docker host detection
server = docker

build:
	docker build -t scheduler -f Dockerfile .

start: stop
    # Database
    docker run -d --name scheduler-db -e "MYSQL_ROOT_PASSWORD=4wV*4ynnCMXj" mysql:latest

    # Scheduler
	docker run -d -p 80:80 --name scheduler \
	 --link scheduler-db:mysql.local \
	 scheduler

stop:
	@docker rm --vf scheduler scheduler-db||:

clean: stop
	docker rmi -f scheduler mysql

rsync:
	ifneq ($(wildcard vendor),)
		$(info Vendor exists, including it)
		$(eval RSYNC_VENDOR := --include=vendor --filter="+ vendor")
	endif
		@printf "scheduler" | xargs -n1 -P1 -ICONTAINER rsync \
			-e "docker exec -i" --blocking-io -avz --delete \
			--no-perms --no-owner --no-group \
			$(RSYNC_VENDOR) \
			--exclude-from=".dockerignore" \
			--exclude-from=".gitignore" \
			--checksum \
			--no-times \
			--itemize-changes \
			. CONTAINER:/home/sites/scheduler/

.PHONY: build start stop clean rsync
