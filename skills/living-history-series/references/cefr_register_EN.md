# CEFR Register Pack — English (EN-UK default) — B1, B1–B2, B2

Read before drafting, before every CEFR audit, and before the publish-ready edit. This pack governs sentence architecture, tenses, cohesion, vocabulary, period terms, and the English of the past. The register is the instrument, not the cage: real literature is written inside it (`quality_standard.md`).

The default band for Living History is **B1–B2**. B1 and B2 books are supported; the spec declares the band.

---

## Spelling and typography

- **British spelling** throughout (-our, -re, -ise, doubled consonants before suffixes as in British usage, British vocabulary where it differs).
- Past forms **learned, burned, dreamed, spelled** (more learner-friendly than the -t forms), unless the bible decides otherwise.
- Prefer **while** and **among** to their older variants.
- **Double quotation marks** for dialogue (single inside double), for consistency across languages and annotation tools.
- Unspaced em dash (—) unless the bible decides otherwise.
- Numbers in narration as words up to one hundred. Our-era dates only in front matter and Notes.

---

## Sentence architecture

### B1
- Mean 9–13 words. About 60% short (5–12), 30% medium (13–20), 10% longer (21–28). Nothing over 28.
- One level of subordination per sentence; a rare two-level sentence must read cleanly.
- Vary openings: subject first; time or place phrase; subordinator first; dialogue first; single word.

### B1–B2 (default)
- Mean 11–15 words. About 50% short (5–12), 35% medium (13–20), 15% longer (21–32). Rare sentences up to 35.
- One level of subordination is the norm; two subordinate elements allowed when one is light (prepositional or adverbial).
- Light participle openings and fronted objects allowed.

### B2
- Mean 13–18 words. About 40% short, 40% medium (13–22), 20% longer (23–38). Very rare sentences up to 42.
- Two levels of subordination freely; three only when the sentence reads cleanly.
- Participle clauses, absolute phrases, occasional inversion for emphasis.

At every band, **variation is the voice**. Monotone length is a Major finding.

## Tenses

- **Narrative tense:** past simple and past continuous, with past perfect for one-step backreference.
- **B1:** present and past simple and continuous, present perfect, light past perfect, will / going to, common modals; first and second conditionals. Past perfect continuous and third conditional rarely.
- **B1–B2:** adds past perfect continuous, third conditional once or twice per story, used to / would for past habits, past perfect passive.
- **B2:** full repertoire; free indirect discourse.
- Present-tense narration in at most one story per book, keeping the band's architecture.

## Cohesion devices

- **B1:** and, but, or, so, because, when, while, after, before, if, although; then, later, after that, meanwhile.
- **B1–B2:** adds however, even though, unless, whereas, besides, on the other hand; therefore and moreover only once every few pages.
- **B2:** full repertoire in measure; academic connectives avoided in fiction.

## Vocabulary

- **The rule of the concrete.** Concrete nouns — tools, foods, plants, animals, clothes, materials, parts of things — may go beyond the band's core vocabulary when they make the world real, provided context makes them clear on first use. Abstract vocabulary above the band is not allowed.
- **Anglo-Saxon first.** Prefer plain Germanic verbs and nouns to Latinate equivalents.
- **Low-frequency density.** On average no more than one low-frequency word per sentence, never more than two in one sentence. Dense physical moments may cluster rare concrete words briefly, then return to plain language.
- **Phrasal verbs** of the common core are welcome. **Idioms** must be period-neutral and transparent; opaque or modern idioms are excluded.

---

## Period terms

A period term is a word from the culture's language, or a specialist word for its things, institutions, garments, vessels, rites, or offices.

**Budget.** At most **6 new period terms per story** at B1–B2 (4 at B1, 8 at B2). A term reused in later stories of the same book does not count again.

**English first.** If plain English carries the meaning without loss, use English. Use the period term only when there is no English equivalent, when the difference matters to the story, or when the characters use it as the name of a specific thing or place.

**Introduce by context, never by definition.** The surrounding action and description make the meaning clear; the narrator never stops to define.

**Consistency.** Each book's dossier holds a rendering table: one thing, one name, all book long.

**Spelling and style.** As in the bible's transliteration convention. No italics for period terms in the running text.

---

## Period-neutral English

The narrator and the characters speak plain, standard, timeless English.

- **No fake-archaic English:** thee, thou, ye, hath, doth, forsooth, methinks, 'tis, prithee, mayhap, verily, and every construction built to sound old.
- **No contemporary-colloquial or modern-marked English:** modern slang, modern informal greetings and exclamations, modern office, therapy, and technology vocabulary, clock-time units where clocks did not exist, modern forms of address.
- **Images from their world.** Similes and metaphors draw only on things the characters knew. Never on machines, electricity, photography, engines, or any later technology.
- **Oaths and blessings** in the period's manner, by its own gods, ancestors, and sacred things, rendered simply.
- **Forms of address** as the period used them, rendered plainly.

## Dialogue

- Short, natural sentences; contractions allowed in dialogue and narration.
- Each speaker recognisable without tags, through rank, role, age, and habit.
- Tags mostly "said" and "asked"; no adverb tags.
- Long speeches rare and simple; a character who explains the theme is a Major finding.

## Historical Notes — register

Notes are written at the top of the book's band or one step above (B2 for B1–B2 books; B1–B2 for B1 books; B2 for B2 books). Words of the historian's trade that any reader of history needs are allowed. Academic jargon is avoided unless immediately and simply explained. Average 14–18 words per sentence; nothing over 30. See `historical_note_craft.md`.

---

## What the CEFR auditor samples

- Three passages of about 200 words per story (opening, middle, ending): sentence-length distribution against the band.
- Every sentence over the band's maximum.
- Subordination above the band's cap.
- Tenses outside the band's repertoire.
- Cohesion devices above the band.
- Period-term count per story and introduction by context.
- Abstract vocabulary spikes.
- Fake-archaic and modern-colloquial English.
- Note register.

**Severity:** a single over-band sentence is Minor; repeated drift in a story is Major; a story that reads a band higher or lower than declared is Critical.

---

## Adding another language

To run the line in another language, create `cefr_register_<LANG>.md` with the same sections. The pipeline does not draft in a language without its pack.
