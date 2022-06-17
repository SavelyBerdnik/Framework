<?php include __DIR__.'/../../header.html';?>
            <link rel="stylesheet" href="../../style.css">
            <p><strong><?= $comment->getAuthor();?></strong></p>
            <p><?= $comment->getText();?></p>
            <hr>
            <form method="POST" action="edit/confirm">
                <label for="text">Новый комментарий:</label>
                <input type="text" id="text" name="newComment">
                <input type="submit" value="Редактировать комментарий">
            </form>
<?php include __DIR__.'/../../footer.html';