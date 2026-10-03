---
name: living-history-book
description: Editorial pipeline that turns a Living History series bible plus one book pitch into a publish-ready, fact-checked collection of ten standalone short stories about ordinary people in one window of a past civilisation, each followed by an honest Historical Note, in clear English (B1-B2 by default) that native adults read for pleasure. Every phase is run by a richly drawn persona - the Living History author, research teams, audit panels, fact-check desks, line editors. Builds a sourced period dossier before writing, plans against variety and plausibility contracts, drafts, loops fiction audits and source-based fact-checks to zero Critical and Major issues, then line-edits. Trigger on living-history, a Living History book, the next book of a civilisation series, or a supplied living-history bible and book pitch; also on phase requests such as build the dossier, plan the book, audit the draft, publish-ready edit. New books only. Not for series design (use living-history-series).
---

# Living History — Book Pipeline

Turn a series bible and one book pitch into a finished Living History book: an introduction with a timeline, **ten standalone stories** — each followed by its **Historical Note** — and a short afterword. Every story is gripping, alive, true in its facts, minds, and names, clear at the declared band, and readable on its own.

This skill makes **new books** from a pitch. It does not repair legacy books.

---

## How this skill works — the persona is the engine

Every phase prompt in `prompts/` opens with **Roles & Qualifications**: the people who do that phase's work, drawn in depth — the Living History author with a career, convictions, tastes, and refusals; research teams of period specialists; audit panels and fact-check desks with real credentials; British line editors. **The first thing you do in every phase is become that persona or team.** Read the persona section slowly and adopt it fully for the whole phase. The methodology that follows is how they work; the persona is why the work is good.


The working documents contain **no examples** — no sample stories, sentences, Notes, or catalogues of past mistakes. Examples get copied. Every phase works from its persona, the doctrine, the sources, and the run's own material.

## The fresh-phase principle

Each phase is a different mind. An author who audits their own draft in the same breath is soft on it; an auditor who watched the planning is loyal to it. So:

- Enter every phase by re-reading its prompt from the top, adopting its persona anew, and treating its input files as if seen for the first time.
- Consult only the artifacts on disk, never your own reasoning from another phase.
- Auditors never revise; revisers never audit.
- When subagents are available, run each phase — and, in audits, each role or each story — as a fresh subagent given only the phase prompt, its references, and its inputs.

## Philosophy — hold this before any phase

**Read `references/line_doctrine.md` first, every run.**

**Truth first, then story.** The dossier is built and verified before any scene is planned; the fact-check after drafting catches what slipped through.

**Ten different pleasures.** Forms, shapes, openings, endings, and people are spread by contract (`references/story_forms.md`, `references/anti_formula.md`). Plotted stories are wanted; contrivance is not.

**Five tests, each on its own:** Gripping, Alive, True, Clear, Standalone (`references/quality_standard.md`).

**Everything on disk; no silent edits.** Every artifact is complete before advancing; every change is logged against a finding. Chat carries short reports to the Managing Editor in her language.

**Zero-tolerance gates.** The fact-check gate is always zero Critical, zero Major.

---

## Inputs

- **Required:** `bible.md` and one `pitches/bookNN_<slug>.md` from `living-history-series`.
- **Recommended:** `slate.md`, `name_registry.md`, the series `sources.md`.
- **Optional:** finished books of the same series, for canon and repetition checks.

If the pitch lacks full story cards, or the language lacks `references/cefr_register_<LANG>.md`, stop at P0 and say what is missing.

## Output (delivered in P9)

```
<working dir>/
├── <book-slug>.md            — the publish-ready book
├── fact_check_final.md       — every claim in the final text, verdict, sources
├── sources.md                — all sources by tier
├── delivery_note.md          — summary for the Managing Editor
├── changelog.md              — every revision tied to findings
├── 00_state.md
└── history: 00_spec.md, 00_canon.md, 01_dossier.md, 02_framework.vN.md,
    03_framework_audit.vN.md, 03_framework_factcheck.vN.md, draft/*.vN.md,
    06_draft_audit.vN.md, 06_draft_factcheck.vN.md, 08_book.pr.md, 08_publish_edit_log.md
```

---

## Phase map

| Phase | Persona | Prompt | Output |
|---|---|---|---|
| P0 | Book Production Desk | `prompts/P0_INGEST.md` | `00_spec.md`, `00_canon.md`, `00_state.md` — **checkpoint** |
| P1 | Period Research Team | `prompts/P1_DOSSIER.md` | `01_dossier.md` |
| P2 | The Author as Architect, with Story Editor and Historian | `prompts/P2_FRAMEWORK.md` | `02_framework.v1.md` |
| P3 | Framework Audit Panel + Fact-Check Desk | `prompts/P3_FRAMEWORK_AUDIT.md` | `03_framework_audit.vN.md`, `03_framework_factcheck.vN.md` |
| P4 | The Author as Architect, revision session | `prompts/P4_FRAMEWORK_REVISE.md` | `02_framework.v<N+1>.md` → P3 |
| P5 | The Author | `prompts/P5_DRAFT.md` | `draft/*.v1.md` |
| P6 | Draft Audit Panel + Fact-Check Desk | `prompts/P6_DRAFT_AUDIT.md` | `06_draft_audit.vN.md`, `06_draft_factcheck.vN.md` |
| P7 | The Author, revising under an editor's eye | `prompts/P7_DRAFT_REVISE.md` | revised units → P6 |
| P8 | British Line-Editing Desk | `prompts/P8_PUBLISH_EDIT.md` | `08_book.pr.md`, `08_publish_edit_log.md` |
| P9 | Final Reader and Production Desk | `prompts/P9_FINAL_DELIVERY.md` | final book and delivery files — **checkpoint** |

### Loop caps
- Framework P3↔P4: 4.
- Draft P6↔P7: 4 per story; 4 for book-level findings.
- Stuck-loop rule everywhere (`references/audit_taxonomy.md`): pause and offer the Managing Editor three options — accept with a recorded limitation, reframe, or replace the story.

### Checkpoints with the Managing Editor
1. End of P0 — the spec.
2. Any stuck loop.
3. End of P9 — delivery.
Optional (chosen at P0): review the framework after its PASS; review the audit-clean draft before P8.

## Research and fact-checking

- P1 researches with the session's web tools to the standard of `references/fact_check_doctrine.md`.
- P3 checks the framework against the dossier and verifies anything new.
- P6 extracts and checks every claim in every story, Note, the introduction, the timeline, and the afterword (`references/claim_taxonomy.md`).
- Without web tools, claims are `UNVERIFIED (offline)`; no gate passes while a load-bearing claim is unverified.

---

## References

Shared doctrine (identical in both Living History skills), in `references/`:
`line_doctrine.md` (read every run) · `quality_standard.md` · `story_forms.md` · `anti_formula.md` · `mentalite_doctrine.md` · `onomastics.md` · `fact_check_doctrine.md` · `claim_taxonomy.md` · `historical_note_craft.md` · `book_format.md` · `cefr_register_EN.md` · `respect_and_darkness.md` · `audit_taxonomy.md`.

Book-specific: `references/dossier_craft.md` · `references/story_craft.md`.

## Templates

Shared: `templates/audit_report_schema.md` · `templates/fact_check_report_schema.md` · `templates/changelog_schema.md` · `templates/state_schema.md` · `templates/name_registry_schema.md`.
Book: `templates/spec_schema.md` · `templates/dossier_schema.md` · `templates/framework_schema.md` · `templates/manuscript_schema.md`.

---

## Execution protocol

1. Read this file and `references/line_doctrine.md`.
2. Confirm the working directory (default `living-history/<civilisation-slug>/books/<NN>-<book-slug>/`).
3. For each phase in order: read the phase prompt from the top; adopt its Roles & Qualifications fully; read the references it lists; read its inputs; execute its method; write its artifacts; update `00_state.md`; report to the Managing Editor in 3–6 lines in her language; stop at checkpoints.
4. Loops and gates as above. Resume from `00_state.md` if it exists.

## No shortcuts

- No story drafted before the dossier and a passed framework exist.
- No unit abbreviated, stubbed, or summarised "for space".
- No fact in the text that is in neither the dossier nor `new_claims`.
- No passing story rewritten without a finding.
- No revision in chat; every revision on disk with a changelog.
