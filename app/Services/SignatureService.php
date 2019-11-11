<?php

namespace App\Services;

use DB;
use Carbon\Carbon;
use App\Models\{Signature,User};

class SignatureService
{

    public function allGuest()
    {
        $guests = User::latest()
        ->paginate(15);

        return $guests;
    }


    public function createGuest($request)
    {

        DB::beginTransaction();

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'purpose' => $request->purpose,
        ]);


        

        if (!$newUser) {

            DB::rollback();
            return false;

        }else{
            DB::commit();
            return $newUser;

            
        }
    }

    public function showGuest($id)
    {
        $findGuest = Signature::find($id);

        return $findGuest;
    }

    public function signin($request)
    {
        $code = User::where(['code' => $request->code])->first();
        
        if (!$code) {
            return 'code not found';
        }else{
            DB::beginTransaction();

                $guest = Signature::create([
                'user_id' => $code->id,
                'body' => $request->body,
                'created_at' => Carbon::now(),
            ]);

            if ($guest) {
                DB::commit();
                return $guest;
            }

        }
    }

    public function signOutWithId($request)
    {

        $findUser = User::find($request->id);

        dd($findUser);

        // DB::beginTransaction();

        // $findGuest = Signature::where('id',$id)->first();
        // $findGuest->time_out = Carbon::now();
        // $findGuest->status = 1;
        // $findGuest->save();


        if ($findGuest) {

            DB::commit();
            return $findGuest;

        }
    }

    public function signOutWithCode($request)
    {
         $code = User::where(['code' => $request->code])->first();

        if($code){

            DB::beginTransaction();
            $query = Signature::where([
                'user_id' => $code->id,
                'time_out' => null,
                'status' => 0,
            ])->first();

            $query->time_out = Carbon::now();
            $query->status = 1;
            $query->save();

            if ($query) {
                DB::commit();
                return $query;
            }
        
        }
    }

    public function editGuest($request,$id)
    {
        DB::beginTransaction();
        $findGuest = User::where('id',$id)->first();
        $findGuest->name = $request->name;
        $findGuest->address = $request->address;
        $findGuest->phone_number = $request->phone_number;
        $findGuest->email = $request->email;
        $findGuest->purpose = $request->purpose;
        $findGuest->save();

        if ($findGuest) {
            DB::commit();
            return $findGuest;
        }
        
    }

    public function delete($id)
    {
        DB::beginTransaction();
        $findGuest = User::find($id)->signature()->delete();

        if (!$findGuest) {
            DB::rollback();
            return false;
          }else {
            DB::commit();
            return $findGuest;

        }
    }
}
