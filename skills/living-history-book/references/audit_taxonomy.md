# Audit Taxonomy — Severities, Finding Format, Gates, Loops

Read at the start of every audit phase in both Living History skills. Severity grades must mean the same thing to every role, in every phase, in every run; otherwise the convergence gate is opinion.

---

## Severity grades

### Critical — the artifact is broken
Shipping it would ship a book an informed reader rejects. Always blocking. Never accepted-as-is.

Examples:
- **Fact:** an anachronism, a misplaced object, a myth, a false statement in a Historical Note, the introduction, the timeline, or the afterword.
- **Mentalité:** a premise or resolution that only works with a modern mind; narrator foresight; a sermon ending.
- **Onomastics:** a famous or divine name on an ordinary protagonist; a name reused in the series.
- **Story:** no engine; a mystery whose solution uses information not on the page; a plot that depends on an impossibility.
- **Standalone:** a story that cannot be understood without another story.
- **CEFR:** a story that reads a band above (or below) the declared band.
- **Variety:** three or more variety-contract breaches in one book.
- **Respect:** gratuitous gore or sexual content; contempt for a culture or belief; restricted sacred knowledge exposed.

### Major — the artifact is visibly weaker
The book works but loses quality an informed reader would notice. Blocking on every axis whose gate is "zero Major".

Examples:
- **Fact:** overstated certainty in narration; an implausible invention; a dubious claim left unresolved.
- **Mentalité:** a modern concept in a character's speech or thought; modern idiom in narration; a sneer at belief.
- **Story:** contrivance (a breach of the plausibility contract); a sagging middle; a flat ending; a formula coda.
- **Prose:** labelled emotions as a habit; generic description; repeated machine-prose tics.
- **Variety:** one or two variety-contract breaches.
- **Onomastics:** a confusable pair of names in one story; wrong sex or status type.

### Minor — a blemish
A careful reader notices; most do not. Not blocking. Fix when cheap.

### Nit — hygiene
Typos, spacing, inconsistent capitalisation. Absorbed by the publish-ready edit.

---

## Finding format

Every finding in every audit uses exactly this structure:

```
[ID] [Severity] <one-line summary>
  Role: <auditor role>
  Where: <book/story/scene/paragraph, or field in a bible/slate/pitch>
  Evidence: "<exact quotation>"
  Issue: <why it fails this role's axis — one to three sentences>
  Direction: <optional — one phrase pointing toward a fix>
  Blocking: <yes/no>
```

- **ID** format: `<phase>-<version>-<role code>-<number>`, e.g. `DA-v2-MEN-04` (draft audit, version 2, mentalité, finding 4). Role codes are listed in each audit prompt.
- **Evidence is quotation.** A finding without a quotation is an impression and is deleted.
- **Where** must let the reviser find the spot in seconds.
- **Direction** gestures; it does not rewrite. Revision is the reviser's job.

Fact-check findings use the fix-block format in `templates/fact_check_report_schema.md` instead.

## Gates

Each audit prompt states its gate per role. The general pattern:

- **Zero Critical, zero Major:** fact-check; mentalité; onomastics; story engine & plausibility; variety & anti-formula; prose (Alive); standalone; native reader.
- **Zero Critical:** CEFR register; dialogue; continuity & logic; respect & darkness.

Majors on "zero Critical" axes may remain only with an explicit one-sentence accept-as-is rationale recorded in the report. Minors and Nits never block.

A gate verdict is binary: **PASS** or **REVISE**. "Nearly passes" is REVISE.

## Revision rules

- The reviser addresses **every** blocking finding, in the order: fact-check → mentalité → onomastics → plausibility → standalone → everything else (truth first, because a true-fix may change a scene).
- Every change is logged in the changelog with the finding ID it resolves.
- No silent edits: changes not tied to a finding are allowed only if logged as "collateral" with a reason.
- A fix must not create a new unchecked claim. New claims introduced by a fix are listed in the changelog under "new claims" for the next fact-check.
- Passing units (stories, books) are frozen unless a book-level finding requires touching them; any touch is logged.

## Loop caps and the stuck-loop rule

- Each skill states its loop caps per phase.
- **Stuck loop:** if a Critical or Major finding appears in two consecutive audits with the same root cause (not merely the same words), stop. Report to the user: the finding, both attempted fixes, the suspected root cause, and three options — accept with a recorded limitation, reframe the story or premise so the problem dissolves, or cut and replace the unit (story, book).
- Do not attempt a third fix of the same root cause.

## Audit discipline

1. **Read the references fresh** at the start of every audit — do not rely on memory of an earlier phase.
2. **Read three times:** once for pleasure (as the native reader), once with notes per role, once for targeted checks (quotas, lists, ledgers).
3. **Roles are separate minds.** One role's praise never softens another role's finding.
4. **Before saving:** every finding has a quotation; every blocking finding is actionable; the gate is applied mechanically.
5. **Subagents:** when the environment supports subagents, audits may be split (per story, or per role). Each subagent reads this taxonomy and its role's references itself; the orchestrator merges the reports and applies the gate.
