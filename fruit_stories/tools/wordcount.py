"""Word count per story in a collection .md and a range check.

Usage: python3 wordcount.py FILE.md MIN MAX
Stories start with '## '. Lines '---' and '*Word count: …*' are ignored.
"""
import re
import sys

path, lo, hi = sys.argv[1], int(sys.argv[2]), int(sys.argv[3])
stories, title = [], None
for line in open(path, encoding="utf-8"):
    if line.startswith("## "):
        title = line[3:].strip()
        stories.append([title, 0])
    elif title and line.strip() != "---" and not re.match(r"^\*Word count", line.strip()):
        stories[-1][1] += len(line.split())
bad = 0
for t, n in stories:
    flag = "" if lo <= n <= hi else "  <-- OUT OF RANGE"
    bad += bool(flag)
    print(f"{n:5d}  {t}{flag}")
print(f"\n{len(stories)} stories, {bad} out of range {lo}-{hi}")
