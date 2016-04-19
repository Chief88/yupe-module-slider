<?php
/**
 * @var $items array
 * @var $item Slide
 * @var $slider Slider
 */
?>

<div class="main-ppomo" style="background: url(<?= $slider->getImageUrl(); ?>) top center/contain no-repeat;">
	<div class="container">
		<div class="main-ppomo__title1"><?= $slider->title1; ?></div>
		<div class="main-ppomo__title2"><?= $slider->title2; ?></div>
		<div class="row">

			<?php foreach ($items as $item): { ?>
				<div class="col-md-4">
					<div class="main-ppomo__item">
						<a class="<?= empty($item->url) ? 'no-click' : ''; ?>" href="<?= $item->url; ?>">
							<div class="main-ppomo__item-ico">
								<img src="<?= $item->getImageUrl(); ?>" alt="<?= $item->name; ?>"/>
							</div>
							<div class="main-ppomo__item-text"><?= $item->name; ?></div>
							<div class="main-ppomo__item-more <?= empty($item->url) ? 'hidden' : ''; ?>"></div>
						</a>
					</div>
				</div>
			<?php }endforeach; ?>

		</div>
	</div>
</div>