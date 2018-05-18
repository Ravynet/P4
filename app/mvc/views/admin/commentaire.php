<?php
$tickets = $data[0];
$nbPage = $data[1];
$cPage = $data[2];
Config::set("site_name", Config::get("site_name").' - Commentaire signalé');
?>

<div class="adminIndex">
    <div class="blog-post">
        <table class="table-expand">
            <thead>
            <tr class="table-expend-row">
                <th class="text-left date" width="17%">Date publication</th>
                <th class="text-left titre" width="25%">Titre</th>
                <th class="text-center" width="18%">Commentaires signalés</th>
                <th class="text-center" width="22%"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tickets as $ticket) {
                if ($ticket->getNbComSignale() > 0){ ?>
                    <tr class="table-expend-row adminCommentaire" data-open-details>
                        <td class="date"><?= $ticket->getDatePublication()->format('d/m/Y à H:i');?></td>
                        <td class="titre"><?= strlen($ticket->getTitle()) > 50 ? substr($ticket->getTitle(), 0, 50)." ..." : $ticket->getTitle();?></td>
                        <td class="text-center"> <?= $ticket->getNbComSignale() > 0 ?'<a class="comSignale" href="modifier?'.$ticket->getId().'#commentaire">'.$ticket->getNbComSignale().'</a>':'-';?><a></td>
                        <td>
                            <a class="button primary" href="modifier?<?=$ticket->getId();?>#commentaire">Modifier</a>
                        </td>
                    </tr>
               <?php }?>
            <?php } ?>
            </tbody>
        </table>

        <?php include("../app/mvc/views/core/paging.php") ?>

    </div>
</div>