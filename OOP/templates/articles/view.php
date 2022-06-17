<?php include __DIR__.'/../header.html';?>
<link rel="stylesheet" href="../style.css">
            <h2><?= $article->getName();?></h2>
            <p><?= $article->getText();?></p>
            <p>Автор: <?= $author;?></p>
            <hr>
            <h3>Редактировать статью</h3>
            <form method="POST" action=<?= $article->getId() . "/edit";?>>
                <label for="title">Новый заголовок</label>
                <input id="title" name="title">
                <label for="text">Новый текст</label>
                <textarea id="text" name="text"></textarea>
                <input type="submit" value="Изменить">
            </form>
            <hr>
            <h3>Комментарии</h3>
            <form method="POST" action=<?= $article->getId() . "/comments";?>>
                <label for="comment">Текст комментария</label>
                <textarea id="comment" name="comment"></textarea>
                <input type="submit" value="Комментировать">
            </form>
            <hr>
            <?php $i=0; foreach($comments as $comment): ?>
            <p id=<?= "comment" . $i?>><?= $comment->getAuthor();?></p>
            <p><?= $comment->getText();?></p>
            <a href=<?= "../comments/" . $comment->getId() . "/edit" ?>>Редактировать</a>
            <hr>
            <?php $i++; endforeach;?>
<?php include __DIR__.'/../footer.html';