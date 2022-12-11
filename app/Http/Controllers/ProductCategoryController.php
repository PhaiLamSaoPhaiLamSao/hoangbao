<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function getCategories(){
        $productCategories = ProductCategory::orderBy('id', 'desc')->get();

        return view('admin.product_category.list')->with('datas', $productCategories);
    }

    public function getViewAddCategory(){
        return view('admin.product_category.add');
    }

    public function addProductCategory(Request $request){
        //validate gia tri nguoi dung gui len
        $request->validate(['name' => 'required|max:255']);

        //luu vao DB
        ProductCategory::create([
            'name' => $request->name
        ]);

        //redirect ve trang category list
        return redirect()->route('product_category.list')->with('success', 'Add Category Successfully !');
    }


    public function deleteCategories($id){
        $productCategory = ProductCategory::find($id);

        $productCategory->delete();
        
        return redirect()->route('product_category.list')->with('success', 'Delete Category Successfully !');
    }
}
