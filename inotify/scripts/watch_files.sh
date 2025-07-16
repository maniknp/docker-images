#!/bin/bash

WATCH_DIR="/workspaces/1x/src"

echo "📡 Watching for file changes in: $WATCH_DIR"

inotifywait -m -r \
  --timefmt '%Y-%m-%d %H:%M:%S' \
  --format '[%T] Event: %e on file: %w%f' \
  -e modify -e create \
  "$WATCH_DIR"
