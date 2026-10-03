# Line Doctrine — Living History

Read this document first, before any phase of either Living History skill (`living-history-series`, `living-history-book`). Every other reference elaborates one part of it. When two rules seem to collide, this document decides.

---

## What the line is

**Living History** is a line of short-story collections set in the everyday worlds of past civilisations. One **series** covers one civilisation. One **book** covers one window of that civilisation — one period, one region, one social world — in **ten standalone stories**, each followed by a short **Historical Note**. Over time the line will hold hundreds of series and thousands of stories.

Each story is told through the eyes of an ordinary person of that world. History is felt from the inside, at human scale.

## Who reads it — the double audience

Every book is written for two readers at once, and must satisfy both completely:

1. **The native adult reader**, who reads the original simply because it is a good book — gripping, specific, alive, and true. This reader must never feel that the text is "for learners".
2. **The adult learner at B1–B2** (default; the line also supports B1 and B2 books), who must be able to read it with pleasure and without a dictionary on every line. Annotated editions and glossaries are produced later, by other pipelines; the text we deliver is the clean original.

The two readers want the same thing: a story they cannot put down, set in a world they can touch. Simplicity of language is not simplicity of meaning. See `quality_standard.md` and `cefr_register_<LANG>.md`.

## The ten commitments

These are the line's promise. Every audit role enforces at least one of them.

### 1. Ordinary people at the centre
Protagonists are invented, ordinary people of the period, across every rank, age, sex, and condition the evidence documents, the unfree and the foreign included. The powerful appear as they appeared to ordinary people — at a distance, as a demand, a procession, a rumour, an order delivered by someone else.

**Real historical figures** may appear only as background or brief cameo, never as protagonist, and are never given invented speeches, private thoughts, or invented deeds that the record does not support. A cameo must be consistent with what is attested about the person at that date and place. When in doubt, refer to the office rather than the person.

### 2. Standalone stories
Every story can be read alone, in any order, by someone who has read nothing else in the book or the series. It establishes its own place, time, and people within its own pages. It never depends on another story for its meaning, never spoils another story, and never ends on a cliffhanger resolved elsewhere.

Light links between stories are welcome as a bonus for the reader of the whole book. A link must be invisible to the reader who reads the story alone. See `story_forms.md` → *Links*.

### 3. Variety of form — every story a different pleasure
A book is not ten versions of one kind of story. The line uses a wide palette of genres and shapes (`story_forms.md`). Within a book, no form dominates. Across the line, the reader should never know which kind of story comes next.

Plotted genres are welcome — they are among the line's pleasures — but they must be **plausible**: the trouble grows out of the period's real conditions, the scale fits an ordinary person, and the resolution uses the means people actually had. See `story_forms.md` → *Plausibility contract*.

### 4. True to the record
Nothing in a story may contradict what is known about its time and place. Objects, tools, techniques, foods, plants, animals, money, units, titles, institutions, gods, rituals, names, places, distances, and events must exist in that window and region. Where evidence is silent, invention is allowed — but invention must stay inside what was possible and plausible, and the Historical Note must not present invention as fact. See `fact_check_doctrine.md` and `claim_taxonomy.md`.

### 5. No modern minds in ancient heads
Characters think, feel, fear, hope, argue, and joke as people of their world did. No modern concepts, values, or vocabulary leak into their thoughts or into the narrator's voice, and the narrator never looks ahead to later history. This is a hard rule. See `mentalite_doctrine.md`.

### 6. Names that belong
Every name is plausible for the person's period, region, language, sex, and status — ideally attested. No famous or mythological names on ordinary people unless that name was demonstrably common. No name reused within a series. See `onomastics.md`.

### 7. Honest Historical Notes
After every story, a Historical Note of 120–180 words tells the reader what the story drew on, what is known, what is debated, and — where it matters — what was invented. The Note is written at the same level as the story or slightly above (B2 for a B1–B2 book), never in academic prose. Every sentence of the Note is a checked claim. See `historical_note_craft.md`.

### 8. Clear language that is still literature
The text sits inside the declared CEFR band in sentence architecture, tenses, and cohesion — and still reads as real literature: concrete observation, shown emotion, subtext, rhythm, restraint, endings on an image rather than a moral. See `quality_standard.md`, `cefr_register_<LANG>.md`, and `anti_formula.md`.

### 9. Honest about hardship, never cruel for effect
Slavery, war, hunger, disease, violence, and unequal law were part of these worlds, and the line does not hide them. But it does not dwell on gore or suffering for effect, and violence happens mostly off the page. No sexual content beyond the implied. See `respect_and_darkness.md`.

### 10. Respect for the people we write about
These were real cultures, and many have living descendants. We write them from the inside, with the dignity we would want for our own ancestors: no exoticism, no "primitive" framing, no idealisation, no ridicule of beliefs, no voyeurism around sacred or restricted knowledge. See `respect_and_darkness.md`.

## What the line is not

- Not a textbook. Stories do not exist to deliver facts; facts exist to make stories true.
- Not costume drama. Modern people in period clothes are forbidden.
- Not a great-man history. Rulers, heroes, and famous thinkers are not our protagonists.
- Not a thriller line. Plotted genres are welcome; conspiracies of state and action-film climaxes are almost never plausible for ordinary people and require exceptional justification.
- Not a sermon. No story ends by explaining its meaning. No narrator lectures on what the past teaches us.

## The book format (summary)

Full specification: `book_format.md`.

- Front matter: title, "About this book" introduction (250–400 words) with a short timeline (5–8 entries).
- Ten standalone stories, each 1,600–2,000 words at B1–B2 (1,300–1,700 at B1; 1,800–2,300 at B2), each followed immediately by its Historical Note (120–180 words).
- Back matter: "What came next" afterword (200–350 words) — what happened to this world after the book's window, told plainly.
- Total: roughly 18,000–23,000 words at B1–B2.

## Languages

The line is designed to run in several languages. The default is **English (British spelling)**. Each language needs its own register pack, `cefr_register_<LANG>.md`. If a run requests a language whose pack does not exist, the pipeline stops at intake and offers to build the pack first, modelled on the English one.

Working artifacts (bibles, dossiers, frameworks, audits) are written in the book's language. Chat summaries to the user are written in the user's language.

## No examples in working documents

The skills deliberately contain no sample stories, sample Notes, sample sentences, or catalogues of past mistakes: examples get copied. Every phase works from rules, sources, and the run's own material. Do not add illustrative examples to any artifact a later phase will read (bibles, dossiers, frameworks, audits); describe requirements and findings in terms of the run's own text.

## Hierarchy of authority

When rules collide, decide in this order:

1. The historical record (as established by the dossier and its sources).
2. The mentalité rule (no modern minds).
3. Respect and darkness limits.
4. The series bible.
5. The book pitch.
6. Craft rules (story forms, anti-formula, quality standard).
7. Register rules — with the caveat that a register violation is never "allowed because the history needed it"; find simpler words for true things.

A story idea that cannot be made true, period-minded, and respectful is cut, not bent.
