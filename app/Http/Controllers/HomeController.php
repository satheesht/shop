<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use File;
use Redirect;
 
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories');
    }

    /*
    | Adding new child to the category
    */
    public function newCategoryChild(Request $data){
        DB::select("call tree_add_node(".$data->input("nodeId").",'".$data->input("childName")."',NULL,NULL);");
    }

    /*
    | Removing a child from the category list
    */
    public function removeChild(Request $data){
        DB::select("call tree_del(".$data->input("nodeId").");");
    }


    /**
     * Show the application categories.
     */
     public function categories()
     {
        $query = DB::select("SELECT node.category_id,node.name, (COUNT(parent.category_id) - 1) AS depth
        FROM categories AS node
        CROSS JOIN categories AS parent
        WHERE node.lft BETWEEN parent.lft AND parent.rht
        GROUP BY node.category_id
        ORDER BY node.lft");
        $tree = array();
        foreach($query as $val){
           $tree[] = (array)$val;
        }

        // bootstrap loop
       $result = '';
       $currDepth = -1;  // -1 to get the outer <ul>
       //$result.='<ul> <li><a href="#">Tree</a>';
       while (!empty($tree)) {
       $currNode = array_shift($tree);
       // Level down?
       
       if ($currNode['depth'] > $currDepth) {
           // Yes, open <ul>
           $result .= '<ul>';
       }
       // Level up?
       if ($currNode['depth'] < $currDepth) {
           // Yes, close n open <ul>
           $result .= str_repeat('</ul>', $currDepth - $currNode['depth']);
       }
       // Always add node
       $result .= '<li><a href="#">' . $currNode['name'] . '</a> 
       <span class="badge badge-danger removeChild" data-name="'.$currNode['name'].'" data-id="'.$currNode['category_id'].'"><i class="fa fa-trash" aria-hidden="true"></i></span> 
       <span class="badge addChild badge-success" data-id="'.$currNode['category_id'].'" data-toggle="modal" data-target="#form"><i class="fa fa-plus" aria-hidden="true"></i> Add child</span> </li>';
       // Adjust current depth
       $currDepth = $currNode['depth'];
       // Are we finished?
       if (empty($tree)) {
           // Yes, close n open <ul>
           $result .= str_repeat('</ul>', $currDepth + 1);
       }
       
       }

       $result .=  '</ul>';
        
       return view('categories',compact("result"));
     }



     public function dashboard(Request $data)
     {
        
        $qry = '';
        if($data->category){ 
            $qry = "WHERE b.name like '%".addslashes($data->category)."%'";
        }else if($data->attribute){

        }else if($data->search){
            $qry = "WHERE a.title like '%".addslashes($data->search)."%'";
        }
        $search     = $data->search;
        $category   = $data->category;
        $categories = DB::select("SELECT name,category_id FROM categories");
        $attributes = DB::select("SELECT a.attribute_id as id,a.description,a.title as name,b.name as category FROM attributes a left join categories b on a.category=b.category_id");
        $products = DB::select("SELECT a.*,b.name as category FROM products a LEFT JOIN categories b on b.category_id=a.category $qry");
        return view('dashboard',compact("categories","attributes","products","search","category"));
     }

    /**
     * Show the attributes page.
     */
    public function attributes()
    {
        $categories = DB::select("SELECT name,category_id FROM categories");
        $attributes = DB::select("SELECT a.attribute_id as id,a.description,a.title,b.name as category FROM attributes a left join categories b on a.category=b.category_id");
        
        return view('attributes',compact("categories","attributes"));
    }

    public function addNewAttribute(Request $data){
        DB::select("INSERT INTO attributes(title,category,description)VALUES('$data->name','$data->category','$data->description')");
    }

    public function removeAttribute(Request $data){
        DB::select("DELETE from attributes WHERE attribute_id='$data->id'");
    }

    /**
     * Show the attributes page.
     */
     public function products()
     {
         $categories = DB::select("SELECT name,category_id FROM categories");
         $attributes = DB::select("SELECT a.attribute_id as id,a.description,a.title as name,b.name as category FROM attributes a left join categories b on a.category=b.category_id");
         $products = DB::select("SELECT a.*,b.name as category FROM products a LEFT JOIN categories b on b.category_id=a.category");
         return view('products',compact("categories","attributes","products"));
     }

     public function addNew(Request $data){

        $file = $data->file("image");
        $extension = $file->getClientOriginalExtension();
        $image = uniqid().'.'.$extension;
        Storage::disk('local')->put($image,  File::get($file));

        $id = DB::table("products")->insertGetId([
             "title"=>$data->input("name"),
             "model"=>$data->input("model"),
             "category"=>$data->input("category"),
             "description"=>$data->input("description"),
             "price"=>$data->input("price"),
             "status"=>$data->input("status"),
             "quantity"=>$data->input("quantity"),
             "image"=>$image
         ]);
        if(is_array($data->input("attribute"))){
            foreach($data->input("attribute") as $rec){
                $pairs [] = ["product"=>$id,"attribute"=>$rec];
            }
        }else{
            $pairs [] = ["product"=>$id,"attribute"=>$data->input("attribute")];
        }
         DB::table("product_attributes")->insert($pairs );
         return Redirect::route('products');
     }

     public function remove(Request $data){
        $data = $data->input("product_id");
        DB::select("DELETE from products WHERE product_id='$data'");
     }
    
}
