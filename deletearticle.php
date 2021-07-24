<?php
   require_once 'core/autoload.php';
   $request = $_GET;

    if(isset($request['delete']))
    {$id = $request['delete'];
        DB::delete("article_likes","article_id",$id);
        DB::delete("article_comments","article_id",$id);
        DB::delete("article_languages","article_id",$id);
        DB::delete("articles","id",$id);
        Helper::redirect("index.php?your_post");
    }

    else{
        echo "Not Hi";
    }
?>