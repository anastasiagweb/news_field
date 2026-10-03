#!/usr/bin/env python3
"""Integrity checks for the Living History skills.

1. Every references/, templates/ and prompts/ file mentioned inside a skill
   exists in that skill.
2. Shared doctrine copies (including per-language references) are identical
   to shared/.
3. Every language has its full prompt set in both skills, and every prompt
   carries the language's own persona structure: Roles section in the first
   lines, team sentence, collective stance, Cognitive Discipline, Edge Cases
   for the language, Final Self-Check, and three level-bound roles
   (B1, B1-B2, B2).
4. Personas are different everywhere: within one language, no role title,
   no stance line and no Cognitive Discipline paragraph repeats across the
   23 prompts of the two skills.
5. No example markers and no named-author lineage anywhere in the skills.

Usage: python3 tools/check_links.py [lang ...]   (exit code 1 on any problem)
With no arguments every language in LANGS is required.
"""
import filecmp
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
SKILLS = {
    "living-history-series": [
        "P0_INTAKE", "P1_SURVEY", "P2_CONCEPT", "P3_BIBLE_DRAFT", "P4_BIBLE_AUDIT",
        "P5_BIBLE_REVISE", "P6_SLATE_DESIGN", "P7_SLATE_AUDIT", "P8_SLATE_REVISE",
        "P9_PITCH_DRAFT", "P10_PITCH_AUDIT", "P11_PITCH_REVISE", "P12_DELIVERY",
    ],
    "living-history-book": [
        "P0_INGEST", "P1_DOSSIER", "P2_FRAMEWORK", "P3_FRAMEWORK_AUDIT",
        "P4_FRAMEWORK_REVISE", "P5_DRAFT", "P6_DRAFT_AUDIT", "P7_DRAFT_REVISE",
        "P8_PUBLISH_EDIT", "P9_FINAL_DELIVERY",
    ],
}

LANGS = {
    "en-uk": dict(roles="## Roles & Qualifications", cog="## Cognitive Discipline (mandatory)",
                  edge="## Edge Cases — English (United Kingdom)", final="## Final Self-Check (twice)",
                  stance="You collectively bring", level="### Level-bound role"),
    "en-us": dict(roles="## Roles & Qualifications", cog="## Cognitive Discipline (mandatory)",
                  edge="## Edge Cases — English (United States)", final="## Final Self-Check (twice)",
                  stance="You collectively bring", level="### Level-bound role"),
    "fr": dict(roles="## Rôles et qualifications", cog="## Discipline cognitive (obligatoire)",
               edge="## Cas limites — français", final="## Auto-vérification finale (deux fois)",
               stance="Vous apportez collectivement", level="### Rôle lié au niveau"),
    "it": dict(roles="## Ruoli e qualifiche", cog="## Disciplina cognitiva (obbligatoria)",
               edge="## Casi limite — italiano", final="## Auto-verifica finale (due volte)",
               stance="Apportate collettivamente", level="### Ruolo legato al livello"),
    "es": dict(roles="## Roles y cualificaciones", cog="## Disciplina cognitiva (obligatoria)",
               edge="## Casos límite — español", final="## Auto-verificación final (dos veces)",
               stance="Aportáis colectivamente", level="### Rol ligado al nivel"),
    "ru": dict(roles="## Роли и квалификации", cog="## Когнитивная дисциплина (обязательная)",
               edge="## Граничные случаи — русский", final="## Окончательная самопроверка (дважды)",
               stance="Вы коллективно приносите", level="### Роль, привязанная к уровню"),
    "de": dict(roles="## Rollen und Qualifikationen", cog="## Kognitive Disziplin (verbindlich)",
               edge="## Grenzfälle — Deutsch", final="## Endgültige Selbstprüfung (zweimal)",
               stance="Sie bringen kollektiv", level="### Niveaugebundene Rolle"),
}

LINK = re.compile(r"\b(references|templates|prompts)/([A-Za-z0-9_<>\-/]+\.md)")
EXAMPLE_MARKERS = re.compile(
    r"\be\.g\.|\bfor example\b|\bfor instance\b|\bexamples?\b|\bsample (story|sentence|note|text)\b"
    r"|par exemple|\bexemples?\b|\bp\. ?ex\."
    r"|ad esempio|per esempio|\besempi[oi]?\b"
    r"|por ejemplo|\bejemplos?\b|\bp\. ?ej\."
    r"|zum beispiel|\bbeispiele?\b|\bz\. ?b\."
    r"|например|\bпример(ы|ов|ам|ами|ах|а|у|ом|е)?\b|\bнапр\."
    r"|failure.gallery|echoes of hellas|lineage|sutcliff|renault|golding|fitzgerald|unsworth|ellis peters"
    r"|lindsey davis|van gulik|mantel|jim crace|geraldine brooks",
    re.IGNORECASE,
)
ALLOWED_EXAMPLE_CONTEXT = ("no examples", "contain no examples", "examples get copied")
LEVEL_LINE = re.compile(r"^- \*\*(B1|B1–B2|B2) — ")
BOLD_ROLE = re.compile(r"^- \*\*(.+?)\*\*")

problems = []


def norm(title: str) -> str:
    title = re.sub(r"\([^)]*\)", "", title)
    title = re.sub(r"[^\w]+", " ", title.lower())
    return " ".join(title.split())


def section(lines, start_heading):
    """Lines from start_heading up to the next '## ' heading."""
    out, inside = [], False
    for line in lines:
        if line.startswith("## "):
            if inside:
                break
            inside = line.strip() == start_heading
            continue
        if inside:
            out.append(line)
    return out


wanted = sys.argv[1:] or list(LANGS)

for skill, phases in SKILLS.items():
    base = ROOT / "skills" / skill
    for md in base.rglob("*.md"):
        text = md.read_text(encoding="utf-8")
        rel = md.relative_to(base)
        for folder, name in LINK.findall(text):
            if "<" in name:
                continue
            if not (base / folder / name).exists():
                problems.append(f"{skill}: {rel} -> missing {folder}/{name}")
        for line_no, line in enumerate(text.splitlines(), 1):
            low = line.lower()
            if EXAMPLE_MARKERS.search(line) and not any(a in low for a in ALLOWED_EXAMPLE_CONTEXT):
                problems.append(f"{skill}: {rel}:{line_no} example marker: {line.strip()[:90]}")

    flat = sorted((base / "prompts").glob("*.md"))
    for stray in flat:
        problems.append(f"{skill}: prompts/{stray.name} sits outside a language folder")

    for kind in ("references", "templates"):
        for shared in (ROOT / "shared" / kind).rglob("*.md"):
            rel_shared = shared.relative_to(ROOT / "shared" / kind)
            copy = base / kind / rel_shared
            if not copy.exists():
                problems.append(f"{skill}: shared {kind}/{rel_shared} not synced")
            elif not filecmp.cmp(shared, copy, shallow=False):
                problems.append(f"{skill}: {kind}/{rel_shared} differs from shared/ (run tools/sync_shared.sh)")

for lang in wanted:
    cfg = LANGS[lang]
    if not (ROOT / "shared" / "references" / "per-language" / f"{lang}.md").exists():
        problems.append(f"{lang}: shared/references/per-language/{lang}.md missing")
    seen_roles, seen_stance, seen_cog = {}, {}, {}
    for skill, phases in SKILLS.items():
        for phase in phases:
            path = ROOT / "skills" / skill / "prompts" / lang / f"{phase}.md"
            where = f"{skill}/{lang}/{phase}"
            if not path.exists():
                problems.append(f"{where}: missing")
                continue
            lines = path.read_text(encoding="utf-8").splitlines()
            head = "\n".join(lines[:4])
            if cfg["roles"] not in head:
                problems.append(f"{where}: does not open with '{cfg['roles']}'")
            for key in ("cog", "edge", "final"):
                if not any(l.strip() == cfg[key] for l in lines):
                    problems.append(f"{where}: lacks '{cfg[key]}'")
            roles = section(lines, cfg["roles"])
            if not any(l.startswith(cfg["level"]) for l in roles):
                problems.append(f"{where}: lacks level-bound heading '{cfg['level']}'")
            levels = [LEVEL_LINE.match(l).group(1) for l in roles if LEVEL_LINE.match(l)]
            if sorted(levels) != sorted(["B1", "B1–B2", "B2"]):
                problems.append(f"{where}: level-bound roles found {levels}, need B1, B1–B2, B2 once each")
            stance = [l.strip() for l in roles if l.startswith(cfg["stance"])]
            if len(stance) != 1:
                problems.append(f"{where}: needs exactly one stance line starting '{cfg['stance']}'")
            for s in stance:
                if s in seen_stance:
                    problems.append(f"{where}: stance line repeats {seen_stance[s]}")
                seen_stance.setdefault(s, where)
            titles = [BOLD_ROLE.match(l).group(1) for l in roles if BOLD_ROLE.match(l)]
            titles += [l[4:].strip() for l in roles
                       if l.startswith("### ") and not l.startswith(cfg["level"])]
            for t in titles:
                key = norm(t)
                if key in seen_roles and seen_roles[key] != where:
                    problems.append(f"{where}: role '{t}' repeats {seen_roles[key]}")
                seen_roles.setdefault(key, where)
            cog = " ".join(l.strip() for l in section(lines, cfg["cog"]) if l.strip())
            if not cog:
                problems.append(f"{where}: Cognitive Discipline is empty")
            elif cog in seen_cog:
                problems.append(f"{where}: Cognitive Discipline repeats {seen_cog[cog]}")
            seen_cog.setdefault(cog, where)

if problems:
    print("\n".join(problems))
    sys.exit(1)
print(f"OK ({', '.join(wanted)}): links resolve, shared doctrine in sync, every prompt opens with its "
      "language's persona team, every persona, stance and discipline is unique, no example markers.")
