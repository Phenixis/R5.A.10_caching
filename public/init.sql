-- Script d'initialisation (optionnel)
CREATE TABLE IF NOT EXISTS items (
    id SERIAL PRIMARY KEY,
    label TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT NOW()
);
