DROP TABLE IF EXISTS resources;
DROP TABLE IF EXISTS user_buildings;
DROP TABLE IF EXISTS user_units;

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULl,
    battles_won INTEGER,
    role VARCHAR(50),
    verified BOOLEAN DEFAULT FALSE
);
CREATE TABLE IF NOT EXISTS user_tokens (
                             token VARCHAR(255) PRIMARY KEY,
                             user_id INTEGER NOT NULL,
                             type VARCHAR(255) NOT NULL,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Use CURRENT_TIMESTAMP for created_at
                             expires_at TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL 1 HOUR),  -- Default to 1 hour from now
                             FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE IF NOT EXISTS resources (
    user_id INTEGER PRIMARY KEY,
    wood INTEGER DEFAULT 5000,
    stone INTEGER DEFAULT 5000,
    gold INTEGER DEFAULT 5000,
    food INTEGER DEFAULt 5000,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE IF NOT EXISTS buildings (
    id INTEGER PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    production_type VARCHAR(50) NOT NULL,
    production_kind VARCHAR(50) NOT NULL,
    img VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS building_levels (
    building_id INTEGER NOT NULL,
    level INTEGER NOT NULL,
    time INTEGER NOT NULL,
    production INTEGER NOT NULL,
    wood INTEGER NOT NULL,
    stone INTEGER NOT NULL,
    gold INTEGER NOT NULL,
    food INTEGER NOT NULL,
    PRIMARY KEY (building_id, level)
);
CREATE TABLE IF NOT EXISTS user_buildings (
    user_id INTEGER NOT NULL,
    current_level INTEGER NOT NULL,
    production_amount INTEGER NOT NULL,
    building_id INTEGER NOT NULL,
    end_time TIMESTAMP,
    PRIMARY KEY (user_id, building_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (building_id) REFERENCES buildings(id)
);
CREATE TABLE IF NOT EXISTS units (
    id INTEGER PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    attack INT NOT NULL,
    defense INT NOT NULL,
    speed INT NOT NULL,
    img VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS unit_costs (
    unit_id INTEGER PRIMARY KEY,
    time INT NOT NULL,
    wood INT NOT NULL,
    stone INT NOT NULL,
    food INT NOT NULL,
    gold INT NOT NULL
);
CREATE TABLE IF NOT EXISTS user_units (
    user_id INTEGER NOT NULL,
    unit_id INTEGER NOT NULL,
    count INTEGER NOT NULL,
    PRIMARY KEY (user_id, unit_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (unit_id) REFERENCES units(id)
);

CREATE TABLE IF NOT EXISTS units_queue (
    user_id INTEGER NOT NULL,
    unit_id INTEGER NOT NULL,
    end_time TIMESTAMP NOT NULL,
    count INTEGER NOT NULL,
    PRIMARY KEY (user_id, unit_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (unit_id) REFERENCES units(id)
);

CREATE TABLE IF NOT EXISTS clans (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    level INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255),
    members_count INT NOT NULL,
    img VARCHAR(255),
    leader_id INTEGER NOT NULL,
    FOREIGN KEY (leader_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS clan_members (
    clan_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    PRIMARY KEY (clan_id, user_id),
    FOREIGN KEY (clan_id) REFERENCES clans(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS battles (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    attacker_id INT NOT NULL,
    defender_id INT NOT NULL,
    winner_id INT NOT NULL,
    wood INT,
    food INT,
    stone INT,
    gold INT,
    FOREIGN KEY (attacker_id) REFERENCES users(id),
    FOREIGN KEY (defender_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id)
);
