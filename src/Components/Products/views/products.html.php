<?php 
	function createProductUri(array $params) {
		$params = array_merge($_GET, $params);
		$uri = "/products";
		foreach ($params as $key => $param) {
			$uri .= "&$key=$param";
		}
		return preg_replace("/&/", "?", $uri, 1);
	}
?>

<h2>Products</h2>

<?php if(!$products): ?>
	<strong>There are no products available at this time.</strong>
<?php else: ?>
	<table>
		<thead>
			<tr>
				<th><a href=<?= createProductUri([
					"orderBy" => "name", 
					"sort" => $orderBy === "name" && $sort === "ASC" ? "DESC" : "ASC"
				]) ?>>Name</a></th>
				<th><a href=<?= createProductUri([
					"orderBy" => "price", 
					"sort" => $orderBy === "price" && $sort === "ASC" ? "DESC" : "ASC"
				]) ?>>Price</a></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($products as $product): ?>
			<tr>
				<td><?= htmlentities($product->name) ?></td>
				<td><?= number_format(htmlentities($product->price), 0, "", " ") ?> €</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td>
				<?php if($page > 0): ?>
					<a href=<?= createProductUri(["p" => $page - 1]) ?>>Previous</a>
				<?php endif; ?>
				</td>
				<td>
				<?php if(!$isLastPage): ?>
					<a href=<?= createProductUri(["p" => $page + 1]) ?>>Next</a>
				<?php endif; ?>
				</td>
			</tr>
		</tfoot>
	</table>
<?php endif; ?>