<?php
    namespace MyProject\Controllers;
    use MyProject\Models\Articles\Article;
    use MyProject\Models\Users\User;
    use MyProject\Models\Comments\Comment;
    use MyProject\View\View;

    class ArticleController{
        private $view;
        private $db;

        public function __construct(){
            $this->view = new View(__DIR__.'/../../../templates');
        }
        public function view(int $articleId){
            $article = Article::getById($articleId);
            $comments = Comment::findAll();    
            $comments = Comment::getCommentsById($comments, $articleId);
            // $reflector = new \ReflectionObject($article);
            // $properties = $reflector->getProperties();
            // $propertiesName = [];
            // foreach($properties as $property){
            //     $propertiesName[] = $property->getName(); 
            // }
            // var_dump($propertiesName);
            if ($article === null){
                $this->view->renderHtml('errors/404.php', [], 404);
                return;
            }
            $author = User::getById($article->getAuthorId())->getName();
            $this->view->renderHtml('articles/view.php', ['article' => $article, 
                                                        'title' => $article->getName(),
                                                        'author' => $author,
                                                        'comments' => $comments]);
        }

        public function edit(int $articleId): void
        {
            $article = Article::getById($articleId);
            if ($article === null){
                $this->view->renderHtml('errors/404.php', ['title' => 'Error 404'], 404);
                return;
            }
            if (!empty($_POST['text'])) {
                $article->setText($_POST['text']);
            }
            if (!empty($_POST['title'])) {
                $article->setName($_POST['title']);
            }
            $article->save();
            header('Location: ../' . $articleId);
        }
        public function add(): void{
            $author = User::getById(1);
            $article = new Article();
            $article->setAuthorId($author);
            $article->setName('new title 07');
            $article->setText('new text 07');
            $article->save();
        }
        public function delete(int $articleId):void{
            $article = Article::getById($articleId);
            if ($article === null){
                $this->view->renderHtml('errors/404.php', ['title' => 'Error 404'], 404);
                return;
            }
            $article->delete();
        }

        public function comments(int $articleId):void{
            $author = User::getById(1);
            $article = Article::getById($articleId);
            $comment = new Comment();
            $comment->setUserId($author);
            $comment->setArticleId($article);
            $comment->setText($_POST['comment']);
            $comment->save();

            $comments = Comment::findAll();    
            $comments = Comment::getCommentsById($comments, $articleId);
            $author = User::getById($article->getAuthorId())->getName();
            header('Location: ../' . $articleId . '#comment' . (string)(count($comments) - 1));
        }
    }
?>