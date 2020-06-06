#!/bin/bash
docker rm -f $(docker ps -a -q)
docker rmi -f $(docker images -q)
docker system prune --all
docker volume prune
