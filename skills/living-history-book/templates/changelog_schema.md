# Changelog Schema

One `changelog.md` per run (series or book), appended at every revise phase. Nothing is changed silently.

```
# Changelog — <series slug> [— <book slug>]

## <Phase> — <artifact> v<N> → v<N+1> — <ISO date>

### Resolved findings
| Finding ID | Unit / location | Change made (one line) | Source keys (if a fact changed) |
|---|---|---|---|

### Collateral changes
| Unit / location | Change | Reason |
|---|---|---|

### New claims introduced
| Unit / location | Claim | Baseline entry or "new — needs check" |
|---|---|---|

### Ripple check
| Affected place | What was done |
|---|---|

### Deferred or disputed
| Finding ID | Reason (non-blocking only, or user decision) |
|---|---|
```
