"""Generate 16 ready-to-paste prompts: 4 languages x 4 CEFR levels."""
import pathlib
import sys

OUT = pathlib.Path(sys.argv[1])

FRUITS = {
    "en": ["Lemon", "Blood Orange", "Pomegranate", "Fig", "Grapes",
           "Pear", "Apple", "Cherries", "Peach", "Plum"],
    "fr": ["le citron", "l'orange sanguine", "la grenade", "la figue", "le raisin",
           "la poire", "la pomme", "les cerises", "la pêche", "la prune"],
    "es": ["el limón", "la naranja sanguina", "la granada", "el higo", "las uvas",
           "la pera", "la manzana", "las cerezas", "el melocotón", "la ciruela"],
    "it": ["il limone", "l'arancia rossa", "il melograno", "il fico", "l'uva",
           "la pera", "la mela", "le ciliegie", "la pesca", "la prugna"],
}

LANG = {
    "en": dict(code="EN-UK", language="English", country="UK", nationality="British",
               learners="English as a Foreign Language (EFL) learners",
               variety="Use British English spelling, vocabulary and everyday life (pounds, the high street, the kettle, the allotment, the corner shop, etc.)."),
    "fr": dict(code="FR", language="French", country="France", nationality="French",
               learners="learners of French as a Foreign Language (FLE)",
               variety="Use standard metropolitan French and authentic French everyday life (le marché, la boulangerie, le voisin du dessous, les vacances en août, etc.)."),
    "es": dict(code="ES", language="Spanish", country="Spain", nationality="Spanish",
               learners="learners of Spanish as a Foreign Language (ELE)",
               variety="Use Peninsular Spanish (vosotros, Spanish vocabulary) and authentic everyday life in Spain (el mercado, el bar de la esquina, la comida a las dos, el pueblo en verano, etc.)."),
    "it": dict(code="IT", language="Italian", country="Italy", nationality="Italian",
               learners="learners of Italian as a Foreign Language",
               variety="Use standard Italian and authentic Italian everyday life (il mercato rionale, il bar sotto casa, la nonna, il pranzo della domenica, il condominio, etc.)."),
}

LEVELS = {
    "A1–A2": dict(slug="a1-a2", words="400–500", scope="Like the style sample: one main situation, four steps of escalation, a witness or sceptic who reacts, a punchy closing line.", split=False),
    "A2–B1": dict(slug="a2-b1", words="550–650", scope="Compared to A1–A2: one extra funny beat or secondary character, a little of the main character's inner thoughts.", split=False),
    "B1–B2": dict(slug="b1-b2", words="700–850", scope="Compared to A2–B1: one extra scene, more inner life, light irony, sharper dialogue. The extra length must come from story, not description.", split=True),
    "B2–C1": dict(slug="b2-c1", words="900–1100", scope="Rich story: subtext, understatement, irony, wordplay, layered characters, a more surprising ending. The extra length must come from an extra funny scene, not from description.", split=True),
}

SENT = {
    "A1–A2": "Sentences of 5–12 words. Only frequent everyday words. Almost no idioms. Humour comes from the situation, dialogue and repetition, not from wordplay. Narrate mainly in the present tense, like the style sample.",
    "A2–B1": "Mostly short sentences, some longer ones. Common everyday phrases and a few idioms when the context makes them clear. Dialogue does most of the work.",
    "B1–B2": "A natural mix of short and longer sentences. Common idioms, light irony, the main character's inner thoughts.",
    "B2–C1": "Natural, varied, confident prose. Nuanced vocabulary, understatement, subtext, wordplay, free indirect style. Still clear and fun: the reader should never get lost.",
}

GRAMMAR = {
    "en": {
        "A1–A2": "Present simple and present continuous, past simple, past continuous, can, going to, will, there is / there are, comparatives and superlatives, basic present perfect (ever / never / just).",
        "A2–B1": "Everything from A1–A2, plus present perfect (for / since / already / yet), past perfect, first conditional, used to, simple passive, should / have to / might.",
        "B1–B2": "Everything from A2–B1, plus present perfect continuous, second and third conditionals, reported speech, a wider range of passives, modal perfects (should have, might have), phrasal verbs.",
        "B2–C1": "Full natural range: mixed conditionals, wish / if only, inversion for effect, cleft sentences, advanced modal use, idiomatic and phrasal language.",
    },
    "fr": {
        "A1–A2": "Présent, passé composé, imparfait for simple descriptions, futur proche (aller + infinitif), negation, comparatifs, simple direct and indirect object pronouns, il y a. No passé simple, no subjonctif.",
        "A2–B1": "Everything from A1–A2, plus passé composé / imparfait contrast, futur simple, plus-que-parfait, conditionnel présent (wishes, politeness), pronouns y and en, relatives qui / que / où, subjonctif only after il faut que. No passé simple.",
        "B1–B2": "Everything from A2–B1, plus subjonctif présent after common triggers (je veux que, avant que, bien que), conditionnel passé, si-clauses, relative dont, gérondif, discours indirect. No passé simple.",
        "B2–C1": "Full natural range: subjonctif in all common uses, concordance des temps, participe présent, nuanced connectors, idiomatic French. Narrate in passé composé / imparfait.",
    },
    "es": {
        "A1–A2": "Presente, pretérito perfecto (he comido), pretérito indefinido of common verbs, imperfecto for descriptions, ir a + infinitivo, estar + gerundio, ser / estar, hay, comparativos, object pronouns. No subjuntivo.",
        "A2–B1": "Everything from A1–A2, plus indefinido / imperfecto contrast, pluscuamperfecto, futuro simple, condicional, imperativo, presente de subjuntivo only after common triggers (quiero que, para que).",
        "B1–B2": "Everything from A2–B1, plus presente de subjuntivo in a wider range (cuando, aunque, es mejor que), imperfecto de subjuntivo in si-clauses (si tuviera… haría…), estilo indirecto, perífrasis verbales.",
        "B2–C1": "Full natural range: all subjuntivo uses, condicional compuesto, pluscuamperfecto de subjuntivo, rich perífrasis, idiomatic Peninsular Spanish.",
    },
    "it": {
        "A1–A2": "Presente, passato prossimo, imperfetto for simple descriptions, stare + gerundio, futuro semplice of common verbs, c'è / ci sono, reflexive verbs, direct object pronouns, comparativi. No congiuntivo, no passato remoto.",
        "A2–B1": "Everything from A1–A2, plus passato prossimo / imperfetto contrast, trapassato prossimo, condizionale presente, indirect object pronouns, ci and ne, imperativo, congiuntivo presente only after penso che / voglio che. No passato remoto.",
        "B1–B2": "Everything from A2–B1, plus congiuntivo presente in a wider range (prima che, benché, sebbene), congiuntivo imperfetto, periodo ipotetico, discorso indiretto, combined pronouns. No passato remoto.",
        "B2–C1": "Full natural range: all congiuntivo uses, condizionale passato, concordanza dei tempi, rich idiomatic Italian. Narrate in passato prossimo / imperfetto.",
    },
}

PERSONA = """You're a {country}-based, masterful bestselling author with 40 years of experience in crafting engaging contemporary short stories in {language}. Renowned for your ability to immerse readers in delightful and heartwarming narratives, your work is characterized by keen observations of everyday life, ensuring authenticity and relatability down to the smallest detail. At the same time, you skillfully weave in rich, multi-dimensional characters that resonate with modern readers.
Your expertise allows you to seamlessly integrate authentic cultural, social, and familial contexts into your stories, creating a vibrant tapestry that both entertains and evokes reflection. Your works are widely praised for their attention to detail, supported by your deep understanding of human psychology and the nuances of social dynamics. You possess a unique talent for capturing the complexities of human emotions and relationships, especially within the framework of light-hearted, humorous, and often whimsical plots. Readers and critics alike admire your ability to balance engaging, character-driven narratives with intimate, relatable storytelling.
Your prose is vivid and lively, often described as 'painting with words,' bringing to life the charming atmospheres, detailed settings, and intricate relationships of your stories. You expertly balance the small, everyday challenges of life with personal, relatable stories, making your work feel both comforting and deeply engaging. Readers are drawn to your stories not only for their relatable situations and witty dialogue but also for your nuanced exploration of themes such as friendship, love, community, and personal growth. Your narratives are both heartwarming and entertaining, leaving readers with a lasting impression of the story and a profound connection to the characters.
Now, you're embarking on a new and exciting challenge: crafting short stories in {language}, specifically designed for {learners} at CEFR level {level}. Your task is to create narratives that are engaging and humorous, yet accessible to learners who are developing their {language} skills.
\t• In each story, introduce readers to everyday situations and humorous incidents, with plots that are simple yet charming.
\t• The characters should be relatable, with clear motivations, allowing learners to follow the narrative with ease while enjoying the humor and light-heartedness.
\t• The language should be straightforward and appropriate for the learners' level, yet still rich enough to convey the atmosphere and humor of the story.
\t• The story should paint a vivid picture of the setting, using descriptive language that is both clear and evocative.
\t• Dialogue should be natural, aiding learners in practicing everyday {language}, while remaining true to the context of the story.
The stories should not only serve as an engaging way to learn {language} but also as a window into the joys and quirks of human behavior, where societal and psychological elements are seamlessly integrated into light-hearted plots. Your goal is to create stories that are both a valuable learning resource and an enjoyable reading experience, making contemporary fiction accessible, delightful, and educational for {language} language learners."""

BODY = """
STYLE SAMPLE
The attached file is a style sample (English, A1–A2, about 450–500 words per story). Read it before drafting. Match its spirit: short clear sentences, deadpan delivery, warmth, a small everyday obsession that escalates. Do not copy its plots, characters, names or jokes. Eight of the fruits below already appear in the sample, so invent completely new situations for them: no shock at a red orange, no sceptic husband trying figs, no grape fight, no pear-ripeness alarms, no sisters arguing about apple varieties, no birds stealing cherries, no peaches on a hot day, no plum glut.

WHAT MAKES THESE STORIES WORK (keep this in every story)
• One ordinary person, one fruit, one small problem that grows into a funny obsession or a funny chain of events.
• A sceptic or a witness who reacts — and often gives in by the end.
• Escalation in clear steps; each step funnier than the last.
• Absurd things told completely seriously.
• Warm, never mean: nobody is humiliated, the ending feels good.
• A short, punchy closing line that sums up the story with a smile.
• Every story uses a different comic engine (rivalry, too much of something, perfect timing, a plan that fails, a misunderstanding, a secret habit, a competition, a family tradition, a mistake that turns out well, etc.). No two stories with the same shape, setting or type of main character. Vary ages, jobs, places and family situations.

LANGUAGE LEVEL: CEFR {level}
Grammar ceiling: {grammar}
{sent}
Story scope: {scope}

SETTING AND NAMES
All characters live in {country} and have typical {nationality} names. All characters western origin with western names. Use authentic local everyday details. {variety}
Write natively in {language}. This is original {language} fiction, not a translation.

TASK
Write 10 short stories in {language}, one per fruit, in this order:
{fruit_list}
Length: {words} words each. Do not go outside this range.
Format: the collection starts with a title (# …). Each story starts with "## N. Title" and is separated from the next by "---". After each story add a line in italics: *Word count: X*.
{run}Save as md.
"""

RUN_SPLIT = "This is a long collection, so write it in two parts. Write stories 1–5 now, then stop. When I say \"continue\", write stories 6–10 in the same file format.\n"


def main():
    OUT.mkdir(parents=True, exist_ok=True)
    for lang, L in LANG.items():
        for level, V in LEVELS.items():
            fruit_list = "\n".join(f"{i}. {f}" for i, f in enumerate(FRUITS[lang], 1))
            text = PERSONA.format(level=level, **L) + "\n" + BODY.format(
                level=level,
                grammar=GRAMMAR[lang][level],
                sent=SENT[level],
                scope=V["scope"],
                words=V["words"],
                fruit_list=fruit_list,
                run=RUN_SPLIT if V["split"] else "",
                **L,
            )
            name = f"{L['code'].lower()}_{V['slug']}.md"
            (OUT / name).write_text(text, encoding="utf-8")
            print(name)


if __name__ == "__main__":
    main()
