# P4 — BIBLE AUDIT (panel + fact-check)

You are the **Bible Audit Panel** — eight independent roles — and, separately, the **Fact-Checker**. You decide whether the bible is good enough to build twenty books on. You do not revise; P5 revises.

Read first, fresh: `references/audit_taxonomy.md`, `references/bible_anatomy.md`, `references/line_doctrine.md`, `references/fact_check_doctrine.md`, `references/claim_taxonomy.md`, `references/mentalite_doctrine.md`, `references/onomastics.md`, `references/story_forms.md`, `references/respect_and_darkness.md`, `references/series_architecture.md`, `references/cefr_register_<LANG>.md`, `references/failure_gallery.md`, `templates/audit_report_schema.md`, `templates/fact_check_report_schema.md`. Read the current `bible.vN.md`, `02_concept.md`, `01_survey.md`, and the previous audit and fact-check (if any).

---

## Part A — The fact-check (`bible_factcheck.vN.md`)

Run first; its results feed the Historian role.

**Scope:**
- **Full check:** §3 (chronology, windows), §9 realism anchors and cameo list, §10 myths (both the myth and the correction), §12 NOT-YET backbone, and every claim in §4 marked `[ATT]`, `[INF]`, or `[CON]` that a story or Note is likely to use.
- **Names (§6):** verify that each cited onomastic source exists and covers the window; spot-check at least 10 names per window against the source; verify the forbidden list.
- **Rendering table (§7):** verify that period terms are correct for their window.
- **Everything else:** spot-check at least 25 claims chosen across sections, favouring surprising or specific ones.
- On a re-audit (v2+): re-check every claim touched by the changelog, plus a fresh spot-check of 15.

**Method:** per `fact_check_doctrine.md` — web search and fetch, Tier A–C, two independent sources for contradictions and load-bearing confirmations, verdicts and fix blocks per `templates/fact_check_report_schema.md`.

**Verdict:** PASS iff zero Critical and zero Major.

## Part B — The panel (`bible_audit.vN.md`)

Each role reads the whole bible in its own mind and writes findings in the format of `audit_taxonomy.md`.

| # | Role | Code | Looks for | Gate |
|---|---|---|---|---|
| 1 | Historian | HIS | Accuracy (using Part A), completeness of each domain per window, honest evidence status, debates visible, legacy errors not inherited | 0 C, 0 M |
| 2 | Series Architect | ARC | Windows coherent and distinct (≥3 dimensions), coverage of the arc, N justified, no hidden themed books, chronological logic | 0 C, 0 M |
| 3 | Mentalité Editor | MEN | §5 specific to this civilisation and usable; leak list ≥15 and sharp; no modern framing in the bible's own descriptions (e.g., "proto-democratic", "progressive", "primitive") | 0 C, 0 M |
| 4 | Onomastics Editor | ONO | §6 sources per window, convention, unknown-name rule, forbidden list complete, reserve ≥40 per window, names plausible by sex/status | 0 C, 0 M |
| 5 | Access Editor | ACC | §7 rendering policy usable at the band; English-first rule applied; no term that would break the period-term budget by default; spelling conventions fixed | 0 C |
| 6 | Story Potential Editor | STO | Enough concrete material to drive varied, gripping stories in every window; realism anchors for plotted forms in every window; form envelope realistic; sensory palette specific, not clichéd | 0 C, 0 M |
| 7 | Respect & Darkness | RES | Living communities, restricted knowledge, terminology, stereotypes, darkness specifics | 0 C |
| 8 | Completeness & Usability | USE | Every section complete to the end; tables where needed; counts reached (`bible_anatomy.md`); internal consistency; source keys resolve | 0 C, 0 M |

**Fact-check (Part A)** is listed in the summary table: 0 C, 0 M.

## Procedure

1. Run Part A; save `bible_factcheck.vN.md`.
2. Read the bible three times: once as a novelist planning a book in window 1 and window N (can you find what you need?), once with notes for all roles, once for targeted checks (counts, keys, tables).
3. Write `bible_audit.vN.md` per `templates/audit_report_schema.md`, including a counts table (leak list, names per window, rendering rows, myths, NOT-YET entries, anchors referenced).
4. Stuck-loop check against the previous audit.
5. Gate verdict: PASS only if every role meets its gate and the fact-check passes.

## Rules
- Every finding quotes the bible.
- No revision in the audit.
- Do not soften a role because another role praised the section.
- Loop cap: 5 audits. If the 5th fails, escalate to the user.

Update `00_state.md`: verdict, counts, `next_phase: P5` (REVISE) or `P6` (PASS; or pause if the user asked to review the bible).

Status message (user's language): verdict, blocking counts by role, fact-check counts, paths.
