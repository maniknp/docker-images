# Use the specified Alpine base image
FROM alpine:3.21.3

# Install necessary packages: brotli, inotify-tools, and bash
# --no-cache reduces image size
RUN apk add --no-cache \
    brotli \
    gzip \
    zstd \
    inotify-tools \
    bash 

# Define common UID/GID for www-data on Alpine, typically 82.
# Using explicit IDs helps with consistency across different base images.
ARG WWW_DATA_UID=33
ARG WWW_DATA_GID=33

# Create the www-data group if it doesn't exist (using --gid for specific ID)
# RUN addgroup -g ${WWW_DATA_GID} www-data

# Create the www-data user if it doesn't exist (using --uid for specific ID)
# -S: system user (no home directory created by default)
# -G: primary group
RUN adduser -S -u ${WWW_DATA_UID} -G www-data www-data

# Set the working directory inside the container
WORKDIR /app

# Copy your script into the container
COPY watch_and_compress.sh .

# Make the script executable
RUN chmod +x watch_and_compress.sh

# Switch to the www-data user. All subsequent RUN, CMD, ENTRYPOINT
# instructions will be executed as this user.
USER www-data

# Set the default command to run your script
CMD ["./watch_and_compress.sh"]
