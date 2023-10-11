@extends('layouts.beheer')

@section('title')
Page
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>Page</h1>
        </div>

        <div class="col-md-6">
            <div class="btn-group mt-2 float-md-right" role="group" aria-label="Actions">
                <a href="{{url('/pages/'.$page->id . '/edit' )}}" class="btn btn-primary">
                    <span title="{{'Edit'}}" class="ion-edit" aria-hidden="true"></span>
                    {{'Edit'}}
                </a>
                <a href="{{url('/pages/')}}" class="btn btn-primary">
                    <span title="{{'Back'}}" class="ion-android-arrow-back" aria-hidden="true"></span>
                    {{'Back'}}
                </a>
                @if($page->deletable)
                    {{ Form::open(array('url' => 'pages/' .$page->id, 'method' => 'delete')) }}
                    <button type="submit" class="btn btn-danger"><span class="ion-trash-a"></span> Remove</button>
                    {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h3>Page {{$page->name}}</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped" style="width:100%">
                <tr>
                    <td>{{'Name'}}</td>
                    <td>{{$page->name}}</td>
                </tr>
                <tr>
                    <td>{{'Sub item of'}}</td>
                    <td>{{($page->partner != null) ?$page->partner->name : ""}}</td>
                </tr>
                <tr>
                    <td>{{'URL name'}}</td>
                    <td>{{$page->urlName}}</td>
                </tr>
                <tr>
                    <td>{{'User needs to be logged in to view the page'}}</td>
                    <td>{{($page->login)? 'Yes' : 'No'}}</td>
                </tr>
                <tr>
                    <td>{{'After menu item'}}</td>
                    <td>{{($page->after != null) ?$page->afterItem->name : ""}}</td>
                </tr>
                @if($subItems != null && count($subItems) > 0)
                    <tr>
                        <td rowspan="{{count($subItems) == 0 ? 1 : count($subItems)}}">{{'Submenu items'}}</td>
                        @if( count($subItems) > 0)
                            <td>
                                {{$subItems[0]->name}}
                            </td>
                        @else
                            <td> </td>
                        @endif
                    </tr>
                    @for ($i = 1; $i < count($subItems); $i++)
                        <tr>
                            <td>
                                {{$subItems[$i]->name}}
                            </td>
                        </tr>
                    @endfor
                @endif
            </table>
        </div>
    </div>
@endsection
