#!/usr/bin/env bash
# Sync shared doctrine, check links, and package both skills into dist/*.skill
# (a .skill file is a zip with the skill folder at its root; it can be uploaded
# to Claude as a skill).
set -euo pipefail
cd "$(dirname "$0")/.."

bash tools/sync_shared.sh
python3 tools/check_links.py

mkdir -p dist
for skill in living-history-series living-history-book; do
  rm -f "dist/$skill.skill"
  (cd skills && zip -qr "../dist/$skill.skill" "$skill" -x '*/.DS_Store')
  echo "built dist/$skill.skill"
done
