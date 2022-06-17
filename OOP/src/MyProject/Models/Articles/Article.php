<?php
    namespace MyProject\Models\Articles;
    use MyProject\Models\Users\User;
    use MyProject\Models\ActiveRecordEntity;

    class Article extends ActiveRecordEntity{
        protected $name;
        protected $text;
        protected $authorId;
        protected $createdAt;

        public static function getTableName(): string{
            return 'articles';
        }
        public function getText(){
            return $this->text;
        }public function getName(){
            return $this->name;
        }
        public function setName(string $name){
            $this->name = $name;
        }
        public function setText(string $text){
            $this->text = $text;
        }
        public function setAuthorId(User $author){
            $this->authorId = $author->id;
        }
        public function getAuthorId(){
            return $this->authorId;
        }
    }
?>