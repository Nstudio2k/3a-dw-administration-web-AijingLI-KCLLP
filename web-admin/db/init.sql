CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(255) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (nom, email)
VALUES
    ('bou', 'bou@b.com'),
    ('cou', 'cou@c.com'),
    ('dou', 'dou@d.com');
