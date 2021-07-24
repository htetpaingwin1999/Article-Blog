<?php 
    require_once 'inc/header.php';
    if(isset($_GET['user'])){
        $id = $_GET['user'];
        $user = DB::table('users')->where('id',$id)->query()->getOne();
        // print_r($user);
    }
    else{
        Helper::redirect("404.php");
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //temp file ထားေပးရတယ္ ၊ temp_name က ေစာန image ရဲ႕ data ရဲ႕ tmp_name အျဖစ္းထားရတယ္ 
        //tmp_name က ဂဏန္းေတြပဲျဖစ္မွာ
        //$image['tmp_name']က ဂဏန္းေတြနဲ႕ မွည္႕ထားတဲ႕ folder နာမည္ပဲ 
        $name = $_POST['name']; 
        $email = $_POST['email'];
        // $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        if($_FILES['user_image']['tmp_name'] != ''){
           
            $image = $_FILES['user_image']; // file ထဲ image ရဲ႕ data ကုိဖတ္မယ္
            $image_name = $image['name']; // ဖတ္ထားတဲ႕ Image ရဲ႕ နာမည္ကုိ ယူမယ္
            $path = "assets/users/$image_name"; // ထားခ်င္တဲ႕ ပတ္လမ္းေျကာင္းနဲ႕ သူ႕နာမည္
            $tmp_name = $image['tmp_name'];
            $temp_name = $_FILES['user_image']['tmp_name'];
            $image_name = $_FILES['user_image']['name'];
            $path = "assets/users/".$image_name;
            if($user->image !=$path){
                move_uploaded_file($temp_name,$path);
            }
            DB::raw("update users set name='".$name."',image='".$path."',email='".$email."' where id=".$user->id)->query();   
        }
        else{
            DB::raw("update users set name='".$name."',email='".$email."' where id=".$user->id)->query();        
        }
        Helper::redirect("index.php");
       
    }
    
?>
<div class="card card-dark">
    <div class="card-header bg-warning">
            <h3>Register</h3>
    </div>
    <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label for="name" class="text-white">Enter Username</label>
                            <input type="name" class="form-control"
                                    placeholder="enter username" name="name" value="<?php echo $user->name?>">
                    </div>
                    <div class="form-group">
                            <label for="email" class="text-white">Enter Email</label>
                            <input type="email" class="form-control"
                                    placeholder="enter email" name="email" value="<?php echo $user->email?>">
                    </div> 
                     <div class="form-group">
                            <label for="password" class="text-white">Enter Password</label>
                            <input type="password" class="form-control"
                                    placeholder="enter username" name="password" value="<?php echo $user->password?>">
                    </div> 
                    <div class="form-group">
                        <label for="" class="text-white">Choose Image</label>
                        <input type="file" class="form-control" name="user_image">
                    </div>
                    <div class="form-group">
                        <img src="<?php echo $user->image?>" width="200" height="200" style="border-radius: 20%;"/>
                    </div>
                    <input type="submit" value="Update"
                            class="btn  btn-outline-warning">
                
            </form>
    </div>
</div>

<?php 
    require_once 'inc/footer.php';
?>