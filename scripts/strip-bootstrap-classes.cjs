// Usage:
//   node scripts/strip-bootstrap-classes.js <bootstrap.css> <style.css> <out.css>
// Example:
//   node scripts/strip-bootstrap-classes.js public/assets/bootstrap/bootstrap.css public/assets/dashboard/css/style.css public/assets/dashboard/css/style.no-bs.css

const fs = require('fs');
const postcss = require('postcss');
const safe = require('postcss-safe-parser');
const selectorParser = require('postcss-selector-parser');

function collectBootstrapClasses(root) {
  const classes = new Set();
  const addFromSelector = selectorParser((selRoot) => {
    selRoot.walkClasses((c) => classes.add(c.value)); // e.g. "btn", "row", "col-6"
  });

  root.walkRules((rule) => {
    try { addFromSelector.processSync(rule.selector); } catch {}
  });

  return classes;
}

function selectorHasBootstrapClass(selector, bootstrapClasses) {
  let hit = false;
  const check = selectorParser((selRoot) => {
    selRoot.walkClasses((c) => {
      if (bootstrapClasses.has(c.value)) hit = true;
    });
  });
  try { check.processSync(selector); } catch {}
  return hit;
}

function stripBootstrapSelectors(root, bootstrapClasses) {
  root.walkRules((rule) => {
    if (!rule.selector) return;

    // Split multi-selectors and keep only those that DON'T touch Bootstrap classes
    const kept = rule.selectors.filter((s) => !selectorHasBootstrapClass(s, bootstrapClasses));

    if (kept.length === 0) {
      rule.remove(); // whole rule targeted Bootstrap -> drop it
    } else if (kept.length !== rule.selectors.length) {
      rule.selector = kept.join(', ');
    }
  });

  // Remove empty @media / @supports blocks after pruning
  root.walkAtRules((atr) => {
    if (!atr.nodes || atr.nodes.length === 0) atr.remove();
  });

  return root;
}

(async () => {
  const [,, bootstrapPath, stylePath, outPath] = process.argv;
  if (!bootstrapPath || !stylePath || !outPath) {
    console.error('Usage: node scripts/strip-bootstrap-classes.js <bootstrap.css> <style.css> <out.css>');
    process.exit(1);
  }

  const bootstrapCSS = fs.readFileSync(bootstrapPath, 'utf8');
  const styleCSS     = fs.readFileSync(stylePath, 'utf8');

  const bootstrapRoot = postcss().process(bootstrapCSS, { parser: safe }).root;
  const styleRoot     = postcss().process(styleCSS, { parser: safe }).root;

  const bootstrapClasses = collectBootstrapClasses(bootstrapRoot);
  const pruned = stripBootstrapSelectors(styleRoot, bootstrapClasses);

  fs.writeFileSync(outPath, pruned.toString());
  console.log(`Wrote ${outPath}`);
})();
