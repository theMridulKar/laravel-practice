<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return view('product.index', compact('product'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        try {

            // checking if the product already exists in database
            $product_check = Product::where('name', $request->input('name'))->first();

            if ($product_check) {
                return redirect()->back();
            }

            //=== validation ===
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:products,name',
                    'price' => 'required',
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ],
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            //=== data store ===
            $inputs = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'price' => $request->input('price'),
            ];

            //=== image store ===
            $image      = $request->file('image');
            $image_name = $this->upload_image_file($image, 'upload/images/product/', "product");
            // this has been come from controller function's helper function
            $inputs['image'] = $image_name;

            Product::create($inputs);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        return view('product.edit');
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            //=== validation ===
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:products,name,' . $id,
                    'price' => 'required',
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ],
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            //=== data update ===
            $inputs = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'price' => $request->input('name'),

            ];

            //=== image update ===
            if ($request->hasFile('image')) {
                $path = public_path() . "upload/images/product/" . $product->image;

                if (file_exists($path)) {
                    unlink($path);
                }

                $image      = $request->file('image');
                $image_name = $this->upload_image_file($image, 'upload/images/product/', "product");
                // this has been come from controller function's helper function
                $product->update(['image' => $image_name]);
            }

            $product->update($inputs);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (file_exists('upload/images/product/' . $product->image)) {
            unlink('upload/images/product/' . $product->image);
        }

        $product->delete();
        return redirect()->back();
    }

    public function status($id)
    {
        try {
            $product = Product::find($id);

            if ($product->status == 1) {
                $product->status = 0;
            } else {
                $product->status = 1;
            }

            $product->save();
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }
}
