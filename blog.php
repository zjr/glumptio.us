<?php
	$posts = get_posts('numberposts=3');
	foreach ($posts as $post) : start_wp(); ?>
	<section>
	<h3><?php the_title(); echo "<br>" ?></h3>
	<h4><?php the_date(); ?></h4>
	<?php the_excerpt(); ?>
	</section>
<?php
	endforeach;
?>

<img class="bg" src="img/bg1.gif">