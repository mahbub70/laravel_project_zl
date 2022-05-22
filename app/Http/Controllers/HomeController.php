<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Slider;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\PromostionalBanner;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the Slider Contents.
     */
    public function show_slider_contents(){
        $data = Slider::all();
        return view('dashboard.slider_contents',[
            'data' => $data,
        ]);
    }

    /**
     * Delete the Speacific Slider with Content.
     */
    public function slider_delete($encrypt_id) {
        $id = decrypt($encrypt_id);

        // Get Selected Slider Item image name
        $slider_image_from_db = Slider::find($id)->image;
        
        $slider_deleted = Slider::find($id)->delete();
        if($slider_deleted !== true) {
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }
        $deleted_image_from_directory = File::delete(public_path('/dashboard_assets/images/slider/'.$slider_image_from_db));
        if($deleted_image_from_directory !== true){
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }

        return back()->with('success','Slider Deleted <strong></strong>.');
    }

    /**
     * Slider Add.
     */
    public function slider_add(Request $request){

        $validator = Validator::make($request->all(),[
            'slider_text' => 'nullable|max:100',
            'image' => 'required|mimes:png,jpg,svg,jpeg',
            'button_text' => 'nullable|max:30',
            'button_link' => 'nullable',
        ],[
           'slider_text.max' => 'Slider Text Contains <strong>Maximam 100 Characters</strong>.',
           'image.required' => 'Please select a <strong>slider image.</strong>',
           'image.mimes' => 'Image must be type of <strong>jpg, png, jpeg, svg.</strong>',
           'button_text.max' => 'Button text contains <strong>maximum 30 characters</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        // Validated item store with safe method
        $validated = $validator->safe()->all();

        // Update information to database
        if(count($validated) > 0 ){
            try{
                $last_inserted_id = Slider::insertGetId([
                    'slider_text' => $validated['slider_text'],
                    'button_text' => $validated['button_text'],
                    'button_link' => $validated['button_link'],
                    'created_at' => Carbon::now(),
                ]);
            }catch(\Exception $e){
                return back()->with('faild','Something worng! Please try again.');
            }
        }


        // Image Make for Upload
        if($request->hasFile('image')){

            $image_file = Image::make($validated['image'])->orientate();
            $extension = $validated['image']->getClientOriginalExtension();
            $new_image_name = Str::lower('slider_'. uniqid() . '_' . $last_inserted_id . '.' . $extension);

            // Image update to database
            $image_updated = Slider::find($last_inserted_id)->update([
                'image' => $new_image_name,
            ]);

            // If Image Update success in Database
            if($image_updated === true){

                $width = $image_file->width();
                $resulation_break_point = [2048,2340,2730,3276,4096,5460,8192];
                $reduce_percentage = [12.5,25,37.5,50,62.5,75];

                // Dynamically Image Resizing & Move to Targeted folder
                if($width > 0 && $width < 2048){
                    $new_width = $width;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/slider/'.$new_image_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/slider/'.$new_image_name),70);
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
                                    })->save(public_path('/dashboard_assets/images/slider/'.$new_image_name),70);
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
                            })->save(public_path('/dashboard_assets/images/slider/'.$new_image_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else{
                return back()->with('faild','Image Upload <strong>Unsuccessfull!</strong>');
            }

        }

        return back()->with('success','Information added <strong>successfully</strong>.');

    }

    /**
     * Show Promotional Banner Page .
     */
    public function promotional_banners() {
        $data = PromostionalBanner::all();
        return view('dashboard.promotional_banners',[
            'data' => $data,
        ]);
    }

    /**
     *  Add Promotional banner.
     */
    public function promotional_banner_add(Request $request) {
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
                $last_insert_id = PromostionalBanner::insertGetId([
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
            $banner_image_updated = PromostionalBanner::find($last_insert_id)->update([
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
                        })->save(public_path('/dashboard_assets/images/promo_banner/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/promo_banner/'.$image_new_name),70);
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
                                    })->save(public_path('/dashboard_assets/images/promo_banner/'.$image_new_name),70);
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
                            })->save(public_path('/dashboard_assets/images/promo_banner/'.$image_new_name),70);
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
     *  Delete Speacific Promotional banner.
     */
    public function promotional_banner_delete($encrypt_id) {
        $id = decrypt($encrypt_id);

        // Get Selected Banner Item image name
        $banner_image_from_db = PromostionalBanner::find($id)->image;
        
        $banner_deleted = PromostionalBanner::find($id)->delete();
        if($banner_deleted !== true) {
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }
        $deleted_image_from_directory = File::delete(public_path('/dashboard_assets/images/promo_banner/'.$banner_image_from_db));
        if($deleted_image_from_directory !== true){
            return back()->with('faild','Delete <strong>Faild!</strong> Please try again.');
        }

        return back()->with('success','Slider Deleted <strong></strong>.');
    }
}
