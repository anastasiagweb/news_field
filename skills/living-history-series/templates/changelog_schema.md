# Changelog Schema

One `changelog.md` per run (series or book), appended at every revise phase. Nothing is changed silently.

```
# Changelog — <series slug> [— <book slug>]

## <Phase> — <artifact> v<N> → v<N+1> — <ISO date>

### Resolved findings
| Finding ID | Unit | Change made (one line) | Notes |
|---|---|---|---|
| DA-v1-MEN-03 | S04 ¶12 | Replaced "a proposal with numbers" with the father's oath to the sea-god to leave the north beds alone for a year | Keeps the conflict; period motive |
| F007 | S02 ¶3 | "foot pedal" → "turned the wheel with his left hand" | Source S21 |
| … | | | |

### Collateral changes
Changes not tied to a finding, each with a reason (e.g., "renamed a minor character to avoid same initial as new name introduced by F012").

### New claims introduced
Facts introduced by fixes that the next fact-check must verify (with dossier IDs if already in the dossier).
| Unit | New claim | Dossier ID or "new" |
|---|---|---|

### Ripple check
Other places affected by these changes (other stories, front matter, Notes, registry) and what was done.

### Deferred / disputed
Findings not applied, with reason (only allowed for non-blocking findings, or for user-decided DUBIOUS claims).
```
