#!/usr/bin/env bash
# Copy the shared Living History doctrine (shared/references, shared/templates)
# into both skills. Edit shared files in shared/, then run this script.
set -euo pipefail
cd "$(dirname "$0")/.."

for skill in living-history-series living-history-book; do
  mkdir -p "skills/$skill/references" "skills/$skill/templates"
  cp shared/references/*.md "skills/$skill/references/"
  cp shared/templates/*.md "skills/$skill/templates/"
  echo "synced shared doctrine -> skills/$skill"
done
