<?php

namespace App\Http\Controllers\Json;

use App\Account;
Use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::paginate();
        return response()->json(
            $accounts
        );
    }

    /**
     * Display a  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Account $account)
    {
        return response()->json([
            'data' => $account->load('contacts', 'tabs', 'fields')
        ]);
    }
}
