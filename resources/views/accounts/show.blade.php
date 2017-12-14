@extends('layouts.app')

@section('title')
<a class="a-link hidden md:inline lg:inline" href="{{url('/accounts') }}">Accounts</a> <span class="hidden md:inline lg:inline">/</span> {{$account->name}}
@endsection

@section('content')

<div class="w-full md:w-3/4 lg:w-3/4 shadow-md h-full">
    <div class="z-40 h-8  p-2 bg-grey-lighter border-b-2 border-grey-light">     
        <div class="text-sm pl-4">
            ID: {{$account->id}}
        </div>        
    </div>
    <div class="z-30 h-12 bg-grey-light h-screen">
        <tabs v-cloak>
            <tab name="General" :selected="true">
                <div>
                    <div>
                        <span class="font-thin">Primary Contact</span>
                    </div>
                    <div>
                        @if( $account->primary())
                        <table>
                            <tr>
                                <th>Name</th>
                                <td>{{ $account->primary()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $account->primary()->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile Phone</th>
                                <td>{{ $account->primary()->mobile_phone }}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                </div>

                <div>
                    <div>
                        <span class="font-thin">Address</span>
                    </div>
                    <div>
                        <span>
                            {{ $account->address }}
                        </span>
                        <span>
                            {{ $account->postal }}
                        </span>
                        <span>
                            {{ $account->city }}
                        </span>
                        <span>
                            {{ $account->country }}
                        </span>
                    </div>
                </div>
                {{ $account->name }}
            </tab>

            <tab name="Information">
                <list id="{{$account->id}}" v-cloak></list>
            </tab>
            <tab name="Communcation"></tab>
            <tab name="Files"></tab>
        </tabs>
    </div>
</div>
<div class="hidden w-1/4 lg:inline md:inline">
    <div class="pl-2 pt-2">
        testing stuff
    </div>
</div>
@endsection
