const fs = require('fs');
const path = require('path');

test('app.js contains a Node HTTP server', () => {
  const appPath = path.join(__dirname, 'app.js');
  const content = fs.readFileSync(appPath, 'utf8');

  expect(content).toContain('http.createServer');
});
