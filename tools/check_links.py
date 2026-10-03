#!/usr/bin/env python3
"""Integrity checks for the Living History skills.

1. Every references/, templates/ and prompts/ file mentioned inside a skill
   exists in that skill.
2. Shared doctrine copies are identical to shared/.
3. Every phase prompt opens with a persona section (Roles & Qualifications)
   and carries a Cognitive Discipline section.
4. No example markers and no named-author lineage anywhere in the skills.

Usage: python3 tools/check_links.py   (exit code 1 on any problem)
"""
import filecmp
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
SKILLS = ["living-history-series", "living-history-book"]
LINK = re.compile(r"\b(references|templates|prompts)/([A-Za-z0-9_<>\-]+\.md)")
EXAMPLE_MARKERS = re.compile(
    r"\be\.g\.|\bfor example\b|\bfor instance\b|\bexample\b|\bsample (story|sentence|note|text)\b"
    r"|failure.gallery|echoes of hellas|lineage|sutcliff|renault|golding|fitzgerald|unsworth|ellis peters"
    r"|lindsey davis|van gulik|mantel|jim crace|geraldine brooks",
    re.IGNORECASE,
)

problems = []

for skill in SKILLS:
    base = ROOT / "skills" / skill
    for md in base.rglob("*.md"):
        text = md.read_text(encoding="utf-8")
        rel = md.relative_to(base)

        for folder, name in LINK.findall(text):
            name = name.replace("<LANG>", "EN")
            if "<" in name:
                continue
            if not (base / folder / name).exists():
                problems.append(f"{skill}: {rel} -> missing {folder}/{name}")

        for line_no, line in enumerate(text.splitlines(), 1):
            if EXAMPLE_MARKERS.search(line) and "no examples" not in line.lower() \
                    and "contain no examples" not in line.lower() \
                    and "examples get copied" not in line.lower():
                problems.append(f"{skill}: {rel}:{line_no} example marker: {line.strip()[:90]}")

    for prompt in sorted((base / "prompts").glob("*.md")):
        text = prompt.read_text(encoding="utf-8")
        head = "\n".join(text.splitlines()[:4])
        if "## Roles & Qualifications" not in head:
            problems.append(f"{skill}: prompts/{prompt.name} does not open with '## Roles & Qualifications'")
        if "## Cognitive Discipline (mandatory)" not in text:
            problems.append(f"{skill}: prompts/{prompt.name} lacks '## Cognitive Discipline (mandatory)'")

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
print("OK: links resolve, shared doctrine in sync, every prompt opens with a persona, no example markers.")
