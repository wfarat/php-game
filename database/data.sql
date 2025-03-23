DELETE FROM building_levels;
DELETE FROM buildings;
DELETE FROM unit_costs;
DELETE FROM units;

INSERT INTO buildings (id, name, description, production_type, production_kind, img)
VALUES
    (1, 'Barracks', 'Train swordsman', 'Military', 'swordsman','barracks.png'),
    (2, 'Farm', 'Produces food for the settlement', 'Resource', 'food','farm.png'),
    (3, 'Woodcutters Hut', 'Generates wood for construction', 'Resource', 'wood','woodcutters_hut.png'),
    (4, 'Stone Quarry', 'Generates stone', 'Resource','stone', 'quarry.png'),
    (5, 'Gold Mines', 'Generate gold', 'Resource','gold','mines.png'),
    (6, 'Town Hall', 'Main building that allows further development of the city', 'Administrative', 'none','town_hall.png');

INSERT INTO building_levels (building_id, level, production, wood, stone, gold, food)
VALUES
    (1, 1, 10, 100, 50, 20, 0),
    (1, 2, 20, 200, 100, 40, 0),
    (1, 3, 30, 300, 150, 60, 0),
    (2, 1, 5, 50, 20, 10, 100),
    (2, 2, 10, 100, 40, 20, 200),
    (2, 3, 15, 150, 60, 30, 300),
    (3, 1, 5, 50, 0, 50, 0),
    (3, 2, 10, 100, 0, 100, 0),
    (3, 3, 15, 150, 0, 150, 0),
    (4, 1, 8, 100, 50, 50, 0),
    (4, 2, 16, 200, 100, 100, 0),
    (4, 3, 24, 300, 150, 150, 0),
    (5, 1, 8, 100, 100, 50, 0),
    (5, 2, 16, 200, 200, 100, 0),
    (5, 3, 24, 300, 300, 150, 0),
    (6, 1, 0, 500, 500, 100, 100),
    (6, 2, 0, 1000, 1000, 200, 200),
    (6, 3, 0, 1500, 1500, 300, 300);
INSERT INTO units (id, name, description, attack, defense, speed, img)
VALUES
    (1, 'Swordman', 'A basic melee unit with balanced stats', 10, 5, 2, 'swordman.png'),
    (2, 'Archer', 'Ranged unit that can attack from a distance', 8, 3, 3, 'archer.png'),
    (3, 'Cavalry', 'Fast moving unit with high attack', 15, 10, 5, 'cavalry.png'),
    (4, 'Catapult', 'Siege unit used to break walls', 25, 20, 1, 'catapult.png');

INSERT INTO unit_costs (unit_id, time, wood, stone, food, gold)
VALUES
    (1, 30, 50, 20, 30, 10),  -- Swordman
    (2, 40, 30, 10, 40, 20),  -- Archer
    (3, 60, 100, 50, 80, 40), -- Cavalry
    (4, 120, 200, 100, 150, 80); -- Catapult
