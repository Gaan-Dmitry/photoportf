const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const path = require('path');
const multer = require('multer');
const session = require('express-session');
const fs = require('fs');

const app = express();
const port = 3000;

// Setup database
const db = new sqlite3.Database('./database.db', (err) => {
    if (err) {
        console.error(err.message);
    }
    console.log('Connected to the SQLite database.');
});

// Init tables
db.serialize(() => {
    db.run(`CREATE TABLE IF NOT EXISTS portfolio (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        before TEXT NOT NULL,
        after TEXT NOT NULL
    )`);
    db.run(`CREATE TABLE IF NOT EXISTS requests (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL,
        link TEXT NOT NULL,
        comments TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )`);
});

// Setup Multer for file uploads
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'public/uploads/');
    },
    filename: (req, file, cb) => {
        cb(null, Date.now() + path.extname(file.originalname));
    }
});
const upload = multer({ storage: storage });

app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(express.urlencoded({ extended: true }));
app.use(session({
    secret: process.env.SESSION_SECRET || 'fallback-secret-key-for-dev',
    resave: false,
    saveUninitialized: true
}));

// Routes
app.get('/', (req, res) => {
    res.render('index');
});

app.get('/portfolio', (req, res) => {
    db.all("SELECT * FROM portfolio", [], (err, rows) => {
        if (err) {
            throw err;
        }
        res.render('portfolio', { portfolioItems: rows });
    });
});

app.post('/submit-request', (req, res) => {
    const { email, link, comments } = req.body;
    db.run(`INSERT INTO requests (email, link, comments) VALUES (?, ?, ?)`, [email, link, comments], function(err) {
        if (err) {
            return console.error(err.message);
        }
        res.redirect('/?success=1');
    });
});

app.get('/login', (req, res) => {
    res.render('login');
});

app.post('/admin/login', (req, res) => {
    const { password } = req.body;
    const adminPassword = process.env.ADMIN_PASSWORD || 'admin'; // Use env variable
    if (password === adminPassword) {
        req.session.loggedIn = true;
        res.redirect('/admin');
    } else {
        res.redirect('/login');
    }
});

app.get('/admin', (req, res) => {
    if (!req.session.loggedIn) return res.redirect('/login');
    db.all("SELECT * FROM requests ORDER BY created_at DESC", [], (err, requests) => {
        if (err) throw err;
        res.render('admin', { requests });
    });
});

app.post('/admin/upload', upload.fields([{ name: 'before', maxCount: 1 }, { name: 'after', maxCount: 1 }]), (req, res) => {
    if (!req.session.loggedIn) return res.redirect('/login');
    if (!req.files || !req.files.before || !req.files.after) {
        return res.status(400).send('Both before and after images are required.');
    }
    const beforePath = '/uploads/' + req.files.before[0].filename;
    const afterPath = '/uploads/' + req.files.after[0].filename;

    db.run(`INSERT INTO portfolio (before, after) VALUES (?, ?)`, [beforePath, afterPath], function(err) {
        if (err) return console.error(err.message);
        res.redirect('/admin');
    });
});

app.listen(port, () => {
    console.log(`Server listening on http://localhost:${port}`);
});
