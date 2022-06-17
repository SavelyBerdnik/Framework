<?php
    namespace MyProject\Models;
    use MyProject\Services\Db;

    abstract class ActiveRecordEntity{
        protected $id;
        public function __set($name, $value){
            $camelCase = $this->underscoreToCamelCase($name);
            $this->$camelCase = $value;
        }
        private function underscoreToCamelCase(string $source):string
        {
            return lcfirst(str_replace('_', '',ucwords($source, '_')));
        }
        private function camelCaseToUnderScore(string $source): string
        {
            return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
        }

        public static function findAll(): array
        {
            $db = Db::getInstance();
            return $db->query('SELECT * FROM `'.static::getTableName().'`', [], static::class);
        }
        
        public static function getById(int $id): ?self{
            $db = Db::getInstance();
            $sql = 'SELECT * FROM `'.static::getTableName().'` WHERE id = :id';
            $article = $db->query($sql, [':id' => $id], static::class );
            return $article ? $article[0] : null;
        }

        public function save(): void
        {
            $mappedProperties = $this->mapPropertiesToDbFormat();
            var_dump($mappedProperties);
            if ($this->id !== null){
                $this->update($mappedProperties);
            } else{
                $this->insert($mappedProperties);
            }
        }

        public function update(array $mappedProperties): void
        {
            $columnsToParams = [];
            $paramsToValues = [];
            $index = 1;
            foreach($mappedProperties as $column => $value){
                $param = ':param'.$index;
                $columnsToParams[] = $column. '='.$param;
                $paramsToValues[$param] = $value; 
                $index++;
            }
            $sql = 'UPDATE `'.static::getTableName().'` SET '.implode(', ', $columnsToParams).' WHERE id = '.$this->id;
            $db = Db::getInstance();
            $db->query($sql, $paramsToValues, static::class);
        }
        public function insert(array $mappedProperties): void
        {
            $filterMappedProperties = array_filter($mappedProperties);
            $columns = [];
            $params = [];
            $paramsToValues = [];
            foreach($filterMappedProperties as $column => $value){
                $columns[] ='`'.$column.'`';
                $paramsName = ':'.$column;
                $params[] = $paramsName;
                $paramsToValues[$paramsName] = $value;
            }
            $sql = 'INSERT INTO `'.static::getTableName().'` ('.implode(', ', $columns).') VALUES ('.implode(', ', $params).')';
            $db = Db::getInstance();
            $db->query($sql, $paramsToValues, static::class);
        }

        public function delete():void{
            $db = Db::getInstance();
            $db->query('DELETE FROM '.static::getTableName().' WHERE id = :id', [':id' => $this->id], static::class);
            $this->id = null;
        }

        private function mapPropertiesToDbFormat(): array
        {
            $reflector = new \ReflectionObject($this);
            $properties = $reflector->getProperties();

            $mappedProperties = [];
            foreach($properties as $property){
                $propertyName = $property->getName();
                $propertyNameUnderScore = $this->camelCaseToUnderScore($propertyName);
                $mappedProperties[$propertyNameUnderScore] = $this->$propertyName; 
            }
            return $mappedProperties;
        }
        abstract public static function getTableName(): string;
        
        public function getId(){
            return $this->id;
        }
    }
?>