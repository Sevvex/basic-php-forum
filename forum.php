<?php
$page_title = "Forum";
include 'includes/header.php';

$categories = get_categories();
?>

<h2>Forum Categories</h2>
<ul>
    <?php foreach ($categories as $category): ?>
        <li>
            <a href="category.php?id=<?php echo $category['id']; ?>">
                <?php echo htmlspecialchars($category['name']); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'includes/footer.php'; ?>
