<?php

namespace App\Http\Controllers\Json;

use App\Account;
use App\AccountTab;
Use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountTabController extends Controller
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
        $tabs = $account->tabs;
        return response()->json([
            'data' => $account->tabs
        ]);
    }

    /**
     * Display a  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account, AccountTab $tab)
    {
        if ((int)$tab->account_id !== (int)$account->id) return response()->json(['error' => "This account doesn't seem to own this tab"], 400);
        return response()->json([
            'data' => $tab->load('fields')
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
            'name' => 'required|max:50'
        ]);
        $tab = $account->tabs()->create([
            'name' => $request->name
        ]);

        return response()->json([
            'data' => $tab
        ]);
    }

    /**
     * Update a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account, AccountTab $tab)
    {
        if ((int)$tab->account_id !== (int)$account->id) return response()->json(['error' => "This account doesn't seem to own this tab"], 400);

        $request->validate([
            'name' => 'required|max:50'
        ]);
        
        $tab->name = $request->name;
        $tab->save();

        return response()->json([
            'data' => $tab
        ]);
    }


    /**
     * Destroy a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account, AccountTab $tab)
    {
        $name = $tab->name;
        $tab->delete();

        return response()->json([
            'data' => [
                'success' => true,
                'message' => "Tab $name successfully deleted."
            ]
        ]);
    }
}