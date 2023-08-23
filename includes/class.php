<?php
class WebApplication
{
    // Configuration
    public $siteName;
    public $siteUrl;
    public $serverPath;
    public $sessionName;

    // Database connection
    public $connection;

    // Structure
    public $component;
    public $action;
    public $id;

    public function __construct($cfg)
    {
        // Report all PHP errors
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        // Turn off all error reporting
        // error_reporting(0);
        // ini_set("display_errors", 0);

        // Configuration
        $this->siteName = $cfg["siteName"];
        $this->siteUrl = $cfg["siteUrl"];
        $this->serverPath = $cfg["serverPath"];

        // Start session
        session_name($cfg["sessionName"]);
        session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = new UserAccount();
        }

        try {
            $this->connection = new PDO($cfg["driver"] . ":host=" . $cfg["host"] . ";port=" . $cfg["port"] . ";dbname=" . $cfg["database"], $cfg["username"], $cfg["password"], array());
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'Connection failed: ' . $ex->getMessage();
            exit();
        }

        $this->component = isset($_REQUEST["component"]) ? $_REQUEST["component"] : "Beranda";
        $this->action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "index";
        $this->id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
    }

    /**
     * Get user
     *
     * @return UserAccount
     */
    public function getUser()
    {
        return $_SESSION['user'];
    }

    public function loadController()
    {
        if (file_exists($this->serverPath . "/components/" . strtolower($this->component) . ".php")) {
            require_once($this->serverPath . "/components/" . strtolower($this->component) . ".php");

            $controllerName = $this->component . "Controller";
            $controller = new $controllerName();

            ob_start();
            if (method_exists($controller, $this->action)) {
                $controller->{$this->action}();
            } else {
                header("Location: " . $this->siteUrl . "/404.php");
            }
            $content = ob_get_contents();
            ob_clean();

            return $content;
        } else {
            header("Location: " . $this->siteUrl . "/404.php");
        }
    }

    public function query($sql, $params = array())
    {
        $affectedRows = 0;

        try {
            $stmt = $this->connection->prepare($sql);
            if (count($params) > 0) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }

            $affectedRows = $stmt->rowCount();
            $stmt->closeCursor();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }

        return $affectedRows;
    }

    public function queryObject($sql, $params = array())
    {
        $result = null;

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            if (count($params) > 0) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }

            $result = $stmt->fetch();
            $stmt->closeCursor();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }

        return $result;
    }

    public function queryArrayOfObjects($sql, $params = array())
    {
        $arr = array();

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            if (count($params) > 0) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }

            while (($obj = $stmt->fetch()) == true) {
                $arr[] = $obj;
            }
            $stmt->closeCursor();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            exit();
        }

        return $arr;
    }
}

class UserAccount
{
    public $id = 0;
    public $username = "";
}
