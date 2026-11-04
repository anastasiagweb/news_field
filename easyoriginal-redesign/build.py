#!/usr/bin/env python3
"""Baut die statischen Seiten aus _src/ zusammen.

Jede Seite in _src/*.html kann Platzhalter wie <!-- @include header --> enthalten;
sie werden durch _src/partials/<name>.html ersetzt. Ergebnis: fertige HTML-Dateien
im Ordner easyoriginal-redesign/, die ohne Server direkt im Browser funktionieren.

Aufruf:  python3 build.py
"""
import pathlib
import re

ROOT = pathlib.Path(__file__).resolve().parent
SRC = ROOT / "_src"
PARTIALS = SRC / "partials"
INCLUDE = re.compile(r"<!-- @include ([\w-]+) -->")


def render(path: pathlib.Path) -> str:
    text = path.read_text(encoding="utf-8")
    return INCLUDE.sub(lambda m: (PARTIALS / f"{m.group(1)}.html").read_text(encoding="utf-8").rstrip("\n"), text)


def main() -> None:
    for page in sorted(SRC.glob("*.html")):
        out = ROOT / page.name
        doctype, _, rest = render(page).partition("\n")
        note = "<!-- Generiert aus _src/" + page.name + " – bitte dort bearbeiten und `python3 build.py` ausführen. -->"
        out.write_text(doctype + "\n" + note + "\n" + rest, encoding="utf-8")
        print("✓", out.relative_to(ROOT))


if __name__ == "__main__":
    main()
