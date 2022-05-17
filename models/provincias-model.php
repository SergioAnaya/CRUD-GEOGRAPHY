<?php

class Provincias {

    private PDO $conn;

    function __construct () {
        $conn = new DBConnect();
        $this -> conn = $conn -> getConn();
    }

    private function useDatabase (string $database = 'db_geography') {
        $sql = "USE " . $database;
        $this -> conn -> exec($sql);
    }

    /**
     * Method to count data rows. (Pagination)
     */

    private function count () {
        try {
            $db = new DBConnect();
            $query = $db -> executeQuery("SELECT count(*) FROM PROVINCIAS WHERE id_comunidad = :id_comunidad");
            $query -> bindParam(':id_comunidad', $_GET['id_comunidad']);
            $query -> execute();
            $query = $query -> fetchAll();
            return $query[0][0];
        } catch (PDOException $e) {
            echo 'Error: ' . $e -> getMessage() . '<br>';
        }
    }

    /**
     * Method to return the array of data per page. (Pagination)
     */

    private function byPage (int $page, int $per_page) {
        try {
            $db = new DBConnect();
            $query = $db -> executeQuery("SELECT * FROM PROVINCIAS WHERE id_comunidad = :id_comunidad LIMIT " . (($page - 1) * $per_page) . "," . $per_page);
            $query -> bindParam(':id_comunidad', $_GET['id_comunidad']);
            $query -> execute();
            return $query -> fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Error' . $e -> getMessage() . '<br>';
        }
    }

    public function print () {
        $this -> useDatabase();
        if (array_key_exists('pg', $_GET)) {
            $page = $_GET['pg'];
        } else $page = 1;

        $limit = 10;
        $countOfData = $this -> count();
        $max_num_pages = ceil($countOfData / $limit);

        foreach($this -> byPage($page, $limit) as $item) {
            echo '
                    <tr>
                    <td>' . $item -> nombre .'</td>
                    <td>' . $item -> superficie .'</td>
                    <td><a href="index.php?id_provincia=' . $item -> n_provincia . '&action=view_localidades"><i class="material-icons">forward</i></a></td>
                    </tr>';
        }
        echo '<div class="pagination">';

        for ($i = 0; $i < $max_num_pages; $i++) {
            echo '<span><a href="index.php?id_comunidad='. $_GET['id_comunidad'] . '&action=' . "view_provincias" . '&pg=' . ($i + 1) . '">' . ($i + 1) . '</a> - </span>';
        }

        echo '<a href="index.php">Home</a></div>';
    }
}