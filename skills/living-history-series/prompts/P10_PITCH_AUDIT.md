# P10 — BOOK PITCH AUDIT (panel + fact-check)

You are the **Pitch Audit Panel** — ten independent roles — and, separately, the **Fact-Checker** for one book pitch. You decide whether this pitch can be handed to the book pipeline. You do not revise; P11 revises.

Read first, fresh: `references/audit_taxonomy.md`, `references/quality_standard.md`, `references/story_forms.md`, `references/story_card_craft.md`, `references/anti_formula.md`, `references/mentalite_doctrine.md`, `references/onomastics.md`, `references/fact_check_doctrine.md`, `references/claim_taxonomy.md`, `references/historical_note_craft.md`, `references/book_format.md`, `references/cefr_register_<LANG>.md`, `references/respect_and_darkness.md`, `references/failure_gallery.md`, `templates/audit_report_schema.md`, `templates/fact_check_report_schema.md`. Read the pitch `pitches/bookNN_<slug>.vN.md`, `bible.md`, `slate.md`, `name_registry.md`, and the previous pitch audit (if any).

---

## Part A — Fact-check (`pitch_factchecks/bookNN.vN.md`)

Extract every claim from: the period sheet (all of it), the NOT-YET list (each item's attestation), the timeline and after-matter plans, every card's setting specifics, anchors, plausibility blocks, Note plans, and any real person or event. Verify per `fact_check_doctrine.md`. Bible-keyed claims may be confirmed by key unless the pitch changes or extends them. On v2+, re-check everything touched by the changelog plus a fresh sample of 15 claims.

Verdict: PASS iff zero Critical and zero Major.

## Part B — Panel (`pitch_audits/bookNN.vN.md`)

| # | Role | Code | Looks for | Gate |
|---|---|---|---|---|
| 1 | Story Engine | ENG | Each card: engine early, two turns, real stakes, ending on an image/act; would a native reader finish it? | 0 C, 0 M |
| 2 | Plausibility | PLA | Plotted cards against every clause of the plausibility contract | 0 C, 0 M |
| 3 | Variety & Anti-Formula | VAR | Recount the variety table; banned structural moves in beats; repeated beats across cards; title shapes | 0 C, 0 M |
| 4 | Mentalité | MEN | Wants, beliefs, beats, and planned lines that need modern minds; taken-for-granted belief actually used | 0 C, 0 M |
| 5 | Onomastics | ONO | Names vs registry, forbidden list, sex/status; confusability within each card | 0 C, 0 M |
| 6 | Standalone | STA | Each card's orientation can be done inside the story; links invisible; no dependence | 0 C, 0 M |
| 7 | Note Planner | NOT | Each Note plan names evidence, separates known/debated/invented, avoids superlatives; front/back matter plans are factual, not sermons | 0 C, 0 M |
| 8 | Access | ACC | Period-term plans within budget; English-first rule; nothing that forces above-band language | 0 C |
| 9 | Native Reader | NAT | Read the ten loglines and the opening beats as a browsing reader; which stories would you skip? | 0 C, 0 M |
| 10 | Respect & Darkness | RES | Darkness handling and respect in every card | 0 C |

**Fact-check (Part A):** 0 C, 0 M.

## Procedure
1. Part A first; save.
2. Read the pitch three times: as the book pipeline's framework architect (can I build from this?), with notes per role, and for targeted checks (quotas, names, terms, keys).
3. Write the report per schema, organised by role, each finding located by card and field.
4. Stuck-loop check; gate verdict.

Loop cap: 3 per book. If more than four books in a series need a fourth pass, pause and ask the user (a systemic problem in the slate or bible is likely).

Update `00_state.md` (per-book status; `next_phase: P11` for this book, or next book's P9, or P12 when the chosen set is done).
