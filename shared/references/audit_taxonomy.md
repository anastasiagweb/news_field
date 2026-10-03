# Audit Taxonomy — Severities, Finding Format, Gates, Loops

Read at the start of every audit phase in both Living History skills. Severity grades must mean the same thing to every role, in every phase, in every run; otherwise the convergence gate is opinion.

---

## Severity grades

### Critical — the artifact is broken
Shipping it would ship a book an informed reader rejects. Always blocking. Never accepted-as-is.

Criteria by axis:
- **Fact:** an anachronism, a misplaced item that is conspicuous or central, a myth stated as fact, any false statement in a Historical Note, the introduction, the timeline, or the afterword.
- **Mentalité:** a premise or resolution that only works with a modern mind; narrator foresight; a sermon ending.
- **Onomastics:** a famous or divine name on an ordinary protagonist; a name reused in the series without declared exception.
- **Story:** no engine; a mystery solved with information that is not on the page; a plot that depends on an impossibility.
- **Standalone:** a story that cannot be understood without another story.
- **CEFR:** a story that reads a band above or below the declared band.
- **Variety:** three or more variety-contract breaches in one book.
- **Respect:** gore or torture on the page; sexual content beyond implication; contempt for a culture or belief; restricted sacred knowledge exposed.

### Major — the artifact is visibly weaker
The book works but loses quality an informed reader would notice. Blocking on every axis whose gate is "zero Major".

Criteria by axis:
- **Fact:** overstated certainty in narration; an implausible invention; a dubious claim left unresolved.
- **Mentalité:** a modern concept in a character's speech or thought; modern idiom in narration; a sneer at belief.
- **Story:** a breach of the plausibility contract; a sagging middle; a flat ending; a banned coda.
- **Prose:** labelled emotion as a habit; generic description; repeated machine-prose tics.
- **Variety:** one or two variety-contract breaches.
- **Onomastics:** confusable names in one story; wrong sex or status type; inconsistent spelling convention.

### Minor — a blemish
A careful reader notices; most do not. Not blocking. Fixed when cheap.

### Nit — hygiene
Typos, spacing, inconsistent capitalisation. Absorbed by the publish-ready edit.

---

## Finding format

Every finding in every audit uses exactly this structure:

```
[ID] [Severity] <one-line summary>
  Role: <auditor role>
  Where: <unit / scene / paragraph, or section and field of a series artifact>
  Evidence: "<exact quotation from the audited artifact>"
  Issue: <why it fails this role's axis — one to three sentences>
  Direction: <optional — one phrase pointing toward a fix>
  Blocking: <yes/no>
```

- **ID:** `<phase code>-v<version>-<role code>-<number>`; phase and role codes are defined in each audit prompt.
- **Evidence is quotation** from the artifact under audit. A finding without a quotation is an impression and is deleted.
- **Where** lets the reviser find the spot in seconds.
- **Direction** gestures toward a fix; it never rewrites. Revision belongs to the reviser.

Fact-check findings use the fix-block format of `templates/fact_check_report_schema.md`.

## Gates

Each audit prompt states its gate per role. The general pattern:

- **Zero Critical, zero Major:** fact-check; mentalité; onomastics; story engine and plausibility; variety and anti-formula; prose; standalone; native reader; Note craft; apparatus.
- **Zero Critical:** CEFR register; dialogue; continuity and logic; respect and darkness; access.

Majors on "zero Critical" axes may remain only with an explicit one-sentence accept-as-is rationale in the report. Minors and Nits never block.

A gate verdict is binary: **PASS** or **REVISE**.

## Revision rules

- The reviser addresses **every** blocking finding, in this order: fact → mentalité → onomastics → plausibility → standalone → everything else. Truth first, because a truth-fix may change a scene.
- Every change is logged in the changelog with the finding ID it resolves.
- Changes not tied to a finding are allowed only when logged as collateral, with a reason.
- A fix must not create an unchecked claim; new claims are listed in the changelog for the next fact-check.
- Passing units are frozen unless a book-level finding requires touching them; any touch is logged.

## Loop caps and the stuck-loop rule

- Each skill states its loop caps per phase.
- **Stuck loop:** if a Critical or Major finding appears in two consecutive audits with the same root cause, stop. Report to the user the finding, both attempted fixes, the suspected root cause, and three options: accept with a recorded limitation; reframe so the problem dissolves; cut and replace the unit.
- No third fix of the same root cause.

## Audit discipline

1. Read the references fresh at the start of every audit.
2. Read three times: once for pleasure as a native reader, once with notes for every role, once for targeted counts and checks.
3. Roles are separate minds; one role's praise never softens another role's finding.
4. Before saving: every finding quotes the artifact; every blocking finding is actionable; the gate is applied mechanically.
5. When subagents are available, an audit may be split by role or by unit; each subagent reads this taxonomy and its role's references itself; the coordinator merges and applies the gate.
