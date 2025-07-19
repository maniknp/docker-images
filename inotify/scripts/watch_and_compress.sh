#!/bin/bash

WATCH_DIR="/workspaces/1x/src"

echo "📡 Watching $WATCH_DIR for file changes..."

inotifywait -m -r \
  --timefmt '%Y-%m-%d %H:%M:%S' \
  --format '%T|%e|%w%f' \
  -e modify -e create -e delete \
  "$WATCH_DIR" | while IFS='|' read -r timestamp event fullpath
do
  echo "[$timestamp] Event: $event on file: $fullpath"

  # Get Brotli file path
  brfile="${fullpath}.br"

  # Skip if it's a directory
  if [[ -d "$fullpath" ]]; then
    continue
  fi

  # Skip already-compressed files
  if [[ "$fullpath" == *.br ]]; then
    continue
  fi

  # On CREATE or MODIFY, compress the file
  if [[ "$event" == *CREATE* ]]; then
    echo "➡️  Compressing (level 6): $fullpath"
    brotli -f -q 6 "$fullpath" && echo "✅ Compressed: $brfile"

  elif [[ "$event" == *MODIFY* ]]; then
    echo "➡️  Compressing (level 11): $fullpath"
    brotli -f -q 11 "$fullpath" && echo "✅ Recompressed: $brfile"

  elif [[ "$event" == *DELETE* ]]; then
    # On DELETE, remove corresponding .br file if it exists
    if [[ -f "$brfile" ]]; then
      echo "🗑️  Deleting compressed file: $brfile"
      rm -f "$brfile" && echo "✅ Deleted: $brfile"
    fi
  fi
done
