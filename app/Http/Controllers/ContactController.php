<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contact;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\ApiController;

class ContactController extends ApiController
{

    public function index()
    {
        $user = auth()->user();
        return $this->respond($user->contacts);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'tel' => 'required|min:10||unique:contacts',
        ]);

        $user = auth()->user();
        $contact = $user->contacts()->save(new Contact($request->all()));

        return $this->respondCreated($contact);
    }

    public function update(Request $request, Contact $contact)
    {
        $this->validate($request, [
            'name' => 'required',
            'tel' => 'required|min:10||unique:contacts',
        ]);
        
        $contact->update($request->all());

        return $this->respondSuccess();
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return $this->respondSuccess();
    }
}
