# Sample project with PHP and NGINX, using other shared services

This project is using traefik and smtp from the common tools and shared postredsql.

First run both dependencies:

    docker-compose up -f ./local-env/tools/docker-compose.yml -f ./postgres/docker-compose.yml -d

When you ran it for the first time there might be some networks missing. Follow the troubleshoot written on the CLI output.
Then run the sample application. 

    docker-compose up -d

## What we have

We have one instance of traefik and smtp running. Reusable by all our projects. We have our project running using these services.
We assume that the source code is in src folder and there is temp and log folder. These folders are ignored and not copied to docker
(.dockerignore). 

From the PHP the smtp is accessible on smtp:25 and postgres on postgres:5432 (names of the containers). This will work when the php is
in the same network as these shared services.
