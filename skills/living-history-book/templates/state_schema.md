# Pipeline State Schema

Every run keeps `00_state.md` in its working directory, updated after every phase. An interrupted run resumes from `next_phase`.

```
# State — <skill> — <series slug> [— <book slug>]

## Parameters
- skill: <living-history-series | living-history-book>
- civilisation: <…>
- language: <code>
- cefr: <B1 | B1-B2 | B2>
- working_directory: <path>
- chat_language: <user's language>
- web_tools: <available | unavailable>

## Progress
| Phase | Status | Artifact(s) | Version | Gate | Date |
|---|---|---|---|---|---|

## Loop counters
| Loop | Count | Cap |
|---|---|---|

## Open user decisions
- <decision and options>

## Next
- next_phase: <code>
- next_action: <one line>
```
