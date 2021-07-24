<?php 
    require_once 'inc/header.php';
    if(User::auth()){
        Helper::redirect("index.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $u = new User();
        $user = $u->login($_POST);
    }
?>
<div class="card card-dark">
    <div class="card-header bg-warning">
            <h3>Login</h3>
    </div>
    <div class="card-body">
    <form action="" method="post">
            <?php
                if(isset($user) && is_array($user)){
                    foreach($user as $e){
            ?>
        <div class="alert alert-danger">
            <?php echo $e; ?>
        </div>                                                
            <?php
                    }
                }
            ?>
            <form action="" method="POST">
                    <div class="form-group">
                            <label for="" class="text-white">Enter Email</label>
                            <input type="name" class="form-control"
                                    placeholder="enter email" name="email">
                    </div>
                    <div class="form-group">
                            <label for="" class="text-white">Enter Password</label>
                            <input type="password" class="form-control"
                                    placeholder="enter password" name="password">
                    </div>
                    <input type="submit" value="Login"
                            class="btn  btn-outline-warning">
            </form>
    </div>
</div>
<?php 
    require_once 'inc/footer.php';
?>