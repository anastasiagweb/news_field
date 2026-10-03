---
name: living-history-series
description: Editorial pipeline that turns a past civilisation into a fact-checked series package for the Living History line of short-story collections about ordinary people (B1, B1-B2 default, B2) - a sourced survey, 8-20 book windows, a detailed series bible, a slate of ten standalone story concepts per book, and a detailed pitch per book. Seven language lines (en-uk, en-us, fr, it, es, ru, de), each with its own full prompt set written in that language; every phase is run by its own richly drawn team from that culture, with level-bound roles for each band. Multi-role audits and source-based fact-checks loop to zero Critical and Major issues. Feeds living-history-book. Trigger on living-history, Living History series, a new civilisation series, daily-life historical story collections by era, a series bible or slate for a civilisation, or phase requests such as civilisation survey, series bible audit, slate design, book pitch. Not for drafting books (use living-history-book).
---

# Living History — Series Pipeline

Turn a civilisation into a series of books for the **Living History** line: collections of ten standalone short stories about ordinary people in one world-window of that civilisation, each story followed by an honest Historical Note, in clear language (B1, B1–B2 by default, or B2) that a native adult reads for pleasure and an adult learner can read.

This skill produces everything the book skill needs: a researched, fact-checked **series bible**, a **slate** of ten story concepts for every book, and a detailed **pitch** for each book. It does not draft stories — that is `living-history-book`.

---

## How this skill works — the persona is the engine

Every phase prompt opens with its **roles section**: the team that does that phase's work, drawn in depth — people with careers, credentials from the real institutions of their language's publishing and scholarly world, convictions, and refusals. **The first thing you do in every phase is become that team.** Read the roles slowly and adopt them for the whole phase: their standards, their tastes, their intolerances. The methodology that follows is how that team works; the team is why the work is good.

- **Every phase has its own team.** No person appears in two phases. The team sentence, the collective stance ("zero …"), and the cognitive discipline are different in every prompt.
- **Every band has its own people.** Each prompt carries three level-bound roles — one for B1, one for B1–B2, one for B2. Embody only the one that matches the band declared in the run's documents; the other two stay silent.
- **Every language has its own people.** Each language line has its own prompt set, written in that language, with teams drawn from that culture. No prompt is a translation of another's personas.

The working documents contain **no examples** — no sample stories, sample cards, sample Notes, or catalogues of past mistakes. Examples get copied. Every phase works from its team, the doctrine, the sources, and the run's own material.

## Language routing — read this second

| Code | Line | Prompt set | Language reference |
|---|---|---|---|
| `en-uk` | English (United Kingdom) — default | `prompts/en-uk/` | `references/per-language/en-uk.md` |
| `en-us` | English (United States) | `prompts/en-us/` | `references/per-language/en-us.md` |
| `fr` | French | `prompts/fr/` | `references/per-language/fr.md` |
| `it` | Italian | `prompts/it/` | `references/per-language/it.md` |
| `es` | Spanish (peninsular) | `prompts/es/` | `references/per-language/es.md` |
| `ru` | Russian | `prompts/ru/` | `references/per-language/ru.md` |
| `de` | German | `prompts/de/` | `references/per-language/de.md` |

The language declared at intake selects the prompt set for every phase of the run. A prompt from one language is never used for a series in another, not even for one phase: the people, the conventions, the source tradition, and the edge cases differ. If asked to mix, refuse and route correctly. A language outside this table stops the run at P0.

## The fresh-phase principle

Each phase is a different editorial mind. When a single long context designs the bible, audits it, and revises it, the audit is not fresh: it has watched the choices go in and is soft on them. So:

- Enter every phase by re-reading its prompt from the top, adopting its team anew, and treating its input files as if seen for the first time.
- Never consult your own earlier reasoning from another phase; consult only the artifacts on disk.
- Auditors never revise; revisers never audit.
- When subagents are available, run each phase as a fresh subagent given only the phase prompt, the references it lists, and the input artifacts it lists.

## Standing rules from the Managing Editor

These apply to every phase, every language, every loop.

- **Maximum cognitive effort always.** No shortcuts, no batching, no "this seems straightforward".
- **Item by item.** Each claim, each concept, each card, each finding on its own.
- **Literal interpretation.** "Each", "every", "all" are hard constraints.
- **Verify, do not invent.** Every fact sourced; every uncertainty flagged, never guessed.
- **Do exactly what is asked.** No unrequested additions, removals, or "improvements"; when in doubt, ask.
- **Self-review twice** before any output.
- **Show reasoning** for any non-obvious decision.
- **The Managing Editor (Anastasia) is the final arbiter.** Phases recommend; she approves. Reports to her are in her language.

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
- **Optional:** span or focus; number of books; language code (default `en-uk`); CEFR band (default B1–B2); legacy material to mine and audit; the line registry (`line_registry.md`).

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

`<lang>` is the run's language code. Each phase's team is described in its own prompt.

| Phase | Work | Prompt | Output |
|---|---|---|---|
| P0 | Commission intake | `prompts/<lang>/P0_INTAKE.md` | `00_intake.md`, `00_state.md` — **checkpoint** |
| P1 | Civilisation survey | `prompts/<lang>/P1_SURVEY.md` | `01_survey.md`, `01_sources.md` |
| P2 | Series concept | `prompts/<lang>/P2_CONCEPT.md` | `02_concept.md` [+ `02_legacy_audit.md`] — **checkpoint** |
| P3 | Bible draft | `prompts/<lang>/P3_BIBLE_DRAFT.md` | `bible.v1.md` |
| P4 | Bible audit + fact-check | `prompts/<lang>/P4_BIBLE_AUDIT.md` | `bible_audit.vN.md`, `bible_factcheck.vN.md` |
| P5 | Bible revision | `prompts/<lang>/P5_BIBLE_REVISE.md` | `bible.v<N+1>.md` → P4 |
| P6 | Slate design | `prompts/<lang>/P6_SLATE_DESIGN.md` | `slate.v1.md`, `name_registry.md` |
| P7 | Slate audit + feasibility check | `prompts/<lang>/P7_SLATE_AUDIT.md` | `slate_audit.vN.md`, `slate_factcheck.vN.md` |
| P8 | Slate revision | `prompts/<lang>/P8_SLATE_REVISE.md` | `slate.v<N+1>.md` → P7; at PASS **checkpoint** |
| P9 | Book pitch | `prompts/<lang>/P9_PITCH_DRAFT.md` | `pitches/bookNN_<slug>.v1.md` |
| P10 | Pitch audit + fact-check | `prompts/<lang>/P10_PITCH_AUDIT.md` | `pitch_audits/bookNN.vN.md`, `pitch_factchecks/bookNN.vN.md` |
| P11 | Pitch revision | `prompts/<lang>/P11_PITCH_REVISE.md` | `pitches/bookNN_<slug>.v<N+1>.md` → P10 |
| P12 | Delivery | `prompts/<lang>/P12_DELIVERY.md` | finalised package — **checkpoint** |

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

Shared doctrine (identical in both Living History skills), in `references/`:
`line_doctrine.md` (read every run) · `quality_standard.md` · `story_forms.md` · `anti_formula.md` · `mentalite_doctrine.md` · `onomastics.md` · `fact_check_doctrine.md` · `claim_taxonomy.md` · `historical_note_craft.md` · `book_format.md` · `respect_and_darkness.md` · `audit_taxonomy.md`.

Language references, in `references/per-language/`: `en-uk.md` · `en-us.md` · `fr.md` · `it.md` · `es.md` · `ru.md` · `de.md` — readers, spelling and typography, register by band, period terms, rendering of past worlds, period-neutral language, dialogue, Notes, source tradition, banned phrase families, book labels.

Series-specific: `references/series_architecture.md` · `references/bible_anatomy.md` · `references/story_card_craft.md`.

## Templates

Shared: `templates/audit_report_schema.md` · `templates/fact_check_report_schema.md` · `templates/changelog_schema.md` · `templates/state_schema.md` · `templates/name_registry_schema.md`.
Series: `templates/intake_schema.md` · `templates/survey_schema.md` · `templates/concept_schema.md` · `templates/bible_schema.md` · `templates/slate_schema.md` · `templates/book_pitch_schema.md` · `templates/line_registry_schema.md`.

---

## Execution protocol

1. Read this file and `references/line_doctrine.md`.
2. Determine the language code and confirm the working directory (default `living-history/<civilisation-slug>/series/`).
3. For each phase in order: read `prompts/<lang>/<phase>.md` from the top; become its team (and the level-bound role for the run's band); read the references it lists; read its inputs; execute its methodology; write its artifacts; run its final self-check twice; update `00_state.md`; report to the Managing Editor in 3–6 lines in her language; stop at checkpoints.
4. Loops and gates as above.

Resume from `00_state.md` if it exists. Never redo a passed phase unless asked.

## No shortcuts

- No phase output abbreviated, summarised "for space", or carried only in chat.
- No telegraphic fragments in any bible section, slate entry, or pitch card.
- No fact from memory; no source invented.
- No Major accepted "because it is only the plan".
- No revision in chat; every revision on disk with a changelog.
- No prompt from another language, and no team borrowed from another phase.
