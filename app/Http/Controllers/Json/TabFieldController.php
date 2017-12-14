<?php

namespace App\Http\Controllers\Json;

use App\Account;
use App\TabField;
use App\AccountTab;
Use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TabFieldController extends Controller
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
     * Create a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Account $account, AccountTab $tab)
    {
        $request->validate([
            'name' => 'required|max:255',
            'value' => 'required|max:255'
        ]);

        $field = $tab->fields()->create([
            'name' => $request->name,
            'value' => $request->value,
        ]);

        return response()->json([
            'data' => $field
        ]);
    }

    /**
     * Update a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account, AccountTab $tab, TabField $field)
    {
        $request->validate([
            'name' => 'required|max:255',
            'value' => 'required|max:255'
        ]);
        $field->name = $request->name;
        $field->value = $request->value;
        $field->save();

        return response()->json([
            'data' => $field
        ]);
    }


    /**
     * Destroy a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Account $account, AccountTab $tab, TabField $field)
    {
        $field->delete();

        return response()->json([
            'data' => [
                'success' => true,
                'message' => 'Field successfully deleted.'
            ]
        ]);
    }
}