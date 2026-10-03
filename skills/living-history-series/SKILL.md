---
name: living-history-series
description: Editorial pipeline that turns a past civilisation (Ancient Greece, Egypt, Rome, the Vikings, Edo Japan, the Aztecs and others) into a fact-checked series package for the Living History line of B1-B2 short-story collections about ordinary people - a sourced civilisation survey, a periodisation into 8-20 books, a detailed series bible, a slate of ten standalone story concepts per book, and a detailed pitch per book - audited and source-checked in loops until zero Critical and Major issues. Feeds the living-history-book skill. Trigger on living-history, Living History series, a new civilisation series, daily-life historical story bundles by era, a series bible or slate of books for a civilisation, auditing an old series plan (e.g. Echoes of Hellas), or phase requests such as civilisation survey, periodisation, series bible audit, slate design, book pitch. Not for drafting books (use living-history-book), crime series, or single historical novels.
---

# Living History — Series Pipeline

Turn a civilisation into a series of books for the **Living History** line: collections of ten standalone short stories about ordinary people in one world-window of that civilisation, each story followed by an honest Historical Note, written in clear English (default B1–B2) that a native adult reads for pleasure.

This skill produces everything the book skill needs: a researched, fact-checked **series bible**; a **slate** of ten story concepts for every book; and a detailed **pitch** for each book. It does not draft stories — that is `living-history-book`.

---

## Philosophy — hold this before any phase

**Read `references/line_doctrine.md` first, every run.** It defines the line: ordinary people, standalone stories, wide variety of genres (including plausible intrigue, theft, mystery, adventure), true to the record, no modern minds, names that belong, honest Notes, clear language that is still literature, honest about hardship without cruelty, respectful.

**Truth is built in from the start.** The earlier generation of this kind of series failed most at the plan level: the plan itself put Solon in a 10th-century colony, Socrates and Cleopatra at the centre, and collapsed into fragments in later volumes. This pipeline researches before it designs and fact-checks every layer — bible, slate anchors, book pitches. See `references/failure_gallery.md`.

**A book is a world-window, not a theme.** One civilisation, one period, one region or social world. See `references/series_architecture.md`.

**Variety is designed, not hoped for.** Every book's ten stories are spread across forms, shapes, openings, endings, and people by contract. See `references/story_forms.md`.

**Cognitive separation.** Each phase is a different editorial mind. Read the phase prompt fresh when entering it; do not let one phase's enthusiasm leak into the next. Auditors never revise; revisers never audit.

**Everything on disk.** Every phase writes a complete artifact before advancing. Chat carries status, not content. No silent edits — every revision is logged against a finding.

**Zero-tolerance gates.** Audits pass only with zero Critical and zero Major on the axes declared in each audit prompt. "Nearly passes" is REVISE.

---

## Inputs

- **Required:** the civilisation (or cultural sphere).
- **Optional:** span or focus; desired number of books; language (default EN-UK); CEFR band (default B1–B2); legacy material (an old plan or old books to mine and audit); a line registry (`line_registry.md`) listing series already produced.

If the requested language has no register pack (`references/cefr_register_<LANG>.md`), stop at P0 and offer to build the pack first.

## Outputs (delivered in P12)

```
<working dir>/
├── bible.md                      — the series bible (finalised)
├── slate.md                      — all books × ten story concepts, with variety tables
├── pitches/bookNN_<slug>.md      — one detailed pitch per book (all, a batch, or just-in-time)
├── name_registry.md              — every name allocated, with attestation
├── sources.md                    — all sources, by tier, with keys
├── changelog.md                  — every revision, tied to findings
├── 00_state.md                   — pipeline state
└── (history) 00_intake.md, 01_survey.md, 01_sources.md, 02_concept.md, [02_legacy_audit.md],
    bible.vN.md, bible_audit.vN.md, bible_factcheck.vN.md, slate.vN.md, slate_audit.vN.md,
    slate_factcheck.vN.md, pitches/*.vN.md, pitch_audits/*.vN.md, pitch_factchecks/*.vN.md
```

The bible plus one pitch are the complete input for one run of `living-history-book`.

---

## Phase map

| Phase | Mind | Prompt | Output |
|---|---|---|---|
| P0 | Intake Editor | `prompts/P0_INTAKE.md` | `00_intake.md`, `00_state.md` — **user checkpoint** |
| P1 | Research Historian | `prompts/P1_SURVEY.md` | `01_survey.md`, `01_sources.md` |
| P2 | Series Architect | `prompts/P2_CONCEPT.md` | `02_concept.md` [+ `02_legacy_audit.md`] — **user checkpoint** |
| P3 | Bible Author | `prompts/P3_BIBLE_DRAFT.md` | `bible.v1.md` |
| P4 | Bible Audit Panel + Fact-Checker | `prompts/P4_BIBLE_AUDIT.md` | `bible_audit.vN.md`, `bible_factcheck.vN.md` |
| P5 | Bible Reviser | `prompts/P5_BIBLE_REVISE.md` | `bible.v<N+1>.md` → back to P4 |
| P6 | Slate Designer | `prompts/P6_SLATE_DESIGN.md` | `slate.v1.md`, `name_registry.md` |
| P7 | Slate Audit Panel + Fact-Checker | `prompts/P7_SLATE_AUDIT.md` | `slate_audit.vN.md`, `slate_factcheck.vN.md` |
| P8 | Slate Reviser | `prompts/P8_SLATE_REVISE.md` | `slate.v<N+1>.md` → back to P7; at PASS **user checkpoint** |
| P9 | Pitch Author | `prompts/P9_PITCH_DRAFT.md` | `pitches/bookNN_<slug>.v1.md` |
| P10 | Pitch Audit Panel + Fact-Checker | `prompts/P10_PITCH_AUDIT.md` | `pitch_audits/bookNN.vN.md`, `pitch_factchecks/bookNN.vN.md` |
| P11 | Pitch Reviser | `prompts/P11_PITCH_REVISE.md` | `pitches/bookNN_<slug>.v<N+1>.md` → back to P10 |
| P12 | Delivery Editor | `prompts/P12_DELIVERY.md` | finalised package — **user checkpoint** |

### Loop caps
- Bible P4↔P5: 5 passes.
- Slate P7↔P8: 4 passes.
- Pitch P10↔P11: 3 passes per book.
- Stuck-loop rule at every loop (`references/audit_taxonomy.md`): the same root cause blocking twice in a row → pause and ask the user.

### Pitches at scale
Twenty detailed pitches are a large body of work. At the P8 checkpoint the user chooses:
- **All books now** (default for short series), or
- **A batch** (e.g., books 1–3), or
- **Just-in-time**: deliver bible + slate now; draft each pitch when that book is about to be written (re-enter at P9 for one book).

---

## User checkpoints

1. **End of P0** — confirm civilisation, span, language, band, defaults, materials.
2. **End of P2** — approve the number of books, the book list, and (if legacy material) the legacy audit decisions.
3. **Stuck loop** — whenever triggered.
4. **End of P8 (slate PASS)** — review the slate; choose pitch mode (all / batch / just-in-time).
5. **End of P12** — delivery.

Optional (user may opt in at P0): pause after bible PASS before slate design.

Use the `AskUserQuestion` tool at checkpoints where available; otherwise ask in chat and wait.

---

## Research and fact-checking

- Research uses the web tools of the session (search and fetch). Every load-bearing fact is verified per `references/fact_check_doctrine.md` (two independent Tier A–C sources; Wikipedia for navigation only; no Tier E).
- If web tools are unavailable, say so at P0. The pipeline may proceed with claims marked `UNVERIFIED (offline)`, but no audit gate can PASS while load-bearing claims are unverified; the user is told exactly what remains unchecked.
- Fact-checks run at P4 (bible), P7 (slate anchors and premises), and P10 (each pitch). Each produces a report per `templates/fact_check_report_schema.md`.

## Subagents

When the environment supports subagents, long phases may be parallelised: the survey by period (P1), audit roles (P4, P7, P10), and pitches by book (P9–P11). Each subagent receives the phase prompt path and the list of references to read itself, writes its artifact to disk, and returns a short status. The orchestrator merges, applies gates, and updates `00_state.md`. Never let a subagent revise what it audited.

---

## References — read when the phase prompt says so

Shared line doctrine (identical in both Living History skills):
- `references/line_doctrine.md` — the line's promise and hierarchy of authority. **Read every run.**
- `references/quality_standard.md` — the five tests (Gripping, Alive, True, Clear, Standalone).
- `references/story_forms.md` — genre palette, shapes, openings, endings, links, plausibility contract, variety contract.
- `references/anti_formula.md` — banned moves, phrases, quotas.
- `references/mentalite_doctrine.md` — no modern minds.
- `references/onomastics.md` — names.
- `references/fact_check_doctrine.md` — sources, evidence status, verdicts.
- `references/claim_taxonomy.md` — what to research and check.
- `references/historical_note_craft.md` — the Notes.
- `references/book_format.md` — the book's output contract.
- `references/cefr_register_EN.md` — English register and period terms.
- `references/respect_and_darkness.md` — darkness ceiling, respect floor.
- `references/audit_taxonomy.md` — severities, findings, gates, loops.
- `references/failure_gallery.md` — calibration from the earlier generation.

Series-specific:
- `references/series_architecture.md` — world-windows, number of books, periodisation, distinctness.
- `references/bible_anatomy.md` — what the bible contains.
- `references/story_card_craft.md` — anchors, engines, slate entries, pitch cards.

## Templates

Shared: `templates/audit_report_schema.md`, `templates/fact_check_report_schema.md`, `templates/changelog_schema.md`, `templates/state_schema.md`, `templates/name_registry_schema.md`.
Series: `templates/intake_schema.md`, `templates/survey_schema.md`, `templates/concept_schema.md`, `templates/bible_schema.md`, `templates/slate_schema.md`, `templates/book_pitch_schema.md`, `templates/line_registry_schema.md`.

---

## Execution protocol

1. Read this file and `references/line_doctrine.md`.
2. Ask for (or confirm) the working directory. Default: `living-history/<civilisation-slug>/series/`.
3. Read `prompts/P0_INTAKE.md`; execute; checkpoint.
4. P1 → P2; checkpoint.
5. P3 → (P4 ↔ P5 until PASS or stuck).
6. P6 → (P7 ↔ P8 until PASS or stuck); checkpoint; choose pitch mode.
7. For each book in the chosen set: P9 → (P10 ↔ P11 until PASS or stuck).
8. P12; checkpoint.

At every phase: read the phase prompt fresh, read the references it lists, write the artifact, update `00_state.md`, post a 3–6 line status in the user's language.

## Resuming

If `00_state.md` exists in the working directory, read it and resume at `next_phase`. Never redo a passed phase unless the user asks.

## Anti-patterns

- Designing books before the survey.
- Themed cross-period books by default.
- Story concepts without anchors; anchors without sources.
- Famous people as protagonists; mythic names on ordinary people.
- A slate where every book has the same shapes in a different costume.
- Telegraphic fragments in any card or pitch.
- Bible facts from memory.
- Accepting a Major because "it's only the plan" — plan errors become book errors.
- Revising in chat instead of on disk.
