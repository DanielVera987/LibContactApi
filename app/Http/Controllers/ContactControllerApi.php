<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactStoreRequest;
use App\Http\Requests\Contact\ContactUpdateRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('emails', 'phones', 'addresses')->get();
        return response()->json($contacts, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        $contact = Contact::create($request->all());

        if ($contact) {
            return response()->json($contact, Response::HTTP_CREATED);
        }

        return response()->json([
            'message' => 'No se pudo guardar el contacto'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);

        return response()->json($contact, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactUpdateRequest $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update($request->validated());

        return response()->json($contact, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
