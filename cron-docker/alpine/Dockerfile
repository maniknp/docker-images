FROM alpine:3.21.3

# Install necessary packages
RUN apk add --no-cache bash curl busybox-suid

# Create working directory
WORKDIR /app

# Copy cron script and crontab file
COPY script.sh /app/script.sh
COPY crontab /etc/crontabs/root

# Make script executable
RUN chmod +x /app/script.sh

# Start cron in foreground
CMD [ "crond", "-f", "-l", "2" ]
