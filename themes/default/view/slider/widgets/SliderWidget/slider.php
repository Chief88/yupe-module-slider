<div class="bg2 hidden-xs hidden-sm hidden-md">
    <div class="main-slider" id="main-slider-block">

        <?php foreach($items as $item): { ?>
            <div>
                <img src="<?= $item->getImageUrl(); ?>" alt="" class="main-slider-item-bg" />
                <div class="slide-content">
                    <div class="slide-title">
                        <?= $item->description?>
                    </div>

                    <?php if( !empty($item->url) ): { ?>
                        <div class="slide-text">Подробности по ссылке</div>
                        <div class="slide-btn">
                            <a href="<?=  $item->url; ?>" class="btn btn-default">Подробнее</a>
                        </div>
                    <?php }endif; ?>

                </div>
            </div>
        <?php }endforeach; ?>

    </div>
</div>