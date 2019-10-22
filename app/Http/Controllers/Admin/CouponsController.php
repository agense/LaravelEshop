<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coupon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CouponsController extends Controller
{
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
        //set the middleware to only allow users with superadmin or admin priviledges
        $this->middleware('adminUser')->except('index','show');
    }

    /**
     * Display a listing of all dicount cards.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.coupons.index')->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new discount card
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Coupon::getTypes();
        return view('admin.coupons.add')->with('types', $types);
    }

    /**
     * Store a newly created card in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:191|min:4|regex:/(^[A-Za-z0-9 ]+$)+/|unique:coupons',
            'type' => ['required', Rule::in(Coupon::getTypes())],
            'value' => 'required|numeric|min:0'
        ]);
        
        if($request->type == 'percent' && $request->value > 100){
            $validator->getMessageBag()->add('value', 'Value is incorrect.');
            return redirect('admin/coupons/create')->withErrors($validator)->withInput();
        }
        if ($validator->fails()) {
            return redirect('admin/coupons/create')->withErrors($validator)->withInput();
        }
         //Store in DB
         $coupon = new Coupon;
         $coupon->code = $request->code;
         $coupon->type = $request->type;
         if($request->type == 'fixed'){
             $coupon->value = $request->value;
             unset($coupon->percent_off);
         }elseif($request->type == 'percent'){
            $coupon->percent_off = $request->value;
            unset($coupon->value);
         }
         $coupon->save();
         return redirect()->route('coupons.index')->with('success_message', 'Disocunt card has been created');

    }

    /**
     * Redirect back to discount card index
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return redirect()->route('coupons.index');
    }

    /**
     * Show the form for editing the discount card.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $card = Coupon::findOrFail($id);
        $types = Coupon::getTypes();
        return view('admin.coupons.edit')->with('card', $card)->with('types', $types);
    }

    /**
     * Update the specified discount card in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon= Coupon::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'code' => [
                'required',
                'max:191',
                'min:4',
                'regex:/(^[A-Za-z0-9 ]+$)+/',
                 Rule::unique('coupons')->ignore($coupon->id)
            ],
            'type' => ['required', Rule::in(Coupon::getTypes())],
            'value' => 'required|numeric|min:0'
        ]);
        
        if($request->type == 'percent' && $request->value > 100){
            $validator->getMessageBag()->add('value', 'Value is incorrect.');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
         //Store in DB
         $coupon->code = $request->code;
         $coupon->type = $request->type;
         if($request->type == 'fixed'){
             $coupon->value = $request->value;
             unset($coupon->percent_off);
         }elseif($request->type == 'percent'){
            $coupon->percent_off = $request->value;
            unset($coupon->value);
         }
         $coupon->save();
         return redirect()->route('coupons.index')->with('success_message', 'Disocunt card has been updated');
    }

    /**
     * Remove the dicount card from DB
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $coupon = Coupon::findOrFail($id);
         $coupon->delete();
         return redirect()->route('coupons.index')->with('success_message', 'Disocunt card has been deleted');
    }
}
