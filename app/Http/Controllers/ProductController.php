<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductController extends Controller
{
    public function getProduct(){
        //lay toan bo san pham
        //Eloquent


        //SELECT * FROM `products` ORDER BY `products`.`id` DESC
        $products = Product::orderBy('id','desc')->get();

        return view('admin.product.list')->with('datas', $products);
    }



    
    public function addProduct(Request $request){
    
        //validate gia tri nguoi dung gui len
        $request->validate([
            'name' => 'required|min:5|max:100',
            'price' => 'required|numeric',
            'des' => 'required',
            'qty' => 'required',
            'weight' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg,gif,svg|max:10240',
            'slug' => 'required'
            // 'category_id' => 'required'
        ]);

    
        if ($request->image) {
            //unlink("images/".$product->image);
            $imageName = uniqid() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
        }
        

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imageName ?? '',
            'des' => $request->des,
            'qty' => $request->qty,
            'weight' => $request->weight,
            'category_id' => $request->category_id,
            'slug' => $request->slug
        ]);

        return redirect()->route('product.list');
    }

    public function deleteProduct($id){
        //B1 : tim record nao tuong ung vs id nay`
        //select * from products where id = $id;
        $product = Product::find($id);
        //B2: dem product di xoa
        $product->delete();
        //B3 : redirect ve trang list
        return redirect()->route('product.list');
    }

    public function getProductDetail($id){
        //B1 : tim record nao tuong ung vs id nay`
        $product = Product::find($id);

        //Lay toan bo product category
        $productCategories = ProductCategory::all();

        return view('admin.product.edit')
        ->with('productCategories', $productCategories)
        ->with('product', $product);
    }

    public function editProduct(Request $request, $id){
        //validate gia tri nguoi dung gui len
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'des' => 'required',
            'qty' => 'required',
            'weight' => 'required',
        ]);



        // di tim product tuong ung vs id
        $product = Product::find($id);
        //ORM - object relation ship management
        $product->name = $request->name;
        $product->price = $request->price;
        $product->des = $request->des;
        $product->qty = $request->qty;
        $product->weight = $request->weight;
        $product->category_id = $request->category_id;


        
        if ($request->image) {
            $imageName = uniqid() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            unlink("images/".$product->image);

            $product->image = $imageName;
        }


        $product->save();

        // return view('admin.product.edit')
        // ->with('product', $product);
        return redirect()->route('product.edit', $product->id)->with('success', 'Edit successfully !');
        // return redirect()->route('product.edit', $product->id)->with('danger', 'Edit failed !');
    }

    public function getViewAddProduct(){
        // $productCategories = ProductCategory::orderBy('id', 'desc')->get();
        $productCategories = ProductCategory::all();
        return view('admin.product.add')->with('productCategories', $productCategories);
    }

    public function getSlug(Request $request){

        $name = $request->title;

        // $slug = implode("-", explode(" ",trim($name)));
        // $slug = Str::slug($name); 

        $slug = SlugService::createSlug(Product::class, 'slug', $request->title);
    
        return response()->json(['slug' => $slug]);
    }

    public function getProductBySlug($slug){
        //Tim product vs slug = slug nguoi dung truyen len
        //select * from products where slug = 'peter-rosenbaum';
        // $product = Product::where('slug','like', '%'.$slug.'%')->first();

        // session()->flush();
        // dd(session()->get('cart'));



        $product = Product::where('slug', $slug)->first();

// dd($product);

        if(!$product){
            return redirect()->route('home');
        }

        return view('frontend.product_detail')->with('product', $product);
    }
}



