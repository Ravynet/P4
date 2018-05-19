<?php $path = App::getRouter()->getController() . '?'; ?>
<?php if ($nbPage > 1) { ;?>
    <ul class="pagination text-center" role="navigation" aria-label="Pagination" data-page="<?=Config::get('art_per_page_admin')?>" data-total="<?= count($tickets)?>">
        <?php
        if ($cPage-1 == 0) { ?>
            <li class="pagination-previous disabled">Précédent<span class="show-for-sr">page</span></li>
            <?php
        } else { ?>
            <li class="pagination-previous"><a href="<?=$path . ($cPage-1)?>" aria-label="Previous page">Précédent<span class="show-for-sr">page</span></a></li>
            <?php
        }
        ?>
        <?php
        for ($i = 1; $i <= $nbPage; $i++) {
            if ($i == $cPage) { ?>
                <li class="current"><span ><?=$i?></span></li>
                <?php
            } else {?>
                <li><a href="<?=$path . $i?>" aria-label="Page"><?=$i?></a></li>
                <?php
            }
        }
        ?>
        <?php
        if ($cPage+1 > $nbPage) { ?>
            <li class="pagination-next disabled">Suivant<span class="show-for-sr">page</span></li>
            <?php
        } else { ?>
            <li class="pagination-next"><a href="<?=$path . ($cPage+1)?>" aria-label="Next page">Suivant<span class="show-for-sr">page</span></a></li>
            <?php
        }
        ?>
    </ul>
<?php }