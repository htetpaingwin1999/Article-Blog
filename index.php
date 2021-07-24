<?php 
    require_once 'inc/header.php';
    $post = POST::all();
    $isyourpost = false;
    $user_id = User::auth()?User::auth()->id:0;
    if(isset($_GET['category'])){
            $slug = $_GET['category'];
            $post = POST::articleByCategory($slug);
    }
    else if(isset($_GET['language'])){
        $slug = $_GET['language'];
        $post = POST::articleByLanguage($slug);
    }else if(isset($_GET['search'])){
        $search = $_GET['search'];
        $post = Post::Search($search);
    }

else if(isset($_GET['your_post'])){
        if($user_id != 0 )
        {
        $isyourpost =true;
        $post = Post::yourPost();
        }
        else{
                $post = Post::none();
        }
        
        }
    else{
            $post = POST::all();
    }
//     echo "<pre>";
//     print_r($post);
// die();
if($user_id == 0)
{
        Helper::redirect("login.php");
}

?>
<div class="card card-dark">
        <div class="card-body">
                <a href="<?php echo $post['prev_page']?>" class="btn btn-danger">Prev Posts</a>
                <a href="<?php echo $post['next_page']?>" class="btn btn-danger float-right">Next Posts</a>
        </div>
</div>
<div class="card card-dark">
        <div class="card-body">
                <div class="row">
                        <!-- Loop this -->
                        <?php 
                        foreach($post['data'] as $a){
                         ?>
                        <div class="col-md-4 mt-2">
                                <div class="card" style="width: 18rem;">
                                        <img class="card-img-top"
                                                src="<?php echo $a->image?>" width="200px" height="200px"
                                                alt="Card image cap">
                                        <div class="card-body">
                                                <h5 class="text-dark"><?php echo $a->title?></h5>
                                        </div>
                                        <div class="card-footer">
                                                <div class="row">
                                                        <div class="col-md-4 text-center">
                                                                <i class="fas fa-heart text-warning">
                                                                </i>
                                                                <small class="text-muted"><?php echo $a->like_count?></small>
                                                        </div>
                                                        <div
                                                                class="col-md-4 text-center">
                                                                <i
                                                                        class="far fa-comment text-dark"></i>
                                                                <small
                                                                        class="text-muted"><?php echo $a->comment_count?></small>
                                                        </div>
                                                        <div
                                                                class="col-md-4 text-center">
                                                                <a href="<?php echo 'detail.php?id='.$a->id?>"
                                                                        class="badge badge-warning p-1">View</a>
                                                                        <?php if($isyourpost == true){?>
                                                                        <a href="<?php echo 'updatearticle.php?id='.$a->id?>"
                                                                        class="badge badge-info p-1">Update</a>
                                                                        <a href="<?php echo 'deletearticle.php?delete='.$a->id?>"
                                                                        class="badge badge-danger p-1">Delete</a>
                                                                        <?php
                                                                        }?>
                                                        </div>
                                                </div>

                                        </div>
                                </div>
                        </div>
                        <?php
                                }
                        ?>
                </div>
        </div>
</div>
<?php 
    require_once 'inc/footer.php';
?>
