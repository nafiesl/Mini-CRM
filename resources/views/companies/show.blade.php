@extends('layouts.app')

@section('title', trans('company.detail'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('company.detail') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <td>{{ trans('company.name') }}</td>
                        <td>{{ $company->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ trans('company.email') }}</td>
                        <td>{{ $company->email }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                @can('update', $company)
                    {{ link_to_route('companies.edit', trans('company.edit'), [$company], ['class' => 'btn btn-warning', 'id' => 'edit-company-'.$company->id]) }}
                @endcan
                {{ link_to_route('companies.index', trans('company.back_to_index'), [], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
@endsection
