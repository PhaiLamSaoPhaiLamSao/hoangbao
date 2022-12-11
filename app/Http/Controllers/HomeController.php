<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getProduct(){
        //Eloquent
        $products = Product::orderBy('id','desc')->limit(12)->get();

        $productCategories = ProductCategory::orderBy('name', 'desc')->get();

        // dd($productCategories);

        $productCategories = ProductCategory::orderBy('name', 'desc')->get()->filter(function ($productCategory) {
            return ($productCategory->getProducts->count() > 0);
        })->values();

        return view('frontend.home')
        ->with('productCategories', $productCategories)
        ->with('products', $products);
    }
    public function shopProductList(Request $request){
        //Cách làm lọc giá sản phẩm từ thấp tới cao và ngược lại
        $sort = $request->sort;
        $sortBy = [];
        switch($sort){
            case 0:
                $sortBy['field'] = 'id';
                $sortBy['sortBy'] = 'desc';
                break;
            case 1:
                $sortBy['field'] = 'price';
                $sortBy['sortBy'] = 'asc';
                break;
            case 2:
                $sortBy['field'] = 'price';
                $sortBy['sortBy'] = 'desc';
                break;
            default:
                $sortBy['field'] = 'id';
                $sortBy['sortBy'] = 'desc';
                break;
        };

        $min = $request->min ?? null;
        $max = $request->max ?? null;

        $category = $request->category ?? null;

        $products = Product::where('id','>','0');

        if(!is_null($min) && !is_null($max)){
            $products = Product::whereBetween('price',[$min,$max]);
        }
        if(!is_null($category) && $category != 'all'){
            $products = $products->where('category_id',$category);
        }

        $products = $products->orderBy($sortBy['field'],$sortBy['sortBy'])->paginate(6);

        $productCategories = ProductCategory::orderBy('name', 'desc')->get()->filter(function ($productCategory) {
            return ($productCategory->getProducts->count() > 0);
        })->values();

        return view('frontend.product_list',[
            'products' => $products,
            'min' => Product::min('price'),
            'max' => Product::max('price'),
            'productCategories' => $productCategories,
            'count' => $products->total()
        ]);
    }
}
