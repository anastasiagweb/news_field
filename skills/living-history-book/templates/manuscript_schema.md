# Manuscript Schema — draft files and the final book

## Draft files (P5–P7)

One file per unit and version, so revisions touch only what failed:

```
draft/
├── front.v1.md      — About this book + timeline (+ note on names)
├── s01.v1.md        — Story 1 + its Historical Note
├── s02.v1.md
├── …
├── s10.v1.md
└── back.v1.md       — What came next
```

Each story file:

```
<!-- unit: S01 | version: v1 | words: story <n>, note <n> | framework: 02_framework.vN.md -->

## 1. <Title>

<story text>

### Historical Note

<note text>
```

Each draft version also writes `draft/new_claims.vN.md`: facts used in the text that are not in the dossier (each with unit and paragraph), for the fact-checker.

## Assembled publish-ready file (P8)

`08_book.pr.md` — the whole book in reading order, front matter YAML per `references/book_format.md`.

## Final file (P9)

`<book-slug>.md`:

```
---
title: <book title>
series: <series title>
book: <NN>
civilisation: <…>
window: <place, c. dates>
language: EN-UK
cefr: B1-B2
word_count: <whole book>
stories:
  - "1. <Title> — <words> — <form>"
  - …
content_notes: <…>
---

# <Book title>

## About this book

<text>

**Timeline**

- <entry>
- …

<optional note on names>

## 1. <Title>

<story>

### Historical Note

<note>

## 2. <Title>
…

## What came next

<text>
```

Nothing else: no audit marks, no scene numbers, no word counts in the text, no glossaries or annotations.
