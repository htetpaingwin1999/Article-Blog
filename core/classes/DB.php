

<?php

use DB as GlobalDB;

class DB{
    private static $dbh = null;
    private static $res,$data,$count,$sql;
    public function __construct()
    {
        self::$dbh = new PDO("mysql:host=localhost;dbname=blog_project",'root');
    }
    public function query(){
        self::$res = self::$dbh->prepare(self::$sql); //self :: ကုိ သုံးရတာက variable မွာ static ပါလုိ႕ 
        self::$res ->execute();
        return $this; // $this နဲ႕  return ျပန္တာက static မပါလုိ႕ ၊ ေျပာရရင္ data အကုန္ return ျပန္ေပးတာ
    }
    public function executeParameter($params =[]){
        self::$res = self::$dbh->prepare(self::$sql); //self :: ကုိ သုံးရတာက variable မွာ static ပါလုိ႕ 
        self::$res ->execute($params);
        return $this;
    }
    public function get(){
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        return self::$data;  
    }
    public function getOne(){
        self::$data = self::$res->fetch(PDO::FETCH_OBJ);
        return self::$data;
    }
    public function count(){
        self::$count = self::$res->rowCount();
        return self::$count;
    }
    public static function table($table){
        $sql = "select * from $table";
        self::$sql = $sql;
        $db = new DB();//can't use $this and create new object to get data;
        // $db->query(self::$sql); 
        return $db; // same ၄like $this but we can't use this in static function
    }
    public function orderBy($cal,$value){
        self::$sql.=" order by $cal $value";
        $this->query(self::$sql); // query ကုိဖတ္တယ္
        return $this; // $this နဲ႕  return ျပန္တာက static မပါလုိ႕ ၊ ေျပာရရင္ data အကုန္ return ျပန္ေပးတာ
    }
    public function where($col,$operator,$value=''){
        if(func_num_args() == 2){
            self::$sql.= " where $col = $operator";
        }
        else{
            self::$sql.= " where $col $operator $value";
        }
        $this->query(self::$sql);
        return $this;
    }
    public function andwhere($col,$operator,$value=''){
        if(func_num_args() == 2){
            self::$sql.= " and  $col = $operator";
        }
        else{
            self::$sql.= " and $col $operator $value";
        }
        $this->query(self::$sql);
        return $this;
    }
    public function orwhere($col,$operator,$value=''){
        if(func_num_args() == 2){
            self::$sql.= " or  $col = '$operator'";
        }
        else{
            self::$sql.= " or $col $operator '$value'";
        }
        $this->query(self::$sql);
        return $this;
    }
    public static function create($table,$data){
        // print_r(array_values($data));
        $db = new DB();
        // print_r($data);
        $str_col =implode(',',array_keys($data));
        // print_r($str_col);
        $v = "";
        $x = 1;
        foreach($data as $d){
            $v.="?";
            if($x<count($data)){
                $v.=',';
                $x++;
            }
        }
        $sql = "insert into $table($str_col) values ($v)";
        $values = array_values($data);
        self::$sql = $sql;
        // $db->executeParameter($values);
        $db->executeParameter($values);
        $id = self::$dbh->lastInsertId();
        return DB::table($table)->where('id',$id)->getOne();
    }
    public static function update($table,$data,$id){
        
        //update users set name=?,age=?,location=? where id=3;
        $db = new DB();
        $sql = "update $table set";
        $x = 1;
        $value = '';
        foreach($data as $k =>$v){
            $value.=" $k=?";
            if($x < count($data))
            {
                $value.= '='.$v.',';
                $x++;
            }
        }
        $sql.= "$value where id= $id";
        self::$sql = $sql;
        Helper::redirect("register.php?");
        // $db->query('');
        // return true;
        } 
        
        public static function delete($table,$col,$id)
        {
            $sql = "delete from $table where $col=$id";
            self::$sql = $sql;
            $db = new DB();
            $db->query('');
            return true;
        }
        public  function paginate($records_per_page,$append ='')
        {
            if(isset($_GET['page']))
            {
                $page_no = $_GET['page'];
            }
            else{
                $page_no = $_GET['page']=1;
            }
            if($_GET['page'] <1){
                $page_no = 1;
            }
            // 0,5 page 1 (1-1)*5 = 0
            // 5,5 page 2 (2-1)*5 = 5;
            // 10,5 page 3 (3-1)*5 = 10
            // 15,5 page 4 (4-1)*5 = 15
            $index = ($page_no -1)*$records_per_page;
            self::$sql.= " limit $index,$records_per_page";
            $this->query('');
            $count = self::$res->rowCount();
            self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
            $prev_no = $page_no - 1;
            $next_no = $page_no + 1;
            $prev_page='?page='.$prev_no.'&'.$append;
            $next_page='?page='.$next_no.'&'.$append;
            $data = ['data'=>self::$data,'total'=>$count,'prev_page'=>$prev_page,'next_page'=>$next_page];
            return $data;
        }
        public static function raw($sql){
            $db = new DB();
            self::$sql = $sql;
            return $db;
        }
}
// $user = DB::table("users")->orderBy('name','asc')->get();
// print_r($user);
// $user = DB::table("users")->where('id',1)->andwhere('name','like','%U%')->getOne();
// print_r($user);

// $user = DB::update('users',[
//     'name'=>'Mg Mg',
//     // 'age'=>'',
//     // 'location'=>'',
// ],3);
// $user = DB::delete('users',2);
// print_r($user);
// if(DB::delete('users',3))
// {
//     echo 'success';
// }

//$user = DB::table('users')->orderBy('id','desc')->paginate(5);
// [
//     'data'=>[],
//     'total'=>,
//     'next_page'=>,
//     'pre_page'=>,
// ]
//echo "<pre>";
?>


