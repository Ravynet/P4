<div class="comment-section-container">
    <div class="comment-section-author">
        <div class="comment-section-name">
            <div class="auteur">
                <i class="fa fa-user" aria-hidden="true"></i>
                <p><?= htmlspecialchars($data->getComAuteur()) ?></p>
            </div>
            <p>Le <?= $data->getComDate() ?></p>
        </div>
    </div>
    <div class="comment-section-text">
        <p><?= $data->getComContenu()?></p>
        <a class="hollow button" href="signaler-<?=$data->getComId()?>">Signaler ce commentaire</a>
    </div>
</div>