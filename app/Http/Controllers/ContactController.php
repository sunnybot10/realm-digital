<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Auth\Middleware\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function all()
    {
        $contacts = Contact::all();

        return response()->json([
            "contacts" => $contacts
        ], 200);
    }

    public function show($id)
    {
        $contact = Contact::whereId($id)->first();

        return response()->json([
            "contact" => $contact
        ], 200);
    }

    public function create(Request $request)
    {
        $contact = Contact::create($request->only($this->data()));

        return response()->json([
            "contact" => $contact
        ], 200);
    }

    public function update(Request $request, contact $contact)
    {
        $contact->update($request->only($this->data()));
        return $contact->toJson();
    }

    public function delete(contact $contact)
    {
        $contact->delete();
    }

    private function data()
    {
        return [
            'first_name',
            'last_name',
        ];
    }
}