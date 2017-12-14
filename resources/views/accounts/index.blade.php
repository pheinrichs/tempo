@extends('layouts.app')

@section('title')
@parent
Accounts
@endsection

@section('sub-menu')
<div class="h-12 flex-initial p-3 border-b">     
    <a class="no-underline bg-brand shadow hover:shadow-lg hover:bg-brand-dark text-white py-1 px-2 border-b-2 border-brand-dark rounded text-sm" href="{{ url('/accounts/create') }}">
        + Create Account
    </a>
</div>
@endsection

@section('content')
    <div class="md:w-3/4 md:mx-auto mt-4">
        <div class="rounded shadow">

            <div class="bg-white p-3 rounded rounded-b">
                @if (session('status'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <account-table></account-table>
            </div>
        </div>
    </div>
@endsection
