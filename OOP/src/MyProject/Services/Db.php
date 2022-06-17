<?php
    namespace MyProject\Services;

    class Db{
        private $connect;
        private static $instance;
        
        private function __construct(){
            $dbOptions = (require __DIR__.'/../../settings.php')['db'];

            $this->connect = new \PDO (
                'mysql:host='.$dbOptions['host'].';dbname='.$dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']
            );
            $this->connect->exec('SET NAMES UTF8');
        }

        public static function getInstance(): self
        {
            if (self::$instance == null){
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function query(string $sql, array $vars = [], string $className = 'stdClass'): ?array
        {
            $stmt = $this->connect->prepare($sql);
            $result = $stmt->execute($vars);
            if ($result == false) return null;

            return $stmt->fetchAll(\PDO::FETCH_CLASS, $className);
        }
    }
?>