# Manuscript Schema — draft units and the final book

## Draft units (P5–P7)

One file per unit and version, so revisions touch only what failed:

```
draft/
├── front.v<N>.md      — About this book, timeline, note on names
├── s01.v<N>.md        — Story 1 and its Historical Note
├── …
├── s10.v<N>.md
├── back.v<N>.md       — What came next
└── new_claims.v<N>.md — facts in the text that are not in the dossier
```

Story unit layout:

```
<!-- unit: S<nn> | version: v<N> | words: story <n>, note <n> | framework: 02_framework.v<N>.md -->

## <n>. <Title>

<story>

### Historical Note

<note>
```

`new_claims.v<N>.md`:

```
| Unit | Paragraph | Claim | Category |
|---|---|---|---|
```

## Assembled publish-ready file (P8)

`08_book.pr.md`: the whole book in reading order, with YAML front matter per `references/book_format.md`.

## Final file (P9)

`<book-slug>.md`:

```
---
<YAML front matter per references/book_format.md>
---

# <Book title>

## About this book

<introduction>

**Timeline**

- <entry>

<note on names, if needed>

## 1. <Title>

<story>

### Historical Note

<note>

(… stories 2–10 …)

## What came next

<afterword>
```

Nothing else in the final file: no audit marks, scene numbers, word counts in the running text, glossaries, or annotations.
