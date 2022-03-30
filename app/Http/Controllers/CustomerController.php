<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //

        $customers = Customer::with(['owners','users'])
            ->orderBy('first_name')
            ->filter(request()->only('search', 'trashed'))
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($c) => $c)
        ;
        return response($customers);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        //
//        dump($request->search);


        $customers = Customer::where("first_name", "like",'%'.$request->search.'%')
            ->orwhere("last_name", "like",'%'.$request->search.'%')
            ->with('owners')->paginate(15);
        return response($customers);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function stats(): Response
    {
        //
       $stats = [
           "customer_count" => Customer::count(),
           "owner_count" => count(Customer::withCount('owners')->get()),
           "user_count" => count(Customer::withCount('users')->get()),
//           "user_count" => DB::select("SELECT COUNT(ms.customer_id_owners) FROM mobile_subscribers ms JOIN customers c on c2.id = ms.customer_id_userm")
       ];
        return response($stats);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {

//        return json_encode($request->all());
        $isp_code = [
            "054", "055", "024", "059",
            "020", "050",
            "026", "056", "057"
        ];

        if($request->has(['isp_code','phone_number'])){
            $request->merge([
                'msisdn' => "233" . ltrim($request->isp_code,"0")  . $request->phone_number]
            );
        }

        //Validate new customer data

//        VALIDATE CUSTOMER
        $request->validate([
            "ghana_card_no" => ["required", "alpha_dash", "digits:6", "unique:customers,ghana_card_no","exists:ghana_cards,pin"],
            "first_name" => ["required", "alpha_dash", "max:20", "min:2"],
            "last_name" => ["required", "alpha_dash", "max:20", "min:2"],
            "service_type" => ["required", "in:mobile_postpaid,mobile_prepaid"],
            "isp_code" => ["required", "in:" . implode(',', $isp_code)],
            "phone_number" => ["required", "digits:7", "unique:mobile_subscribers,msisdn"],
            "owner" => ["required", "in:no,yes"]

        ]);

//        VALIDATE CUSTOMER WHO IS A USER

        if ($request->owner === "no") {
            $request->validate([
                "user_ghana_card_no" => ["required", "alpha_dash", "digits:6", "unique:customers,ghana_card_no","exists:ghana_cards,pin"],
                "user_first_name" => ["required", "alpha_dash", "max:20", "min:2"],
                "user_last_name" => ["required", "alpha_dash", "max:20", "min:2"],
            ]);
        }


//        DATABASE TRANSACTION
        DB::transaction(function () use ($request) {
            $created_at = now();
            $updated_at = now();
            $owner_id = DB::table("customers")->insertGetId([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "ghana_card_no" => $request->ghana_card_no,
                "created_at" => $created_at,
                "updated_at" => $updated_at,
            ]);
            $user_id = null;

            if ($request->owner === "no") {
                $user_id = DB::table("customers")->insertGetId([
                    "first_name" => $request->user_first_name,
                    "ghana_card_no" => $request->user_ghana_card_no,
                    "last_name" => $request->user_last_name,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at,
                ]);
            }

            DB::table("mobile_subscribers")->insert([
                "msisdn" => $request->msisdn,
                "service_type" => strtoupper($request->service_type),
                "service_start_date" => round(microtime(true) * 1000),
//                "created_at" => $created_at,
//                "updated_at" => $updated_at,
                "customer_id_owner" => $owner_id,
                "customer_id_user" =>  $user_id ?? $owner_id,
//
            ]);


        }, 2);



        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return Response
     */
    public function show(Customer $customer): Response
    {
        //

        return response(
            [
                "id" => $customer->id,
                "first_name" => $customer->first_name,
                "last_name" => $customer->last_name,
                "ghana_card_no" => $customer->ghana_card_no,
                "owners" => $customer->owners,
                "users" => $customer->users
            ]
            ,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return Response
     */
    public function update(Request $request, Customer $customer): Response
    {
        //
//        Validate User Request
//        Update user Information
        return response()->noContent(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer): Response
    {
        //
//        Soft Delete, to protect again data loss
        $customer->delete();
        return response( )->noContent();
    }
}
