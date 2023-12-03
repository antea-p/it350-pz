<?php

class EsportRepository
{
    private mysqli $con;

    public function __construct(mysqli $con)
    {
        $this->con = $con;
    }

    private function execute_query($query, $params, $param_types)
    {
        $stmt = $this->con->prepare($query);
        $this->con->begin_transaction(); // https://www.php.net/manual/en/mysqli.begin-transaction.php
        try {
            if (!empty($params)) {
                $stmt->bind_param($param_types, ...$params);
            }
            $stmt->execute();
            $stmt->close();
            $this->con->commit();
        } catch (mysqli_sql_exception $exception) {
            $this->con->rollback();
            // https://stackoverflow.com/a/20897108
            echo '<script type="text/javascript">alert("It wasn\'t possible to make change!" +
            " The most likely cause is that another table depends on the record.")</script>';

            // logiranje greške
            error_log('Error executing SQL query: ' . $query . ' with params ' . implode(',', $params));
            error_log('Error message: ' . $exception->getMessage());

            throw $exception;
        }
    }


    public function get_arenas()
    {
        $stmt = $this->con->prepare('SELECT id_arena, arena_name, city, country FROM Arena');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_arena($id_arena, $arena_name, $city, $country)
    {
        $stmt = 'INSERT INTO Arena (id_arena, arena_name, city, country) VALUES (?, ?, ?, ?)';
        $params = array($id_arena, $arena_name, $city, $country);
        $param_types = 'isss';
        $this->execute_query($stmt, $params, $param_types);
    }

    public function update_arena($id_arena, $arena_name, $city, $country)
    {
        $stmt = 'UPDATE Arena SET arena_name = ?, city = ?, country = ? WHERE id_arena = ?';
        $params = array($arena_name, $city, $country, $id_arena);
        $param_types = 'sssi';
        $this->execute_query($stmt, $params, $param_types);
    }

    public function delete_arena($id_arena)
    {
        $stmt = 'DELETE FROM Arena WHERE id_arena = ?';
        $params = array($id_arena);
        $param_types = 'i';
        $this->execute_query($stmt, $params, $param_types);
    }


    public function insert_tournament($id_tournament, $id_arena, $id_game, $tournament_name)
    {
        $query = 'INSERT INTO Tournament (id_tournament, id_arena, id_game, tournament_name) VALUES (?, ?, ?, ?)';
        $params = array($id_tournament, $id_arena, $id_game, $tournament_name);
        $param_types = 'iiis';
        $this->execute_query($query, $params, $param_types);
    }

    public function update_tournament($id_tournament, $id_arena, $id_game, $tournament_name)
    {
        $query = 'UPDATE Tournament SET id_arena = ?, id_game = ?, tournament_name = ? WHERE id_tournament = ?';
        $params = array($id_arena, $id_game, $tournament_name, $id_tournament);
        $param_types = 'iisi';
        $this->execute_query($query, $params, $param_types);
    }


    public function get_tournament($id_tournament)
    {
        $stmt = $this->con->prepare('SELECT id_tournament, id_arena, id_game, tournament_name FROM Tournament WHERE id_tournament = ?');
        $stmt->bind_param('i', $id_tournament);
        $stmt->execute();
        $result = $stmt->get_result();
        $tournament = $result->fetch_assoc();
        $result->close();
        return $tournament;
    }

    public function delete_tournament($id_tournament)
    {
        $query = 'DELETE FROM Tournament WHERE id_tournament = ?';
        $params = array($id_tournament);
        $param_types = 'i';
        $this->execute_query($query, $params, $param_types);
    }

    public function get_tournaments()
    {
        $stmt = $this->con->prepare('SELECT id_tournament, id_arena, id_game, tournament_name FROM Tournament');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function get_games()
    {
        $stmt = $this->con->prepare('SELECT id_game, game_title, year, publisher FROM Game');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_game($id_game, $game_title, $year, $publisher)
    {
        $query = 'INSERT INTO Game (id_game, game_title, year, publisher) VALUES (?, ?, ?, ?)';
        $paramTypes = 'isss';
        $params = array($id_game, $game_title, $year, $publisher);
        $this->execute_query($query, $params, $paramTypes);
    }

    public function update_game($id_game, $game_title, $year, $publisher)
    {
        $query = 'UPDATE Game SET game_title = ?, year = ?, publisher = ? WHERE id_game = ?';
        $paramTypes = 'sssi';
        $params = array($game_title, $year, $publisher, $id_game);
        $this->execute_query($query, $params, $paramTypes);
    }

    public function delete_game($id_game)
    {
        $query = 'DELETE FROM Game WHERE id_game = ?';
        $paramTypes = 'i';
        $params = array($id_game);
        $this->execute_query($query, $params, $paramTypes);
    }


    public function get_gameGenre()
    {
        $stmt = $this->con->prepare('
        SELECT Game.id_game, Genre.id_genre, Game.game_title, Genre.genre_name
        FROM Game
        INNER JOIN GameGenre ON Game.id_game = GameGenre.id_game
        INNER JOIN Genre ON Genre.id_genre = GameGenre.id_genre;
       ');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function get_genres()
    {
        $stmt = $this->con->prepare('SELECT id_genre, genre_name FROM Genre');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_genre($id_genre, $genre_name)
    {
        $query = 'INSERT INTO Genre (id_genre, genre_name) VALUES (?, ?)';
        $paramValues = array($id_genre, $genre_name);
        $paramTypes = 'is';
        $this->execute_query($query, $paramValues, $paramTypes);
    }

    public function update_genre($id_genre, $genre_name)
    {
        $query = 'UPDATE Genre SET genre_name = ? WHERE id_genre = ?';
        $paramValues = array($genre_name, $id_genre);
        $paramTypes = 'si';
        $this->execute_query($query, $paramValues, $paramTypes);
    }

    function delete_genre($id_genre)
    {
        $query = 'DELETE FROM Genre WHERE id_genre = ?';
        $paramValues = array($id_genre);
        $paramTypes = 'i';
        $this->execute_query($query, $paramValues, $paramTypes);
    }


    public function insert_team($unique_tag, $id_computer, $team_name, $est_year)
    {
        $query = 'INSERT INTO Team (unique_tag, id_computer, team_name, est_year) VALUES (?, ?, ?, ?)';
        $paramValues = array($unique_tag, $id_computer, $team_name, $est_year);
        $paramTypes = 'sisi';
        $this->execute_query($query, $paramValues, $paramTypes);
    }

    public function update_team($unique_tag, $id_computer, $team_name, $est_year)
    {
        $query = 'UPDATE Team SET id_computer=?, team_name=?, est_year=? WHERE unique_tag=?';
        $paramValues = array($id_computer, $team_name, $est_year, $unique_tag);
        $paramTypes = 'isis';
        $this->execute_query($query, $paramValues, $paramTypes);
    }

    public function delete_team($unique_tag)
    {
        $query = 'DELETE FROM Team WHERE unique_tag=?';
        $paramValues = array($unique_tag);
        $paramTypes = 's';
        $this->execute_query($query, $paramValues, $paramTypes);
    }

    public function get_teams()
    {
        $stmt = $this->con->prepare('SELECT unique_tag, id_computer, team_name, est_year FROM Team');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_player($ign, $unique_tag, $player_name, $player_surname, $player_gender, $age)
    {
        $query = 'INSERT INTO Player (ign, unique_tag, player_name, player_surname, player_gender, age) VALUES (?, ?, ?, ?, ?, ?)';
        $params = array($ign, $unique_tag, $player_name, $player_surname, $player_gender, $age);
        $paramTypes = 'sssssi';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function update_player($ign, $unique_tag, $player_name, $player_surname, $player_gender, $age)
    {
        $query = 'UPDATE Player SET unique_tag=?, player_name=?, player_surname=?, player_gender=?, age=? WHERE ign=?';
        $params = array($unique_tag, $player_name, $player_surname, $player_gender, $age, $ign);
        $paramTypes = 'ssssis';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function delete_player($ign)
    {
        $query = 'DELETE FROM Player WHERE ign=?';
        $params = array($ign);
        $paramTypes = 's';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function get_players()
    {
        $stmt = $this->con->prepare('SELECT ign, unique_tag, player_name, player_surname, player_gender, age FROM Player');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function get_computers()
    {
        $stmt = $this->con->prepare('SELECT id_computer, cpu_model, gpu_model, ram_gb, ip_address FROM Computer');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_computer($id_computer, $cpu_model, $gpu_model, $ram_gb, $ip_address)
    {
        $query = 'INSERT INTO Computer (id_computer, cpu_model, gpu_model, ram_gb, ip_address) VALUES (?, ?, ?, ?, ?)';
        $params = array($id_computer, $cpu_model, $gpu_model, $ram_gb, $ip_address);
        $paramTypes = 'issis';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function update_computer($id_computer, $cpu_model, $gpu_model, $ram_gb, $ip_address)
    {
        $query = 'UPDATE Computer SET cpu_model = ?, gpu_model = ?, ram_gb = ?, ip_address = ? WHERE id_computer = ?';
        $params = array($cpu_model, $gpu_model, $ram_gb, $ip_address, $id_computer);
        $paramTypes = 'ssiii';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function delete_computer($id_computer)
    {
        $query = 'DELETE FROM Computer WHERE id_computer = ?';
        $params = array($id_computer);
        $paramTypes = 'i';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function get_cpus()
    {
        $stmt = $this->con->prepare('SELECT cpu_model, cpu_manufacturer FROM CPU');
        $stmt->execute();
        $result = $stmt->get_result();
        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_cpu($cpu_model, $cpu_manufacturer)
    {
        $query = 'INSERT INTO CPU (cpu_model, cpu_manufacturer) VALUES (?, ?)';
        $params = array($cpu_model, $cpu_manufacturer);
        $paramTypes = 'ss';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function update_cpu($cpu_model, $cpu_manufacturer)
    {
        $query = 'UPDATE CPU SET cpu_manufacturer = ? WHERE cpu_model = ?';
        $params = array($cpu_manufacturer, $cpu_model);
        $paramTypes = 'ss';
        $this->execute_query($query, $params, $paramTypes);
    }

    public function delete_cpu($cpu_model)
    {
        $query = 'DELETE FROM CPU WHERE cpu_model = ?';
        $paramTypes = 's';
        $params = array($cpu_model);
        $this->execute_query($query, $params, $paramTypes);
    }

    public function get_gpus()
    {
        $stmt = $this->con->prepare('SELECT gpu_model, gpu_manufacturer FROM GPU');
        $stmt->execute();
        $result = $stmt->get_result();
        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_gpu($gpu_model, $gpu_manufacturer)
    {
        $sql = 'INSERT INTO GPU (gpu_model, gpu_manufacturer) VALUES (?, ?)';
        $params = array($gpu_model, $gpu_manufacturer);
        $paramTypes = 'ss';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function update_gpu($gpu_model, $gpu_manufacturer)
    {
        $sql = 'UPDATE GPU SET gpu_manufacturer = ? WHERE gpu_model = ?';
        $params = array($gpu_manufacturer, $gpu_model);
        $paramTypes = 'ss';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function delete_gpu($gpu_model)
    {
        $sql = 'DELETE FROM GPU WHERE gpu_model = ?';
        $params = array($gpu_model);
        $paramTypes = 's';
        $this->execute_query($sql, $params, $paramTypes);
    }


    public function get_awards()
    {
        $stmt = $this->con->prepare('SELECT id_award, unique_tag, id_tournament, award_name, award_type FROM Award');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_award($id_award, $unique_tag, $id_tournament, $award_name, $award_type)
    {
        $sql = 'INSERT INTO Award (id_award, unique_tag, id_tournament, award_name, award_type) VALUES (?, ?, ?, ?, ?)';
        $params = array($id_award, $unique_tag, $id_tournament, $award_name, $award_type);
        $paramTypes = 'isiss';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function update_award($id_award, $unique_tag, $id_tournament, $award_name, $award_type)
    {
        $sql = 'UPDATE Award SET unique_tag = ?, id_tournament = ?, award_name = ?, award_type = ? WHERE id_award = ?';
        $params = array($unique_tag, $id_tournament, $award_name, $award_type, $id_award);
        $paramTypes = 'sissi';
        $this->execute_query($sql, $params, $paramTypes);
    }

    function delete_award($id_award)
    {
        $sql = 'DELETE FROM Award WHERE id_award = ?';
        $params = array($id_award);
        $paramTypes = 'i';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function get_hosts()
    {
        $stmt = $this->con->prepare('SELECT id_host, host_name, host_surname, gender, jmbg, years_experience FROM Host');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_host($id_host, $host_name, $host_surname, $gender, $jmbg, $years_experience)
    {
        $sql = 'INSERT INTO Host (id_host, host_name, host_surname, gender, jmbg, years_experience) VALUES (?, ?, ?, ?, ?, ?)';
        $params = array($id_host, $host_name, $host_surname, $gender, $jmbg, $years_experience);
        $paramTypes = 'issssi';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function update_host($id_host, $host_name, $host_surname, $gender, $jmbg, $years_experience)
    {
        $sql = 'UPDATE Host SET host_name = ?, host_surname = ?, gender = ?, jmbg = ?, years_experience = ? WHERE id_host = ?';
        $params = array($host_name, $host_surname, $gender, $jmbg, $years_experience, $id_host);
        $paramTypes = 'ssssii';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function delete_host($id_host)
    {
        $sql = 'DELETE FROM Host WHERE id_host = ?';
        $params = array($id_host);
        $paramTypes = 'i';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function get_sponsors()
    {
        $stmt = $this->con->prepare('SELECT id_sponsor, sponsor_name FROM Sponsor');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function insert_sponsor($id_sponsor, $sponsor_name)
    {
        $sql = 'INSERT INTO Sponsor (id_sponsor, sponsor_name) VALUES (?, ?)';
        $params = array($id_sponsor, $sponsor_name);
        $paramTypes = 'is';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function update_sponsor($id_sponsor, $sponsor_name)
    {
        $sql = 'UPDATE Sponsor SET sponsor_name = ? WHERE id_sponsor = ?';
        $params = array($sponsor_name, $id_sponsor);
        $paramTypes = 'si';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function delete_sponsor($id_sponsor)
    {
        $sql = 'DELETE FROM Sponsor WHERE id_sponsor = ?';
        $params = array($id_sponsor);
        $paramTypes = 'i';
        $this->execute_query($sql, $params, $paramTypes);
    }

    public function get_sponsorAwards()
    {
        $stmt = $this->con->prepare('
        SELECT Sponsor.id_sponsor, Award.id_award, Sponsor.sponsor_name, Award.award_name
        FROM Sponsor
        JOIN SponsorAward ON Sponsor.id_sponsor = SponsorAward.id_sponsor
        JOIN Award ON SponsorAward.id_award = Award.id_award
        ORDER BY Sponsor.id_sponsor ASC, Award.id_award ASC;');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function get_teamSponsors()
    {
        $stmt = $this->con->prepare('
        SELECT Sponsor.id_sponsor, TeamSponsor.unique_tag, Sponsor.sponsor_name, Team.team_name
        FROM Sponsor
        INNER JOIN TeamSponsor ON Sponsor.id_sponsor = TeamSponsor.id_sponsor
        INNER JOIN Team ON TeamSponsor.unique_tag = Team.unique_tag
        ORDER BY Sponsor.id_sponsor;
');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function get_teamTournaments()
    {
        $stmt = $this->con->prepare('
        SELECT 
            t.id_tournament, 
            tt.unique_tag, 
            t.tournament_name, 
            a.arena_name, 
            te.team_name
        FROM 
            Tournament t
            INNER JOIN Arena a ON t.id_arena = a.id_arena
            INNER JOIN TeamTournament tt ON t.id_tournament = tt.id_tournament
            INNER JOIN Team te ON tt.unique_tag = te.unique_tag
        ORDER BY 
            t.id_tournament ASC, 
            tt.unique_tag ASC;
');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }

    public function get_TournamentHosts()
    {
        $stmt = $this->con->prepare('
        SELECT h.id_host, t.id_tournament, h.host_name, h.host_surname, t.tournament_name, a.arena_name
        FROM TournamentHost th
        JOIN Host h ON th.id_host = h.id_host
        JOIN Tournament t ON th.id_tournament = t.id_tournament
        JOIN Arena a ON t.id_arena = a.id_arena
        ORDER BY h.id_host, t.id_tournament;
');
        $stmt->execute();
        $result = $stmt->get_result();

        $results_array = array();
        foreach ($result as $row) {
            $results_array[] = $row;
        }
        $result->close();
        return $results_array;
    }


}

function create_repository(): ?EsportRepository
{
    $mysqli = null;
    try {
        $mysqli = new mysqli('localhost:3307', 'esportfan',
            'password', 'esportTournaments');
    } catch (mysqli_sql_exception $e) {
        echo "Error: {$e->getMessage()}";
    }
    return new EsportRepository($mysqli);
}
