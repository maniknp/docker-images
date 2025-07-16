FROM alpine:3.21.3

RUN apk add --no-cache \
    brotli \
    inotify-tools \
    bash

WORKDIR /app

COPY watch_and_compress.sh .

RUN chmod +x watch_and_compress.sh

CMD ["./watch_and_compress.sh"]
