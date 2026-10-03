# Audit Report Schema

Used by every audit phase in both skills. Severity, finding format, and gates: `references/audit_taxonomy.md`.

```
# <Audit name> — <series slug> [— <book slug>] — v<N>

## Header
- Phase: <phase code and name>
- Artifact audited: <paths and versions>
- Previous audit: <path | none>
- References read fresh: <list>
- Date: <ISO date>

## Headline
One paragraph: the strongest and weakest aspects of the artifact, with unit references. No vague praise.

## Findings summary
| Role (code) | Critical | Major | Minor | Nit | Gate | Role verdict |
|---|---|---|---|---|---|---|
| … | | | | | | |
| Fact-check (separate report) | | | | | zero C, zero M | |

## Findings by role

### <Role name> (<code>)
<findings in the audit_taxonomy format, or "No findings.">

(every role appears; none is omitted)

## Counts and quota tables
The tables the phase prompt requires, each line marked PASS or FAIL.

## Cross-role patterns
Root causes that span roles.

## Stuck-loop check
- Compared with: <previous audit | n/a>
- Persisting blocking root causes: <list | none>
- Verdict: <no stuck loop | STUCK — pause and escalate>

## Gate verdict
**PASS** or **REVISE**

REVISE: all blocking finding IDs grouped by unit, in revision priority order (fact → mentalité → onomastics → plausibility → standalone → others).
PASS: remaining non-blocking Majors with accept-as-is rationale; count of open Minors and Nits.
```
