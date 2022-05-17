<?php

class Comunidades {

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
            $query = $db -> executeQuery("SELECT count(*) FROM COMUNIDADES");
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
            $query = $db -> executeQuery("SELECT * FROM COMUNIDADES ORDER BY nombre LIMIT " . (($page - 1) * $per_page) . "," . $per_page);
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
                    <td class="icon-container"><a href="index.php?id_comunidad=' . $item -> id_comunidad . '&action=view_provincias"><i class="material-icons">forward</i></a></td>
                    </tr>';
        }
        echo '<div class="pagination">';

        for ($i = 0; $i < $max_num_pages; $i++) {
            echo '<span><a href="index.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a> - </span>';
        }

        echo '<a href="index.php">Home</a></div>';
    }
}