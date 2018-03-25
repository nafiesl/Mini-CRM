@extends('layouts.app')

@section('title', trans('company.edit'))

@section('content')

@if (request('action') == 'delete' && $company)
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @can('delete', $company)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ trans('company.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ trans('company.name') }}</label>
                    <p>{{ $company->name }}</p>
                    <label class="control-label">{{ trans('company.email') }}</label>
                    <p>{{ $company->email }}</p>
                    <label class="control-label">{{ trans('company.website') }}</label>
                    <p>{{ $company->website }}</p>
                    <label class="control-label">{{ trans('company.address') }}</label>
                    <p>{{ $company->address }}</p>
                    {!! $errors->first('company_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['companies.destroy', $company]],
                        trans('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'company_id' => $company->id,
                            'page' => request('page'),
                            'q' => request('q'),
                        ]
                    ) !!}
                    {{ link_to_route('companies.edit', trans('app.cancel'), [$company], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @endcan
    </div>
</div>
@else
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('company.edit') }}</h3></div>
            {!! Form::model($company, ['route' => ['companies.update', $company],'method' => 'patch']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('company.name')]) !!}
                {!! FormField::email('email', ['required' => true, 'label' => trans('company.email')]) !!}
                {!! FormField::text('website', ['label' => trans('company.website')]) !!}
                {!! FormField::textarea('address', ['label' => trans('company.address')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('company.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('companies.show', trans('app.cancel'), [$company], ['class' => 'btn btn-default']) }}
                @can('delete', $company)
                    {{ link_to_route('companies.edit', trans('app.delete'), [$company, 'action' => 'delete'], ['class' => 'btn btn-danger pull-right', 'id' => 'del-company-'.$company->id]) }}
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('company.logo_upload') }}</h3></div>
            <div class="panel-body">
                @if ($company->logo && is_file(public_path('storage/'.$company->logo)))
                {{ Html::image('storage/'.$company->logo, $company->name, ['style' => 'width:100%']) }}
                @endif
                {{ Form::open(['route' => ['companies.logo-upload', $company], 'method' => 'patch', 'files' => true]) }}
                {!! FormField::file('logo', ['label' => false]) !!}
                {{ Form::submit(trans('company.upload_logo'), ['class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endif
@endsection
