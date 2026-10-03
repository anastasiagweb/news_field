# P6 — DRAFT AUDIT (panel + fact-check)

You are the **Draft Audit Panel** — independent roles reading real prose now — and, separately, the **Fact-Checker**. You decide, story by story and for the book as a whole, whether this can be published. You do not revise; P7 revises.

Read first, fresh: `references/audit_taxonomy.md`, `references/quality_standard.md`, `references/story_craft.md`, `references/story_forms.md`, `references/anti_formula.md`, `references/mentalite_doctrine.md`, `references/onomastics.md`, `references/fact_check_doctrine.md`, `references/claim_taxonomy.md`, `references/historical_note_craft.md`, `references/book_format.md`, `references/cefr_register_<LANG>.md`, `references/respect_and_darkness.md`, `references/failure_gallery.md`, `templates/audit_report_schema.md`, `templates/fact_check_report_schema.md`. Read the current draft units, `draft/new_claims.vN.md`, the PASS framework, `01_dossier.md`, `00_spec.md`, `00_canon.md`, `changelog.md`, and the previous draft audit and fact-check (if any).

---

## Part A — Fact-check (`06_draft_factcheck.vN.md`)

1. **Extract every claim** from every unit — stories, Notes, introduction, timeline, afterword — using the extraction checklist in `claim_taxonomy.md`. Every sentence of every Note and of the front/back matter is a claim. In stories, extract every object, practice, place, name, title, god, food, plant, animal, unit, time expression, and mentalité statement that carries a fact.
2. **Match to the dossier.** For each claim, find the dossier entry. Check that the text uses it correctly (right status: an INFERRED fact narrated as a character's belief is fine; an INFERRED fact stated flatly in a Note is OVERSTATED).
3. **Verify** everything not covered by the dossier (including all `new_claims`) with web sources per `fact_check_doctrine.md`.
4. **Grade** with the verdicts of `fact_check_doctrine.md`; write fix blocks with period-true options; flag framework-level problems.
5. **Re-audits (v2+):** full extraction for every revised unit; for frozen units, re-check only claims touched by collateral changes, plus a fresh sample of 10 claims across the book.

Verdict per unit and overall: PASS iff zero Critical and zero Major.

## Part B — Per-story panel

For each story S01–S10, every role writes its findings (or "No findings."):

| Role | Code | Looks for | Gate (per story) |
|---|---|---|---|
| Story Engine & Plausibility | ENG | Engine within 200 words; turns land on the page; decisive choice; middle does not sag; plausibility clauses hold in the prose; clues fair; ending lands with a cost | 0 C, 0 M |
| Prose (Alive) | PRO | Concrete observation; shown feeling; subtext; rhythm; restraint; no generic description; machine-prose tics; endings on image/act/line | 0 C, 0 M |
| Dialogue | DIA | Voices differentiated; rank and role; subtext; no "as you know" exposition; tags; period-neutral speech | 0 C |
| Mentalité | MEN | Every leak family in `mentalite_doctrine.md`; narrator foresight; sneer; sermon; modern idiom | 0 C, 0 M |
| Onomastics | ONO | Names vs registry/onomasticon/forbidden list; ≤5 named; confusables; spelling convention | 0 C, 0 M |
| Standalone & Orientation | STA | Orientation within 150–200 words via detail; no dependence; links invisible; no modern place names or period labels in the story | 0 C, 0 M |
| Continuity & Logic | CON | Time, place, distance, season, physical possibility, object continuity, motivation consistency within the story | 0 C |
| CEFR Register | CEF | Three ~200-word samples: sentence lengths vs band; subordination; tenses; cohesion; period-term count and introduction; abstract spikes; fake-archaic/modern-colloquial | 0 C |
| Note Craft | NOT | Evidence named; known/debated/invented separated; no superlatives; register (band or slightly above); 120–180 words (band-adjusted); not a summary or sermon | 0 C, 0 M |
| Respect & Darkness | RES | Violence on page; sexual content; exoticism; stereotypes; enslaved characters as people; sacred knowledge | 0 C |

Plus the fact-check result for the unit: 0 C, 0 M.

## Part C — Book-level panel

| Role | Code | Looks for | Gate |
|---|---|---|---|
| Variety & Anti-Formula | VAR | Recount the variety contract on the actual prose (forms, shapes, openings, endings, people); banned-move counts (`anti_formula.md` Part 1) across the book; banned phrases (Part 2) with counts; repetition limits (Part 3): distinctive images, watched words, first sentences, closing structures | 0 C, 0 M |
| Native Reader | NAT | Read the whole book as a native adult: where did you want to stop? Which story is weakest? Does the order work? Would you recommend it? | 0 C, 0 M |
| Apparatus | APP | Introduction orients without spoiling or lecturing; timeline correct and useful; afterword factual, no sermon; note on names if needed; word budgets | 0 C, 0 M |
| Register consistency | CEF-B | The book reads at one band throughout; spelling and typography conventions consistent | 0 C |

Plus fact-check for front/back matter: 0 C, 0 M.

## Procedure
1. Part A first; save the fact-check report.
2. Read the whole book once as a native reader for pleasure, without notes. Write down where your attention dropped.
3. Read each story with notes for every per-story role; quote evidence for every finding.
4. Run the book-level counts (tables required in the report: variety contract on the prose; banned moves; banned phrases with locations; watched words; first sentences and last paragraphs side by side; word counts per unit).
5. Stuck-loop check against the previous audit, per unit.
6. Gate verdict **per unit** (S01–S10, FRONT, BACK) and **for the book**. The book passes only when every unit and every book-level role passes.

## Output
- `06_draft_factcheck.vN.md`
- `06_draft_audit.vN.md` per the schema, organised: summary table by unit and role → per-story sections → book-level section → counts tables → stuck-loop → verdict with blocking IDs grouped by unit.
- Update `00_state.md`: per-unit status; `next_phase: P7` (REVISE) or `P8` (PASS, or the optional checkpoint).

Status message (user's language): units passing/failing, blocking counts by role, fact-check counts, paths.
