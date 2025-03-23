CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULl,
    verified BOOLEAN DEFAULT FALSE
);
CREATE TABLE user_tokens (
                             token VARCHAR(255) PRIMARY KEY,
                             user_id INTEGER NOT NULL,
                             type VARCHAR(255) NOT NULL,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Use CURRENT_TIMESTAMP for created_at
                             expires_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 1 HOUR),  -- Default to 1 hour from now
                             FOREIGN KEY (user_id) REFERENCES users(id)
);
