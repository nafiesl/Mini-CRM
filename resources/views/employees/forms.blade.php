@if (Request::get('action') == 'create')
@can('create', new App\Employee)
    {!! Form::open(['route' => 'employees.store']) !!}
    {!! FormField::text('first_name', ['required' => true, 'label' => trans('employee.first_name')]) !!}
    {!! FormField::text('last_name', ['required' => true, 'label' => trans('employee.last_name')]) !!}
    {!! FormField::select('company_id', $companyList, ['required' => true, 'label' => trans('employee.company'), 'placeholder' => trans('company.select')]) !!}
    {!! FormField::email('email', ['label' => trans('employee.email')]) !!}
    {!! FormField::text('phone', ['label' => trans('employee.phone')]) !!}
    {!! Form::submit(trans('employee.create'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('employees.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endcan
@endif
@if (Request::get('action') == 'edit' && $editableEmployee)
@can('update', $editableEmployee)
    {!! Form::model($editableEmployee, ['route' => ['employees.update', $editableEmployee],'method' => 'patch']) !!}
    {!! FormField::text('first_name', ['required' => true, 'label' => trans('employee.first_name')]) !!}
    {!! FormField::text('last_name', ['required' => true, 'label' => trans('employee.last_name')]) !!}
    {!! FormField::select('company_id', $companyList, ['required' => true, 'label' => trans('employee.company'), 'placeholder' => trans('company.select')]) !!}
    {!! FormField::email('email', ['label' => trans('employee.email')]) !!}
    {!! FormField::text('phone', ['label' => trans('employee.phone')]) !!}
    @if (request('q'))
        {{ Form::hidden('q', request('q')) }}
    @endif
    @if (request('page'))
        {{ Form::hidden('page', request('page')) }}
    @endif
    {!! Form::submit(trans('employee.update'), ['class' => 'btn btn-success']) !!}
    {{ link_to_route('employees.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
    {!! Form::close() !!}
@endcan
@endif
@if (Request::get('action') == 'delete' && $editableEmployee)
@can('delete', $editableEmployee)
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">{{ trans('employee.delete') }}</h3></div>
        <div class="panel-body">
            <label class="control-label">{{ trans('app.name') }}</label>
            <p>{{ $editableEmployee->first_name }} {{ $editableEmployee->last_name }}</p>
            <label class="control-label">{{ trans('employee.company') }}</label>
            <p>{{ $editableEmployee->company->name }}</p>
            <label class="control-label">{{ trans('employee.email') }}</label>
            <p>{{ $editableEmployee->email }}</p>
            <label class="control-label">{{ trans('employee.phone') }}</label>
            <p>{{ $editableEmployee->phone }}</p>
            {!! $errors->first('employee_id', '<span class="form-error small">:message</span>') !!}
        </div>
        <hr style="margin:0">
        <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
        <div class="panel-footer">
            {!! FormField::delete(
                ['route' => ['employees.destroy', $editableEmployee]],
                trans('app.delete_confirm_button'),
                ['class'=>'btn btn-danger'],
                [
                    'employee_id' => $editableEmployee->id,
                    'page' => request('page'),
                    'q' => request('q'),
                ]
            ) !!}
            {{ link_to_route('employees.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
        </div>
    </div>
@endcan
@endif
