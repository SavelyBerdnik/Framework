<?php include __DIR__.'/../header.html';?>
            <?php foreach($articles as $article):?>
            <h2><a href="article/<?=$article->getId();?>"><?= $article->getName();?></a></h2>
            <p><?= $article->getText();?></p>
            <hr>
            <?php endforeach;?>
<?php include __DIR__.'/../footer.html';