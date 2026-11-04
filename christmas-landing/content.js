/*
 * Inhalte und Produktdaten der Weihnachts-Landingpage.
 * Alle IDs, Preise und Texte stammen aus dem Shop easyoriginal.com (Stand: 4. November 2026).
 *
 * Neue Sprache (z. B. Englisch) hinzufügen: einen weiteren Eintrag in LANGS anlegen –
 * gleiche Struktur, eigene Produkt-IDs, Bilder in img/ ablegen. Der Rest der Seite baut sich automatisch.
 */
window.EO = {
  shop: "https://easyoriginal.com",
  cartPath: "/warenkorb/",
  metaPixelId: "1076640955760504",   // Pixel aus dem Shop
  freeShippingFrom: 39,
  shippingFlat: 6.9,

  // Format-Slugs (WooCommerce-Attribut pa_buch-ebook)
  formats: [
    { key: "print",  slug: "taschenbuch",          label: "Taschenbuch + Audio-Online", short: "Taschenbuch" },
    { key: "cd",     slug: "taschenbuch-audio-cd", label: "Taschenbuch + Audio-CD",     short: "Taschenbuch + CD" },
    { key: "pdf",    slug: "pdf",                  label: "E-Book PDF + Audio-Online",  short: "PDF" },
    { key: "epub",   slug: "epub",                 label: "E-Book ePub + Audio-Online", short: "ePub" }
  ],

  editions: {
    frank: {
      name: "Frank-Lesemethode",
      level: "A1–A2",
      line: "Deutsche Übersetzung direkt im Text",
      points: [
        "Deutsche Übersetzung und Erklärungen stehen direkt in den Textabschnitten",
        "Danach folgt derselbe Abschnitt noch einmal ohne Hilfen",
        "Kein Wörterbuch nötig, auch mit ersten Kenntnissen",
        "Ideal für Einsteiger und Wiedereinsteiger"
      ],
      fit: "Sie möchten ein ganzes Buch lesen, verstehen ohne Hilfe aber noch wenig."
    },
    wort: {
      name: "Mit Worterklärungen",
      level: "A2–B1",
      line: "Ausführliches deutsches Glossar",
      points: [
        "Zusammenhängender Text in der Originalsprache",
        "Nummerierte Fußnoten erklären Wörter, Wendungen und Grammatik auf Deutsch",
        "Ausführliches deutsches Glossar",
        "Ideal, wenn Sie einer Handlung schon gut folgen"
      ],
      fit: "Sie verstehen schon vieles, nur einzelne Wörter bringen Sie noch ins Stocken."
    }
  },

  // Preise der Einzelbücher (für alle Weihnachtsbücher gleich)
  bookPrices: {
    frank: { print: 13.99, cd: 19.99, pdf: 7.99, epub: 7.99 },
    wort:  { print: 11.99, cd: 17.99, pdf: 6.99, epub: 6.99 }
  },
  // Preise der 3er-Sets
  setPrices: {
    frank: { print: 41.97, cd: 59.97, pdf: 23.97, epub: 23.97 },
    wort:  { print: 35.97, cd: 53.97, pdf: 20.97, epub: 20.97 }
  },
  // Geschenksets (3 Bücher + Schreibset Deluxe)
  giftPrices: {
    frank: { online: 75.96, cd: 93.96 },
    wort:  { online: 69.96, cd: 87.96 }
  },

  giftContents: [
    "Drei gedruckte Bücher mit Audio-Online oder Audio-CDs",
    "Hardcover-Notizbuch A5, 64 fein linierte Seiten",
    "Spiral-Notizbuch A5 mit Soft-Touch-Einband, 64 Seiten, um 360° umklappbar",
    "Notizheft A6, 40 fein linierte Seiten",
    "Drei Lesezeichen im passenden Design",
    "Kugelschreiber und Druckbleistift im Etui"
  ],

  LANGS: [
    {
      code: "it",
      intro: ["Matteo möchte seine Schwiegermutter endlich für Weihnachten begeistern. Die Nachbarn in der Via Roma möchten angeblich nur ein wenig dekorieren. Und Giulia möchte den Gästen ihres kleinen Hotels einen unvergesslichen Aufenthalt bereiten. An guten Absichten fehlt es also nicht. An Gelegenheiten zum Lachen ebenfalls nicht.", "Drei moderne italienische Lesebücher, 30 Geschichten über Familien, Nachbarn und Gastgeber mit ganz eigenen Vorstellungen vom perfekten Fest. Es wird gekocht und diskutiert, geschmückt und improvisiert."],
      name: "Italienisch",
      country: "Italien",
      greeting: "Buon Natale",
      color: "#C4262E",
      setName: "Weihnachten in Italien",
      claim: "Ein Stück Italien zum Verschenken.",
      tint: "#F2737A", cover: "img/cover-it-stella-frank.webp",
      places: "Verona · Ligurien · Comer See",
      set: {
        frank: { id: 18820, vars: { print: 18821, cd: 18822, pdf: 18823, epub: 18824 } },
        wort:  { id: 18857, vars: { print: 18858, cd: 18859, pdf: 18860, epub: 18861 } }
      },
      gift: {
        schreibset: "Marmorträume",
        schreibsetText: "Ein Marmormuster wie ein Traum: Tiefes Violett fließt in sanftes Blau, durchzogen von goldenen Adern, die das Licht einfangen.",
        schreibsetImg: "img/schreibset-marmor.webp",
        frank: { online: 18880, cd: 18882 },
        wort:  { online: 18884, cd: 18887 }
      },
      books: [
        { key: "suocera", title: "La Suocera a Natale", de: "Die Schwiegermutter zu Weihnachten", place: "Verona",
          hook: "Ein perfektes Weihnachtsfest? Ada hat Einwände.",
          desc: ["Matteo liebt Weihnachten. Seine Frau Giulia fast ebenso sehr. Ihre Mutter Ada dagegen findet den Baum zu groß, den Panettone zu süß und die Festtagsmusik verdächtig fröhlich. Wenn sie mit ihrem grauen Koffer nach Verona kommt, beginnt für Matteo die anspruchsvollste Aufgabe des Jahres.", "Lasagne nach altem Familienrezept, ein sorgfältig ausgesuchtes Geschenk, Weihnachtskaraoke, eine Tombola und ein großer orangefarbener Kater, der zeigt, wie wenig sich ein Familienfoto planen lässt. Hinter Adas trockenen Kommentaren stecken Erinnerungen, die den Geschichten ihre Wärme geben."],
          cast: ["Matteo", "Giulia", "Ada", "der Kater"],
          frank: { id: 18790, vars: { print: 18791, cd: 18792, pdf: 18793, epub: 18794 } },
          wort:  { id: 18849, vars: { print: 18850, cd: 18851, pdf: 18852, epub: 18853 } } },
        { key: "viaroma", title: "Le Luci di Via Roma", de: "Die Lichter der Via Roma", place: "Ligurien",
          hook: "Ein Balkon leuchtet. Die Nachbarn legen nach.",
          desc: ["In Portofiorino in Ligurien stellt Giorgio einen Weihnachtsbaum auf seinen Balkon. Dotti nebenan antwortet mit einem größeren Baum und mehr Lichtern. Signora Benedetti holt leuchtende Rentiere hervor – damit hat die Via Roma ihre winterliche Ruhe verloren.", "Bald baut Tischler Massimo eine Krippe, die den ganzen Vorgarten einnimmt, Konditor Roberto verwandelt seinen Balkon in ein Süßigkeitenhaus mit Vanilleduft, und die Stromrechnungen sorgen für eine eigene Art von Überraschung. Als Wettbewerb möchte die Sache allerdings kaum jemand bezeichnen."],
          cast: ["Giorgio", "Dotti", "Signora Benedetti", "Massimo"],
          frank: { id: 18798, vars: { print: 18799, cd: 18800, pdf: 18801, epub: 18802 } },
          wort:  { id: 18840, vars: { print: 18841, cd: 18842, pdf: 18843, epub: 18844 } } },
        { key: "stella", title: "Natale all’Albergo Stella", de: "Weihnachten im Hotel Stella", place: "Comer See",
          hook: "Im Albergo Stella kommen die Wünsche schneller an als die Gäste.",
          desc: ["Ein kleines Hotel am Comer See, zwölf Zimmer und eine Gastgeberin mit einem vollen Notizbuch: Giulia möchte, dass über Weihnachten alles klappt. Dann meldet sich der Koch krank, und die bestellte Tanne ist vier Meter hoch statt zwei.", "Klaus wünscht sich sieben Fischgerichte an Heiligabend, eine französische Beraterin reist mit Pudel an, zwei englische Kinder erobern das Haus – und ein Schriftsteller verlangt absolute Ruhe. Zum Glück kommt Teresa. Sie kocht hervorragend und weiß genau, wer in ihrer Küche das Sagen hat."],
          cast: ["Giulia", "Roberto", "Luca", "Teresa"],
          frank: { id: 18782, vars: { print: 18783, cd: 18784, pdf: 18785, epub: 18786 } },
          wort:  { id: 18829, vars: { print: 18830, cd: 18831, pdf: 18832, epub: 18833 } } }
      ],
      sample: {
        title: "L’Albergo Stella",
        frank: [
          ["L’Albergo Stella è un piccolo hotel", "das Albergo Stella ist ein kleines Hotel"],
          ["sulla riva del Lago di Como", "am Ufer des Comer Sees"],
          [". Ha dodici camere", "/es/ hat zwölf Zimmer"],
          [", una terrazza con vista sul lago", "eine Terrasse mit Blick auf den See; vista f — Blick, Aussicht"],
          [" e una cucina", "und eine Küche"],
          [" dove tutto profuma di burro e rosmarino", "in der alles nach Butter und Rosmarin duftet; profumare di qualcosa — nach etw. duften"],
          [".", null]
        ],
        plain: "L’Albergo Stella è un piccolo hotel sulla riva del Lago di Como. Ha dodici camere, una terrazza con vista sul lago e una cucina dove tutto profuma di burro e rosmarino.",
        wort: "L’Albergo Stella è un piccolo hotel sulla riva[1] del Lago di Como. Ha dodici camere[2], una terrazza con vista[3] sul lago e una cucina dove tutto profuma di[4] burro e rosmarino. I proprietari[5] sono Giulia e suo marito Roberto.",
        notes: ["riva f – Ufer", "camera f – Zimmer", "vista f – Aussicht, Blick", "profumare di qlco. – nach etw. duften", "proprietario m – Besitzer, Inhaber"],
        audio: {
          frank: "https://easyoriginal1.s3.eu-central-1.amazonaws.com/italienisch/i37/001.mp3",
          wort:  "https://easyoriginal1.s3.eu-central-1.amazonaws.com/italienisch/i37w/01.mp3"
        }
      }
    },
    {
      code: "fr",
      intro: ["Ein Konditor will endlich den ganz großen Wurf schaffen. Eine Großmutter hat einen Stand auf dem Weihnachtsmarkt gebucht und ihre Familie gleich mit eingeplant. Zwei Nachbarn sind sich sicher: Der schönste Weihnachtsbaum steht selbstverständlich im eigenen Haus.", "Ein französischer Dezember voller Plätzchenduft, Lichterketten und Menschen, die es mit dem perfekten Fest ein wenig zu genau nehmen – von einer Pâtisserie in der Touraine über den Weihnachtsmarkt in Colmar bis in eine kleine Straße in der Charente."],
      name: "Französisch",
      country: "Frankreich",
      greeting: "Joyeux Noël",
      color: "#7B4699",
      setName: "Weihnachten in Frankreich",
      claim: "Ein Stück Frankreich zum Verschenken.",
      tint: "#C99BE3", cover: "img/cover-fr-marche-frank.webp",
      places: "Touraine · Colmar · Charente",
      set: {
        frank: { id: 18978, vars: { print: 18980, cd: 18981, pdf: 18982, epub: 18983 } },
        wort:  { id: 18979, vars: { print: 18984, cd: 18985, pdf: 18986, epub: 18987 } }
      },
      gift: {
        schreibset: "Marmorträume",
        schreibsetText: "Ein Marmormuster wie ein Traum: Tiefes Violett fließt in sanftes Blau, durchzogen von goldenen Adern, die das Licht einfangen.",
        schreibsetImg: "img/schreibset-marmor.webp",
        frank: { online: 19023, cd: 19024 },
        wort:  { online: 19025, cd: 19026 }
      },
      books: [
        { key: "buche", title: "La Bûche Parfaite", de: "Die perfekte Weihnachtsbûche", place: "Touraine",
          hook: "Sechs Wochen bis zum Wettbewerb. Und schon der Biskuit macht Probleme.",
          desc: ["Antoine Mareschal backt gute Kuchen. Aber gut reicht ihm nicht mehr: Beim regionalen Wettbewerb will er mit einer außergewöhnlichen Bûche de Noël überzeugen, dem französischen Weihnachtskuchen in Baumstammform.", "Leider hält eine Biskuitrolle nicht allein deshalb zusammen, weil man fest an sie glaubt. Mangos werden nicht auf Kommando reif, ein Schuss Calvados fällt erstaunlich großzügig aus, und ein Konkurrent aus Tours kommt mit Yuzu und Wasabi. Eine warmherzige Komödie über Ehrgeiz, ehrliche Freunde und den Duft von Schokolade, Honig und warmem Gebäck."],
          cast: ["Antoine", "Pauline", "Gilles", "Madame Fournier"],
          frank: { id: 18935, vars: { print: 18936, cd: 18937, pdf: 18938, epub: 18939 } },
          wort:  { id: 18941, vars: { print: 18946, cd: 18947, pdf: 18961, epub: 18962 } } },
        { key: "marche", title: "Le Marché de Noël", de: "Der Weihnachtsmarkt", place: "Colmar",
          hook: "Mamie Odile hat schon reserviert. Ihre Familie erfährt es beim Essen.",
          desc: ["Beim Sonntagsessen in Colmar verkündet die achtzigjährige Mamie Odile: Die Familie Muller betreibt in diesem Jahr einen Stand auf dem Weihnachtsmarkt. Der Platz ist reserviert, die Aufgaben sind verteilt. Verkauft werden ihre berühmten Bredele und Glühwein nach dem Rezept des Großvaters.", "Doch beim Aufbau der Holzhütte hilft selbst ein Ingenieursberuf nur bedingt, nebenan taucht ein selbstbewusster Konkurrent auf, und eine Schulklasse verteilt die Weihnachtsfreude in Form von Mehl. Zwischen Kasse und Plätzchentüten tauchen außerdem kleine Nachrichten auf, unterschrieben mit einem einzigen Buchstaben."],
          cast: ["Mamie Odile", "François", "Antoine", "Élise"],
          frank: { id: 18942, vars: { print: 18948, cd: 18949, pdf: 18950, epub: 18951 } },
          wort:  { id: 18943, vars: { print: 18952, cd: 18953, pdf: 18963, epub: 18964 } } },
        { key: "voisins", title: "Le Noël des voisins", de: "Weihnachten unter Nachbarn", place: "Charente",
          hook: "Ein schöner Weihnachtsbaum? Nur bis der Nachbar einen größeren hat.",
          desc: ["Jean-Marc Poulain und Gérard Michaud sind seit zweiundzwanzig Jahren Nachbarn. Gleich alt, gleiches Automodell, jeder überzeugt vom eigenen besseren Geschmack. Im Sommer geht es um Tomaten. Im Dezember geht es um alles.", "Ein Baum, der das Wohnzimmer fast vollständig verdrängt, ein mechanischer Pinguin und ein aufblasbarer Weihnachtsmann vor dem Briefkasten des Postboten. Catherine und Françoise trinken derweil zusammen Kaffee und betrachten den Ehrgeiz ihrer Männer mit Geduld, Belustigung und Erschöpfung."],
          cast: ["Jean-Marc", "Gérard", "Catherine", "Françoise"],
          frank: { id: 18944, vars: { print: 18954, cd: 18955, pdf: 18956, epub: 18957 } },
          wort:  { id: 18945, vars: { print: 18958, cd: 18959, pdf: 18967, epub: 18968 } } }
      ],
      sample: {
        title: "L’annonce du concours",
        frank: [
          ["Antoine Mareschal était pâtissier à Beaumont-sur-Loire", "Antoine Mareschal war Konditor in Beaumont-sur-Loire; pâte f — Teig"],
          [", un petit village de Touraine", "einem kleinen Dorf in der Touraine"],
          [", depuis quinze ans", "seit fünfzehn Jahren; an m"],
          [". Sa boutique", "sein Laden"],
          [", « Le Fournil d’Antoine »", "Antoines Backstube; four m — Ofen"],
          [", se trouvait entre la boucherie de monsieur Grenot", "lag zwischen der Metzgerei von Herrn Grenot; se trouver — sich befinden, liegen"],
          [" et le salon de coiffure de Sylvie", "und dem Friseursalon von Sylvie"],
          [".", null]
        ],
        plain: "Antoine Mareschal était pâtissier à Beaumont-sur-Loire, un petit village de Touraine, depuis quinze ans. Sa boutique, « Le Fournil d’Antoine », se trouvait entre la boucherie de monsieur Grenot et le salon de coiffure de Sylvie.",
        wort: "Antoine Mareschal était pâtissier[1] à Beaumont-sur-Loire, un petit village de Touraine, depuis quinze ans. Sa boutique[2], « Le Fournil[3] d’Antoine », se trouvait entre la boucherie de monsieur Grenot et le salon de coiffure[4] de Sylvie. Les femmes qui sortaient de chez Sylvie avec une nouvelle coiffure[5] avaient toujours envie[6] d’un éclair[7] au chocolat.",
        notes: ["pâtissier m – Konditor", "boutique f – Laden, Geschäft", "fournil m – Backstube", "salon m de coiffure – Friseursalon", "coiffure f – Frisur", "avoir envie de qch – Lust auf etw. haben", "éclair m – Blitz; Eclair, Liebesknochen"],
        audio: {
          frank: "https://easyoriginal1.s3.eu-central-1.amazonaws.com/franzoesisch/f60/001.mp3",
          wort:  "https://easyoriginal1.s3.eu-central-1.amazonaws.com/franzoesisch/f60w/01.mp3"
        }
      }
    },
    {
      code: "es",
      intro: ["Ein Cousin aus Mexiko bringt neue Festideen mit. Ein Schwager erklärt der Familie ungefragt die Welt. Zwei Nachbarn in Sevilla wollen unbedingt die eindrucksvollste Weihnachtskrippe bauen.", "Drei humorvolle Bücher von Ricardo Melero mit 30 kurzen Geschichten: Fruchtpunsch und Piñata, Schinken und Silvestertrauben, Kamele und Krippenberge. Spanische Weihnachten mit viel Dialog und kleinen häuslichen Katastrophen."],
      name: "Spanisch",
      country: "Spanien",
      greeting: "¡Feliz Navidad!",
      color: "#D2691E",
      setName: "Weihnachten in Spanien",
      claim: "30 humorvolle Weihnachtsgeschichten von Ricardo Melero.",
      tint: "#F4A65E", cover: "img/cover-es-primo-frank.webp",
      places: "Sevilla · Krippen · Familienfeste",
      set: {
        frank: { id: 19116, vars: { print: 19118, cd: 19119, pdf: 19120, epub: 19121 } },
        wort:  { id: 19117, vars: { print: 19122, cd: 19123, pdf: 19124, epub: 19125 } }
      },
      gift: {
        schreibset: "Eleganz der Natur",
        schreibsetText: "Eine goldschimmernde Blüte, Blütenblätter wie aus Licht gewoben. Drumherum Blätter in Bernstein, Blau und zartem Grün.",
        schreibsetImg: "img/schreibset-natur.webp",
        frank: { online: 19126, cd: 19127 },
        wort:  { online: 19128, cd: 19129 }
      },
      books: [
        { key: "primo", title: "El primo de América", de: "Der Cousin aus Mexiko", place: "Sevilla",
          hook: "Zwei riesige Koffer, ein Sombrero und die feste Absicht, Weihnachten zu verbessern.",
          desc: ["Wenn Javier aus Mexiko bei der Familie Ruiz in Sevilla ankommt, freut sich nicht jeder auf seine Überraschungen. Carlos hat vorsorglich Regeln aufgestellt: keine Änderungen an Mutters Rezepten, keine Piñata im Haus und kein Tequila für die Großmutter.", "Javier sieht die Sache etwas großzügiger. Vom Fruchtpunsch über die Krippe bis zu Rancheras und Silvester bleibt kaum ein Teil des Festes ohne Diskussion – und Marta versucht zu vermitteln, während die Kinder ganz eigene Erwartungen an den Besuch haben."],
          cast: ["Javier", "Carlos", "Marta"],
          frank: { id: 19069, vars: { print: 19075, cd: 19076, pdf: 19077, epub: 19078 } },
          wort:  { id: 19070, vars: { print: 19079, cd: 19080, pdf: 19081, epub: 19082 } } },
        { key: "cunado", title: "El Cuñado Experto", de: "Der Schwager, der alles besser weiß", place: "Familie Méndez",
          hook: "Ein Schwager. Zehn Geschichten. Und zu jedem Thema eine ungefragte Meinung.",
          desc: ["In der Familie Méndez weiß Ricardo grundsätzlich alles besser: wie man Schinken schneidet, wie Wein serviert wird und was beim Weihnachtsessen auf den Tisch gehört. Ob er es selbst schon ausprobiert hat, ist für ihn eine völlig andere Frage.", "Doña Carmen kocht seit Jahrzehnten ihren berühmten Lammbraten, Pablo ist Elektriker – und trotzdem bekommen beide Unterricht. Nur die sechzehnjährige Sofía stellt die Fragen, denen der selbst ernannte Fachmann lieber ausweicht. Vom Weihnachtsbaum bis zu den zwölf Silvestertrauben."],
          cast: ["Ricardo", "Doña Carmen", "Pablo", "Sofía"],
          frank: { id: 19071, vars: { print: 19083, cd: 19084, pdf: 19100, epub: 19101 } },
          wort:  { id: 19072, vars: { print: 19085, cd: 19086, pdf: 19102, epub: 19103 } } },
        { key: "belen", title: "El Belén Más Grande del Mundo", de: "Die größte Weihnachtskrippe der Welt", place: "Sevilla",
          hook: "Alles beginnt mit einem Kamel. Dann wird Weihnachten zur Frage der Ehre.",
          desc: ["Don Rafael hat für seine Krippe eine neue Figur gekauft: vierzig Zentimeter groß, handbemalt und unübersehbar. Sein Nachbar Don Paco sieht sie durchs Fenster in der Calle Esperanza. Kurz darauf ist er auf dem Weg zum Krippenladen.", "Weitere Kamele, Hirten, ein Berg und moderne Technik folgen. Der Platz im Wohnzimmer bleibt derselbe. Doña Carmen und Doña Lola verfolgen den Wettstreit ihrer Männer mit deutlich weniger Begeisterung: Dieser Dezember wird wieder lang."],
          cast: ["Don Rafael", "Don Paco", "Doña Carmen", "Doña Lola"],
          frank: { id: 19073, vars: { print: 19087, cd: 19088, pdf: 19089, epub: 19090 } },
          wort:  { id: 19074, vars: { print: 19091, cd: 19092, pdf: 19097, epub: 19098 } } }
      ],
      sample: {
        title: "La llegada",
        frank: [
          ["Cada año", "jedes Jahr"],
          [", el veintidós de diciembre", "am zweiundzwanzigsten Dezember"],
          [", la familia Ruiz de Sevilla tiene el mismo problema", "die Familie Ruiz aus Sevilla hat dasselbe Problem"],
          [": el primo Javier", "Cousin Javier"],
          [". Javier es mexicano", "Javier ist Mexikaner"],
          [". Vive en Guadalajara", "/er/ lebt in Guadalajara"],
          [", tiene cuarenta años", "ist vierzig: „hat vierzig Jahre“"],
          [".", null]
        ],
        plain: "Cada año, el veintidós de diciembre, la familia Ruiz de Sevilla tiene el mismo problema: el primo Javier. Javier es mexicano. Vive en Guadalajara, tiene cuarenta años.",
        wort: "Cada año, el veintidós de diciembre, la familia Ruiz de Sevilla tiene el mismo[2] problema: el primo Javier.",
        notes: [null, "mismo – gleich, derselbe"],
        audio: {
          frank: "https://easyoriginal1.s3.eu-central-1.amazonaws.com/spanisch/s51/001.mp3",
          wort:  "https://easyoriginal1.s3.eu-central-1.amazonaws.com/spanisch/s51w/01.mp3"
        }
      }
    }
  ],

  faq: [
    { q: "Welche Ausgabe passt zu mir?",
      a: "Die Frank-Lesemethode (A1–A2) passt, wenn Sie mit ersten Kenntnissen ein ganzes Buch lesen möchten: Die deutsche Übersetzung steht direkt im Text. Die Ausgabe mit Worterklärungen (A2–B1) passt, wenn Sie einer Handlung schon folgen und nur bei einzelnen Wörtern Hilfe brauchen. Die Geschichten sind in beiden Ausgaben dieselben." },
    { q: "Wie funktioniert die Frank-Lesemethode?",
      a: "Jeder Abschnitt steht zuerst mit deutscher Übersetzung und Erklärungen zu Wörtern, Wendungen und Grammatik. Danach folgt derselbe Abschnitt noch einmal ohne Hilfen. So verstehen Sie eine Szene zuerst und lesen sie dann zusammenhängend in der Fremdsprache." },
    { q: "Gibt es die Bücher auch einzeln?",
      a: "Ja. Jedes der drei Bücher einer Sprache gibt es einzeln, als E-Book ab 6,99 € oder als Taschenbuch. Das Set mit allen drei Büchern enthält 30 Geschichten." },
    { q: "Was ist im Geschenkset enthalten?",
      a: "Die drei gedruckten Bücher einer Sprache in der gewählten Ausgabe, mit Audio-Online oder Audio-CDs, dazu ein Schreibset Deluxe: Hardcover-Notizbuch A5, Spiral-Notizbuch A5, Notizheft A6, drei Lesezeichen sowie Kugelschreiber und Druckbleistift im Etui." },
    { q: "Was bedeutet Audio-Online?",
      a: "Zu den Geschichten gibt es Audioaufnahmen, die Sie online anhören. Wer lieber eine CD in den Händen hält, wählt die Ausgabe mit Audio-CD." },
    { q: "Was kostet der Versand?",
      a: "Wir liefern innerhalb der EU. Ab einem Bestellwert von über 39 € ist der Versand kostenlos, darunter berechnen wir pauschal 6,90 €. Für E-Books fallen keine Versandkosten an." }
  ]
};
