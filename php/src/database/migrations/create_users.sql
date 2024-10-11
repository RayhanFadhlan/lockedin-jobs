CREATE TABLE IF NOT EXISTS users (
    id UUID DEFAULT gen_random_uuid() ,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);