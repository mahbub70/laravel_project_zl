<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BusinessProfile;
use App\Models\Category;
use App\Models\CustomerMessage;

class CustommerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Subscriber::orderBy('id','desc')->get();
        return view('dashboard.subscriber_list',[
            'data'=>$data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscriber_delete($id)
    {
        $subscriber_delete = Subscriber::find($id)->delete();
        if($subscriber_delete != true){
            return back()->with('faild','Something worng! Please try again.');
        }
        return back()->with('success','Deleted <strong>Success!</strong>');
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
    public function public_product_details($product_code)
    {
        $data['about_company'] = BusinessProfile::firstOrFail();
        $data['product'] = Product::where('product_code',$product_code)
                ->where('status',1)
                ->firstOrFail();
        $data['categories'] = Category::all();
        $data['related_products'] = Product::where('category_id',$data['product']->category_id)
                                            ->where('id', '!=', $data['product']->id)
                                            ->orderBy('id','desc')
                                            ->limit(15)
                                            ->get();

        return view('public.product_details',$data);

    }

    // Show Customer Message Page with all of messages
    public function customer_message()
    {
        $data = CustomerMessage::orderBy('id','desc')->get();
        return view('dashboard.custommer_message',['data'=>$data]);
    }

    // Delete Custommer Message
    public function customer_message_delete($id)
    {
        $deleted = CustomerMessage::find($id)->delete();

        if($deleted != true){
            return back()->with('faild', 'Something Worng! Please try again.');
        }

        return back()->with('success','Message Deleted Success!');
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
