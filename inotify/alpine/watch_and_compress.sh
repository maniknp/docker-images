#!/bin/bash

WATCH_DIRS=(
  "/var/www/public/wp-cotent/themes"
  "/var/www/public/wp-cotent/plugins"
)


# Allowed extensions (you can expand this list)
EXTENSIONS=("png" "jpg" "jpeg" "webp" "html" "js" "css")

# Convert array to regex pattern: .*\.(png|jpg|jpeg|...)
EXT_REGEX=".*\.($(IFS=\|; echo "${EXTENSIONS[*]}"))$"

echo "📡 Watching for changes in:"
for dir in "${WATCH_DIRS[@]}"; do
  echo "  ➤ $dir"
done
echo "  🔍 Extensions: ${EXTENSIONS[*]}"

# Start watching
inotifywait -m -r \
  --timefmt '%Y-%m-%d %H:%M:%S' \
  --format '%T|%e|%w%f' \
  -e modify -e create -e delete \
  "${WATCH_DIRS[@]}" | while IFS='|' read -r timestamp event fullpath
do
  # Skip if it's a directory
  [[ -d "$fullpath" ]] && continue

  # Skip Brotli files
  [[ "$fullpath" == *.br ]] && continue

  # Match only selected extensions
  if [[ ! "$fullpath" =~ $EXT_REGEX ]]; then
    continue
  fi

  echo "[$timestamp] Event: $event on file: $fullpath"

  brfile="${fullpath}.br"
  gzfile="${fullpath}.gz"
  zstfile="${fullpath}.zst"

  if [[ "$event" == *CREATE* ]]; then
    brotli -f -q 6 "$fullpath" && echo "✅ brotli Compressed: ${fullpath}.br"
    gzip -k -9 "$fullpath" && echo "✅ gzip Compressed: ${fullpath}.gz"
    zstd -k -19 "$fullpath" && echo "✅ zstd Compressed: ${fullpath}.zst"

  elif [[ "$event" == *MODIFY* ]]; then
    brotli -f -q 6 "$fullpath" && echo "✅ brotli Recompressed: ${fullpath}.br"
    gzip -k -9 "$fullpath" && echo "✅ gzip Recompressed: ${fullpath}.gz"
    zstd -k -22 "$fullpath" && echo "✅ zstd Recompressed: ${fullpath}.zst"

  elif [[ "$event" == *DELETE* ]]; then
    if [[ -f "$brfile" ]]; then
      echo "🗑️  Deleting compressed file: $brfile"
      rm -f "$brfile" && echo "✅ Deleted: $brfile"
      rm -f "$gzfile" && echo "✅ Deleted: $gzfile"
      rm -f "$zstfile" && echo "✅ Deleted: $zstfile"
    fi
  fi
done
