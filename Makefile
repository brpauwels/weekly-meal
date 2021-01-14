ENVIRONMENT ?= dev

include etc/make/docker.mk

profile:
	$(eval ENVIRONMENT=blackfire)
