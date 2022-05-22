<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\BusinessProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\AboutUsGallery;

class BusinessController extends Controller
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
     * Show Business Profile Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function business_profile()
    {
        $data = BusinessProfile::first();
        return view('dashboard.business_profile',[
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function business_profile_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'company_name' => 'string',
            'email' => 'email',
            'phone' => 'numeric',
            'address' => 'max:255',
            'website'=>'nullable',
            'facebook_link' => 'nullable',
            'twitter_link' => 'nullable',
            'youtube_link' => 'nullable',
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        // Information store
        $validated = $validator->safe()->all();
        $validated['created_at'] = Carbon::now();
        
        if(count($validated) > 0){
            if(BusinessProfile::first() != null){
                $info_updated = BusinessProfile::find(1)->update(
                    $validated,
                );
            }else {
                $info_updated = BusinessProfile::insert([
                    $validated,
                ]);
            }
        }

        if($info_updated === false) {
            return back()->with('faild','Something wrong! Please try again.');
        }

        return back()->with('success','Business Profile <strong>Updated!</strong>');

    }

    /**
     * Add Company Logo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logo_add(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg,svg',
        ],[
            'image.required' => 'Please select your <strong>logo</strong>.',
            'image.mimes' => 'Image must be type of <strong>jpg, jpeg, png, svg</strong>.'
        ]);

        // Update Image to database
        if($request->hasFile('image')){
            $image_file = Image::make($validated['image'])->orientate();
            $extension = $validated['image']->getClientOriginalExtension();
            $database_info = BusinessProfile::firstOrFail();
            $new_image_name = Str::lower('logo_'. uniqid() . '_' . $database_info->id . '.' . $extension);

            // Update Image to Database
            $logo_updated = BusinessProfile::find($database_info->id)->update([
                'image' => $new_image_name,
            ]);
            
            if($logo_updated === true){
                // Image Resizing Processing Start
                $width = $image_file->width();
                $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                // Dynamically Image Resizing & Move to Targeted folder
                if($width > 0 && $width < 2048){
                    $new_width = $width;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/logo/'.$new_image_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/logo/'.$new_image_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }else{
                    for($i = 0; $i < count($resulation_break_point); $i++){
                        if($i != count($resulation_break_point) -1){
                            if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                try {
                                    $image_file->resize($new_width, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save(public_path('/dashboard_assets/images/logo/'.$new_image_name),70);
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
                            })->save(public_path('/dashboard_assets/images/logo/'.$new_image_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else{
                return back()->with('faild','Something Worng! Please try again.');
            }
        }

        return back()->with('success','Logo updated <strong>Success!</strong>');
    }

    /**
     * Show Brand Page in Business page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function business_brands()
    {
        $data = Brand::all();
        return view('dashboard.brands',[
            'data' => $data,
        ]);
    }

    /**
     * Add New Brand.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brand_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,svg,jpeg',
        ],[
            'image.required' => 'Please Select <strong>Image</strong>.',
            'image.mimes' => 'Image must be type of <strong>jpg, jpeg, png, svg</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }
        $validated = $validator->safe()->all();

        if(count($validated) > 0){
            try{
                $last_insert_id = Brand::insertGetId([
                    'created_at' => Carbon::now(),
                ]); 
            }catch(\Exception $e){
                return back()->with('faild','Something worng! Please try again.');
            }
            
        }

        // Image update
        if($request->hasFile('image')){
            $image_file = Image::make($validated['image'])->orientate();
            $extension = $validated['image']->getClientOriginalExtension();
            $image_new_name = Str::lower('promo_banner_'. uniqid(). '_' . $last_insert_id . "." . $extension);

            // udpate image to database
            $banner_image_updated = Brand::find($last_insert_id)->update([
                'image' => $image_new_name,
            ]);

            if($banner_image_updated === true){
                // Image Resizing Processing Start
                $width = $image_file->width();
                $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                // Dynamically Image Resizing & Move to Targeted folder
                if($width > 0 && $width < 2048){
                    $new_width = $width;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/brand/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/brand/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }else{
                    for($i = 0; $i < count($resulation_break_point); $i++){
                        if($i != count($resulation_break_point) -1){
                            if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                try {
                                    $image_file->resize($new_width, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save(public_path('/dashboard_assets/images/brand/'.$image_new_name),70);
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
                            })->save(public_path('/dashboard_assets/images/brand/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else {
                return back()->with('faild','Something worng! Please try again.');
            }
        }

        return back()->with('success','Banner Image Added <strong>Success!</strong>.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function brand_delete($encrypt_id)
    {
        $id = decrypt($encrypt_id);

        // Get Selected Banner Item image name
        $banner_image_from_db = Brand::find($id)->image;
        
        $banner_deleted = Brand::find($id)->delete();
        if($banner_deleted !== true) {
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }
        $deleted_image_from_directory = File::delete(public_path('/dashboard_assets/images/brand/'.$banner_image_from_db));
        if($deleted_image_from_directory !== true){
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }

        return back()->with('success','Slider Deleted <strong></strong>.');
    }


    // Show About US Information Page
    public function show_about_us(){
        $data = AboutUs::orderBy('id','desc')->get();
        return view('dashboard.about_us',[
            'data' => $data,
        ]);
    }
    // Add information About Us 
    public function add_about_us(Request $request){
        $validator = Validator::make($request->all(),[
            'about_text' => 'required',
            'image' => '|mimes:png,jpg,jpeg,svg',
        ],[
            'about_text.required' => 'Please enter your <strong>about text</strong>.',
            'image.mimes'=> 'Image must be type of <strong>jpg, jpeg, png, svg</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }
        $validated = $validator->safe()->all();

        if(count($validated) > 0){
            try{
                $last_insert_id = AboutUs::insertGetId([
                    'about_text' => $validated['about_text'],
                    'created_at' => Carbon::now(),
                ]); 
            }catch(\Exception $e){
                return back()->with('faild','Something worng! Please try again.');
            }
            
        }

        // Image update
        if($request->hasFile('image')){
            $image_file = Image::make($validated['image'])->orientate();
            $extension = $validated['image']->getClientOriginalExtension();
            $image_new_name = Str::lower('about_image'. uniqid(). '_' . $last_insert_id . "." . $extension);

            // udpate image to database
            $banner_image_updated = AboutUs::find($last_insert_id)->update([
                'image' => $image_new_name,
            ]);

            if($banner_image_updated === true){
                // Image Resizing Processing Start
                $width = $image_file->width();
                $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                // Dynamically Image Resizing & Move to Targeted folder
                if($width > 0 && $width < 2048){
                    $new_width = $width;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/about_us/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/about_us/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }else{
                    for($i = 0; $i < count($resulation_break_point); $i++){
                        if($i != count($resulation_break_point) -1){
                            if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                try {
                                    $image_file->resize($new_width, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save(public_path('/dashboard_assets/images/about_us/'.$image_new_name),70);
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
                            })->save(public_path('/dashboard_assets/images/about_us/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else {
                return back()->with('faild','Something worng! Please try again.');
            }
        }

        return back()->with('success','Banner Image Added <strong>Success!</strong>.');
    }

    // Delete About Us 
    public function delete_about_us($encrypt_id){
        $id = decrypt($encrypt_id);

        // Get Selected About US Item image name
        $about_image_from_db = AboutUs::find($id)->image;
        
        $about_deleted = AboutUs::find($id)->delete();
        if($about_deleted !== true) {
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }
        $deleted_image_from_directory = File::delete(public_path('/dashboard_assets/images/about_us/'.$about_image_from_db));

        if($deleted_image_from_directory !== true){
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }

        return back()->with('success','Slider Deleted <strong></strong>.');
    }

    // About Us Gallery view
    public function about_us_gallery() {
        $data = AboutUsGallery::orderBy('id','desc')->get();
        return view('dashboard.about_us_gallery',[
            'data' =>$data,
        ]);
    }
    
    // About Us Gallery Add
    public function about_us_gallery_add(Request $request) {
        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,svg,jpeg',
        ],[
            'image.required' => 'Please Select <strong>Image</strong>.',
            'image.mimes' => 'Image must be type of <strong>jpg, jpeg, png, svg</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }
        $validated = $validator->safe()->all();

        if(count($validated) > 0){
            try{
                $last_insert_id = AboutUsGallery::insertGetId([
                    'created_at' => Carbon::now(),
                ]); 
            }catch(\Exception $e){
                return back()->with('faild','Something worng! Please try again.');
            }
            
        }

        // Image update
        if($request->hasFile('image')){
            $image_file = Image::make($validated['image'])->orientate();
            $extension = $validated['image']->getClientOriginalExtension();
            $image_new_name = Str::lower('gallery_'. uniqid(). '_' . $last_insert_id . "." . $extension);

            // udpate image to database
            $banner_image_updated = AboutUsGallery::find($last_insert_id)->update([
                'image' => $image_new_name,
            ]);

            if($banner_image_updated === true){
                // Image Resizing Processing Start
                $width = $image_file->width();
                $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                // Dynamically Image Resizing & Move to Targeted folder
                if($width > 0 && $width < 2048){
                    $new_width = $width;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/about_us_gallery/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/about_us_gallery/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }else{
                    for($i = 0; $i < count($resulation_break_point); $i++){
                        if($i != count($resulation_break_point) -1){
                            if($width >= $resulation_break_point[$i] && $width <= $resulation_break_point[$i + 1]){
                                $new_width = ceil($width - (($width*$reduce_percentage[$i])/100));
                                try {
                                    $image_file->resize($new_width, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save(public_path('/dashboard_assets/images/about_us_gallery/'.$image_new_name),70);
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
                            })->save(public_path('/dashboard_assets/images/about_us_gallery/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else {
                return back()->with('faild','Something worng! Please try again.');
            }
        }

        return back()->with('success','Banner Image Added <strong>Success!</strong>.');
    }

    // About Us Delete
    public function about_us_gallery_delete($encrypt_id) {
        $id = decrypt($encrypt_id);

        // Get Selected Gallery Item image name
        $gallery_image_from_db = AboutUsGallery::find($id)->image;
        
        $gallery_deleted = AboutUsGallery::find($id)->delete();
        if($gallery_deleted !== true) {
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }
        $deleted_image_from_directory = File::delete(public_path('/dashboard_assets/images/about_us_gallery/'.$gallery_image_from_db));
        if($deleted_image_from_directory !== true){
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }

        return back()->with('success','Slider Deleted <strong></strong>.');
    }


    
}
