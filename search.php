<?php
if (isset($_GET['query'])) {
	$query = $_GET['query'];
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$itemsPerPage = 5;
	$offset = ($page - 1) * $itemsPerPage;

	try {
		// Database connection
		$pdo = new PDO('mysql:host=localhost;dbname=search_db', 'root', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Count total results for pagination
		$countStmt = $pdo->prepare("SELECT COUNT(*) FROM items WHERE name LIKE :query OR description LIKE :query");
		$countStmt->execute(['query' => '%' . $query . '%']);
		$totalResults = $countStmt->fetchColumn();
		$totalPages = ceil($totalResults / $itemsPerPage);

		// Prepare and execute the query
		$stmt = $pdo->prepare(
			"SELECT name, description 
             FROM items 
             WHERE name LIKE :query OR description LIKE :query 
             LIMIT :limit OFFSET :offset"
		);

		// Bind parameters for secure pagination
		$stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
		$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();

		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// Generate results HTML with highlighted terms
		$htmlResults = '';
		if ($results) {
			foreach ($results as $row) {
				$name = preg_replace("/(" . preg_quote($query, '/') . ")/i", '<span class="highlight">$1</span>', htmlspecialchars($row['name']));
				$description = preg_replace("/(" . preg_quote($query, '/') . ")/i", '<span class="highlight">$1</span>', htmlspecialchars($row['description']));

				$htmlResults .= "<div><h3>$name</h3><p>$description</p></div>";
			}
		} else {
			$htmlResults = '<p>No results found.</p>';
		}

		// Generate pagination buttons
		$pagination = '';
		if ($totalPages > 1) {
			for ($i = 1; $i <= $totalPages; $i++) {
				$activeClass = ($i === $page) ? 'style="font-weight: bold;"' : '';
				$pagination .= "<button data-page=\"$i\" $activeClass>$i</button>";
			}
		}

		// Return JSON response
		echo json_encode([
			'results' => $htmlResults,
			'pagination' => $pagination
		]);
	} catch (PDOException $e) {
		echo json_encode([
			'error' => 'Error: ' . $e->getMessage()
		]);
	}
}
?>