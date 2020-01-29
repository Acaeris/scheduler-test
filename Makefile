# Docker host detection
server = docker

build:
	docker build -t scheduler -f Dockerfile .

start: stop
	docker run -d -p 80:80 --name scheduler scheduler

stop:
	@docker rm --vf scheduler||:

clean: stop
	docker rmi -f scheduler

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
