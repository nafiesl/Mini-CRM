@extends('layouts.app')

@section('title', trans('company.edit'))

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (request('action') == 'delete' && $company)
        @can('delete', $company)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ trans('company.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ trans('company.name') }}</label>
                    <p>{{ $company->name }}</p>
                    <label class="control-label">{{ trans('company.email') }}</label>
                    <p>{{ $company->email }}</p>
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
        @else
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('company.edit') }}</h3></div>
            {!! Form::model($company, ['route' => ['companies.update', $company],'method' => 'patch']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('company.name')]) !!}
                {!! FormField::email('email', ['required' => true, 'label' => trans('company.email')]) !!}
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
</div>
@endif
@endsection
