<?php

include_once 'db-config.php';

class DBConnect {

    private PDO $conn;

    function __construct () {
        try {
            $this -> conn = new PDO("mysql:host=" . servername . ";", username, password);
            $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e -> getMessage() . '<br>';
        }
    }

    private function useDatabase (string $database = 'db_geography') {
        $sql = "USE " . $database;
        $this -> conn -> exec($sql);
    }

    function executeQuery ($query) {
        try {
            $this -> useDatabase();
            return $this -> conn -> prepare($query);
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
    }

    /**
     * TODO: Revisión de los métodos
     */

    /*function numRows ($query) {
        try {
            $query = $this -> conn -> query($query);
            return $query -> fetchColumn();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
    }

    function  getDataSingle ($query) {
        try {
            $query = $this -> conn -> query($query);
            return $query -> fetch();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
    }

    function executeInstruction ($query) {

    }

    function closeConn ($conn) {
        $conn = null;
    }*/

    function getConn (): PDO {
        return $this -> conn;
    }
}