<?php
    namespace MyProject\Models\Comments;
    use MyProject\Models\Users\User;
    use MyProject\Models\Articles\Article;
    use MyProject\Models\ActiveRecordEntity;

    class Comment extends ActiveRecordEntity{
        protected $text;
        protected $articleId;
        protected $userId;
        protected $createdAt;

        public static function getTableName(): string{
            return 'comments';
        }

        public static function getCommentsById(array $comments, int $id) {
            $result = [];
            foreach ($comments as $comment) {
                if ($comment->articleId == $id) {
                array_push($result, $comment);
                }
            }
            return $result;
        }
        public function getText(){
            return $this->text;
        }
        public function getDate(){
            return $this->createdAt;
        }
        public function getUserId(){
            return $this->userId;
        }
        public function getAuthor(){
            return User::getById($this->userId)->getName();
        }
        public function getArticleId(){
            return $this->articleId;
        }
        public function setText(string $text){
            $this->text = $text;
        }
        public function setUserId(User $user){
            $this->userId = $user->getId();
        }
        public function setArticleId(Article $article){
            $this->articleId = $article->getId();
        }
    }
?>