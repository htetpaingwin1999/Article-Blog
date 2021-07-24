<?php 
    require_once 'inc/header.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $article = DB::table('articles')->where('id',$id)->query()->getOne();
        $als = DB::table('article_languages')->where('article_id',$id)->query()->get();
    }
    else{
        Helper::redirect("404.php");
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $d = Post::update($_POST,$id);
        Helper::redirect("index.php?your_post");
    }
?>
 <div class="card card-dark">
        <div class="card-header">
                <h3>Update Article</h3>
        </div>
        <div class="card-body">
                <?php 
                if(isset($d) and $d == 'success'){
                    ?>
                <div class="alert alert-success">Article Update Success</div>
                    <?php
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                                <label for="" class="text-white">Enter Title</label>
                                <input type="text" name='title' class="form-control"
                                        placeholder="enter title" value="<?php echo $article->title ?>">
                        </div>
                        <div class="form-group">
                                <label for="" class="text-white">Choose Category</label>
                                <select name="category_id" id="" class="form-control">
                                        <?php 
                                        $cat = DB::table('categories')->query()->get();
                                         foreach($cat as $c){
                                             
                                        ?>
                                         <option value="<?php echo $c->id;?>" <?php if($c->id == $article->category_id){?>selected<?php }?> ><?php echo $c->name?> </option>
                                        <?php
                                             
                                         }
                                        ?>
                                       
                                        <!-- <option value="">Advance Programming</option>
                                        <option value="">Programming</option> -->
                                </select>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php 
                            $lan = DB::table('languages')->query()->get();
                            // print_r($lan);
                                foreach($lan as $l){
                                    // print_r($l);
                                    ?>
                            <span class="mr-2">
                                <?php 
                                    $checked = false;
                                    foreach($als as $al){
                                        if($al->language_id == $l->id){
                                            $checked = true;
                                        }
                                    }
                                ?>
                            <input class="form-check-input" type="checkbox"
                                    name="languageid[]" value="<?php echo $l->id?>"<?php if($checked ==true){?>checked<?php }?>>
                            <label class="form-check-label"
                                    for="inlineCheckbox1"><?php echo $l->name?></label>
                            </span>
                            <?php
                                }
                            ?>
                        </div>
                        <br><br>
                        <div class="form-group">
                                <label for="">Choose Image</label>
                                <input type="file" class="form-control" name="image">
                                <img src="./<?php echo $article->image; ?>" width="200px" height="200px"/>

                        </div>
                        <div class="form-group">
                                <label for="" class="text-white">Enter Articles</label>
                                <textarea name="description" class="form-control" id="description"
                                        cols="30" rows="10"><?php print $article->description;?></textarea>
                        </div>
                        <input type="submit" value="Create"
                                class="btn  btn-outline-warning">
                </form>
        </div>
</div>
<?php
    require_once 'inc/footer.php';
?>