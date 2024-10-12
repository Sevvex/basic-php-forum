<?php
$page_title = "Create Post";
include 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$category_id = $_GET['category_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    $post = create_post($_SESSION['user']['id'], $category_id, $title, $content);
    header("Location: post.php?id={$post['id']}");
    exit;
}

$categories = get_categories();
?>

<h2>Create New Post</h2>
<form action="create_post.php" method="post">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
    </div>
    <div>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $category_id ? 'selected'
