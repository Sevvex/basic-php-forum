<?php
$page_title = "Category";
include 'includes/header.php';

$category_id = $_GET['id'] ?? null;
$category = get_category($category_id);

if (!$category) {
    echo "<p>Category not found.</p>";
    include 'includes/footer.php';
    exit;
}

$posts = get_posts($category_id);
?>

<h2><?php echo htmlspecialchars($category['name']); ?></h2>
<a href="create_post.php?category_id=<?php echo $category_id; ?>">Create New Post</a>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="post.php?id=<?php echo $post['id']; ?>">
                <?php echo htmlspecialchars($post['title']); ?>
            </a>
            by <?php echo htmlspecialchars(get_user($post['user_id'])['username']); ?>
            on <?php echo $post['created_at']; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'includes/footer.php'; ?>
