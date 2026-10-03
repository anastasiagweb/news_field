#!/usr/bin/env bash
# Copy the shared Living History doctrine (shared/references, including
# shared/references/per-language/, and shared/templates) into both skills.
# Edit shared files in shared/, then run this script.
set -euo pipefail
cd "$(dirname "$0")/.."

for skill in living-history-series living-history-book; do
  mkdir -p "skills/$skill/references/per-language" "skills/$skill/templates"
  rm -f "skills/$skill/references/cefr_register_EN.md"
  cp shared/references/*.md "skills/$skill/references/"
  cp shared/references/per-language/*.md "skills/$skill/references/per-language/"
  cp shared/templates/*.md "skills/$skill/templates/"
  echo "synced shared doctrine -> skills/$skill"
done
