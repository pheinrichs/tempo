<?php

namespace App\Http\Controllers\Json;

use App\Account;
use App\Contact;
Use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account)
    {
        return response()->json([
            'data' => $account->contacts
        ]);
    }

    /**
     * Display a  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account, Contact $contact)
    {
        if ((int)$contact->account_id !== (int)$account->id) return response()->json(['error' => "This account doesn't seem to own this contact"], 400);
        return response()->json([
            'data' => $tab->load('contacts')
        ]);
    }

    /**
     * Create a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|max:255',
            'work_phone' => 'nullable|max:50',
            'mobile_phone' => 'nullable|numeric',
            'home_phone' => 'nullable|numeric',
            'primary' => 'boolean',
            'email' => 'email|max:255|nullable'
        ]);

        $contact = $account->contacts()->create([
            'name' => $request->name,
            'work_phone' => (isset($request->work_phone) ? $request->work_phone : null),
            'mobile_phone' => (isset($request->mobile_phone) ? $request->mobile_phone : null),
            'home_phone' => (isset($request->home_phone) ? $request->home_phone : null),
            'primary' => (isset($request->primary) ? (int)$request->primary : 0),
            'email' => (isset($request->email) ? $request->email : null)
        ]);
        
        return response()->json([
            'data' => $contact
        ]);
    }

    /**
     * Update a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account, Contact $contact)
    {
        if ((int)$contact->account_id !== (int)$account->id) return response()->json(['error' => "This account doesn't seem to own this contact"], 400);
        
        $request->validate([
            'name' => 'required|max:255',
            'work_phone' => 'nullable|max:50',
            'mobile_phone' => 'nullable|numeric',
            'home_phone' => 'nullable|numeric',
            'primary' => 'boolean',
            'email' => 'email|max:255|nullable'
        ]);

        $contact->name = $request->name;
        $contact->work_phone = (isset($request->work_phone) ? $request->work_phone : null);
        $contact->mobile_phone = (isset($request->mobile_phone) ? $request->mobile_phone : null);
        $contact->home_phone = (isset($request->home_phone) ? $request->home_phone : null);
        $contact->primary = (isset($request->primary) ? (int)$request->primary : 0);
        $contact->email = (isset($request->email) ? $request->email : null);
        $contact->save();

        return response()->json([
            'data' => $contact
        ]);
    }


    /**
     * Destroy a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account, Contact $contact)
    {
        $name = $contact->name;
        $contact->delete();

        return response()->json([
            'data' => [
                'success' => true,
                'message' => "Contact $name successfully deleted."
            ]
        ]);
    }
}