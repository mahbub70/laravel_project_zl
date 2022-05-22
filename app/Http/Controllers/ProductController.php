<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  Product::orderBy('id','desc')->paginate(10);
        return view('dashboard.product_list',[
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
        $data = Category::all('id','name');
        return view('dashboard.product_add',[
            'data'=>$data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        // Store Validated Information 
        $validated = $request->safe()->all();
        $validated['created_by'] = Auth::user()->id;
        $validated['created_at'] = Carbon::now()->toDateTimeString();
        $validated['status'] = 1;
        if($validated['phone'] == 'on'){
            $validated['phone'] = BusinessProfile::first()->phone;
        }else {
            $validated['phone'] = "";
        }

        // Make Product Unique Code
        if(!empty(Product::count())){
            $table_id = Product::orderBy('id','desc')->first()->id + 1;
        }else{
            $table_id = 1;
        }
        $unique_product_code = 'p-'. rand(1000,9999).$table_id;
        $validated['product_code'] = $unique_product_code;

        // Make Array Without Image
        $info_withoutImage = [];
        foreach($validated as $key=>$item){
            if($key != 'image'){
                $info_withoutImage[$key] = $item;
            }
        }

        // information update to database
        if(count($info_withoutImage) > 0){
            try{
                $last_inserted_id = Product::insertGetId(
                    $info_withoutImage,
                );
            }catch(\Exception $e){
                return back()->with('faild','Information Updated Faild!');
            }
        }

        if($request->hasFile('image')){
            $images = $validated['image'];
            $images_array = [];

            foreach($images as $key=>$image){
                $single_img_file = Image::make($image)->orientate();
                $image_extension = $image->getClientOriginalExtension();
                $image_new_name = Str::lower(preg_replace('/ /i','_',$validated['title']).'_'. $last_inserted_id .'_'.$key + 1 .'.'.$image_extension);

                // Make Product Thimbnail
                if($key == 0){
                    $thumb_image_file = Image::make($image)->orientate();
                    $thumb_img_name = Str::lower('thumbnail_'.preg_replace('/ /i','_',$validated['title']).'_'. $last_inserted_id . '_' . $key + 1 . '.' . $image_extension);

                    // Update Thumbnail to database
                    $thumb_update = Product::find($last_inserted_id)->update([
                        'thumbnail'=>$thumb_img_name,
                    ]);

                    // Thumbnail Resizing
                    if($thumb_update === true){
                        // Resize width 287px & Height 287px
                        try{
                            $thumb_image_file->fit(287)->save(public_path('/dashboard_assets/images/thumbnail/287x287/'.$thumb_img_name));
                        }catch(\Exception $e){
                            return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                        }
                        // Resize width 125px & Height 125px
                        try{
                            $thumb_image_file->fit(125)->save(public_path('/dashboard_assets/images/thumbnail/125x125/'.$thumb_img_name));
                        }catch(\Exception $e){
                            return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                        }
                        // Resize width 115px & Height 158px
                        try{
                            $thumb_image_file->fit(125,158)->save(public_path('/dashboard_assets/images/thumbnail/125x158/'.$thumb_img_name));
                        }catch(\Exception $e){
                            return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                        }
                    }
                }//------------------------------------------

                // Images new Name Store in an array
                $images_array['image_'.$key + 1] = $image_new_name;

                // Update Images to Database
                $images_updated = Product::find($last_inserted_id)->update([
                    'images'=> json_encode($images_array),
                ]);

                // If Image Update success in Database
                if($images_updated === true){
                    $width = $single_img_file->width();
                    $height = $single_img_file->height();

                    $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                    $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                    // Dynamically Image Resizing & Move to Targeted folder
                    if($width > 0 && $width < 2048){
                        $new_width = $width;
                        try {
                            $single_img_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/product/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                    if($width > 5460 && $width <= 6140){
                        $new_width = 2048;
                        try {
                            $single_img_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/product/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }else{
                        for($i = 0; $i < count($resulation_break_point); $i++){
                            if($i != count($resulation_break_point) -1){
                                if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                    $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                    try {
                                        $single_img_file->resize($new_width, null, function ($constraint) {
                                            $constraint->aspectRatio();
                                        })->save(public_path('/dashboard_assets/images/product/'.$image_new_name),70);
                                    } catch (\Exception $e) {
                                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                                    }
                                }
                            }
                        }
                        if($width > 8192){
                            $new_width = 2048;
                            try {
                                $single_img_file->resize($new_width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->save(public_path('/dashboard_assets/images/product/'.$image_new_name),70);
                            } catch (\Exception $e) {
                                return back()->with('faild','Image Upload <strong>Faild!</strong>');
                            }
                        }
                    }
                }else{
                    return back()->with('faild','Image Upload <strong>Unsuccessfull!</strong>');
                }

                if($key == 4){
                    break;
                }

            }
        }

        return back()->with('success','Product Added <strong>Successfully!</strong>');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_code)
    {
        $data = Product::where('product_code',$product_code)->first();
        return view('dashboard.product_details',[
            'data'=>$data,
        ]);
    }

    /**
     * Update Specific Product Status (Sold or Available).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productStatusUpdate($product_code){
        $get_product = Product::where('product_code',$product_code)->first();
        if($get_product->status != 1){
            $updated = Product::find($get_product->id)->update([
                'status'=>'1',
            ]);
        }else{
            $updated = Product::find($get_product->id)->update([
                'status'=>'0',
            ]);
        }
        if($updated === true){
            return back()->with('success','Product status update <strong>success!</strong>');
        }
    }

    /**
     * Delete Specific Product with all information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productDelete($product_id){
        $thumb_deleted = "";
        $id = decrypt($product_id);
        $product_info = Product::find($id);
        $product_images = json_decode($product_info->images, true);
        $thumb_image_name = $product_info->thumbnail;
        $deleted = $product_info->delete();
        if($deleted === true){
            // Delete Product Thumbnails
            $thumbnail_folders = ['287x287','125x125','125x158'];
            foreach($thumbnail_folders as $key=>$folder){
                if(File::exists(public_path('/dashboard_assets/images/thumbnail/' . $thumbnail_folders[$key] . '/' . $thumb_image_name))){
                    $thumb_deleted = File::delete(public_path('/dashboard_assets/images/thumbnail/' . $thumbnail_folders[$key] . '/' . $thumb_image_name));
                }
            }
            if($thumb_deleted === true){
                foreach($product_images as $image){
                    if(File::exists(public_path('/dashboard_assets/images/product/'.$image))){
                        $image_deleted = File::delete(public_path('/dashboard_assets/images/product/'.$image));
                        if($image_deleted != true){
                            return back()->with('faild','Something worng! Please try again.');
                        }
                    }
                }
            }else{
                return back()->with('faild','Something worng! Please try again.');
            }
        }else{
            return back()->with('faild','Something worng! Please try again.');
        }

        return back()->with('success','Product Delete <strong>Successfully!</strong>');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product_code)
    {
        $data = Product::where('product_code',$product_code)->first();
        return view('dashboard.product_edit',[
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_code)
    {
        $target_product_info = Product::where('product_code',$product_code)->first();
        // Validation for Edit Item
        $validator = Validator::make($request->all(),[
            'brand'=>'bail|required|alpha|max:30',
            'model'=>'bail|required|max:50',
            'title'=>'bail|required|max:100',
            'color'=>'bail|alpha_space_comma|max:100',
            'description'=>'bail|required|max:5000',
            'price'=>'bail|required|numeric|digits_between:0,11',
            'image.*'=>'mimes:png,jpg,jpeg,svg',
            'phone'=>'nullable',
            'discount'=>'bail|nullable|numeric|digits_between:0,100',
            'position' => 'nullable|numeric',
            'optional_phone'=>'bail|nullable|numeric|digits_between:11,11',
            'deleted_images'=>'nullable',
        ],[
            'brand.required'=>'Please enter product <strong>brand</strong>.',
            'brand.alpha'=>'Brand is <strong>not valid</strong>.',
            'brand.max'=>'Brand contains <strong>maximam 30 characters.</strong>',
            'model.required'=>'Please enter product <strong>model</strong>.',
            'model.max'=>'Model contains <strong>maximam 50 characters</strong>.',
            'title.required'=>'Please enter your <strong>title</strong>.',
            'title.max'=>'Title contains <strong>maximam 100 characters</strong>.',
            'color.alpha_space_comma'=>'Multiple color seperated by <strong>comma</strong>.',
            'color.max'=>'Color contains <strong>maximam 100 characters</strong>.',
            'description.required'=>'Please enter product <strong>description</strong>.',
            'description.max'=>'Description contains <strong>maximam 5000 characters</strong>.',
            'price.required'=>'Plese enter product <strong>price</strong>.',
            'price.numeric'=>'This price is <strong>not valid</strong>.',
            'price.digits_between'=>'Price contains <strong>maximam 11 digits</strong>.',
            'image.*.mimes'=>'Image must be type of <strong>jpg,jpeg,png,svg</strong>.',
            'discount.numeric'=>'Discount is <strong>not valid</strong>.',
            'discount.digits_between'=>'Discount is <strong>not valid</strong>.',
            'position.numeric' => 'Please enter valid <strong>position</strong>.',
            'optional_phone.numeric'=>'This phone number is <strong>not valid</strong>.',
            'optional_phone.digits_between'=>'This phone number is <strong>not valid</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        // Store Information after validation
        $validated = $validator->safe()->all();
        if($validated['phone'] == 'on'){
            $validated['phone'] = BusinessProfile::first()->phone;
        }else {
            $validated['phone'] = "";
        }

        // Make Deleted Images Array
        $deleted_images_str = $validated['deleted_images'];
        $deleted_images = [];
        if($deleted_images_str != ""){
            $deleted_images = explode(',',$deleted_images_str);
        }

        // Database stored images
        $available_images = json_decode(Product::where('product_code',$product_code)->first()->images, true);

        // If all old images deleted & new image not selected
        if(count($available_images) == count($deleted_images)){
            if(!$request->hasFile('image')){
                $validator->errors()->add('image', 'Please select minumum <strong>1</strong> new image.');
                return back()->withErrors($validator)->withInput();
            }
        }

        // get deleted image file name
        $deleted_image_name = [];
        // Delete Image from 
        foreach($deleted_images as $key=>$item){
            foreach($available_images as $db_key=>$db_item){
                if($item == $db_key){
                    $deleted_image_name[$item] = $db_item; 
                    unset($available_images[$item]);
                }
            }
        }

        $get_images_db = json_decode(Product::where('product_code',$product_code)->first()->images, true);
        // Image array ready to update with new key for old images
        $images_ready_to_update = [];
        $image_array_key_loop = 1;

        // Check Old thumbnail image is delete or not
        if(in_array(array_key_first($get_images_db),$deleted_images)){
            // Get Image Thumbnail form database
            $product_old_thumbnail = Product::where('product_code',$product_code)->first()->thumbnail;

            // delete old thumbnail from all of location
            $thumbnail_folders = ['287x287','125x125','125x158'];
            foreach($thumbnail_folders as $folder){
                if(File::exists(public_path('/dashboard_assets/images/thumbnail/' . $folder . '/' . $product_old_thumbnail))){
                    $thumbnail_delete = File::delete(public_path('/dashboard_assets/images/thumbnail/' . $folder . '/' . $product_old_thumbnail));
                    if($thumbnail_delete != true){
                        return back()->with('faild','Something wrong! Please try again.');
                    }
                }
            }

            // Take new thumbnail image from form input if available
            if($request->hasFile('image')){
                // take first image from input
                $new_thumb_image = Image::make($validated['image'][0])->orientate();
                $image_extension = $validated['image'][0]->getClientOriginalExtension();
                $new_thumb_img_name = Str::lower('thumbnail_'.preg_replace('/ /i','_',$validated['title']).'_'. $target_product_info->id . '_' . 1 . '.' . $image_extension);

                // Update new thumbnail to database
                $new_thumb_update = Product::find($target_product_info->id)->update([
                    'thumbnail'=>$new_thumb_img_name,
                ]);

                if($new_thumb_update === true){
                    // Ready Space for first image
                    $images_ready_to_update['image_'.$image_array_key_loop] = "";
                    $image_array_key_loop++;

                    // Resize width 287px & Height 287px
                    try{
                        $new_thumb_image->fit(287)->save(public_path('/dashboard_assets/images/thumbnail/287x287/'.$new_thumb_img_name));
                    }catch(\Exception $e){
                        return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                    }
                    // Resize width 125px & Height 125px
                    try{
                        $new_thumb_image->fit(125)->save(public_path('/dashboard_assets/images/thumbnail/125x125/'.$new_thumb_img_name));
                    }catch(\Exception $e){
                        return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                    }
                    // Resize width 115px & Height 158px
                    try{
                        $new_thumb_image->fit(125,158)->save(public_path('/dashboard_assets/images/thumbnail/125x158/'.$new_thumb_img_name));
                    }catch(\Exception $e){
                        return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                    }
                }else{
                    return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                }
                
            }else{
                // make dynamic thumbnail from existing old image
                $first_old_img = array_values($available_images)[0];
                $dynamic_thumb_image_file = Image::make(public_path('/dashboard_assets/images/product/'.$first_old_img))->orientate();
                $dynamic_thumb_image_extension = $dynamic_thumb_image_file->extension;
                $dynamic_thumb_image_name =  Str::lower('thumbnail_'.preg_replace('/ /i','_',$validated['title']).'_'. $target_product_info->id . '_' . 1 . '.' . $dynamic_thumb_image_extension);

                // Dynamic image thumbnail update to database
                $dynamic_thumb_update = Product::find($target_product_info->id)->update([
                    'thumbnail'=>$dynamic_thumb_image_name,
                ]);

                if($dynamic_thumb_update === true){
                    // Resize width 287px & Height 287px
                    try{
                        $dynamic_thumb_image_file->fit(287)->save(public_path('/dashboard_assets/images/thumbnail/287x287/'.$dynamic_thumb_image_name));
                    }catch(\Exception $e){
                        return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                    }
                    // Resize width 125px & Height 125px
                    try{
                        $dynamic_thumb_image_file->fit(125)->save(public_path('/dashboard_assets/images/thumbnail/125x125/'.$dynamic_thumb_image_name));
                    }catch(\Exception $e){
                        return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                    }
                    // Resize width 115px & Height 158px
                    try{
                        $dynamic_thumb_image_file->fit(125,158)->save(public_path('/dashboard_assets/images/thumbnail/125x158/'.$dynamic_thumb_image_name));
                    }catch(\Exception $e){
                        return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                    }
                }else{
                    return back()->with('faild','<strong>Something worng!</strong> Please try again.');
                } 

            }
        }

        // Available Images Ready to Update
        foreach($available_images as $single_image){
            $images_ready_to_update['image_'.$image_array_key_loop] = $single_image;
            $image_array_key_loop++;
        }

        // Deleted Image From Location
        foreach($deleted_image_name as $image){
            if(File::exists(public_path('/dashboard_assets/images/product/'.$image))){
                $deleted = File::delete(public_path('/dashboard_assets/images/product/'.$image));
                if($deleted != true){
                    return back()->with('faild','Something wrong! Please try again.');
                }
            }
        }
    
        // Now Handle Form Input Images
        if($request->hasFile('image')){
            $input_images = $validated['image'];

            foreach($input_images as $key=>$item){
                // Loop run throw already available images
                if($key >= 5 - count($available_images)){
                    break;
                }
                $new_image_file = Image::make($item)->orientate();
                $new_image_extension = $item->getClientOriginalExtension();
                $new_image_name = Str::lower(preg_replace('/ /i','_',$validated['title']).'_'. $target_product_info->id .'_'.$key .'.'.$new_image_extension);

                for($i = 1; in_array($new_image_name,$images_ready_to_update); $i++){
                    $new_image_name = Str::lower(preg_replace('/ /i','_',$validated['title']).'_'. $target_product_info->id .'_'.$i .'.'.$new_image_extension);
                }
                
                if($key == 0){
                    if(in_array(array_key_first($get_images_db),$deleted_images)){
                        $images_ready_to_update['image_'.$key+1] = $new_image_name;
                    }else{
                        $images_ready_to_update['image_'. $image_array_key_loop] = $new_image_name;
                    }
                }else{
                    $images_ready_to_update['image_'. $image_array_key_loop] = $new_image_name;
                } 
                // Asigning new image form input to this array with key
                
                // Finally Update all final images to database if input field has minimum one image
                $images_updated = Product::find($target_product_info->id)->update([
                    'images'=>json_encode($images_ready_to_update),
                ]);

                // If Image Update success in 
                if($images_updated === true){
                    $width = $new_image_file->width();

                    $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                    $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                    // Dynamically Image Resizing & Move to Targeted folder
                    if($width > 0 && $width < 2048){
                        $new_width = $width;
                        try {
                            $new_image_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/product/'.$new_image_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                    if($width > 5460 && $width <= 6140){
                        $new_width = 2048;
                        try {
                            $new_image_file->resize($new_width, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(public_path('/dashboard_assets/images/product/'.$new_image_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }else{
                        for($i = 0; $i < count($resulation_break_point); $i++){
                            if($i != count($resulation_break_point) -1){
                                if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                    $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                    try {
                                        $new_image_file->resize($new_width, null, function ($constraint) {
                                            $constraint->aspectRatio();
                                        })->save(public_path('/dashboard_assets/images/product/'.$new_image_name),70);
                                    } catch (\Exception $e) {
                                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                                    }
                                }
                            }
                        }
                        if($width > 8192){
                            $new_width = 2048;
                            try {
                                $new_image_file->resize($new_width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->save(public_path('/dashboard_assets/images/product/'.$new_image_name),70);
                            } catch (\Exception $e) {
                                return back()->with('faild','Image Upload <strong>Faild!</strong>');
                            }
                        }
                    }
                }else{
                    return back()->with('faild','Image Upload <strong>Unsuccessfull!</strong>');
                }

                $image_array_key_loop++;

            }

        }else{
            // Update without mew input image
            $images_updated = Product::find($target_product_info->id)->update([
                'images'=> json_encode($images_ready_to_update),
            ]);
            
            if($images_updated != true){
                return back()->with('faild','Something wrong! Please try again.');
            }
        }

        // Update another form information
        foreach($validated as $key=>$item){
            $updated = Product::find($target_product_info->id)->update([
                $key => $item,
            ]);
            if($updated != true){
                return back()->with('faild','Something wrong! Please try again.');
            }
        }

        return back()->with('success','Information <strong></strong>');

    }

    /**
     * Show All Product List.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_inventory_list(){
        $data = Product::orderBy('id','desc')->get();
        return view('dashboard.inventory',[
            'data'=>$data,
        ]);
    }


    /**
     * Show Only Stock Available Product List.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_stock_list(){
        $data = Product::where('status', 1)->orderBy('id','desc')->get();

        return view('dashboard.stock_list' , [
            'data' => $data,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}