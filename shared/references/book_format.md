# Book Format — What a Living History Book Contains

Read before designing book pitches (series), before the framework and the draft (book), and before final assembly. This is the output contract.

---

## Shape of a book

```
Front matter
  Title page block (YAML front matter in the .md file)
  About this book            — introduction, 250–400 words
  Timeline                   — 5–8 entries
  (optional) A note on names — 1–3 sentences, only when names are invented by rule

Ten stories, each followed by its Historical Note
  1. <Story title>           — 1,600–2,000 words (B1–B2)
     Historical Note         — 120–180 words
  2. …
  …
  10. …

Back matter
  What came next             — afterword, 200–350 words
```

## Word budgets by band

| Element | B1 | B1–B2 (default) | B2 |
|---|---|---|---|
| Story | 1,300–1,700 | 1,600–2,000 | 1,800–2,300 |
| Historical Note | 110–160 | 120–180 | 130–190 |
| About this book | 220–350 | 250–400 | 280–450 |
| What came next | 180–300 | 200–350 | 220–380 |
| Whole book (approx.) | 15,000–19,000 | 18,000–23,000 | 20,000–26,000 |

Stories within a book should vary in length (not ten stories of 1,800 words). A spread of at least 300 words between the shortest and longest is healthy.

## About this book (introduction)

Purpose: give any reader — native or learner — the minimum orientation to enjoy the stories, without spoiling any of them and without a lecture.

Content:
- Where and when: the region, the window of time, in plain words (with one or two modern place names to help: "the island we now call Crete").
- What kind of world: two or three concrete features that will matter in the stories (who ruled, how people lived, what they believed) — chosen so that no story needs to stop and explain them.
- What we know and how: one or two sentences on the evidence (ruins, tablets, paintings, later writers).
- What the book does: ten ordinary people, ten stories, each standalone; a Note after each says what is known and what is imagined.
- If names are invented by rule: the note on names.

Register: the top of the book's band. No superlatives, no "Europe's first great civilisation". Every sentence is a checked claim.

## Timeline

Five to eight entries, each one line, in plain words, framing the book's window: what came before, the window itself, what came after. Dates in the bible's chosen form ("around 1700 BCE"). Contested dates marked ("around 1600 BCE — the date is debated"). Each entry is a checked claim.

## Stories

Each story begins with its number and title as a heading. Titles are short (two to five words), concrete, and not formulaic across the book (avoid ten titles of the form "The [Craftsperson]'s [Noun]"). No epigraphs. No subtitles with dates — orientation happens inside the story.

## Historical Notes

Directly after each story, under the heading "Historical Note". See `historical_note_craft.md`.

## What came next (afterword)

Purpose: close the book by telling the reader, plainly and briefly, what happened to this world after the window — the next centuries in a few sentences — so that the book sits inside the larger story of the civilisation and points toward the next book of the series without advertising it.

Rules:
- Facts, not reflection. No "these stories remind us that…", no moral about resilience or the human spirit, no list of what the stories showed.
- Every sentence is a checked claim.
- It may end on one concrete image (a ruin, an object, a word that survived), checked.

## Front matter (YAML) for the final file

```
---
title: <book title>
series: <series title>
book: <number>
civilisation: <e.g., Ancient Greece>
window: <e.g., Crete, c. 1550–1450 BCE>
language: <EN-UK>
cefr: <B1 | B1-B2 | B2>
word_count: <integer, whole book>
stories:
  - <1. title — word count — form>
  - …
content_notes: <e.g., slavery shown; a death off the page; no sexual content>
---
```

## What the final file never contains

- Audit comments, scaffolding, scene numbers, word counts in the text.
- Annotations, glossaries, translations (produced later by other pipelines).
- Images or maps (an illustration brief may be delivered separately).
- Mixed spelling conventions.

## Illustration brief (separate delivery file, optional)

If the user asks, the delivery may include `illustration_brief.md`: one map description (places named in the book, in the period's geography), and one image suggestion per story (a moment, not a spoiler), each with period-accurate visual notes from the dossier (clothes, hair, buildings, tools). The brief is fact-checked like everything else.
