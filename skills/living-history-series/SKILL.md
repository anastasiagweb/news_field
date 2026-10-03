---
name: living-history-series
description: Editorial pipeline that turns a past civilisation into a fact-checked series package for the Living History line of B1-B2 short-story collections about ordinary people - a sourced civilisation survey, a periodisation into 8-20 books, a detailed series bible, a slate of ten standalone story concepts per book, and a detailed pitch per book - with every phase run by a richly drawn expert persona team, multi-role audits, and source-based fact-checks looped until zero Critical and Major issues. Feeds the living-history-book skill. Trigger on living-history, Living History series, a new civilisation series, daily-life historical story collections by era, a series bible or slate of books for a civilisation, auditing an old series plan, or phase requests such as civilisation survey, periodisation, series bible audit, slate design, book pitch. Not for drafting books (use living-history-book), crime series, or single historical novels.
---

# Living History — Series Pipeline

Turn a civilisation into a series of books for the **Living History** line: collections of ten standalone short stories about ordinary people in one world-window of that civilisation, each story followed by an honest Historical Note, written in clear English (default B1–B2) that a native adult reads for pleasure.

This skill produces everything the book skill needs: a researched, fact-checked **series bible**, a **slate** of ten story concepts for every book, and a detailed **pitch** for each book. It does not draft stories — that is `living-history-book`.

---

## How this skill works — the persona is the engine

Every phase prompt in `prompts/` opens with **Roles & Qualifications**: a team of richly drawn experts — historians, archaeologists, onomasticians, fact-checkers, series architects, story editors, the Living History author — each with deep credentials, convictions, and refusals. **The first thing you do in every phase is become that team.** Read the persona section slowly and adopt it fully for the whole phase: its standards, its tastes, its intolerances. The methodology that follows is how that team works; the persona is why the work is good.


The working documents contain **no examples** — no sample stories, sample cards, sample Notes, or catalogues of past mistakes. Examples get copied. Every phase works from its persona, the doctrine, the sources, and the run's own material.

## The fresh-phase principle

Each phase is a different editorial mind. When a single long context designs the bible, audits it, and revises it, the audit is not fresh: it has watched the choices go in and is soft on them. So:

- Enter every phase by re-reading its prompt from the top, adopting its persona anew, and treating its input files as if seen for the first time.
- Never consult your own earlier reasoning from another phase; consult only the artifacts on disk.
- Auditors never revise; revisers never audit.
- When subagents are available, run each phase (and each audit role, if useful) as a fresh subagent given only the phase prompt, the references it lists, and the input artifacts.

## Philosophy — hold this before any phase

**Read `references/line_doctrine.md` first, every run.** Ordinary people at the centre; standalone stories; a wide palette of genres, plotted ones included, never contrived; true to the record; no modern minds; names that belong; honest Notes; clear language that is still literature; honest about hardship without cruelty; respect.

**Truth is built in from the start.** The survey is researched before anything is designed, and every layer — bible, slate, pitches — is fact-checked against real sources.

**A book is a world-window, not a theme** (`references/series_architecture.md`).

**Variety is designed, not hoped for** (`references/story_forms.md`).

**Everything on disk; no silent edits.** Every phase writes a complete artifact before advancing; every revision is logged against a finding. Chat carries short status reports to the Managing Editor in her language.

**Zero-tolerance gates.** Audits pass only with zero Critical and zero Major on the axes each audit declares.

---

## Inputs

- **Required:** the civilisation (or cultural sphere).
- **Optional:** span or focus; number of books; language (default EN-UK); CEFR band (default B1–B2); legacy material to mine and audit; the line registry (`line_registry.md`).

If the requested language lacks `references/cefr_register_<LANG>.md`, stop at P0 and offer to build it first.

## Outputs (delivered in P12)

```
<working dir>/
├── bible.md                      — the series bible
├── slate.md                      — all books × ten story concepts, with variety tables
├── pitches/bookNN_<slug>.md      — detailed pitch per book (all, a batch, or just-in-time)
├── name_registry.md              — every name allocated, with attestation
├── sources.md                    — all sources by tier, keyed
├── changelog.md                  — every revision tied to findings
├── delivery_note.md              — summary for the Managing Editor
├── 00_state.md                   — pipeline state
└── history: 00_intake.md, 01_survey.md, 01_sources.md, 02_concept.md, [02_legacy_audit.md],
    bible.vN.md, bible_audit.vN.md, bible_factcheck.vN.md, slate.vN.md, slate_audit.vN.md,
    slate_factcheck.vN.md, pitches/*.vN.md, pitch_audits/*.vN.md, pitch_factchecks/*.vN.md
```

---

## Phase map

| Phase | Persona team | Prompt | Output |
|---|---|---|---|
| P0 | Series Production Desk | `prompts/P0_INTAKE.md` | `00_intake.md`, `00_state.md` — **checkpoint** |
| P1 | Research Team | `prompts/P1_SURVEY.md` | `01_survey.md`, `01_sources.md` |
| P2 | Series Architecture Board | `prompts/P2_CONCEPT.md` | `02_concept.md` [+ `02_legacy_audit.md`] — **checkpoint** |
| P3 | Bible Writers' Room | `prompts/P3_BIBLE_DRAFT.md` | `bible.v1.md` |
| P4 | Bible Audit Panel + Fact-Check Desk | `prompts/P4_BIBLE_AUDIT.md` | `bible_audit.vN.md`, `bible_factcheck.vN.md` |
| P5 | Bible Revision Desk | `prompts/P5_BIBLE_REVISE.md` | `bible.v<N+1>.md` → P4 |
| P6 | Story Room | `prompts/P6_SLATE_DESIGN.md` | `slate.v1.md`, `name_registry.md` |
| P7 | Slate Audit Panel + Fact-Check Desk | `prompts/P7_SLATE_AUDIT.md` | `slate_audit.vN.md`, `slate_factcheck.vN.md` |
| P8 | Story Room, revision session | `prompts/P8_SLATE_REVISE.md` | `slate.v<N+1>.md` → P7; at PASS **checkpoint** |
| P9 | Pitch Author and research partners | `prompts/P9_PITCH_DRAFT.md` | `pitches/bookNN_<slug>.v1.md` |
| P10 | Pitch Audit Panel + Fact-Check Desk | `prompts/P10_PITCH_AUDIT.md` | `pitch_audits/bookNN.vN.md`, `pitch_factchecks/bookNN.vN.md` |
| P11 | Pitch Revision Desk | `prompts/P11_PITCH_REVISE.md` | `pitches/bookNN_<slug>.v<N+1>.md` → P10 |
| P12 | Production and Delivery Desk | `prompts/P12_DELIVERY.md` | finalised package — **checkpoint** |

### Loop caps
- Bible P4↔P5: 5. Slate P7↔P8: 4. Pitch P10↔P11: 3 per book.
- Stuck-loop rule everywhere (`references/audit_taxonomy.md`).

### Pitches at scale
At the slate checkpoint the Managing Editor chooses: all books now; a batch; or just-in-time (bible and slate now, each pitch when its book is about to be written).

## Checkpoints with the Managing Editor

1. End of P0 — the commission.
2. End of P2 — number of books, book list, legacy decisions.
3. Any stuck loop.
4. End of P8 — slate review and pitch mode.
5. End of P12 — delivery.

Optional: pause after bible PASS. Use `AskUserQuestion` where available; otherwise ask in chat and wait.

## Research and fact-checking

- Research uses the session's web tools to the standard of `references/fact_check_doctrine.md`: load-bearing facts on two independent Tier A–C sources; Wikipedia for navigation only; no Tier E; no invented sources.
- Without web tools, claims are marked `UNVERIFIED (offline)` and no gate passes on an unverified load-bearing claim; the Managing Editor is told exactly what remains unchecked.
- Fact-checks run at P4, P7, and P10, each reported per `templates/fact_check_report_schema.md`.

---

## References

Shared doctrine (identical in both Living History skills):
`line_doctrine.md` (read every run) · `quality_standard.md` · `story_forms.md` · `anti_formula.md` · `mentalite_doctrine.md` · `onomastics.md` · `fact_check_doctrine.md` · `claim_taxonomy.md` · `historical_note_craft.md` · `book_format.md` · `cefr_register_EN.md` · `respect_and_darkness.md` · `audit_taxonomy.md` — all in `references/`.

Series-specific: `references/series_architecture.md` · `references/bible_anatomy.md` · `references/story_card_craft.md`.

## Templates

Shared: `templates/audit_report_schema.md` · `templates/fact_check_report_schema.md` · `templates/changelog_schema.md` · `templates/state_schema.md` · `templates/name_registry_schema.md`.
Series: `templates/intake_schema.md` · `templates/survey_schema.md` · `templates/concept_schema.md` · `templates/bible_schema.md` · `templates/slate_schema.md` · `templates/book_pitch_schema.md` · `templates/line_registry_schema.md`.

---

## Execution protocol

1. Read this file and `references/line_doctrine.md`.
2. Confirm the working directory (default `living-history/<civilisation-slug>/series/`).
3. For each phase in order: read the phase prompt from the top; adopt its Roles & Qualifications fully; read the references it lists; read its inputs; execute its method; write its artifacts; update `00_state.md`; report to the Managing Editor in 3–6 lines in her language; stop at checkpoints.
4. Loops and gates as above.

Resume from `00_state.md` if it exists. Never redo a passed phase unless asked.

## No shortcuts

- No phase output abbreviated, summarised "for space", or carried only in chat.
- No telegraphic fragments in any bible section, slate entry, or pitch card.
- No fact from memory; no source invented.
- No Major accepted "because it is only the plan".
- No revision in chat; every revision on disk with a changelog.
