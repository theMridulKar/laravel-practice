<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('backend.category.index', compact('category'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try {

            // checking if the category already exists in database
            $category_check = Category::where('name', $request->input('name'))->first();

            if ($category_check) {
                return redirect()->back();
            }

            //=== validation ===
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:categories,name',
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
            ];

            //=== image store ===
            $image      = $request->file('image');
            $image_name = $this->upload_image_file($image, 'upload/images/category/', "category");
            // this has been come from controller function's helper function
            $inputs['image'] = $image_name;

            Category::create($inputs);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('backend.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);

            //=== validation ===
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:categories,name,' . $id,
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

            ];

            //=== image update ===
            if ($request->hasFile('image')) {
                $path = public_path() . "upload/images/category/" . $category->image;

                if (file_exists($path)) {
                    unlink($path);
                }

                $image      = $request->file('image');
                $image_name = $this->upload_image_file($image, 'upload/images/category/', "category");
                // this has been come from controller function's helper function
                $category->update(['image' => $image_name]);
            }

            $category->update($inputs);
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (file_exists('upload/images/category/' . $category->image)) {
            unlink('upload/images/category/' . $category->image);
        }

        $category->delete();
        return redirect()->back();
    }

    public function status($id)
    {
        try {
            $category = Category::find($id);

            if ($category->status == 1) {
                $category->status = 0;
            } else {
                $category->status = 1;
            }

            $category->save();
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }
}
