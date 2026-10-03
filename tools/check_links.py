#!/usr/bin/env python3
"""Check that every references/, templates/ and prompts/ file mentioned inside a
skill exists in that skill, and that shared files are identical to shared/.

Usage: python3 tools/check_links.py
Exit code 1 on any problem.
"""
import filecmp
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
SKILLS = ["living-history-series", "living-history-book"]
PATTERN = re.compile(r"\b(references|templates|prompts)/([A-Za-z0-9_<>\-]+\.md)")

problems = []

for skill in SKILLS:
    base = ROOT / "skills" / skill
    for md in base.rglob("*.md"):
        text = md.read_text(encoding="utf-8")
        for folder, name in PATTERN.findall(text):
            if "<LANG>" in name:
                name = name.replace("<LANG>", "EN")
            if "<" in name:
                continue
            target = base / folder / name
            if not target.exists():
                problems.append(f"{skill}: {md.relative_to(base)} -> missing {folder}/{name}")

    for kind in ("references", "templates"):
        for shared in (ROOT / "shared" / kind).glob("*.md"):
            copy = base / kind / shared.name
            if not copy.exists():
                problems.append(f"{skill}: shared {kind}/{shared.name} not synced")
            elif not filecmp.cmp(shared, copy, shallow=False):
                problems.append(f"{skill}: {kind}/{shared.name} differs from shared/ (run tools/sync_shared.sh)")

if problems:
    print("\n".join(problems))
    sys.exit(1)
print("OK: all referenced files exist and shared doctrine is in sync.")
