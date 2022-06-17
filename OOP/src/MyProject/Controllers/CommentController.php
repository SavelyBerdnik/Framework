<?php
    namespace MyProject\Controllers;
    use MyProject\Models\Comments\Comment;
    use MyProject\Models\Articles\Article;
    use MyProject\Models\Users\User;
    use MyProject\View\View;

    class CommentController{
        private $view;
        private $db;

        public function __construct(){
            $this->view = new View(__DIR__.'/../../../templates');
        }

        public function view(int $commentId){
            $comment = Comment::getById($commentId);
            // $reflector = new \ReflectionObject($article);
            // $properties = $reflector->getProperties();
            // $propertiesName = [];
            // foreach($properties as $property){
            //     $propertiesName[] = $property->getName(); 
            // }
            // var_dump($propertiesName);
            if ($comment === null){
                $this->view->renderHtml('errors/404.php', [], 404);
                return;
            }
            $this->view->renderHtml('articles/comments/edit.php', ['comment' => $comment,
                                                                    'title' => 'Изменить комментарий']);
        }

        public function edit(int $commentId): void
        {
            $comment = Comment::getById($commentId);
            $articleId = $comment->getArticleId();
            $comments = Comment::findAll();    
            $comments = Comment::getCommentsById($comments, $articleId);
            if ($comment === null){
                $this->view->renderHtml('errors/404.php', ['title' => 'Error 404'], 404);
                return;
            }
            if (!empty($_POST['newComment'])) {
                $comment->setText($_POST['newComment']);
            }
            $comment->save();
            
            $commentNum = 0;
            foreach ($comments as $curComment) {
                if ($curComment->getId() == $comment->getId()) {
                    $commentId = $commentNum;
                }
                $commentNum++;
            }
            header('Location: ../../../article/' . $articleId . '#comment' . $commentId);
        }
    }
?>