# Pipeline State Schema

Every run keeps `00_state.md` in its working directory. Update it after every phase. If a session is interrupted, the next session reads this file first and resumes from `next_phase`.

```
# State — <skill> — <series slug> [— <book slug>]

## Parameters
- skill: <living-history-series | living-history-book>
- civilisation: <…>
- language: <EN-UK>
- cefr: <B1 | B1-B2 | B2>
- working_directory: <path>
- chat_language: <user's language>
- web_tools: <available | unavailable>

## Progress
| Phase | Status | Artifact(s) | Version | Gate | Date |
|---|---|---|---|---|---|
| P0 | done | 00_intake.md | — | user-confirmed | … |
| P1 | done | 01_survey.md | v1 | — | … |
| P4 | in loop | bible_audit.v2.md | v2 | REVISE (C1, M3) | … |
| … | | | | | |

## Loop counters
- <loop name>: <n> of <cap>

## Open user decisions
- <decision needed, with options>

## Next
- next_phase: <P…>
- next_action: <one line>
```
