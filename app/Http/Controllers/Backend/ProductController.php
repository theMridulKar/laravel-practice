<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function getProduct()
    {
        $products = Product::latest()->get();

        return DataTables::of($products)

            //=== column: Serial ===
            ->addIndexColumn()

            //=== raw column no 1: Category ID ===
            ->addColumn('category_id', function ($product) {
                return $product->category->name;
            })
           
            //=== raw column no 2: Status ===
            ->addColumn('status', function ($product) {
                $status = '';
                if ($product->status == 1) {
                    $status .= '<span class="badge badge-success">Active</span>';
                } else {
                    $status .= '<span class="badge badge-danger">Inactive</span>';
                }
                return $status;
            })

            //=== raw column no 3: Created At ===
            ->addColumn('created_at', function ($product) {
                return date('d M, Y', strToTime($product->created_at));
            })

            //=== raw column no 4: Updated At ===
            ->addColumn('updated_at', function ($product) {
                return date('d M, Y', strToTime($product->updated_at));
            })

            //=== raw column no 5: Action ===
            ->addColumn('action', function ($product) {

                $action  =
                    '<a class="btn btn-sm btn-info" href="' . route("product.edit", $product->id) . '">
                       Edit <i class="fa fa-pencil"></i>
                     </a>';

                $action .=
                    '<a class="btn btn-sm btn-danger" href="' . route("product.destroy", $product->id) . '">
                        Delete <i class="fa fa-trash"></i>
                    </a>';


                if ($product->status == 1) {
                    $action .=
                        '<a href="' . route("product.status", $product->id) . '"
                        class="btn btn-sm btn-warning style="padding: 2px;">Inactive <i class="fa fa-thumbs-o-down"></i></a> ';
                } else {
                    $action .=
                        '<a href="' . route("product.status", $product->id) . '"
                        class="btn btn-sm btn-success style="padding: 2px;">Active <i class="fa fa-thumbs-o-up"></i></a> ';
                }


                return $action;
            })

            //=== raw column no 6: Image ===
            ->addColumn('image', function ($product) {
                if ($product->image) {
                    '<img src="'.asset("upload/products/" . $product->image).'" />';
                } else {
                    '<h5>No Image</h5>';
                }
            })

            ->rawColumns(['created_at', 'updated_at', 'status', 'action', 'image', 'category_id'])
            ->make(true);

        return view('backend.product.index');
    }

    public function index(){
        $product = Product::with('category')->get();
        return view('backend.product.index', compact('product'));
    }

    public function create(){
        $category= Category::all();
        return view('backend.product.create', compact('category'));
    }

    public function store(Request $request){
        // dd($request->all());
        try {
            //=== validation ===
            $validator = Validator::make(
                $request->all(),
                [
                    'name'        => 'required',
                    'description' => 'required',
                    'category_id' => 'required',
                    'price'       => 'required',
                    'image'       => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ],
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            //=== data store ===
            $inputs = [
                'name'        => $request->input('name'),
                'slug'        => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'price'       => $request->input('price'),
                'code'        => $request->input('code'),
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


    public function edit($id){
        $product = Product::find($id);
        return view('backend.product.edit', compact('product'));
    }

    public function update(Request $request, $id){
        try {
            $product = Product::find($id);

            //=== validation ===
            $validator = Validator::make(
                $request->all(),
                [
                    'name'        => 'required',
                    'description' => 'required',
                    'category_id' => 'required',
                    'price'       => 'required',
                    'image'       => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ],
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
            }

            //=== data update ===
            $inputs = [
                'name'        => $request->input('name'),
                'slug'        => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'price'       => $request->input('price'),
                'code'        => mt_rand( 1000000000, 9999999999 ),
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
