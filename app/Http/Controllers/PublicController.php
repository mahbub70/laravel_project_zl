<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\AboutUsGallery;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\Product;
use App\Models\PromostionalBanner;
use App\Models\Slider;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerMessage;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        $data['sliders'] = Slider::all();
        $data['banners'] = PromostionalBanner::orderBy('id','desc')->limit(2)->get();
        $data['products'] = Product::orderBy('id','desc')->get();
        $data['brands'] = Brand::orderBy('id','desc')->get();
        return view('welcome',$data);
    }

    /**
     * Find Speacific Product By using Ajax.
     *
     * @return \Illuminate\Http\Response
     */
    public function find_product(Request $request)
    {
        $id = $request->product_identity;
        $product_info = Product::find($id);
        return json_encode($product_info,true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscriber_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ],[
            'email.required' => 'Please enter your <strong>email</strong>.',
            'email.email' => 'Please enter a valid <strong>email</strong>.',
        ]);

        // If Single Validation Fails
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->all();

        $inserted_data = Subscriber::insert([
            'email' => $validated['email'],
            'created_at' => Carbon::now(),
        ]);
        if($inserted_data != true) {
            $validator->errors()->add('eamil', 'Something worng! Please try again.');
            return back()->withErrors($validator)->withInput();
        }

        return back()->with('success','Subscription <strong>Success!</strong>.');


    }

    /**
     * Display the About US Page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function about_us()
    {
        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        $data['about_us'] = AboutUs::orderBy('id','desc')->first();
        $data['gallery_images']= AboutUsGallery::orderBy('id','desc')->get();
        return view('public.about_us',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function contact_us()
    {
        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        return view('public.contact_us',$data);
    }

    /**
     * Costomer Message Send form public website.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer_message_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|alpha_num_space_colon|max:35',
            'email_address' => 'required|email',
            'subject' => 'nullable|max:40',
            'phone' => 'numeric|digits_between:0,11',
            'message'=> 'required|max:500',
        ],[
            'email_address.required' => 'Please enter your <strong>email</strong>.',
            'email_address.email' => 'Please enter a valid <strong>email</strong>.',
            'name.required'=>'Please enter your <strong>name</strong>.',
            'name.alpha_num_space_colon' => 'Name can be contain <strong>Alpha, Number, Space and Colon</strong>.',
            'name.max' => 'Name contains <strong>maximum 35 characters</strong>.',
            'subject.max' => 'Subject contain <strong>maximum 40 characters</strong>.',
            'phone.numeric' => 'Please enter a <strong>valid</strong> phone number.',
            'phone.digits_between' => 'Phone number contains <strong>maximum 11 digits</strong>.',
            'message.required'=> 'Please enter your <strong>Message</strong>.',
            'message.max' => 'Message contains maximum <strong>500</strong> characters.',
        ]);

        // If Single Validation Fails
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->all();
        $validated['created_at'] = Carbon::now();

        $inserted = CustomerMessage::insert(
            $validated,
        );

        if($inserted != true) {
            return back()->with('Cfaild','Something Worng! Please try again.');
        }

        return back()->with('Csuccess','Message Send Success!');
    }


    // Get Search Product by using Ajax Request
    public function search_product(Request $request)
    {   
        $category_id = $request->category;
        $input_text = $request->search_value;

        $search_result = Product::where('category_id',$category_id)
                                ->where('title','LIKE','%'.$input_text.'%')
                                ->where('status',1)
                                ->rightJoin('categories','categories.id','=','products.category_id')
                                ->select('products.*','categories.name')
                                ->get();

        return json_encode($search_result, true);
    }


    // Show indivisual Category Product
    public function browse_category($category_name) {
        $category = preg_replace('/_/i',' ',$category_name);
        $get_category_id = Category::where('name',$category)->firstOrFail()->id;

        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['categories'] = Category::all();
        $data['products'] = Product::where('category_id',$get_category_id)
                                    ->where('status',1)
                                    ->join('categories','categories.id','=','products.category_id')
                                    ->select('products.*','categories.name')
                                    ->get();

        return view('public.category_browse',$data);

    }
}
