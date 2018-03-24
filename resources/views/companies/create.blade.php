@extends('layouts.app')

@section('title', trans('company.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('company.create') }}</h3></div>
            {!! Form::open(['route' => 'companies.store']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('company.name')]) !!}
                {!! FormField::email('email', ['required' => true, 'label' => trans('company.email')]) !!}
                {!! FormField::text('website', ['label' => trans('company.website')]) !!}
                {!! FormField::textarea('address', ['label' => trans('company.address')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('company.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('companies.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
