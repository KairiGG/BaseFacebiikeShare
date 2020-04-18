<?php

use Comment\Comment;
use Post\Post;

include '../src/Factory/DbAdaperFactory.php';

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';

include '../src/Model/Post/Post.php';
include '../src/Model/Post/PostRepository.php';

include '../src/Model/Comment/Comment.php';
include '../src/Model/Comment/CommentRepository.php';


$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);
$postRepository = new \Post\PostRepository($dbAdaper);
$commentRepository = new \Comment\CommentRepository($dbAdaper);

if(isset($_GET['displayPost']))
    $displayPost = $_GET['displayPost'];
else
    $displayPost = 1;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    #get all example
    $posts = $postRepository->fetchAll();
    $users = $userRepository->fetchAll();
    $comments = $commentRepository->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if($displayPost == 1) {
        $newPost = new Post();

        $newPost
            ->setContent($_POST["content"])
            ->setCreatedAt(date("Y-m-d H:i:s"))
            ->setAuthorId(($_POST["user"]));

        $postRepository->create($newPost);
    }
    else {
        $newComment = new Comment();

        $newComment
            ->setContent($_POST["contentComment"])
            ->setCreatedAt(date("Y-m-d H:i:s"))
            ->setAuthorId(($_POST["userComment"]))
            ->setPostId(($_POST["postComment"]));

        $commentRepository->create($newComment);
    }

    $posts = $postRepository->fetchAll();
    $users = $userRepository->fetchAll();
    $comments = $commentRepository->fetchAll();
}
?>

<html>
<head>
    <title>Post Query</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <div class="container">

        <table class="table table-bordered table-hover table-striped">
        <thead style="font-weight: bold">
        <td>#</td>
        <td>Id</td>
        <td>Contenu</td>
        <td>Date de création</td>
        <td>Auteur</td>
        <td>Commentaires</td>
        </thead>
        <?php
        foreach ($posts as $post) : ?>
            <tr>
                <td></td>
                <td><?php echo $post->getId() ?></td>
                <td><?php echo $post->getContent() ?></td>
                <td><?php echo $post->getCreatedAt()->format("Y-m-d") ?></td>
                <td><?php
                    foreach ($users as $user) {
                        if($user->getId() == $post->getAuthorId())
                            echo $user->getUsername();
                    }
                ?></td>
                <td><?php
                    foreach ($comments as $comment) {
                        if($comment->getPostId() == $post->getId()) {
                            foreach ($users as $user) {
                                if($user->getId() == $comment->getAuthorId())
                                    echo $user->getUsername();
                            }
                            echo ' : ';
                            echo $comment->getContent();
                            echo '<br>';
                        }
                    }
                ?></td>
            </tr>
        <?php endforeach; ?>
        </table>



        <?php if ($displayPost == 1): ?>

            <a href="http://localhost:8080/post-example.php?displayPost=0">Passer à la création de commentaire</a>

            <div class="card">

                <h5 class="card-header info-color white-text text-center">
                <strong>Post</strong>
                </h5>

                <form action="" method="POST" class="text-center" style="background-color: #e6e6ff">
                    <label for="content">Content :</label><br>
                    <input type="text" id="content" name="content"><br>
                    <select name="user" id="user">
                        <?php
                        foreach ($users as $user) : ?>
                            <option value="<?php echo $user->getId() ?>"> user : <?php echo $user->getUsername() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <input id="saveButton" type="submit" value="Sauvegarder"><br>
                </form>

            </div>
        <?php endif; ?>

        <?php if ($displayPost == 0): ?>

            <a href="http://localhost:8080/post-example.php?displayPost=1">Passer à la création de post</a>

            <div class="card">

                <h5 class="card-header info-color white-text text-center">
                <strong>Comment</strong>
                </h5>

                <form action="" method="POST" class="text-center" style="background-color: #e6e6ff">      
                    <label for="contentComment">Content :</label><br>
                    <input type="text" id="contentComment" name="contentComment"><br>
                    <select name="userComment" id="userComment">
                        <?php
                        foreach ($users as $user) : ?>
                            <option value="<?php echo $user->getId() ?>"> user : <?php echo $user->getUsername() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <select name="postComment" id="postComment">
                        <?php
                        foreach ($posts as $post) : ?>
                            <option value="<?php echo $post->getId() ?>"> post : <?php echo $post->getContent() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <input id="saveButtonComment" type="submit" value="Sauvegarder"><br>
                </form>

            </div>
        <?php endif; ?>

        

        
        
    </div>
</body>
</html>