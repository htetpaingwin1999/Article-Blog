<?php 
class User{
    //Auth
    public static function auth(){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION['user_id'];
            return DB::table("users")->where('id',$user_id)->query()->getOne();
        }
        return false;
    }
    public static function login($request){
        $error = [];
        $email = Helper::filter($request['email']);
        $password = $request['password'];

        if(empty($request['email']))
        {
            $error[] = "Email Field is required";
        }
        if(empty($request['password'])){
            $error[] = "Password Field is required";
        }
        if(count($error)){
            return $error;
        }
        else{
            $user = DB::table('users')->where("email","'".$email."'")->query()->getOne();
            if($user){
                $db_password = $user->password;
 
                if(password_verify($password,$db_password)){   
                    $_SESSION['user_id']= $user->id;
                    Helper::redirect("login.php?".$user->id);
                    die();
                    return 'success';
                }
                else{
                    // wrong password
                    $error[] = "Wrong Password";
                    
                    return $error;
                }
            }
            else{
                //wrong email
                $error[] = "Wrong Email";
                return $error;
            }
        }
    }
    public function register($request){
         $error = [];
        if(isset($request))
        {
            if(empty($request['name']))
            {
                $error[] = "Name Field is required";
            }
            if(empty($request['email']))
            {
                $error[] = "Email Field is required";
            }
            // if(filter_var($request['email'],FILTER_VALIDATE_EMAIL))
            // {
            //     $error[] = "Invalid Email Format";
            //     echo 'email1';
            // }

           // $user = DB::table('users')->where('email',$request['email']);
            // if($user){
            //     $error[] = "Email is already existed";
            // }
            if(empty($request['password'])){
                $error[] = "Password Field is required";
            }
            if(count($error)){
                return $error;
            }else{
                $user = DB::create('users',[
                    'name' =>Helper::filter($request['name']),
                    'slug'=>Helper::slug($request['name']),
                    'email' =>Helper::filter($request['email']),
                    'password' =>password_hash($request['password'],PASSWORD_BCRYPT),
                ]);

                echo $user->id;
                $_SESSION['user_id'] = $user->id;
                return 'success';
            }
        }
    }
}
?>