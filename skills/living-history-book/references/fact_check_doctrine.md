# Fact-Check Doctrine — Sources, Evidence Status, Verification, Verdicts

Read before any research phase (survey, bible, dossier) and before every fact-check (bible, slate, pitch, framework, draft). Read together with `claim_taxonomy.md`. This is the line's guarantee that nothing in a book is untrue about its world — least of all in the Historical Notes, where a false sentence is a lie told as history.

---

## Two principles

1. **Check what you think you know.** The worst errors are the confident ones. Model memory is not a source. Every load-bearing fact is verified against real, retrievable sources.
2. **Separate what is known from what is invented.** Fiction may invent freely where the record is silent. It may never contradict the record, and the Note may never pass invention off as knowledge.

## Research tools

Research and verification use the web tools available in the session (web search and page fetch). Cite real, retrievable sources with URLs or full bibliographic references. Never invent a source, a page number, or a quotation. Never cite "general knowledge".

**If web tools are unavailable** in a run, the pipeline does not fake verification. It marks load-bearing claims `UNVERIFIED (offline)`, and the gate cannot pass on any load-bearing claim that is unverified. Pause and tell the user what could not be checked.

---

## Source hierarchy

### Tier A — Specialist and academic
- Peer-reviewed journals and university-press monographs.
- Excavation reports and site publications by the excavating institution.
- Specialist dictionaries, encyclopedias, and handbooks of record for the civilisation and period.
- Epigraphic, papyrological, and archival corpora and their databases.
- Onomastic lexica and prosopographies.

### Tier B — Major edited encyclopedias and institutional overviews
- General encyclopedias with named expert authors and editorial oversight.
- Overviews published by major museums, universities, and heritage bodies.

### Tier C — Primary evidence and collections
- Museum collection databases and catalogue records of the actual objects referenced.
- Digitised primary texts and their scholarly editions.

### Tier D — Wikipedia and similar crowd-edited works (navigation only)
- Allowed for orientation and for finding Tier A–C references in footnotes.
- Never sufficient alone to confirm a load-bearing claim or to contradict a claim. A finding resting only on Tier D is `DUBIOUS`, not `CONTRADICTED`.

### Tier E — Never used
- Unbylined popular history sites, listicles, blogs, forums, video transcripts, AI-generated text, tourist sites, fan wikis, news reports of research (chase back to the study).

### Evidentiary standards
- **Confirm an uncontroversial claim:** one Tier A or B source.
- **Confirm a load-bearing claim** (a story's anchor, any claim in a Historical Note or in the front/back matter, any claim a plot turn depends on, any NOT-YET entry): two independent sources from Tiers A–C, at least one of them Tier A or B.
- **Contradict a claim:** two independent Tier A–C sources.
- **Independence:** different authors, not derived from each other.
- **Disagreement:** when good sources disagree, the claim is `CONTESTED`. The story may follow one reading; the Note must not present it as settled.
- **Date of the source:** prefer recent scholarship where the field moves fast (dating, new finds, decipherment, scientific analysis). Record when a popular belief has been revised.

---

## Evidence status — how every fact is labelled

| Status | Meaning | What fiction may do | What the Note may say |
|---|---|---|---|
| **ATTESTED** | Directly evidenced by an object, site, text, image, or record | Use freely | State it as known, naming the kind of evidence |
| **INFERRED** | A reconstruction most specialists accept, built from indirect evidence | Use freely | State as probable, with plain hedging |
| **CONTESTED** | Specialists disagree | Use one reading if the story needs it | Say that it is debated; never state one side as fact |
| **UNKNOWN** | The record is silent | Invent, within what was possible and plausible | Do not present the invention as known; if it is central, say it is imagined |
| **ABSENT / NOT YET** | Did not exist or was not available in this time and place | **Forbidden** | Mention only to correct a common belief |
| **MYTH** | A popular belief contradicted by evidence | **Forbidden** as fact; may appear only as a character's period-plausible belief | May correct it if useful |

## The NOT-YET list

Every period dossier carries a list of the anachronism traps most likely for its window: things that appear later, elsewhere, or never. It is the most valuable page in the dossier. Build it by walking every category of `claim_taxonomy.md` against every setting and plot in the book and asking: *what would a modern writer reach for here that did not exist in this time and place?* Each entry records the item, its earliest attestation in this region (or "never"), what to use instead, and source keys.

---

## Verdicts — how a checked claim is graded

| Verdict | Meaning | Default severity |
|---|---|---|
| **VERIFIED** | True for this time and place | — |
| **VERIFIED-WITH-CAVEAT** | True, but stated with more precision or certainty than the evidence has | Minor (Major if in a Note) |
| **ANACHRONISTIC** | Real, but not yet existing or not available in this time and place | Critical |
| **MISPLACED** | Real in this period but wrong region, culture, or social level | Major (Critical if conspicuous or central) |
| **CONTRADICTED** | Wrong | Critical (Major if cosmetic and without story effect) |
| **OVERSTATED** | Inferred or contested evidence presented as settled fact | Major in narration if it creates a false "fact"; **Critical in a Note or in front/back matter** |
| **MYTH** | Repeats a popular misconception | Critical |
| **DUBIOUS** | Could not be confirmed or contradicted with good sources; non-trivial risk | Major — user decides, or replace with a safer detail |
| **UNVERIFIABLE** | Sources silent; claim plausible | Minor if plausible; Major if suspicious |
| **FICTIONAL-PLAUSIBLE** | Invented detail inside the UNKNOWN space, consistent with the period | — |
| **FICTIONAL-IMPLAUSIBLE** | Invented detail that the period's conditions make unlikely | Major |

## Fix blocks

Every ANACHRONISTIC, MISPLACED, CONTRADICTED, OVERSTATED, MYTH, DUBIOUS, or FICTIONAL-IMPLAUSIBLE verdict gets a fix block (format in `templates/fact_check_report_schema.md`): the exact text; the problem with the correct information; one to three period-true replacement options chosen so that the scene still works; sources; severity.

Prefer replacements that keep the story's emotional beat. If a story's central anchor is false, the fix is a framework-level change, flagged as such.

## Special rules for Historical Notes and front/back matter

- Every sentence is a claim and is checked.
- Superlatives (first, finest, unique, unchanged) are claims and need sources; usually they are false or contested — avoid them.
- Speculation is marked as speculation, in plain words.
- The Note names the kind of evidence and, where useful, how far that evidence is from the story's date.
- No precision the evidence lacks.

## Severity — summary for the fact-check gate

- **Critical:** anything a well-informed reader would recognise as impossible for the time and place; any false statement in a Note or front/back matter; a myth stated as fact; a plot that depends on a false fact.
- **Major:** misplaced items; overstated certainty in narration; dubious claims left unresolved; implausible inventions; wrong but non-central dates.
- **Minor:** precision caveats, unverifiable plausible details.
- **Nit:** spelling of a site or term.

The fact-check gate at every level is **zero Critical, zero Major**.

## Record keeping

- Every research phase writes its sources with tier, full reference, URL, and access date.
- Every fact used in a story is traceable: story text → framework scene → dossier entry → source.
- Fact-check reports keep the full claim table, including VERIFIED claims.
