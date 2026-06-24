import fs from "fs";
import vm from "vm";
const txt = fs.readFileSync("resources/views/peta.blade.php", "utf8");
const start = txt.indexOf('<script');
const open = txt.indexOf('>', start) + 1;
const close = txt.indexOf('</script>', open);
const script = txt.slice(open, close).replace(/\{\{[^\}]*\}\}/g, '"PLACEHOLDER"');
try {
  new vm.Script(script);
  console.log('ok');
} catch (e) {
  console.error(e);
}
