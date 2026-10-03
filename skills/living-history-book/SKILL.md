---
name: living-history-book
description: Editorial pipeline that turns a Living History series bible plus one book pitch into a publish-ready, fact-checked collection of ten standalone short stories about ordinary people in one window of a past civilisation, each followed by an honest Historical Note, in clear English (B1-B2 by default) that native adults read for pleasure. Builds a sourced period dossier before writing, plans the stories against variety and plausibility contracts (mystery, theft, intrigue, journey, comedy and more), drafts, then loops a multi-role fiction audit and a source-based fact-check until zero Critical and Major issues, then line-edits. Trigger on living-history, a Living History book, the next book of a civilisation series, historical stories with historical notes, or a supplied living-history bible and book pitch; also on phase requests such as build the dossier, plan the book, audit or fact-check the draft, publish-ready edit. New books only. Not for series design (use living-history-series) or crime novellas.
---

# Living History — Book Pipeline

Turn a series bible and one book pitch into a finished Living History book: an introduction with a timeline, **ten standalone stories** — each followed by its **Historical Note** — and a short afterword. Every story is gripping, alive, true (facts, minds, names), clear at the declared band, and readable on its own.

This skill only makes **new books** from a pitch. It does not repair legacy books; legacy material is mined by the series skill instead.

---

## Philosophy — hold this before any phase

**Read `references/line_doctrine.md` first, every run.** Ordinary people at the centre; standalone stories; wide variety of genres (plotted genres welcome, never contrived); true to the record; no modern minds; names that belong; honest Notes; clear language that is still literature; honest about hardship, never cruel; respectful.

**Truth first, then story.** The dossier is built before any scene is planned. Stories are designed on verified ground; the fact-check after drafting catches what slipped through. See `references/dossier_craft.md` and `references/failure_gallery.md`.

**Ten different pleasures.** The book is designed as a set: forms, shapes, openings, endings, and people are spread by contract. See `references/story_forms.md` and `references/anti_formula.md`.

**Five tests, each on its own.** Gripping, Alive, True, Clear, Standalone (`references/quality_standard.md`). Strength in one never compensates for weakness in another.

**Cognitive separation.** Researcher, architect, auditors, drafter, reviser, editor are different minds. Read each phase prompt fresh. Auditors never revise; revisers never audit.

**Everything on disk; no silent edits.** Every artifact is written in full before advancing; every change is logged against a finding. Chat carries short status in the user's language.

**Zero-tolerance gates.** Audits pass only with zero Critical and zero Major on the axes each audit declares. The fact-check gate is always zero Critical, zero Major.

---

## Inputs

- **Required:** `bible.md` (series bible from `living-history-series`) and one book pitch `pitches/bookNN_<slug>.md`.
- **Recommended:** `slate.md`, `name_registry.md`, the series `sources.md`.
- **Optional:** earlier books of the series (finals), for canon and repetition checks.

If the pitch lacks story cards or the bible lacks a register pack for the language, stop at P0 and say what is missing.

## Output (delivered in P9)

```
<working dir>/
├── <book-slug>.md            — the publish-ready book (the deliverable)
├── fact_check_final.md       — every claim, final verdict, sources (evidence file)
├── sources.md                — all sources by tier
├── delivery_note.md          — summary for the user (their language)
├── changelog.md              — every revision tied to findings
├── 00_state.md
└── (history) 00_spec.md, 00_canon.md, 01_dossier.md, 02_framework.vN.md, 03_framework_audit.vN.md,
    03_framework_factcheck.vN.md, draft/*.vN.md, 06_draft_audit.vN.md, 06_draft_factcheck.vN.md,
    08_book.pr.md, 08_publish_edit_log.md, (optional) illustration_brief.md, <book-slug>.docx
```

---

## Phase map

| Phase | Mind | Prompt | Output |
|---|---|---|---|
| P0 | Ingest Editor | `prompts/P0_INGEST.md` | `00_spec.md`, `00_canon.md`, `00_state.md` — **user checkpoint** |
| P1 | Period Researcher | `prompts/P1_DOSSIER.md` | `01_dossier.md` |
| P2 | Book Architect | `prompts/P2_FRAMEWORK.md` | `02_framework.v1.md` |
| P3 | Framework Audit Panel + Fact-Checker | `prompts/P3_FRAMEWORK_AUDIT.md` | `03_framework_audit.vN.md`, `03_framework_factcheck.vN.md` |
| P4 | Framework Reviser | `prompts/P4_FRAMEWORK_REVISE.md` | `02_framework.v<N+1>.md` → back to P3 |
| P5 | Drafter | `prompts/P5_DRAFT.md` | `draft/front.v1.md`, `draft/s01…s10.v1.md`, `draft/back.v1.md`, `draft/new_claims.v1.md` |
| P6 | Draft Audit Panel + Fact-Checker | `prompts/P6_DRAFT_AUDIT.md` | `06_draft_audit.vN.md`, `06_draft_factcheck.vN.md` |
| P7 | Draft Reviser | `prompts/P7_DRAFT_REVISE.md` | revised units `draft/*.v<N+1>.md` → back to P6 |
| P8 | Publish-Ready Editor | `prompts/P8_PUBLISH_EDIT.md` | `08_book.pr.md`, `08_publish_edit_log.md` |
| P9 | Final Polish & Delivery | `prompts/P9_FINAL_DELIVERY.md` | `<book-slug>.md` and delivery files — **user checkpoint** |

### Loop caps
- Framework P3↔P4: 4 passes.
- Draft P6↔P7: 4 passes per story and 4 for book-level findings.
- Stuck-loop rule everywhere (`references/audit_taxonomy.md`): the same blocking root cause twice in a row → pause and ask the user with three options (accept with recorded limitation; reframe; replace the story with a reserve concept from the slate/pitch).

### Checkpoints
1. **End of P0** — confirm spec (language, band, budgets, story list, variety table).
2. **Stuck loop** — whenever triggered.
3. **End of P9** — delivery.

Optional (chosen at P0): review the framework after P3 PASS; review the audit-clean draft before P8.

---

## Research and fact-checking

- P1 researches with the session's web tools to the standard of `references/fact_check_doctrine.md`: load-bearing facts on two independent Tier A–C sources; Wikipedia for navigation only; no Tier E.
- P3 fact-checks the framework (every planned fact maps to the dossier or is newly verified).
- P6 fact-checks the draft: every claim in every story, Note, the introduction, the timeline, and the afterword is extracted and graded (`references/claim_taxonomy.md`).
- If web tools are unavailable, claims are marked `UNVERIFIED (offline)`; no gate passes while a load-bearing claim (plot turn, Note sentence, front/back matter) is unverified.

## Subagents

When the environment supports subagents: P1 may split research by domain or by story; P3 and P6 may split by role or by story (each subagent reads the audit prompt and references itself); P5 may draft stories in parallel only after the framework is frozen, and the orchestrator then runs a book-level formula and register pass before P6. The orchestrator merges, applies gates, and keeps `00_state.md` current.

---

## References

Shared line doctrine (identical in both Living History skills):
- `references/line_doctrine.md` — **read every run.**
- `references/quality_standard.md` — five tests.
- `references/story_forms.md` — palette, shapes, openings, endings, links, plausibility contract, variety contract.
- `references/anti_formula.md` — banned moves, phrases, quotas.
- `references/mentalite_doctrine.md` — no modern minds.
- `references/onomastics.md` — names.
- `references/fact_check_doctrine.md` — sources, evidence status, verdicts.
- `references/claim_taxonomy.md` — what to extract and check.
- `references/historical_note_craft.md` — the Notes.
- `references/book_format.md` — output contract and budgets.
- `references/cefr_register_EN.md` — English register, period terms, period-neutral English.
- `references/respect_and_darkness.md` — darkness ceiling, respect floor.
- `references/audit_taxonomy.md` — severities, findings, gates, loops.
- `references/failure_gallery.md` — calibration.

Book-specific:
- `references/dossier_craft.md` — building the period dossier.
- `references/story_craft.md` — writing the story.

## Templates

Shared: `templates/audit_report_schema.md`, `templates/fact_check_report_schema.md`, `templates/changelog_schema.md`, `templates/state_schema.md`, `templates/name_registry_schema.md`.
Book: `templates/spec_schema.md`, `templates/dossier_schema.md`, `templates/framework_schema.md`, `templates/manuscript_schema.md`.

---

## Execution protocol

1. Read this file and `references/line_doctrine.md`.
2. Confirm the working directory. Default: `living-history/<civilisation-slug>/books/<NN>-<book-slug>/`.
3. P0; checkpoint.
4. P1.
5. P2 → (P3 ↔ P4 until PASS or stuck); optional checkpoint.
6. P5.
7. P6 ↔ P7 until every story and the book pass, or stuck; optional checkpoint.
8. P8 → P9; checkpoint.

At every phase: read the prompt fresh, read the references it lists, write the artifact(s), update `00_state.md`, post a 3–6 line status in the user's language. Resume from `00_state.md` if it exists.

## Anti-patterns

- Drafting before the dossier exists.
- A fact in the text that is in neither the dossier nor `new_claims`.
- Ten stories in one shape; dawn openings; generation codas; praise-from-authority endings.
- Intrigue that only works with a prince who explains himself to a craftsman at night.
- Modern minds, modern idiom, narrator foresight.
- Mythic or famous names on ordinary people.
- A Note that states speculation as fact.
- Explaining the period inside the story instead of showing it.
- Rewriting passing stories without a finding.
- Revising in chat instead of on disk.
