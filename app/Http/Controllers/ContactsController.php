<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacts;
use Illuminate\Support\Facades\Validator;


class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(Contacts::all(), "Success");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact_number' => 'required',
        ]);

        if($validator->fails()) {
            return $this->failedResponse($validator->errors(), "Required Fields");
        }

        $contact = new Contacts($request->all());
        $contact->save();
        return $this->successResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contacts::find($id);
        
        if(!$contact) {
            return $this->failedResponse(null, "Contact not found");
        }
        return $this->successResponse($contact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact_number' => 'required',
        ]);

        if($validator->fails()) {
            return $this->failedResponse($validator->errors(), "Required Fields");
        }

        $contact = Contacts::find($id);
        $contact->name = $request->name;
        $contact->contact_number = $request->contact_number;
        $contact->save();

        return $this->successResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contacts::find($id);
        if($contact) {
            $contact->delete();

            return $this->successResponse();
        }

        return $this->failedResponse();
    }

    public function successResponse($data = null, $message = "Success") {
        return response([
            "success" => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    public function failedResponse($data = null, $message = "Failed") {
        return response([
            "success" => false,
            "message" => $message,
            "data" => $data
        ]);
    }
}
