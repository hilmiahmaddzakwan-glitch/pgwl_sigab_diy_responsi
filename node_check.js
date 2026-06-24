const fs = require('fs');
const text = fs.readFileSync('resources/views/peta.blade.php', 'utf8');
const start = text.indexOf('<script');
const open = text.indexOf('>', start) + 1;
const close = text.indexOf('</script>', open);
const script = text.slice(open, close);
fs.writeFileSync('temp_script.js', script.replace(/\{\{[^\}]*\}\}/g, '"X"'), 'utf8');
try {
  new (require('vm')).Script(script.replace(/\{\{[^\}]*\}\}/g, '"X"'));
  console.log('ok');
} catch (e) {
  console.error(e);
}
