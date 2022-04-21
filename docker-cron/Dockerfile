FROM ubuntu:latest

RUN apt-get update && apt-get install -y cron

COPY example-crontab /etc/cron.d/example-crontab
RUN chmod 0644 /etc/cron.d/example-crontab &&\
    crontab /etc/cron.d/example-crontab
