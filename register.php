<?php 
    require_once 'inc/header.php';
    if(User::auth()){
        Helper::redirect("index.php");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user = new User();
        $user= $user->register($_POST);
        
        if($user == 'success')
        {
            Helper::redirect("index.php");
        }
       
        if(is_array($user)){
        }
    }
?>
<div class="card card-dark">
    <div class="card-header bg-warning">
            <h3>Register</h3>
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

                    <div class="form-group">
                            <label for="name" class="text-white">Enter Username</label>
                            <input type="name" class="form-control"
                                    placeholder="enter username" name="name">
                    </div>
                    <div class="form-group">
                            <label for="email" class="text-white">Enter Email</label>
                            <input type="email" class="form-control"
                                    placeholder="enter email" name="email">
                    </div>
                    <div class="form-group">
                            <label for="password" class="text-white">Enter Password</label>
                            <input type="password" class="form-control"
                                    placeholder="enter username" name="password">
                    </div>
                    <input type="submit" value="Register"
                            class="btn  btn-outline-warning">
            </form>
    </div>
</div>
<?php 
    require_once 'inc/footer.php';
?>