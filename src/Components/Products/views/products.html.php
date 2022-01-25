<h2>Products</h2>

<?php if(!$products): ?>
	<strong>There are no products available at this time.</strong>
<?php else: ?>
	<ul>
	<?php foreach($products as $product): ?>
		<li>
			<?= htmlentities($product->name) ?>: 
			<strong><?= htmlentities($product->price) ?></strong>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>