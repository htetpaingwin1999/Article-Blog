<?php

use JetBrains\PhpStorm\Language;

class Post{
    public static function all(){
        $data = DB::table('articles')->orderBy('id','desc')->paginate(6);
        foreach($data['data'] as $k=>$d){

            $data['data'][$k]->comment_count = DB::table('article_comments')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_likes')->where('article_id',$d->id)->count();
        }
        return $data;
    }
    public static function none(){
        $data = DB::table('')->orderBy('id','desc');
        return $data;
    }

    public static function yourPost(){

        $data = DB::raw("select * from articles where user_id=".User::auth()->id)->paginate(6);
        foreach($data['data'] as $k=>$d){

            $data['data'][$k]->comment_count = DB::table('article_comments')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_likes')->where('article_id',$d->id)->count();
        }
        return $data;
    }
    public static function detail($id){//we have used $slug before

        $data = DB::table('articles')->where('id',$id)->getOne();
        $data->languages = DB::raw("select l.id,l.slug,l.name from article_languages as al left join languages as l on al.language_id=l.id where al.article_id=".$id)->query()->get();
        $data->comments = DB::raw("select ac.comment,u.name,u.image from article_comments as ac join users as u on ac.user_id=u.id where ac.article_id=".$id)->query()->get();
        $data->category = DB::table("categories")->where("id",$data->category_id)->query()->getOne();
        $data->comment_count = DB::table('article_comments')->where('article_id',$id)->count();
        $data->like_count = DB::table('article_likes')->where('article_id',$id)->count();

        return $data;
    }

    public static function articleByCategory($id){
        // $category_id = DB::table('categories')->where('id',$id)->getOne()->id;
        $data = DB::table('articles')->where('category_id',$id)->orderBy('id','desc')->paginate(6,'category='.$id);
        foreach($data['data'] as $k=>$d){

            $data['data'][$k]->comment_count = DB::table('article_comments')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_likes')->where('article_id',$d->id)->count();
        }
        return $data;
    }
    public static function articleByLanguage($id){
        $data = DB::raw("select * from article_languages as al join articles as a on al.article_id=a.id join languages as l on al.language_id=l.id where l.id=".$id)->orderBy('a.id','desc')->paginate(6,'language='.$id);
        foreach($data['data'] as $k=>$d){

            $data['data'][$k]->comment_count = DB::table('article_comments')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_likes')->where('article_id',$d->id)->count();
        }
        return $data;
    }
    public static function create($request)
    {
        //image upload
        
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $path = "assets/article/$image_name";
        $tmp_name = $image['tmp_name'];
        if(move_uploaded_file($tmp_name,$path))
        {
           $article = DB::create("articles",[
                'user_id'=>User::auth()->id,
                'category_id'=>$request['category_id'],
                'slug'=>Helper::slug($request['title']),
                'title'=>$request['title'],
                'image'=>$path,
                'description'=>$request['description']
            ]);
            if($article){
                foreach($request['languageid'] as $id){
                    DB::create('article_languages',[
                        'article_id'=>$article->id,
                        'language_id'=>$id
                    ]);
                }
                return 'success';
            }
            else{
                return 'false';
            }
        }
        else{
            return false;
        }
    }

    public static function update($request,$article_id)
    {
        //image upload
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $path = "assets/article/$image_name";
        $tmp_name = $image['tmp_name'];
        if($_FILES['image']['tmp_name'] != '')
        {
            DB::raw("update articles set image='".$path."' where id='".$article_id."'")->query('');
            move_uploaded_file($tmp_name,$path);
        }
        //    $article =DB::raw("update articles set category_id='".$request['category_id']."',slug='".Helper::slug($request['title'])."',title='".$request['title']."',image='".$path."',descriptioon='".$request['description']."' where id='"+$id+".")->query();
        DB::raw("update articles set category_id='".$request['category_id']."' where id='".$article_id."'")->query('');
        DB::raw("update articles set description='".$request['description']."' where id='".$article_id."'")->query('');
        DB::raw("update articles set title='".$request['title']."' where id='".$article_id."'")->query('');
        DB::raw("update articles set slug='".Helper::slug($request['title'])."' where id='".$article_id."'")->query('');

        DB::raw("delete from article_languages where article_id='".$article_id."'")->query();
        if(isset($request['languageid']))
        {
        foreach($request['languageid'] as $id){
            DB::create('article_languages',[
                'article_id'=>$article_id,
                'language_id'=>$id
            ]);
        }        
        }
    }

    public static function remove($article_id)
    {
        //image upload
        DB::raw("delete from articles where id='".$article_id."'")->query();
        return 'success';
    }
    
    public static function search($search)
    {
        // $data = DB::table("articles")->where('title','like','%'.$search.'%')->orderBy('id','desc')->query()->paginate(6,'search='.$search);
        $data = DB::raw("select * from articles where title like '%".$search."%' order by id desc")->query()->paginate(6,"search=".$search);
        foreach($data['data'] as $k=>$d){

            $data['data'][$k]->comment_count = DB::table('article_comments')->where('article_id',$d->id)->count();
            $data['data'][$k]->like_count = DB::table('article_likes')->where('article_id',$d->id)->count();
        }
        return $data;
    }
   
}

?>