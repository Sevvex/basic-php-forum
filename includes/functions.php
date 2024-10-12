<?php
session_start();

function load_data($file) {
    $json = file_get_contents(__DIR__ . "/../data/$file.json");
    return json_decode($json, true) ?: [];
}

function save_data($file, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__ . "/../data/$file.json", $json);
}

function create_user($username, $password, $email) {
    $users = load_data('users');
    $new_user = [
        'id' => count($users) + 1,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'email' => $email,
        'rank' => 'member',
        'joined' => date('Y-m-d H:i:s')
    ];
    $users[] = $new_user;
    save_data('users', $users);
    return $new_user;
}

function get_user($username) {
    $users = load_data('users');
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return $user;
        }
    }
    return null;
}

function create_post($user_id, $category_id, $title, $content) {
    $posts = load_data('posts');
    $new_post = [
        'id' => count($posts) + 1,
        'user_id' => $user_id,
        'category_id' => $category_id,
        'title' => $title,
        'content' => $content,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    $posts[] = $new_post;
    save_data('posts', $posts);
    return $new_post;
}

function get_posts($category_id = null) {
    $posts = load_data('posts');
    if ($category_id) {
        return array_filter($posts, function($post) use ($category_id) {
            return $post['category_id'] == $category_id;
        });
    }
    return $posts;
}

function get_post($post_id) {
    $posts = load_data('posts');
    foreach ($posts as $post) {
        if ($post['id'] == $post_id) {
            return $post;
        }
    }
    return null;
}

function get_categories() {
    return load_data('categories');
}

function get_category($category_id) {
    $categories = load_data('categories');
    foreach ($categories as $category) {
        if ($category['id'] == $category_id) {
            return $category;
        }
    }
    return null;
}

function create_comment($user_id, $post_id, $content) {
    $comments = load_data('comments');
    $new_comment = [
        'id' => count($comments) + 1,
        'user_id' => $user_id,
        'post_id' => $post_id,
        'content' => $content,
        'created_at' => date('Y-m-d H:i:s')
    ];
    $comments[] = $new_comment;
    save_data('comments', $comments);
    return $new_comment;
}

function get_comments($post_id) {
    $comments = load_data('comments');
    return array_filter($comments, function($comment) use ($post_id) {
        return $comment['post_id'] == $post_id;
    });
}

function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['rank'] === 'admin';
}

function update_user_rank($user_id, $new_rank) {
    $users = load_data('users');
    foreach ($users as &$user) {
        if ($user['id'] == $user_id) {
            $user['rank'] = $new_rank;
            break;
        }
    }
    save_data('users', $users);
}

function delete_post($post_id) {
    $posts = load_data('posts');
    $posts = array_filter($posts, function($post) use ($post_id) {
        return $post['id'] != $post_id;
    });
    save_data('posts', $posts);

    // Delete associated comments
    $comments = load_data('comments');
    $comments = array_filter($comments, function($comment) use ($post_id) {
        return $comment['post_id'] != $post_id;
    });
    save_data('comments', $comments);
}
