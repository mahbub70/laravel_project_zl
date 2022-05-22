<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Category::all();
        return view('dashboard.category_list',[
            'data'=>$data,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view_info = ['title'=>'Category Add','action_url'=>'category.add'];
        return view('dashboard.category_add',[
            'view_info'=>$view_info,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $last_inserted_id ='';

        // Validation Overwrite For Unique Rule
        $request->validate([
            'name' => [Rule::unique('categories','name')],
        ],[
            'name.unique'=>'Already <strong>exists</strong>.',
        ]);

        // Safely Store Validated Information
        $validated = $request->safe()->all();;

        // Store Indivisual Values
        $category_name = $validated['name'];

        // Insert All information without imgae
        if(count($validated) > 0){
            try{
                $last_inserted_id = Category::insertGetId([
                    'name'=>$category_name,
                    'created_by'=>Auth::user()->id,
                    'created_at'=>Carbon::now(),
                ]);
            }catch(\Exception $e){
                return back()->with('faild','Information Updated Faild!');
            }
            
        }

        if($last_inserted_id != ""){
            // Image Process
            if($request->hasFile('image')){
                $image_file = $validated['image'];
                $extension = $image_file->getClientOriginalExtension();
                $new_img_name = Str::lower(preg_replace('/ /i','_',$validated['name']).'_'.$last_inserted_id.'.'.$extension);

                // Update Image to Database
                $img_updated = Category::find($last_inserted_id)->update([
                    'image'=>$new_img_name,
                ]);

                // Check Image Successfully Update or Not
                if($img_updated == true){
                    $image_file = Image::make($validated['image'])->orientate();
                    $width = $image_file->width();
                    $height = $image_file->height();

                    $resulation_break_point = [2048,2340,2730,3276,4096,6140,8192];
                    $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                    if($width > 0 && $width < 2048){
                        $new_width = $width;
                        try {
                            $image_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                    if($width > 5460 && $width <= 6140){
                        $new_width = 2048;
                        try {
                            $image_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }else{
                        for($i = 0; $i < count($resulation_break_point); $i++){
                            if($i != count($resulation_break_point) -1){
                                if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                    $new_width = ceil($width - (($width*12.5)/100));
                                    try {
                                        $image_file->resize($new_width, null, function ($constraint) {
                                            $constraint->aspectRatio();
                                        })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                                    } catch (\Exception $e) {
                                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                                    }
                                }
                            }
                        }
                        if($width > 8192){
                            $new_width = 2048;
                            try {
                                $image_file->resize($new_width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                            } catch (\Exception $e) {
                                return back()->with('faild','Image Upload <strong>Faild!</strong>');
                            }
                        }
                    }
                }else{
                    return back()->with('faild','Image Upload <strong>Faild!</strong>');
                }
            }

        }

        return back()->with('success','Information Update <strong>Success!</strong>');
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $category_id = decrypt($slug);
        $data = Category::find($category_id);
        $view_info = ['title'=>'Category Edit','action_url'=>'category.edit'];

        return view('dashboard.category_add',[
            'data'=>$data,
            'view_info'=>$view_info,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $slug)
    {
        // ID For Speacific Item Edit
        $category_id = decrypt($slug);

        // Validation Overwrite For Unique Rule
        $request->validate([
            'name' => [Rule::unique('categories','name')->ignore($category_id)],
        ],[
            'name.unique'=>'Already <strong>exists</strong>.',
        ]);
        
        // Safely Store All Validated Information
        $validated = $request->safe()->all();

        // Store Indivisual Values
        $category_name = $validated['name'];

        if(count($validated) > 0){
            try{
                $updated = Category::find($category_id)->update([
                    'name'=>$category_name,
                    'created_by'=>Auth::user()->id,
                ]);
            }catch(\Exception $e){
                return back()->with('faild','Information Updated Faild! Please Try Again.');
            }
        }

        // Update Image
        if($request->hasFile('image')){
            $image_file = $validated['image'];
            $extension = $image_file->getClientOriginalExtension();
            $new_img_name = Str::lower(preg_replace('/ /i','_',$validated['name']).'_'.$category_id.'.'.$extension);

            // Old Image Find from Database
            $old_image_db = Category::find($category_id)->image;

            // Update Image to Database
            $img_updated = Category::find($category_id)->update([
                'image'=>$new_img_name,
            ]);

            // Check Image is Properly Update is Not
            if($img_updated === true){
                // Delete Old Image from File
                if(File::exists(public_path('/dashboard_assets/images/category/').$old_image_db)){
                    $img_deleted = File::delete(public_path('/dashboard_assets/images/category/').$old_image_db);
                    if($img_deleted === true){
                        // Image Make And Move
                        $image_file = Image::make($image_file)->orientate();
                        $width = $image_file->width();
                        $height = $image_file->height();

                        $resulation_break_point = [2048,2340,2730,3276,4096,6140,8192];
                        $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                        if($width > 0 && $width < 2048){
                            $new_width = $width;
                            try {
                                $image_file->resize($new_width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                            } catch (\Exception $e) {
                                return back()->with('faild','Image Upload <strong>Faild!</strong>');
                            }
                        }
                        if($width > 5460 && $width <= 6140){
                            $new_width = 2048;
                            try {
                                $image_file->resize($new_width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                            } catch (\Exception $e) {
                                return back()->with('faild','Image Upload <strong>Faild!</strong>');
                            }
                        }else{
                            for($i = 0; $i < count($resulation_break_point); $i++){
                                if($i != count($resulation_break_point) -1){
                                    if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                        $new_width = ceil($width - (($width*12.5)/100));
                                        try {
                                            $image_file->resize($new_width, null, function ($constraint) {
                                                $constraint->aspectRatio();
                                            })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                                        } catch (\Exception $e) {
                                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                                        }
                                    }
                                }
                            }
                            if($width > 8192){
                                $new_width = 2048;
                                try {
                                    $image_file->resize($new_width, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save(public_path('/dashboard_assets/images/category/'.$new_img_name),60);
                                } catch (\Exception $e) {
                                    return back()->with('faild','Image Upload <strong>Faild!</strong>');
                                }
                            }
                        }

                    }
                }
            }else{
                return back()->with('faild','Image Upload <strong>Faild!</strong>');
            }
            
        }

    if($updated === true){
        return back()->with('success','Information <strong>Updated</strong> Successfully!');
    }

    return back()->with('faild','Something <strong>Worng!</strong> Please Try Again.');
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($encrypt_id) {
        $id = decrypt($encrypt_id);
        $get_targeted_category = Category::find($id)->firstOrFail();

        $get_items_under_this_category = Product::where('category_id',$get_targeted_category->id)->get();

        // Delete Items from product table on database 
        $delete_items_under_this_category = Product::where('category_id',$get_targeted_category->id)->delete();

        if($delete_items_under_this_category > 0) {
            // Delete items first in this category
            foreach ($get_items_under_this_category as $item) {
                $get_single_item_images = json_decode($item->images, true);
                // print_r($get_single_item_images);
                // Delete Images from resource
                foreach ($get_single_item_images as $single_image) {
                    if(File::exists(public_path('dashboard_assets/images/product/'.$single_image))) {
                        $singla_image_deleted = File::delete(public_path('dashboard_assets/images/product/'.$single_image));
                        if($singla_image_deleted !==true){
                            return back()->with('faild','Something worng! Please try again.');
                        }
                    }
                }
                $get_single_item_thumbnail = $item->thumbnail;
                // print_r($get_single_item_thumbnail);

                // Delete Images thumbnail from resource
                $folders = ['125x125','125x158','287x287'];
                foreach ($folders as $single_folder) {
                    if(File::exists(public_path('dashboard_assets/images/thumbnail/'. $single_folder .'/'.$get_single_item_thumbnail))){
                        $delete_product_thumbnail = File::delete(public_path('dashboard_assets/images/thumbnail/'. $single_folder .'/'.$get_single_item_thumbnail));
    
                        if($delete_product_thumbnail !== true){
                            return back()->with('faild','Something worng! Please try again.');
                        }
                    }
                }

            }
        } //-------------------

        // Delete Category form Databse
        $delete_category = Category::find($get_targeted_category->id)->delete();
        if($delete_category === true){
            $get_targeted_category_image_name = $get_targeted_category->image;
            if(File::exists(public_path('dashboard_assets/images/category/' . $get_targeted_category_image_name))){
                $category_image_delete = File::delete(public_path('dashboard_assets/images/category/'. $get_targeted_category_image_name));
                if($category_image_delete !== true){
                    return back()->with('faild','Something worng! Please try again.');
                }
            }
        }else{
            return back()->with('faild','Something worng! Please try again.');
        }


        return back()->with('success','Category Delete <strong>Successfully!</strong>');

    }
}
