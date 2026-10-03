# Fact-Check Doctrine — Sources, Evidence Status, Verification, Verdicts

Read before any research phase (survey, bible, dossier) and before every fact-check (bible, slate, pitch, framework, draft). Read together with `claim_taxonomy.md`. This is the line's guarantee that nothing in a book is untrue about its world.

The previous generation of this kind of book failed most often not in the stories but in the facts — and worst of all in the Historical Notes, where speculation was presented as fact ("chemical analysis shows lapis lazuli" in Minoan frescoes; "the technology remained unchanged since the Bronze Age"). This doctrine exists so that never happens again. See `failure_gallery.md`.

---

## Two principles

1. **Check what you think you know.** The worst errors are the confident ones: a bear on Crete, a lighthouse in a Bronze Age harbour, a hoplite in Mycenaean Greece, Alexandria in the 13th century BCE. Model memory is not a source. Every load-bearing fact is verified against real, retrievable sources.
2. **Separate what is known from what is invented.** Fiction may invent freely where the record is silent. It may never contradict the record, and the Note may never pass invention off as knowledge.

## Research tools

Research and verification use the web tools available in the session (web search and page fetch). Cite real, retrievable sources with URLs or full bibliographic references. Never invent a source, a page number, or a quotation. Never cite "general knowledge".

**If web tools are unavailable** in a run, the pipeline does not fake verification. It marks load-bearing claims `UNVERIFIED (offline)`, and the gate cannot pass on any Critical-risk claim that is unverified. Pause and tell the user what could not be checked.

---

## Source hierarchy

### Tier A — Specialist and academic
- Peer-reviewed journals and university-press monographs (JSTOR, Project MUSE, Persée, OpenEdition, Cairn, university repositories).
- Excavation reports and site publications by the excavating institution.
- Specialist reference works: *Oxford Classical Dictionary*, *Cambridge Ancient History*, *Brill's New Pauly*, *Encyclopaedia Iranica*, *Encyclopaedia of Islam*, *Oxford Encyclopedia of Ancient Egypt*, *Reallexikon der Assyriologie*, *Cambridge World History*, *Oxford Handbooks* on the relevant period, the *Grove* dictionaries for art and music.
- Epigraphic and papyrological corpora and their databases; corpora of tablets and inscriptions.
- Onomastic lexica (e.g., LGPN).

### Tier B — Major edited encyclopedias and institutional overviews
- *Encyclopædia Britannica*, *Treccani*, *Larousse*, *Brockhaus*, national encyclopedias with named expert authors.
- Overviews published by major museums and heritage bodies (e.g., the Metropolitan Museum's *Heilbrunn Timeline of Art History*), UNESCO World Heritage documentation.

### Tier C — Primary evidence and collections
- Museum collection databases (British Museum, Metropolitan Museum, Louvre, national and regional archaeological museums, site museums).
- Digitised primary texts (Perseus, ORACC, CDLI, Thesaurus Linguae Graecae where accessible, digital Egyptological resources, digitised codices).
- Photographs and catalogue records of the actual objects referenced.

### Tier D — Wikipedia and similar crowd-edited works (navigation only)
- Allowed for orientation and for finding Tier A–C references in footnotes.
- Never sufficient alone to confirm a load-bearing claim or to contradict a claim. A finding resting only on Tier D is `DUBIOUS`, not `CONTRADICTED`.

### Tier E — Never used
- Unbylined popular history sites, listicles, blogs, forums, video transcripts, AI-generated text, tourist sites, fan wikis, news reports of research (chase back to the study).

### Evidentiary standards
- **Confirm an uncontroversial claim:** one Tier A or B source.
- **Confirm a load-bearing claim** (the story's anchor, any claim stated in a Historical Note, any claim that a plot turn depends on): two independent sources from Tiers A–C, at least one of them Tier A or B.
- **Contradict a claim** (record it as wrong): two independent Tier A–C sources.
- **Independence:** different authors, not derived from each other. Two encyclopedia entries by the same scholar are one source.
- **Disagreement:** when good sources disagree, the claim is `CONTESTED`. The story may follow one reading; the Note must not present it as settled.
- **Date of the source:** prefer recent scholarship for fast-moving fields (archaeological dating, DNA studies, decipherment, chronology debates). Note when a popular "fact" has been revised.

---

## Evidence status — how the dossier labels every fact

Every fact used to build a story carries one of these labels. The labels decide what fiction may do with it.

| Status | Meaning | What fiction may do | What the Note may say |
|---|---|---|---|
| **ATTESTED** | Directly evidenced: an object, site, text, image, or record shows it | Use freely | State it as known, with the kind of evidence ("tablets from Pylos list…") |
| **INFERRED** | A reconstruction most specialists accept, built from indirect evidence | Use freely | State as "probably", "scholars think", "seems to have" |
| **CONTESTED** | Specialists disagree | Use one reading if the story needs it | Say that it is debated; never state one side as fact |
| **UNKNOWN** | The record is silent | Invent, within what was possible and plausible | Do not present the invention as known; if it is central, say it is imagined |
| **ABSENT / NOT YET** | Did not exist or was not available in this time and place | **Forbidden** | Can mention only to correct a common myth |
| **MYTH** | A popular belief contradicted by evidence (horned Viking helmets; Romans vomiting at feasts) | **Forbidden** as fact; may appear only as something a character wrongly believes, if period-plausible | May correct gently if useful |

## The NOT-YET list

Every period dossier carries a list of the anachronism traps most likely for its window: things that appear later, elsewhere, or never. It is the most valuable page in the dossier. It is built by asking, category by category (`claim_taxonomy.md`), "what would a modern writer reach for here that did not exist?" Typical candidates to check — each may or may not be absent in a given window, which is exactly what the dossier establishes: coins before coinage; stirrups before stirrups; paper, glass windows, sugar, tomatoes, potatoes, maize, chillies, coffee, tea, citrus fruits, chickens, cats, horses as riding animals, iron tools, writing, wax tablets, soap, candles, scissors, spinning wheels, kick wheels, rotary querns, rotary olive mills, pulleys, lighthouses, sea charts, magnetic compasses, mechanical clocks, the seven-day week, surnames, schools, guilds, police, prisons, lotteries, and the names of later peoples, places, and gods. Each item records its earliest attestation in this region, with source.

---

## Verdicts — how a checked claim is graded

| Verdict | Meaning | Default severity |
|---|---|---|
| **VERIFIED** | True for this time and place | — |
| **VERIFIED-WITH-CAVEAT** | True, but stated with a precision or certainty the evidence does not have | Minor (Major if in a Note) |
| **ANACHRONISTIC** | Real, but not yet existing or not available in this time and place | Critical |
| **MISPLACED** | Real in this period but wrong region, culture, or social level | Major (Critical if conspicuous or central) |
| **CONTRADICTED** | Simply wrong | Critical (Major if cosmetic, e.g., a date off by a decade with no story effect) |
| **OVERSTATED** | Inferred or contested evidence presented as settled fact | Major in narration if it creates a false "fact"; **Critical in a Historical Note** |
| **MYTH** | Repeats a popular misconception | Critical |
| **DUBIOUS** | Could not be confirmed or contradicted with good sources; non-trivial risk | Major — user decides, or replace with a safer detail |
| **UNVERIFIABLE** | Sources silent; claim plausible | Minor if plausible; Major if suspicious |
| **FICTIONAL-PLAUSIBLE** | Invented detail inside the UNKNOWN space, consistent with the period | — |
| **FICTIONAL-IMPLAUSIBLE** | Invented detail that the period makes unlikely (an Egyptian woman ship's captain in the Late Bronze Age; a palace that pays "double" by written contract) | Major |

## Fix blocks

Every ANACHRONISTIC, MISPLACED, CONTRADICTED, OVERSTATED, MYTH, DUBIOUS, or FICTIONAL-IMPLAUSIBLE verdict gets a fix block (format in `templates/fact_check_report_schema.md`):

- The exact text.
- The problem, in two to four sentences, with the correct information.
- One to three period-true replacement options, chosen so that the scene still works.
- Sources (two for any correction that changes the text).
- Severity.

Prefer replacements that keep the story's emotional beat. If a story's central anchor is false (a Minoan potter whose triumph is a technique that did not exist), the fix is a framework-level change, flagged as such.

## Special rules for Historical Notes

- Every sentence of a Note is a claim and is checked.
- Superlatives ("the finest", "the first", "unique", "unchanged for three thousand years") are claims and need sources; usually they are false or contested — avoid them.
- Speculation must be marked as speculation ("may have", "some scholars think", "we do not know").
- The Note names the kind of evidence (a fresco, tablets, a shipwreck, a later writer) and, where useful, how far that evidence is from the story's date ("a Greek writer living a thousand years later says…").
- The Note never claims precision the evidence lacks (exact numbers of flowers per gram may be fine for saffron, which is modern-measurable; "Minoans harvested 300 kilograms a year" is not).

## Severity — summary for the fact-check gate

- **Critical:** anything a well-informed reader would recognise as impossible for the time and place; any false statement in a Note; a myth stated as fact; a plot that depends on a false fact.
- **Major:** misplaced items; overstated certainty in narration; dubious claims left unresolved; implausible inventions; wrong but non-central dates.
- **Minor:** precision caveats, unverifiable plausible details.
- **Nit:** spelling of a site or term.

The fact-check gate at every level is **zero Critical, zero Major**.

## Record keeping

- Every research phase writes its sources to a `sources` section or file with tier, full reference, URL, and access date.
- Every fact used in a story should be traceable: story text → framework scene → dossier entry → source.
- Fact-check reports keep the full claim table, including VERIFIED claims, so the user can see what was checked.
