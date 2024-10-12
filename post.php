<?php
$page_title = "Post";
include 'includes/header.php';

$post_id = $_GET['id'] ?? null;
$post = get_post($post_id);

if (!$post) {
    echo "<p>Post not found.</p>";
    include 'includes/footer.php';
    exit;
}

$comments = get_comments($post_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $content = $_POST['content'];
    create_comment($_SESSION['user']['id'], $post_id, $content);
    header("Location: post.php?id=$post_id");
    exit;
}
?>

<h2><?php echo htmlspecialchars($post['title']); ?></h2>
<p>by <?php echo htmlspecialchars(get_user($post['user_id'])['username']); ?> on <?php echo $post['created_at']; ?></p>
<div><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>

<h3>Comments</h3>
<?php foreach ($comments as $comment): ?>
    <div>
        <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
        <p>by <?php echo htmlspecialchars(get_user($comment['user_id'])['username']); ?> on <?php echo $comment['created_at']; ?></p>
    </div>
<?php endforeach; ?>

<?php if (isset($_SESSION['user'])): ?>
    <h3>Add Comment</h3>
    <form action="post.php?id=<?php echo $post_id; ?>" method="post">
        <div>
            <textarea name="content" required></textarea>
        </div>
        <div>
            <input type="submit" value="Submit Comment">
        </div>
    </form>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
