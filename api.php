<?php 
require_once 'core/autoload.php';
$request = $_GET;
    if(isset($request['like'])){
        $user_id = $request['user_id'];
        $article_id = $request['article_id'];
        
        $u = DB::table('article_likes')->where('user_id',$user_id)->andwhere('article_id',$article_id)->getOne();
        if($user_id == 0)
        {
            Helper::redirect("login.php");
        }
        if($u){
            echo 'hi';
        }
        else{
            
            $user = DB::create("article_likes",[
                'user_id'=>$user_id,
                'article_id'=>$article_id
            ]);
            $count =  DB::table('article_likes')->where('article_id',$article_id)->count();
            echo $count;
             
        }
    }

    if(isset($_POST['comment'])){
        $user_id = User::auth()->id;
        $article_id = $_POST['article_id'];
        $comment = $_POST['comment'];
        // echo $user_id.$article_id.$comment;

        $cmt = DB::create('article_comments',[
            'user_id'=>$user_id,
            'article_id'=>$article_id,
            'comment'=>$comment
        ]);

        if($cmt){
            $cmt_Lists = DB::table('article_comments')->where('article_id',$article_id)->orderBy('id','desc')->get();
            $html = "";
            foreach($cmt_Lists as $c){
                $user = DB::table('users')->where('id',$c->user_id)->getOne();
                $html.="
                <div class='card-dark mt-1'>
                                        <div id='comment_list'>
                                                <div class='card-body'>
                                                        <div class='row'>
                                                                <div class='col-md-1'>
                                                                        <img src='$user->image'
                                                                                style='width:50px;border-radius:50%'
                                                                                alt=''>
                                                                </div>
                                                                <div class='col-md-4 d-flex align-items-center'>
                                                                    $user->name
                                                                </div>
                                                        </div>
                                                        <hr>
                                                        <p>$c->comment</p>
                                                </div>

                                        </div>
                                </div>
                ";
            }
            echo $html;
        }
    }
    
?>