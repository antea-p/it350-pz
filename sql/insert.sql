USE esportTournaments;


INSERT INTO Arena (id_arena, arena_name, city, country)
VALUES (1, 'Belgrade Arena', 'Belgrade', 'Serbia'),
       (2, 'The O2 Arena', 'London', 'UK'),
       (3, 'Mercedes-Benz Arena', 'Berlin', 'Germany'),
       (4, 'Arena 1', 'Beijing', 'China');


INSERT INTO CPU (cpu_model, cpu_manufacturer)
VALUES ('Core i9-11900K', 'Intel'),
       ('Ryzen 9 5900X', 'AMD'),
       ('Core i7-11700K', 'Intel'),
       ('Ryzen 7 5800X', 'AMD'),
       ('Core i5-11600K', 'Intel'),
       ('Ryzen 5 5600X', 'AMD'),
       ('Core i9-10900K', 'Intel'),
       ('Ryzen 9 3900X', 'AMD'),
       ('Core i7-10700K', 'Intel'),
       ('Ryzen 7 3700X', 'AMD');


INSERT INTO GPU (gpu_model, gpu_manufacturer)
VALUES ('GeForce RTX 3080', 'NVIDIA'),
       ('Radeon RX 6900 XT', 'AMD'),
       ('GeForce RTX 3070', 'NVIDIA'),
       ('Radeon RX 6800 XT', 'AMD'),
       ('GeForce RTX 3060 Ti', 'NVIDIA'),
       ('Radeon RX 6700 XT', 'AMD'),
       ('GeForce RTX 2080 Ti', 'NVIDIA'),
       ('Radeon RX 5700 XT', 'AMD'),
       ('GeForce RTX 2080 Super', 'NVIDIA'),
       ('Radeon RX 5600 XT', 'AMD');


INSERT INTO Computer (id_computer, cpu_model, gpu_model, ram_gb, ip_address)
VALUES (1, 'Core i9-11900K', 'GeForce RTX 3080', 64, '192.168.0.1'),
       (2, 'Ryzen 9 5900X', 'Radeon RX 6900 XT', 32, '192.168.0.2'),
       (3, 'Core i7-11700K', 'GeForce RTX 3070', 32, '192.168.0.3'),
       (4, 'Ryzen 7 5800X', 'Radeon RX 6800 XT', 32, '192.168.0.4'),
       (5, 'Core i5-11600K', 'GeForce RTX 3060 Ti', 16, '192.168.0.5');



INSERT INTO Game (id_game, game_title, year, publisher)
VALUES (1, 'League of Legends', 2009, 'Riot Games'),
       (2, 'Counter-Strike: Global Offensive', 2012, 'Valve Corporation'),
       (3, 'Dota 2', 2013, 'Valve Corporation'),
       (4, 'Overwatch', 2016, 'Blizzard Entertainment');


INSERT INTO Genre (id_genre, genre_name)
VALUES (1, 'MOBA'),
       (2, 'FPS'),
       (3, 'Strategy'),
       (4, 'Sports'),
       (5, 'Action');


INSERT INTO GameGenre (id_genre, id_game)
VALUES (1, 1),
       (1, 3),
       (2, 2),
       (2, 4),
       (3, 3),
       (5, 4);


INSERT INTO Tournament (id_tournament, id_arena, id_game, tournament_name)
VALUES (1, 1, 1, 'Serbian eSports Championship'),
       (2, 2, 2, 'UK Gaming Tournament'),
       (3, 3, 3, 'German eSports League'),
       (4, 4, 4, 'China Gaming Festival');


INSERT INTO Team (unique_tag, id_computer, team_name, est_year)
VALUES ('FA-001', 1, 'Flaming Avocadoes', 2022),
       ('GB-002', 2, 'Galactic Bananas', 2020),
       ('ZN-003', 3, 'Zombie Ninjas', 2018),
       ('PR-004', 4, 'Pirate Robots', 2020),
       ('AL-005', 5, 'Alien Llamas', 2019);

INSERT INTO TeamTournament (id_tournament, unique_tag)
VALUES (1, 'PR-004'),
       (1, 'GB-002'),
       (1, 'ZN-003'),
       (1, 'AL-005'),
       (1, 'FA-001'),
       (2, 'FA-001'),
       (2, 'PR-004'),
       (2, 'AL-005'),
       (3, 'AL-005'),
       (3, 'ZN-003'),
       (4, 'AL-005'),
       (4, 'GB-002'),
       (4, 'PR-004'),
       (4, 'ZN-003');


INSERT INTO Player (ign, unique_tag, player_name, player_surname, player_gender, age)
VALUES ('SuperCharlie123', 'FA-001', 'Charlie', 'Jones', 'M', 24),
       ('S1llySof1ja', 'FA-001', 'Sofija', 'Petrovic', 'F', 20),
       ('Lovely_Lena', 'GB-002', 'Lena', 'Muller', 'F', 22),
       ('GiddyGiuseppe', 'GB-002', 'Giuseppe', 'Russo', 'M', 23),
       ('MysteriousMaria', 'ZN-003', 'Maria', 'Santos', 'F', 20),
       ('WackyWei1337', 'ZN-003', 'Wei', 'Chen', 'M', 21),
       ('AmazingAlejandro', 'PR-004', 'Alejandro', 'Garcia', 'M', 22),
       ('EnergeticElin', 'PR-004', 'Elin', 'Lindqvist', 'F', 23),
       ('KrazyKenji', 'AL-005', 'Kenji', 'Nakamura', 'M', 24),
       ('YodaYuto', 'ZN-003', 'Yuto', 'Tanaka', 'M', 21),
       ('J1ngleBells', 'ZN-003', 'Kaitlyn', 'Kim', 'F', 24),
       ('N3rdyBo1', 'GB-002', 'John', 'Idle', 'M', 22),
       ('SpicyRamen', 'ZN-003', 'Amelia', 'Lee', 'F', 23),
       ('Craz1H4cker', 'PR-004', 'Cameron', 'Nguyen', 'M',20),
       ('B4byGumm1b34r', 'AL-005', 'Isabella', 'Zhang', 'F', 21);


INSERT INTO Host (id_host, host_name, host_surname, gender, jmbg, years_experience)
VALUES (1, 'Jovan', 'Popovic', 'M', '1308967870011', 4),
       (2, 'Mina', 'Jankovic', 'F', '2001979345064', 3),
       (3, 'Oliver', 'Green', 'M', '0407993456089', 5),
       (4, 'Hannah', 'Jones', 'F', '1206982765051', 6),
       (5, 'Sebastian', 'Muller', 'M', '1511988357015', 7),
       (6, 'Anna', 'Schmidt', 'F', '2111991983022', 2),
       (7, 'Yoshihiro', 'Tanaka', 'M', '0102996409055', 8),
       (8, 'Miyako', 'Sato', 'F', '2001988754044', 4),
       (9, 'Pablo', 'Gonzalez', 'M', '1509999275088', 6),
       (10, 'Sofia', 'Fernandez', 'F', '2401983456099', 3),
       (11, 'Giuseppe', 'Rossi', 'M', '1910995470011', 5),
       (12, 'Francesca', 'Conti', 'F', '1212981982033', 2),
       (13, 'Kim', 'Min-jun', 'M', '9803971550078', 4);


INSERT INTO Award (id_award, unique_tag, id_tournament, award_name, award_type)
VALUES (1, 'PR-004', 1, 'Champion of the Tournament', 'Team'),
        (2, 'GB-002', 1, 'Most Valuable Player', 'Individual'),
        (3, 'ZN-003', 1, 'Fan Favorite', 'Team'),
       (4, 'FA-001', 2, 'Most Valuable Player', 'Individual'),
       (5, 'PR-004', 2, 'Best Teamwork', 'Team'),
       (6, 'AL-005', 2, 'Most Improved Player', 'Individual'),
       (7, 'AL-005', 2, 'Most Improved Player', 'Individual'),
       (8, 'ZN-003', 3, 'Top Scorer', 'Individual'),
       (9, 'ZN-003', 3, 'Fair Play Award', 'Team'),
       (10, 'GB-002', 4, 'Most Improved Player', 'Individual'),
       (11, 'ZN-003', 4, 'Best Teamwork', 'Team'),
       (12, 'AL-005', 4, 'Top Scorer', 'Team');

INSERT INTO TournamentHost (id_host, id_tournament)
VALUES (1, 1),
       (2, 1),
       (3, 1),
       (4, 2),
       (5, 2),
       (6, 2),
       (7, 3),
       (8, 3),
       (9, 3),
       (10, 4),
       (11, 4),
       (12, 4),
       (13, 4);

INSERT INTO Sponsor (id_sponsor, sponsor_name)
VALUES (1, 'Intel'),
       (2, 'Nvidia'),
       (3, 'Red Bull'),
       (4, 'Logitech'),
       (5, 'Samsung'),
       (6, 'ASUS'),
       (7, 'Corsair');


INSERT INTO SponsorAward (id_sponsor, id_award)
VALUES (1, 1),
       (1, 2),
       (2, 2),
       (3, 3),
       (4, 4),
       (4, 5),
       (4, 6),
       (5, 7),
       (6, 8),
       (7, 9),
       (7, 10),
       (7, 11),
       (7, 12);

INSERT INTO TeamSponsor (id_sponsor, unique_tag)
VALUES (1, 'FA-001'),
       (2, 'GB-002'),
       (3, 'GB-002'),
       (1, 'GB-002'),
       (4, 'ZN-003'),
       (5, 'PR-004'),
       (6, 'PR-004');