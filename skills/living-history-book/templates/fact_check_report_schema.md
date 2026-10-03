# Fact-Check Report Schema

Used by every fact-check in both skills: bible, slate, book pitch, book framework, book draft. Verdicts, severities, and standards: `references/fact_check_doctrine.md`. Categories: `references/claim_taxonomy.md`.

```
# Fact-Check Report — <artifact> — v<N>

## Header
- Artifact checked: <paths and versions>
- Baseline used (bible / dossier): <paths>
- Web tools available: <yes | no — consequences listed>
- Date: <ISO date>

## Summary
- Claims extracted: <n>
- VERIFIED <n> | VERIFIED-WITH-CAVEAT <n> | ANACHRONISTIC <n> | MISPLACED <n> | CONTRADICTED <n> | OVERSTATED <n> | MYTH <n> | DUBIOUS <n> | UNVERIFIABLE <n> | FICTIONAL-PLAUSIBLE <n> | FICTIONAL-IMPLAUSIBLE <n> | UNVERIFIED (offline) <n>
- Severity: Critical <n> | Major <n> | Minor <n>
- Verdict: **PASS** (zero Critical, zero Major) | **FAIL**

## Claim table
| ID | Unit / location | Cat | Claim (short) | Baseline entry and status | Verdict | Severity | Source keys |
|---|---|---|---|---|---|---|---|

Every extracted claim appears, including VERIFIED and FICTIONAL ones.
Unit codes: S01–S10 (stories with their Notes), INTRO, TIMELINE, AFTER; for series artifacts, section and field.

## Fix blocks
One block per ANACHRONISTIC, MISPLACED, CONTRADICTED, OVERSTATED, MYTH, DUBIOUS, FICTIONAL-IMPLAUSIBLE, and load-bearing UNVERIFIED (offline) claim.

---
FIX_ID: F<nnn>
Claim: C<nnn> (<verdict>) — Severity: <Critical | Major>
Location: <unit, paragraph>
Text: "<exact text>"
Problem: <two to four sentences with the correct information>
Options:
  [1] <period-true replacement that keeps the scene's beat>
  [2] <alternative>
  [3] <alternative, optional>
Story impact: <sentence | scene | framework-level>
Sources:
  [<key>] <full reference, tier, URL, access date>
  [<key>] <full reference, tier, URL, access date>
---

## Framework-level flags
Claims whose fix changes a premise, an engine, a turn, or a resolution; each with the affected unit and the decision needed.

## Sources
| Key | Tier | Full reference | URL | Accessed |
|---|---|---|---|---|

## Notes to reviser
Fixes that must be applied together; verified facts available for replacements.
```
