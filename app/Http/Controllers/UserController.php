<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Command\WhereamiCommand;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class UserController extends Controller
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
     * Method for identifying user by using link that given in the URL
     * @return User Information
     */
    public function user_identity($user_slug){ 
        if(User::where('username',$user_slug)->exists() !== true){
            try {
                if(User::where('id',decrypt($user_slug))->exists() === true){
                    return User::where('id',decrypt($user_slug))->first();
                }
            } catch (DecryptException $e) {
                abort(403);
            }
        }else{
            return User::where('username',$user_slug)->first();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_identity)
    {
        $user_info = $this->user_identity($user_identity);
        return view('dashboard.profile',[
            'user_data'=>$user_info,
        ]);
    }


    /**
     * Method for update login user password 
     */
    public function update_password(Request $request,$user_identity){

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|current_password',
            'new_password'=>'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'new_password_confirmation'=>'required_with:new_password',
        ],[
            'old_password.required'=>'Please enter your <strong>old password.</strong>',
            'old_password.current_password'=>'Password did <strong>not match</strong>',
            'new_password.required'=>'Please enter your <strong>new password.</strong>',
            'regex'=>'Password must contain <strong>1 uppercase</strong>, <strong>1 lowercase</strong>, <strong>1 number</strong>, <strong>1 speacial character</strong> & <strong>minimum 8 characters.</strong>',
            'new_password.confirmed'=>'Confirm password <strong>does not match</strong>.',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();        
        }

        $validated = $validator->validated();
        $new_password_hash = Hash::make($validated['new_password']);
        $updated = User::find($this->user_identity($user_identity)->id)->update([
            'password'=>$new_password_hash,
        ]);

        if($updated === true){
            return back()->with('success','Password Update Success!');
        }

        return back()->with('faild','Opps! Something Wrong. Please try again.');
    }

    /**
     * Method for upadate user information
     * 
     */
    public function update_info(Request $request,$user_identity){
        // Find User Id From User Identity
        $get_user_id = $this->user_identity($user_identity)->id;

        // Validation user information
        $validator = Validator::make($request->all(),[
            'confirm_password'=>'required|current_password',
            'name'=>'bail|alpha_num_space_colon|max:35',
            'phone'=>'bail|numeric|digits_between:11,11',
            'address'=>'max:255',
            'bio'=>'max:500',
            'username'=>'bail|alpha_num|unique:users|max:30',
            'website'=>'url',
        ],[
            'confirm_password.required'=>'Please enter your <strong>password</strong>.',
            'confirm_password.current_password'=>'Password <strong>did not match</strong>.',
            'name.alpha_num_space_colon' => 'Name can contains only <strong>Alphanumaric, Spaces & Colon</strong>.',
            'name.max' => 'Name can be contains <strong>maximum 35 characters</strong>',
            'phone.digits_between'=>'Invalid <strong>phone number</strong>.',
            'address.max' => 'Address can be contains <strong>maximum 255 characters</strong>.',
            'bio'=>'Bio can be contains <strong>maximum 500 characters</strong>.',
            'username.unique'=> 'This username already <strong>taken</strong>.',
            'username.max'=>'Username contains <strong>maximum 30 characters</strong>.',
            'username.alpha_num'=>'Username contains only <strong>letters & numbers</strong>.',
            
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        
        // Safely Store Validated Information
        $validated = $validator->validated();
        $validated = $validator->safe()->all();

        // Count Validated Items For Getting How Many Field Updated Successfully.
        $validated_items = count($validated);
        $loop_count = 0;
        foreach($validated as $key=>$item){
            $updated = User::find($get_user_id)->update([
                $key => $item,
            ]);
            if($updated === true){
                $loop_count++;
            }
        }

        if($validated_items == $loop_count){
            return back()->with('success','Information update success!');
        }

        return back()->with('faild','Something Wrong! Please try again.');

    }

    /**
     * Update Specific User Profile Image.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile_image(Request $request , $user_identity)
    {
        // Find User Id From User Identity
        $get_user_id = $this->user_identity($user_identity)->id;

        // Validate
        $validated = $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,svg',
        ],[
            'image.required' => 'Please enter your <strong>Profile Image</strong>.',
            'image.mimes' => 'Image must be type of <strong>jpg, jpeg, png, svg</strong>.',
        ]);

        if($request->hasFile('image')){
            $image_file = Image::make($validated['image'])->orientate();
            $extention = $validated['image']->getClientOriginalExtension();
            $image_new_name = Str::lower(User::find($get_user_id)->username . '_' . uniqid() . '_' . $get_user_id . '.' . $extention);

            // Update image to database
            $image_updated = User::find($get_user_id)->update([
                'profile_image' => $image_new_name,
            ]);

            if($image_updated === true){
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
                        })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
                    } catch (\Exception $e) {
                        return back()->with('faild','Image Upload <strong>Faild!</strong>');
                    }
                }
                if($width > 5460 && $width <= 6140){
                    $new_width = 2048;
                    try {
                        $image_file->resize($new_width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
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
                                    })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
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
                            })->save(public_path('/dashboard_assets/images/user/'.$image_new_name),70);
                        } catch (\Exception $e) {
                            return back()->with('faild','Image Upload <strong>Faild!</strong>');
                        }
                    }
                }
            }else{
                return back()->with('faild','Something Worng! Please try again');
            }
        }

        return back()->with('success','Profile image upload <strong>success!</strong>');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
