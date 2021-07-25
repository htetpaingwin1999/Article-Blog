<?php
ob_start();
require_once 'core/autoload.php';
?>
<!doctype html>
<html lang="en">

<head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--  Font Awesome for Bootstrap fonts and icons -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

        <!-- Material Design for Bootstrap CSS -->
        <link rel="stylesheet"
                href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css"
                integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX"
                crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="assets/style.css">
        <title>MM-Coder</title>
        <style>

        </style>
</head>

<body>
        <!-- Start Nav -->
        <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand text-warning" href="index.php">Blogging!</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                        <a class="nav-link" href="index.php">Articles</a>
                                </li>

                                <div class="dropdown show">
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                User
                                </a>
                
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <?php 
                                        if(User::auth()){
                                        ?>
                                        <a class="dropdown-item" href="#">Welcome <?php echo User::auth()->name ?></a>
                                        <a class="dropdown-item" href="edit.php?user=<?php echo User::auth()->id;?>">Edit</a>
                                        <a class="dropdown-item" href="logout.php">Logout</a>
                                        <?php 
                                        }else{
                                        ?>
                                        <a class="dropdown-item" href="register.php">Register</a>
                                        <a class="dropdown-item" href="login.php">Login</a>
                                        <?php 
                                        }?>                               
                                </div>
                                </div>
                                <li class="nav-item">
                                        <a class="nav-link" href="index.php?your_post">Your Post</a>
                                </li>
                               
                                <li class="nav-item ml-5">
                                        <a class="nav-link btn btn-sm  btn-warning" href="create.php">
                                                <i class="fas fa-plus"></i>
                                                Create Article</a>
                                                
                                </li>

                        </ul>
                        <form class="form-inline my-2 my-lg-0" method="GET">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search"
                                        aria-label="Search" name="search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                </div>
        </nav>

        <!-- Start Header -->

        <div class="jumbotron jumbotron-fluid header">
                <div class="container">
                        <h1 class="text-white">MM-Coder Online Course</h1>
                        <h1 class="display-4 text-white">Welcome Com From Advance PHP Online Class</h1>
                        <p class="lead text-white">Hello Now We publish this course free.</p>
                        <br>
                        <?php
                        if(User::auth()){
                        ?>
                        <h3>Welcome <?php echo User::auth()->name?></h3>
                        <?php
                        } 
                        ?>
                        <a href="register.php" class="btn btn-warning">Create Account</a>
                        <a href="login.php" class="btn btn-outline-success">Login</a>
                </div>
        </div>

        <!-- Content -->
        <div class="container-fluid">
                <div class="row">
                        <div class="col-md-4 pr-3 pl-3">
                                <!-- Category List -->
                                <div class="card card-dark">
                                        <div class="card-header">
                                                <h4>All Category</h4>
                                        </div>
                                        <div class="card-body">
                                                <?php
                                                $category = DB::raw("select * ,(select count(id) from articles where articles.category_id=categories.id) as 'articlecount' from categories
                                                ")->query()->get();
                                                ?>
                                                <ul class="list-group">
                                                       
                                                        <?php
                                                        foreach($category as $c){
                                                        ?>
                                                         <a href="index.php?category=<?php echo $c->id?>">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <?php echo $c->name; ?>
                                                                        <span class="badge badge-primary badge-pill"><?php echo $c->articlecount ?></span>
                                                                </li>
                                                         </a>
                                                        <?php
                                                        }
                                                        ?>
                                                </ul>
                                        </div>

                                </div>
                                <hr>
                                <!-- Language List -->
                                <div class="card card-dark">
                                        <div class="card-header">
                                                <h4>All Languages</h4>
                                        </div>

                                        <div class="card-body">
                                        <?php
                                                $language = DB::raw("SELECT *,(select count(id) from article_languages where article_languages.language_id=languages.id) as 'articlecount' FROM languages
                                                ")->query()->get();
                                                ?>
                                                <ul class="list-group">         
                                                <?php
                                                foreach($language as $l){
                                                ?>
                                               <a href="index.php?language=<?php echo $l->id?>">
                                                        <li  class="list-group-item d-flex justify-content-between align-items-center">
                                                        <?php echo $l->name; ?>
                                                        <span class="badge badge-primary badge-pill"><?php echo $l->articlecount ?></span>
                                                        </li>
                                               </a>
                                                <?php
                                                }
                                                ?>
                                                
                                        </div>

                                </div>
                        </div>

                        <!-- Content -->
                        <div class="col-md-8">