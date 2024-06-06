<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactStoreRequest;
use App\Http\Requests\Contact\ContactUpdateRequest;
use App\Models\Contact;
use App\Models\ContactAddress;
use App\Models\ContactEmail;
use App\Models\ContactPhone;
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

        if (!empty($request->all('phones'))) {
            $wrapperPhones = $request->all('phones');
            foreach($wrapperPhones as $phones) {
                foreach($phones as $phone) {
                    ContactPhone::create([
                        'contact_id' => $contact->id,
                        'phone' => $phone['phone']
                    ]);
                }
            }
        }

        if (!empty($request->all('emails'))) {
            $wrapperEmails = $request->all('emails');
            foreach ($wrapperEmails as $emails) {
                foreach ($emails as $email) {
                    ContactEmail::create([
                        'contact_id' => $contact->id,
                        'email' => $email['email']
                    ]);
                }
            }
        }

        if (!empty($request->all('addresses'))) {
            $wrapperAddresses = $request->all('addresses');
            foreach ($wrapperAddresses as $addresses) {
                foreach ($addresses as $address) {
                    ContactAddress::create([
                        'contact_id' => $contact->id,
                        'street' => $address['street'],
                        'between_streets' => $address['between_streets'],
                        'zip' => $address['zip'],
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'num_ext' => $address['num_ext'],
                        'num_int' => $address['num_int'],
                    ]);
                }
            }
        }

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
        $contact = Contact::with('emails', 'phones', 'addresses')->where('id', $id)->firstOrFail();

        return response()->json($contact, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactUpdateRequest $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update($request->validated());

        if (!empty($request->all('phones'))) {
            $phones = $contact->phones;
            foreach ($phones as $phone) {
                $phone->delete();
            }

            $wrapperPhones = $request->all('phones');
            foreach ($wrapperPhones as $phones) {
                foreach ($phones as $phone) {
                    ContactPhone::create([
                        'contact_id' => $contact->id,
                        'phone' => $phone['phone']
                    ]);
                }
            }
        }

        if (!empty($request->all('emails'))) {
            $emails = $contact->emails;
            foreach ($emails as $email) {
                $email->delete();
            }

            $wrapperEmails = $request->all('emails');
            foreach ($wrapperEmails as $emails) {
                foreach ($emails as $email) {
                    ContactEmail::create([
                        'contact_id' => $contact->id,
                        'email' => $email['email']
                    ]);
                }
            }
        }

        if (!empty($request->all('addresses'))) {
            $addresses = $contact->addresses;
            foreach ($addresses as $address) {
                $address->delete();
            }

            $wrapperAddresses = $request->all('addresses');
            foreach ($wrapperAddresses as $addresses) {
                foreach ($addresses as $address) {
                    ContactAddress::create([
                        'contact_id' => $contact->id,
                        'street' => $address['street'],
                        'between_streets' => $address['between_streets'],
                        'zip' => $address['zip'],
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'num_ext' => $address['num_ext'],
                        'num_int' => $address['num_int'],
                    ]);
                }
            }
        }

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
