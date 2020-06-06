SHELL := /bin/bash
help: ## Show this help
	@echo -e "usage: make [target]\n\ntarget:"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/: ##\s*/\t/' | expand -t 18 | pr -to2

build-docker: ## Build docker containers
	docker-compose up -d --build
clean-docker: ## Clean all docker containers
	./clean-docker.sh
restart-docker: ## Clean all docker containers
	./restart-docker.sh
ifndef VERBOSE
.SILENT:
endif
