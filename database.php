<?php
require_once('config.php');

class Database
{

    public $connection;

    function __construct()
    {
        $this->db_connect();
    }

    public function db_connect()
    {
        $this->connection = mysqli_connect(config::DB_HOST, config::DB_USER, config::DB_PASS);
        if (!$this->connection) {
            die("Nepavyko prisijungti prie duomenų bazės:" . mysqli_connect_error());
        } else {
            $select_db = $this->connection->select_db(config::DB_NAME);
            if (!$select_db) {
                die("Nepavyko pasirinkti duomenų bazės:" . mysqli_connect_error());
            }
        }
    }

    function getCountries($page_no, $rows_per_page)
    {
        $offset = ($page_no - 1) * $rows_per_page;
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM salis LIMIT ?, ?');
        $statement->bind_param('ii', $offset, $rows_per_page);
        $statement->execute();
        return $statement->get_result();
    }

    function getCountry($id)
    {
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM salis WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result);
    }

    function addCountry($country)
    {
        $statement = mysqli_prepare($this->connection, 'INSERT INTO salis(salis) VALUES(?)');
        $statement->bind_param('s', $country['Salis']);
        $statement->execute();
    }

    function deleteCountry($id)
    {
        $statement = mysqli_prepare($this->connection, 'DELETE FROM miestas WHERE salisId = ?;');
        $statement->bind_param('i', $id);
        $statement->execute();
        $statement = mysqli_prepare($this->connection, 'DELETE FROM salis WHERE ID = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
    }

    function getCountriesCount()
    {
        $query = "SELECT count(*) as count FROM salis";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getCities($country_id, $page_no, $rows_per_page)
    {
        $offset = ($page_no - 1) * $rows_per_page;
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM miestas WHERE salisId = ? LIMIT ?, ?');
        $statement->bind_param("iii", $country_id, $offset, $rows_per_page);
        $statement->execute();
        return $statement->get_result();
    }


    public function addCity($city)
    {
        $statement = mysqli_prepare($this->connection, 'INSERT INTO miestas (miestas, salisId) VALUES(?, ?)');
        $statement->bind_param('si', $city['Miestas'], $city['SalisId']);
        $statement->execute();
    }

    public function deleteCity($id)
    {
        $statement = mysqli_prepare($this->connection, 'DELETE FROM miestas WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
    }

    public function searchCities($country_id, $search, $page_no, $rows_per_page)
    {
        $offset = ($page_no - 1) * $rows_per_page;
        $statement = mysqli_prepare($this->connection, "SELECT * FROM miestas WHERE miestas LIKE ? AND salisId = ? LIMIT ?, ?");
        $search = '%' . $search . '%';
        $statement->bind_param('siii', $search, $country_id, $offset, $rows_per_page);
        $statement->execute();
        return $statement->get_result();
    }

    public function getCitiesCount($country_id)
    {
        $statement = mysqli_prepare($this->connection, "SELECT count(*) as count FROM miestas WHERE salisId = ?");
        $statement->bind_param('i', $country_id);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getSearchedCitiesCount($country_id, $search)
    {
        $statement = mysqli_prepare($this->connection, 'SELECT count(*) as count FROM miestas WHERE salisId = ? AND miestas LIKE ?');
        $search = '%' . $search . '%';
        $statement->bind_param('is', $country_id, $search);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result)['count'];
    }

    function searchCountries($search, $page_no, $rows_per_page)
    {
        $offset = ($page_no - 1) * $rows_per_page;
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM salis WHERE salis LIKE ? LIMIT ?, ?');
        $search = '%' . $search . '%';
        $statement->bind_param('sii', $search, $offset, $rows_per_page);
        $statement->execute();
        return $statement->get_result();
    }

    function getSearchedCountriesCount($search)
    {
        $statement = mysqli_prepare($this->connection, 'SELECT count(*) as count FROM salis WHERE salis LIKE ?');
        $search = '%' . $search . '%';
        $statement->bind_param('s', $search);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result)['count'];
    }
}