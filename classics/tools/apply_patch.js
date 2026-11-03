// Apply an audit patch (<code>.patch.json) to a Classics list (<code>.json) and renumber.
// usage: node apply_patch.js data/<code>.json data/<code>.patch.json
const fs = require('fs');
const [, , basePath, patchPath] = process.argv;
const d = JSON.parse(fs.readFileSync(basePath, 'utf8'));
const pt = JSON.parse(fs.readFileSync(patchPath, 'utf8'));
const warn = [];
const byId = new Map(d.books.map(b => [b.id, b]));
const order = new Map(d.books.map(b => [b.id, b.id]));

for (const f of pt.fixes || []) {
  const b = byId.get(f.id);
  if (!b) { warn.push(`fix: no id ${f.id}`); continue; }
  Object.assign(b, f.set);
}
const removed = new Set();
for (const x of pt.remove || []) {
  if (!byId.has(x.id)) { warn.push(`remove: no id ${x.id}`); continue; }
  removed.add(x.id);
}
let k = 0;
const pending = (pt.add || []).slice();
for (const b of pending) {
  if (byId.has(b.id)) { warn.push(`add: id ${b.id} collides`); continue; }
  byId.set(b.id, b);
}
// resolve order of new books (anchor may itself be new)
const resolve = (b, depth = 0) => {
  if (order.has(b.id)) return order.get(b.id);
  k += 1;
  let o;
  const a = b.after != null ? byId.get(b.after) : null;
  if (a && depth < 50) o = resolve(a, depth + 1) + k * 1e-4;
  else {
    if (b.after != null) warn.push(`add ${b.id}: unknown after ${b.after}`);
    o = 1e6 + k; // end of its tier
  }
  order.set(b.id, o);
  return o;
};
pending.forEach(b => resolve(b));
const books = [...d.books, ...pending].filter(b => !removed.has(b.id));

// bundles
const bundles = d.bundles.map(x => ({ ...x, ids: x.ids.slice() }));
for (const e of pt.bundle_edit || []) {
  const t = bundles.find(x => x.name === e.name);
  if (!t) { warn.push(`bundle_edit: no bundle "${e.name}"`); continue; }
  if (e.concept) t.concept = e.concept;
  if (e.new_name) t.name = e.new_name;
  t.ids = t.ids.filter(i => !(e.remove_ids || []).includes(i)).concat(e.add_ids || []);
}
for (const n of pt.bundle_add || []) bundles.push({ name: n.name, concept: n.concept, ids: n.ids.slice() });

// renumber
books.sort((a, b) => a.tier - b.tier || order.get(a.id) - order.get(b.id));
const map = new Map();
books.forEach((b, i) => { map.set(b.id, i + 1); });
books.forEach(b => { b.id = map.get(b.id); delete b.after; });
for (const x of bundles) {
  const before = x.ids.length;
  x.ids = [...new Set(x.ids.filter(i => map.has(i)).map(i => map.get(i)))];
  if (x.ids.length < before) warn.push(`bundle "${x.name}": dropped ${before - x.ids.length} missing/dup ids`);
  if (x.ids.length < 3) warn.push(`bundle "${x.name}": only ${x.ids.length} books`);
}

// validation
const req = ['tier', 'title', 'title_ru', 'author', 'author_ru', 'years', 'published', 'form', 'length', 'level', 'summary', 'why', 'rights'];
books.forEach(b => req.forEach(f => { if (b[f] == null || b[f] === '') warn.push(`book ${b.id} "${b.title}": missing ${f}`); }));
const seen = {};
books.forEach(b => { const t = `${b.title}|${b.author}`.toLowerCase(); if (seen[t]) warn.push(`duplicate: ${b.title} (${seen[t]}, ${b.id})`); seen[t] = b.id; });

d.books = books;
d.bundles = bundles;
fs.writeFileSync(basePath, JSON.stringify(d, null, 2) + '\n');
const c = t => books.filter(b => b.tier === t).length;
console.log(`${basePath}: ${books.length} books (${c(1)}/${c(2)}/${c(3)}), ${bundles.length} bundles; fixes ${(pt.fixes || []).length}, removed ${removed.size}, added ${pending.length}`);
warn.forEach(w => console.log('WARN', w));
