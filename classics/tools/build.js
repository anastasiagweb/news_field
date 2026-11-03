// Build one Classics library .docx per language from <code>.json
// usage: node build.js <in.json> <out.docx>
const fs = require('fs');
const {
  Document, Packer, Paragraph, TextRun, HeadingLevel, Table, TableRow, TableCell,
  WidthType, ShadingType, BorderStyle, AlignmentType, LevelFormat, Footer, PageNumber,
  TableOfContents, PageBreak,
} = require('docx');

const [, , inPath, outPath] = process.argv;
const d = JSON.parse(fs.readFileSync(inPath, 'utf8'));
const books = d.books.slice().sort((a, b) => a.tier - b.tier || a.id - b.id);
const byId = Object.fromEntries(d.books.map(b => [b.id, b]));
// display numbers follow the tier ordering
const num = {};
books.forEach((b, i) => { num[b.id] = i + 1; });

const FONT = 'Arial';
const C = { accent: '7A2E1D', muted: '666666', warm: 'F9DCC4', humor: 'FFF1A8', gem: 'D8E8F5', head: 'EFE7DF', line: 'BFB5AA' };
const TIER = { 1: 'Первая очередь', 2: 'Вторая очередь', 3: 'Третья очередь' };
const TIER_NOTE = {
  1: 'Лучшее сочетание интереса, доступности для изучающих и продаваемости — издавать первыми.',
  2: 'Сильный второй эшелон: расширяет жанры и уровни, хорошо работает в наборах.',
  3: 'Подзабытые жемчужины, нишевые жанры и более трудные тексты — для полноты библиотеки.',
};

const r = (text, o = {}) => new TextRun({ text, font: FONT, ...o });
const p = (children, o = {}) => new Paragraph({ children: Array.isArray(children) ? children : [r(children)], spacing: { after: 100 }, ...o });
const h = (text, level) => new Paragraph({ heading: level, children: [r(text)] });
const label = (text, fill) => r(` ${text} `, { bold: true, size: 16, shading: { type: ShadingType.CLEAR, color: 'auto', fill } });
const tags = b => {
  const out = [];
  if (b.warm) out.push(label('ТЕПЛО', C.warm), r(' '));
  if (b.humor) out.push(label('ЮМОР', C.humor), r(' '));
  if (b.gem) out.push(label('ЖЕМЧУЖИНА', C.gem), r(' '));
  return out;
};
const bookLine = b => `${num[b.id]}. ${b.title} — ${b.author_ru}`;

// ---------- intro ----------
const up = (d.upcoming || []).slice().sort((a, b) => a.free_eu - b.free_eu || a.author_ru.localeCompare(b.author_ru));
const total = books.length;
const cnt = f => books.filter(f).length;
const isCollection = b => /сборник|сказки|новеллы|очерки/.test(b.form) || (b.contents && b.contents.length);
const stats = [
  ['Всего изданий', total],
  ['Первая / вторая / третья очередь', `${cnt(b => b.tier === 1)} / ${cnt(b => b.tier === 2)} / ${cnt(b => b.tier === 3)}`],
  ['Тёплые', cnt(b => b.warm)],
  ['С юмором', cnt(b => b.humor)],
  ['Тёплые и с юмором одновременно', cnt(b => b.warm && b.humor)],
  ['Подзабытые жемчужины', cnt(b => b.gem)],
  ['Сборники рассказов, сказок, новелл', cnt(isCollection)],
  ['Готовых наборов', d.bundles.length],
];

const W = 9638; // A4 minus 2 cm margins
const border = { style: BorderStyle.SINGLE, size: 4, color: C.line };
const borders = { top: border, bottom: border, left: border, right: border };
const cell = (children, width, o = {}) => new TableCell({
  borders, width: { size: width, type: WidthType.DXA },
  margins: { top: 60, bottom: 60, left: 90, right: 90 },
  children: Array.isArray(children) ? children : [new Paragraph({ children: [r(String(children), { size: 18 })] })],
  ...o,
});

const statsTable = new Table({
  width: { size: W, type: WidthType.DXA }, columnWidths: [6600, 3038],
  rows: stats.map(([k, v]) => new TableRow({ children: [cell(k, 6600), cell(String(v), 3038)] })),
});

// ---------- overview table ----------
const cols = [560, 4140, 2238, 1100, 1600];
const headRow = new TableRow({
  tableHeader: true,
  children: ['№', 'Произведение', 'Форма · объём', 'Уровень', 'Метки'].map((t, i) => cell(
    [new Paragraph({ children: [r(t, { bold: true, size: 18 })] })], cols[i],
    { shading: { type: ShadingType.CLEAR, color: 'auto', fill: C.head } })),
});
const overviewRows = [];
for (const t of [1, 2, 3]) {
  overviewRows.push(new TableRow({ children: [cell([new Paragraph({ children: [r(TIER[t], { bold: true, size: 18, color: C.accent })] })], W, { columnSpan: 5 })] }));
  for (const b of books.filter(x => x.tier === t)) {
    overviewRows.push(new TableRow({
      cantSplit: true,
      children: [
        cell(String(num[b.id]), cols[0]),
        cell([new Paragraph({ children: [r(b.title, { bold: true, size: 18 }), r(` — ${b.author_ru}`, { size: 18 })] }),
          new Paragraph({ children: [r(`«${b.title_ru}»`, { size: 16, color: C.muted })] })], cols[1]),
        cell(`${b.form} · ${b.length}`, cols[2]),
        cell(b.level, cols[3]),
        cell([new Paragraph({ children: tags(b).length ? tags(b) : [r('—', { size: 16, color: C.muted })] })], cols[4]),
      ],
    }));
  }
}
const overview = new Table({ width: { size: W, type: WidthType.DXA }, columnWidths: cols, rows: [headRow, ...overviewRows] });

// ---------- lists ----------
const bullet = (children) => new Paragraph({ numbering: { reference: 'bul', level: 0 }, spacing: { after: 40 }, children });
const shortList = arr => arr.map(b => bullet([r(`${num[b.id]}. `, { bold: true }), r(b.title, { bold: true }), r(` — ${b.author_ru}. `), r(`«${b.title_ru}», ${b.level}`, { color: C.muted })]));

// ---------- cards ----------
const field = (name, text) => p([r(`${name}: `, { bold: true, color: C.accent }), r(text)], { spacing: { after: 80 } });
const card = b => {
  const out = [
    new Paragraph({ heading: HeadingLevel.HEADING_3, children: [r(`${num[b.id]}. ${b.title}`), r(`  «${b.title_ru}»`, { color: C.muted, bold: false })] }),
    p([r(`${b.author} (${b.author_ru}, ${b.years}) · ${b.published} · ${b.form} · ${b.length} · уровень ${b.level}`, { color: C.muted, size: 18 })], { spacing: { after: 60 } }),
  ];
  const tg = [...tags(b), r((b.genres || []).join(' · '), { size: 18, italics: true, color: C.muted })];
  out.push(p(tg, { spacing: { after: 80 } }));
  out.push(field('О чём', b.summary));
  out.push(field('Почему', b.why));
  if (b.contents && b.contents.length) {
    out.push(p([r('Состав:', { bold: true, color: C.accent })], { spacing: { after: 40 } }));
    b.contents.forEach(c => out.push(bullet([r(c, { size: 19 })])));
  }
  if (b.caveats) out.push(field('Учесть', b.caveats));
  out.push(field('Права', b.rights));
  return out;
};

// ---------- bundles ----------
const bundleBlock = bd => {
  const out = [
    new Paragraph({ heading: HeadingLevel.HEADING_3, children: [r(bd.name)] }),
    p(bd.concept),
  ];
  bd.ids.forEach(id => {
    const b = byId[id];
    if (!b) throw new Error(`bundle ${bd.name}: unknown id ${id}`);
    out.push(bullet([r(`${num[id]}. `, { bold: true }), r(b.title, { bold: true }), r(` — ${b.author_ru}`), r(`  (${b.form}, ${b.length}, ${b.level})`, { color: C.muted, size: 18 }), ...(b.warm || b.humor ? [r('  ')] : []), ...tags(b)]));
  });
  return out;
};

const children = [
  new Paragraph({ heading: HeadingLevel.TITLE, children: [r('Библиотека Classics')] }),
  p([r(`${d.language} язык — что издавать в первую очередь`, { size: 30, color: C.accent })], { spacing: { after: 300 } }),
  h('Логика списка', HeadingLevel.HEADING_1),
  p(d.intro),
  h('Как читать карточки', HeadingLevel.HEADING_2),
  p([label('ТЕПЛО', C.warm), r(' — уютное, доброе, утешительное чтение.  '), label('ЮМОР', C.humor), r(' — смешно по-настоящему.  '), label('ЖЕМЧУЖИНА', C.gem), r(' — настоящая находка: забытый бестселлер, книга, известная у себя на родине, но почти неизвестная за её пределами, или неожиданный жанр у знаменитого автора.')]),
  p('Уровень указан для оригинального неадаптированного текста и примерный: B1 — читается со словарём без мучений, B2 — нужен уверенный средний уровень, C1 — для продвинутых. Объём — оценка в словах. Номера идут по порядку выпуска: первая очередь, затем вторая и третья; внутри очереди — по убыванию приоритета.'),
  h('Авторское право', HeadingLevel.HEADING_2),
  p(d.rights_note),
  p('Права указаны на 2026 год для Австрии и ЕС; отдельно отмечены США (для мировых продаж через Amazon) и исключения внутри ЕС (Испания, Франция). Текст берём из старого издания, а не из современной научной редакции.'),
  h('Цифры', HeadingLevel.HEADING_2),
  statsTable,
  new Paragraph({ children: [new PageBreak()] }),
  h('Содержание', HeadingLevel.HEADING_1),
  ...[
    ['Весь список одной таблицей', `${total} изданий в порядке выпуска`],
    ['Тёплое', `${cnt(b => b.warm)} изданий`],
    ['С юмором', `${cnt(b => b.humor)} изданий; отдельно — тепло и юмор вместе (${cnt(b => b.warm && b.humor)})`],
    ['Подзабытые жемчужины', `${cnt(b => b.gem)} изданий`],
    ['Готовые наборы', `${d.bundles.length} наборов: ` + d.bundles.map(x => x.name).join(' · ')],
    ...(up.length ? [['Скоро станут свободными', `${up.length} авторов, свободных в ЕС с 2027–2029 годов`]] : []),
    ['Карточки книг', 'по очередям: о чём, почему, состав сборника, что учесть, права'],
  ].map(([a, b]) => bullet([r(a, { bold: true }), r(` — ${b}`, { color: C.muted })])),
  new Paragraph({ children: [new PageBreak()] }),
  h('Весь список одной таблицей', HeadingLevel.HEADING_1),
  overview,
  new Paragraph({ children: [new PageBreak()] }),
  h('Тёплое', HeadingLevel.HEADING_1),
  p('Книги для уютного чтения: добрые герои, утешительные финалы, чувство дома. Хорошо продаются к праздникам и в подарок.'),
  ...shortList(books.filter(b => b.warm)),
  h('С юмором', HeadingLevel.HEADING_1),
  p('Смешное в оригинале — самый сильный довод для тех, кто «не любит классику».'),
  ...shortList(books.filter(b => b.humor)),
  h('Тепло и юмор вместе', HeadingLevel.HEADING_2),
  ...shortList(books.filter(b => b.warm && b.humor)),
  h('Подзабытые жемчужины', HeadingLevel.HEADING_1),
  ...shortList(books.filter(b => b.gem)),
  new Paragraph({ children: [new PageBreak()] }),
  h('Готовые наборы', HeadingLevel.HEADING_1),
  p('Наборы из нескольких книг для серий, бандлов и подписки. Одна книга может входить в несколько наборов.'),
  ...d.bundles.flatMap(bundleBlock),
  ...(up.length ? [
    new Paragraph({ children: [new PageBreak()] }),
    h('Скоро станут свободными', HeadingLevel.HEADING_1),
    p('Авторы, которые станут общественным достоянием в Австрии и ЕС в ближайшие годы, — чтобы готовить издания заранее и выпускать их 1 января.'),
    ...[...new Set(up.map(u => u.free_eu))].sort().flatMap(y => [
      h(`Свободны с 1 января ${y}`, HeadingLevel.HEADING_2),
      ...up.filter(u => u.free_eu === y).flatMap(u => [
        new Paragraph({ heading: HeadingLevel.HEADING_3, children: [r(`${u.author_ru}`), r(`  ${u.author}, ум. ${u.died}`, { color: C.muted, bold: false })] }),
        ...u.titles.map(t => bullet([r(t)])),
        field('Почему', u.why),
        ...(u.notes ? [field('Учесть', u.notes)] : []),
      ]),
    ]),
  ] : []),
  new Paragraph({ children: [new PageBreak()] }),
  h('Карточки книг', HeadingLevel.HEADING_1),
];
for (const t of [1, 2, 3]) {
  children.push(h(`${TIER[t]} (${cnt(b => b.tier === t)})`, HeadingLevel.HEADING_2));
  children.push(p([r(TIER_NOTE[t], { italics: true, color: C.muted })]));
  books.filter(b => b.tier === t).forEach(b => children.push(...card(b)));
}

const doc = new Document({
  creator: 'Classics',
  title: `Библиотека Classics — ${d.language}`,
  styles: {
    default: { document: { run: { font: FONT, size: 20 } } },
    paragraphStyles: [
      { id: 'Title', name: 'Title', basedOn: 'Normal', next: 'Normal', run: { font: FONT, size: 48, bold: true, color: '222222' }, paragraph: { spacing: { before: 0, after: 120 }, keepNext: true } },
      { id: 'Heading1', name: 'Heading 1', basedOn: 'Normal', next: 'Normal', quickFormat: true, run: { font: FONT, size: 32, bold: true, color: C.accent }, paragraph: { spacing: { before: 360, after: 160 }, keepNext: true, outlineLevel: 0 } },
      { id: 'Heading2', name: 'Heading 2', basedOn: 'Normal', next: 'Normal', quickFormat: true, run: { font: FONT, size: 26, bold: true, color: '333333' }, paragraph: { spacing: { before: 280, after: 120 }, keepNext: true, outlineLevel: 1 } },
      { id: 'Heading3', name: 'Heading 3', basedOn: 'Normal', next: 'Normal', quickFormat: true, run: { font: FONT, size: 22, bold: true, color: '222222' }, paragraph: { spacing: { before: 260, after: 60 }, keepNext: true, outlineLevel: 2 } },
    ],
  },
  numbering: { config: [{ reference: 'bul', levels: [{ level: 0, format: LevelFormat.BULLET, text: '•', alignment: AlignmentType.LEFT, style: { paragraph: { indent: { left: 400, hanging: 260 } } } }] }] },
  sections: [{
    properties: { page: { size: { width: 11906, height: 16838 }, margin: { top: 1134, bottom: 1134, left: 1134, right: 1134 } } },
    footers: { default: new Footer({ children: [new Paragraph({ alignment: AlignmentType.CENTER, children: [r(`Classics · ${d.language} · `, { size: 16, color: C.muted }), new TextRun({ children: [PageNumber.CURRENT], font: FONT, size: 16, color: C.muted })] })] }) },
    children,
  }],
});

Packer.toBuffer(doc).then(buf => { fs.writeFileSync(outPath, buf); console.log(`${outPath}: ${total} books, ${d.bundles.length} bundles`); });
