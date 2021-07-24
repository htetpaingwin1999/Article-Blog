<?php 
    require_once "inc/header.php";
    $post = POST::all();
    if(!isset($_GET["id"])){
        Helper::redirect("404.php");
    }
    else{
        $id = $_GET["id"];
        $articles = Post::detail($id);
    }
?>
<div class="card card-dark">
        <div class="card-body">
                <div class="row">
                        <div class="col-md-12">
                                <div class="card card-dark">
                                        <div class="card-body">
                                                <div class="row">
                                                        <!-- icons -->
                                                        <div class="col-md-4">
                                                                <div class="row">
                                                                        <div
                                                                                class="col-md-4 text-center">
                                                                                <?php 
                                                                                    $articles_id = $articles->id;
                                                                                    $user_id = User::auth()?User::auth()->id:0;
                                                                                ?>
                                                                                <i
                                                                                        class="fas fa-heart text-warning" id="like" user_id="<?php echo $user_id?> article_id=" article_id="<?php echo $articles_id?>">
                                                                                </i>
                                                                                <small
                                                                                        class="text-muted" id="like_count"> <?php echo $articles->like_count;?></small>
										<label value="3" id="cc"></label>
                                                                        </div>
                                                                        <div
                                                                                class="col-md-4 text-center">
                                                                                <i
                                                                                        class="far fa-comment text-dark"></i>
                                                                                <small
                                                                                        class="text-muted" id="comment_count" value=<?php echo $articles->comment_count?>> <?php echo $articles->comment_count;?></small>
                                                                        </div>

                                                                </div>
                                                        </div>
                                                        <!-- Icons -->

                                                        <!-- Category -->
                                                        <div class="col-md-4">
                                                                <div class="row">
                                                                        <div  class="col-md-12">
                                                                            <a href=""
                                                                                    class="badge badge-primary"><?php echo $articles->category->name?>
                                                                            </a>

                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <!-- Category -->


                                                        <!-- Category -->
                                                        <div class="col-md-4">
                                                                <div class="row">
                                                                        <div class="col-md-12">
                                                                                
                                                                                <?php 
                                                                                foreach($articles->languages as $l){
                                                                                ?>
                                                                                <a href=""
                                                                                        class="badge badge-success"><?php echo $l->name;?>
                                                                                </a>
                                                                                <?php 
                                                                                }
                                                                                ?>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <!-- Category -->

                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                <br>
                <div class="col-md-12">
                        <h3><?php echo $articles->title?></h3>
                        <p>
                        <?php echo $articles->description?>   
                        </p>
                        <img src="<?php echo $articles->image?>" width="50%" />
                </div>
                
                <div class="card card-dark">
                    <div class="card-body">
                        <form action="" method="POST" id="frmCmt">
                            <input type="text" name="commentbox" id="commentbox" placeholder="Enter Comment" class="form-control"><br/>
                            <input type="submit" value="Create" class="btn btn-outline-warning float-right">
                        </form>
                    </div>
                </div>
                <!-- Comments -->
              
                <div class="card card-dark">
                        <div class="card-header">
                                <h4>Comments</h4>
                        </div>
                        <div class="card-body">
                                <!-- Loop Comment -->
                                <div id="comment_list">
                                <?php 
                                 foreach($articles->comments as $c){
                                         $u = User::auth()->id;
                                        //  $user_image = DB::table('users')->where('id',$articles->user_id)->query()->getOne();
                                ?>
                                        <div class="card-dark mt-1">
                                                <div class="card-body">
                                                        <div class="row">
                                                                <div class="col-md-1">
                                                                        <img src="<?php echo $c->image?>"
                                                                                style="width:50px;border-radius:50%"
                                                                                alt="">
                                                                </div>
                                                                <div class="col-md-4 d-flex align-items-center">
                                                                        <?php echo $c->name?>
                                                                </div>
                                                        </div>
                                                        <hr>
                                                        <p><?php echo $c->comment?></p>
                                                </div>

                                        </div>
                                 <?php }?>
                                </div>
                        </div>
                </div>
        </div>
</div>
<?php 
    require_once "inc/footer.php";
?>
<script>
 //Comment
 var frmCmt = document.getElementById("frmCmt");
 var comment_lists = document.getElementById('comment_list');
var comment_count= document.getElementById("comment_count");
 var id = 0;
var no = parseInt((comment_count.getAttribute('value')));

 frmCmt.addEventListener("submit",function(e){
        e.preventDefault();
        var data = new FormData();
        data.append("comment",(document.getElementById("commentbox").value));
        data.append("article_id",<?php echo $articles_id;?>);
        console.log(data);
        axios.post("api.php",data)
        .then(function(res){
                //console.log(res.data);
                comment_lists.innerHTML = res.data;
                no = parseInt((comment_count.getAttribute('value')));
                comment_count.setAttribute("value",(no+1));
                comment_count.innerText = no + 1;
	 })
       
})


// toastr.info("Are you the six fingered man?")
var like = document.querySelector("#like");
var like_count = document.getElementById("like_count");
console.log(like_count);

like.addEventListener("click",function(){
    console.log("like");
    var user_id = like.getAttribute("user_id");
    var article_id = like.getAttribute("article_id");
    user_id = user_id.split("");
    console.log(user_id[0]);
    axios.get(`api.php?like&article_id=${article_id}&user_id=${user_id[0]}`)
    .then(function(res){
        if(Number.isInteger(res.data)){;
            like_count.innerHTML = res.data;
        }
        else{
            alert("Already Like");
        }
    })
});
</script>