<?php
$tickets = $data[0];
$nbPage = $data[1];
$cPage = $data[2];
Config::set("site_name", Config::get("site_name").' - Les épisodes');
?>

<div class="blogIndex">

    <?php if (empty($tickets)) {?>
        <h3>Aucun épisode de publié pour le moment.</h3>
        <h4>Revenez un peu plus tard ...</h4>
    <?php } else {?>

        <?php foreach ($tickets as $ticket) { ?>
            <section class="blog-post">
                <h1><a href="blog/billet?<?= $ticket->getId()?>"><?= htmlspecialchars($ticket->getTitle())?></a>
                    <div>
                        <small id="publie">Publié le : <?= $ticket->getDatePublication()?></small>
                        <small id="modifie"><?= $ticket->getDateModification() != $ticket->getDatePublication() ? 'Modifié le : '. $ticket->getDateModification() : ''?></small>
                    </div>
                </h1>
                <img class="thumbnail" src="<?= LOCAL.'/webroot/images/'.$ticket->getId().'.jpg'?>" alt="Image <?=htmlspecialchars($ticket->getTitle())?>">
                <div class="content">
                    <?= substr($ticket->getContent(), 0, 1000)." ..."?>
                </div>

                <div class="callout">
                    <ul class="menu simple">
                        <li class="auteur"><i class="fa fa-user" aria-hidden="true"></i><span><?= htmlspecialchars($ticket->getAuthor())?></span></li>
                        <li><a href="blog/billet?<?= $ticket->getId() . '#commentaire' ?>"><?= $ticket->getNbcoms() . ($ticket->getNbcoms() > 1 ? ' Commentaires' : ' Commentaire')?></a></li>
                    </ul>
                </div>
            </section>
       <?php } ?>

        <ul class="pagination text-center" role="navigation" aria-label="Pagination" data-page="<?=Config::get('art_per_page_admin')?>" data-total="<?= count($tickets)?>">
            <?php
            if ($cPage-1 == 0) { ?>
                <li class="pagination-previous disabled">Précédent<span class="show-for-sr">page</span></li>
                <?php
            } else { ?>
                <li class="pagination-previous"><a href="blog?<?=$cPage-1?>" aria-label="Previous page">Précédent<span class="show-for-sr">page</span></a></li>
                <?php
            }
            ?>
            <?php
            for ($i = 1; $i <= $nbPage; $i++) {
                if ($i == $cPage) { ?>
                    <li class="current"><span ><?=$i?></span></li>
                    <?php
                } else {?>
                    <li><a href="blog?<?=$i?>" aria-label="Page"><?=$i?></a></li>
                    <?php
                }
            }
            ?>
            <?php
            if ($cPage+1 > $nbPage) { ?>
                <li class="pagination-next disabled">Suivant<span class="show-for-sr">page</span></li>
                <?php
            } else { ?>
                <li class="pagination-next"><a href="blog?<?=$cPage+1?>" aria-label="Next page">Suivant<span class="show-for-sr">page</span></a></li>
                <?php
            }
            ?>
        </ul>
    <?php } ?>
</div>