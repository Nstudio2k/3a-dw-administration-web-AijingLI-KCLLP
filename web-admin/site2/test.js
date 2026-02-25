const fs = require('fs');
const assert = require('assert');

const content = fs.readFileSync(__dirname + '/app.js', 'utf8');

assert(content.includes('http.createServer'), 'app.js should create an HTTP server');
assert(content.includes('server.listen(3000'), 'app.js should listen on port 3000');

console.log('Simple test passed');
