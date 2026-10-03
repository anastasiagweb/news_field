# Fact-Check Report Schema

Used by every fact-check in both skills: bible (series P4), slate anchors (series P7), book pitches (series P10), framework (book P3), draft (book P6). Verdicts, severities, and standards are defined in `references/fact_check_doctrine.md`; categories in `references/claim_taxonomy.md`.

```
# Fact-Check Report — <artifact> — v<N>

## Header
- Artifact checked: <path(s), version(s)>
- Claim ledger: <path or "inline below">
- Dossier/bible used as baseline: <path(s)>
- Web tools available: <yes / no — if no, list consequences>
- Date: <ISO date>

## Summary
- Claims extracted: <n>
- VERIFIED: <n> | VERIFIED-WITH-CAVEAT: <n> | ANACHRONISTIC: <n> | MISPLACED: <n> | CONTRADICTED: <n> | OVERSTATED: <n> | MYTH: <n> | DUBIOUS: <n> | UNVERIFIABLE: <n> | FICTIONAL-PLAUSIBLE: <n> | FICTIONAL-IMPLAUSIBLE: <n> | UNVERIFIED (offline): <n>
- Severity: Critical <n> | Major <n> | Minor <n>
- Verdict: **PASS** (zero Critical, zero Major) or **FAIL**

## Claim table
| ID | Unit / location | Cat | Claim (short) | Status in dossier | Verdict | Severity | Source keys |
|---|---|---|---|---|---|---|---|
| C001 | S03 ¶4 | 4 | bear in the Cretan mountains | NOT-YET list #12 | ANACHRONISTIC | Critical | S12, S14 |
| C002 | S03 Note s.2 | 2 | Minoan clay beehives found at several sites | ATTESTED (D-047) | VERIFIED | — | S09 |
| … | | | | | | | |

Every extracted claim appears in the table, including VERIFIED and FICTIONAL ones.
Units: S01–S10 for stories, INTRO, TIMELINE, AFTER for front/back matter; for series artifacts use section numbers.

## Fix blocks
One block per ANACHRONISTIC, MISPLACED, CONTRADICTED, OVERSTATED, MYTH, DUBIOUS, FICTIONAL-IMPLAUSIBLE, and UNVERIFIED (offline, load-bearing) claim.

---
FIX_ID: F001
Claim: C001 (ANACHRONISTIC) — Severity: Critical
Location: S03 ¶4
Text: "A bear emerged from the forest line, massive and dark…"
Problem: No bears are known from Crete in the period; the island's large wild mammals at the time were few (e.g., the Cretan wild goat, introduced or feral). A bear here is impossible and would be noticed.
Options:
  [1] Replace the bear with a wild goat herd whose movement brings down stones on the path (keeps danger, keeps the scene's rhythm).
  [2] Replace with a sudden storm on the ridge.
  [3] Replace with a rival honey-gatherer at the tree (shifts the scene to human conflict).
Story impact: scene-level; the song-to-calm-the-beast beat must be rethought.
Sources:
  [S12] <full reference, tier, URL, access date>
  [S14] <full reference, tier, URL, access date>
---

(The example illustrates the format; the facts in any real block must come from the run's own verified sources.)

## Framework-level flags
Claims whose fix changes the story's premise, engine, or resolution (not just a sentence). Each lists the affected story and the decision needed.

## Sources
| Key | Tier | Full reference | URL | Accessed |
|---|---|---|---|---|
| S09 | A | <author, title, publisher/journal, year, pages> | <url> | <date> |
| … | | | | |

## Notes to reviser
Interactions between fixes; fixes that must be applied together; new facts the reviser may use (already verified) for replacements.
```
