# Audit Report Schema

Used by every audit phase in both skills (bible, slate, pitch, framework, draft). Follow exactly; revisers and gates parse this structure. Severity, finding format, and gate logic are defined in `references/audit_taxonomy.md`.

```
# <Audit name> — <series slug> — <book/unit> — v<N>

## Header
- Phase: <e.g., P6 Draft Audit>
- Artifact audited: <path(s) and version(s)>
- Previous audit: <path or "none">
- References read fresh: <list>
- Date: <ISO date>

## Headline
One paragraph: the strongest and weakest aspects of the artifact, with concrete references (story numbers, sections). No vague praise.

## Findings summary
| Role | Critical | Major | Minor | Nit | Gate for this role | Role verdict |
|---|---|---|---|---|---|---|
| <role> | 0 | 1 | 2 | 0 | zero C, zero M | FAIL |
| … | | | | | | |
| **Fact-check (separate report)** | <from report> | <…> | | | zero C, zero M | <…> |

## Findings by role

### <Role name> (code <XXX>)
[<ID>] [<Severity>] <one-line summary>
  Role: <role>
  Where: <location>
  Evidence: "<quotation>"
  Issue: <why>
  Direction: <optional>
  Blocking: <yes/no>

(repeat for every finding; write "No findings." if none — never omit a role)

### <next role> …

## Quota and checklist tables
(Where the phase requires them: variety contract table, anti-formula counts, name checks, period-term counts, word counts. Each table states PASS/FAIL per line.)

## Cross-role patterns
Root causes that span roles (e.g., "three stories share the deadline-from-authority premise; this drives findings in Variety, Plausibility, and Native Reader").

## Stuck-loop check
- Compared with: <previous audit path or "n/a">
- Persisting blocking root causes: <list or "none">
- Verdict: <no stuck loop | STUCK — pause and escalate>

## Gate verdict
**PASS** or **REVISE**

If REVISE: numbered list of all blocking finding IDs, grouped by unit (story/book/section), in revision priority order (fact → mentalité → onomastics → plausibility → standalone → others).

If PASS: list remaining non-blocking Majors with accept-as-is rationale (one sentence each), and the count of open Minors/Nits for the publish-ready edit.
```
