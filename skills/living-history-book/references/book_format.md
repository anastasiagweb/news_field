# Book Format — What a Living History Book Contains

Read before designing book pitches (series), before the framework and the draft (book), and before final assembly. This is the output contract.

---

## Shape of a book

```
Front matter
  YAML front matter (in the .md file)
  About this book            — introduction
  Timeline                   — 5–8 entries
  Note on names              — 1–3 sentences, only when names are invented by rule

Ten stories, each followed by its Historical Note
  1. <Story title>
     Historical Note
  …
  10. <Story title>
     Historical Note

Back matter
  What came next             — afterword
```

## Word budgets by band

| Element | B1 | B1–B2 (default) | B2 |
|---|---|---|---|
| Story | 1,300–1,700 | 1,600–2,000 | 1,800–2,300 |
| Historical Note | 110–160 | 120–180 | 130–190 |
| About this book | 220–350 | 250–400 | 280–450 |
| What came next | 180–300 | 200–350 | 220–380 |
| Whole book (approx.) | 15,000–19,000 | 18,000–23,000 | 20,000–26,000 |

Story lengths vary within a book: a spread of at least 300 words between the shortest and the longest.

## About this book (introduction)

Purpose: the minimum orientation any reader needs to enjoy the stories, without spoiling any of them and without a lecture.

Content:
- Where and when, in plain words, with modern place names where they help.
- Two or three concrete features of this world that the stories will rely on, so that no story has to stop and explain them.
- One or two sentences on the kinds of evidence we have.
- What the book does: ten ordinary people, ten standalone stories, a Note after each separating the known from the imagined.
- The note on names, if names are invented by rule.

Register: the top of the book's band. No superlatives. Every sentence is a checked claim.

## Timeline

Five to eight one-line entries framing the window: what came before, the window itself, what came after. Dates in the series' chosen format; contested dates marked as debated. Each entry is a checked claim.

## Stories

Each story begins with its number and title as a heading. Titles are short and concrete, and vary in shape across the book. No epigraphs. No subtitles with dates — orientation happens inside the story.

## Historical Notes

Directly after each story, under the heading "Historical Note". See `historical_note_craft.md`.

## What came next (afterword)

Purpose: tell the reader, plainly and briefly, what happened to this world after the window, so the book sits inside the larger history of the civilisation.

Rules: facts, not reflection; no moral about resilience or the human spirit; no list of what the stories showed; every sentence a checked claim; it may end on one concrete, checked image.

## YAML front matter of the final file

```
---
title: <book title>
series: <series title>
book: <number>
civilisation: <civilisation>
window: <place, dates>
language: <language code>
cefr: <B1 | B1-B2 | B2>
word_count: <integer, whole book>
stories:
  - <number. title — word count — form>
content_notes: <darkness and content flags>
---
```

## What the final file never contains

- Audit comments, scaffolding, scene numbers, word counts in the running text.
- Annotations, glossaries, translations (produced later by other pipelines).
- Images or maps (an illustration brief may be delivered separately on request).
- Mixed spelling conventions.

## Illustration brief (separate delivery file, optional)

On request: one map description (places named in the book, in the period's geography) and one image suggestion per story (a moment, not a spoiler), with period-accurate visual notes from the dossier. Fact-checked like everything else.
