const http = require('http');
const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8' });
    res.end(`
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Site 2 - App Node.js</title>
<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin:
50px auto; padding: 20px; }
h1 { color: #e74c3c; }
.info { background: #fdf2f2; padding: 15px; border-radius: 5px; }
</style>
</head>
<body>
<h1>Application Node.js</h1>
<div class="info">
<p>Cette page est servie par <strong>Node.js</strong> via un reverse
proxy Nginx.</p>
<p>Heure du serveur : ${new Date().toLocaleString('fr-FR')}</p>
</div>
</body>
</html>
`);
});
server.listen(3000, () => {
    console.log('App Node.js demarree sur http://localhost:3000');
});