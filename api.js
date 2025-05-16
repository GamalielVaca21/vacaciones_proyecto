// === api.js ===
const http = require("http");
const mysql = require("mysql2");
const fs = require("fs");
const url = require("url");

const PORT = 3006;

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "", // Ajusta si tienes contraseña
    database: "vacaciones"
});

db.connect(err => {
    if (err) {
        console.error("Error al conectar a la base de datos:", err);
        return;
    }
    console.log("Conectado a la base de datos MySQL");
});

const server = http.createServer((req, res) => {
    res.setHeader("Access-Control-Allow-Origin", "*");
    res.setHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
    res.setHeader("Access-Control-Allow-Headers", "Content-Type");

    if (req.method === "OPTIONS") {
        res.writeHead(204);
        return res.end();
    }

    const partes = req.url.split("/").filter(Boolean);

    if (req.method === "GET" && partes[0] === "solicitudes") {
        const numero = partes[1];
        db.query("SELECT * FROM solicitudes WHERE numero_reloj = ?", [numero], (err, resultados) => {
            if (err) {
                res.writeHead(500);
                return res.end("Error al consultar la base de datos");
            }

            // Guardar los resultados en datos.json
            fs.writeFile("datos.json", JSON.stringify(resultados, null, 2), err => {
                if (err) console.error("Error al guardar JSON:", err);
            });

            res.writeHead(200, { "Content-Type": "application/json" });
            res.end(JSON.stringify(resultados));
        });
    } else {
        res.writeHead(404);
        res.end("Ruta no válida");
    }
});

server.listen(PORT, () => {
    console.log(`API escuchando en http://localhost:${PORT}`);
});
