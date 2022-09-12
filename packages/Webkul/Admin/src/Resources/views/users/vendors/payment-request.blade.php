@extends('admin::layouts.content')

@section('page_title') Payments and Earnings @stop

@section('content')
<form method="POST" action="{{ route('admin.payment-request.create') }}">
    @csrf
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>Payments and Earnings</h1>
            </div>
        </div>
        <div class="page-content">
            <accordian :title="'Create New Payment Request'" :active="true">
                <div slot="body">
                    <div class="control-group {{ $errors->first('amount_requested') ? 'has-error' :'' }}">
                        <label class="required">Amount To Request</label>
                        <input type="tel" maxlength="7" onkeypress="validate()" class="control" name="amount_requested" />
                        <span class="control-error">{{ $errors->first('amount_requested') }}</span>
                    </div>
                    <div class="control-group">
                        <button type="submit" class="btn btn-lg btn-primary">Submit Request</button>
                    </div>
                </div>
            </accordian>    
            <datagrid-plus src="{{ route('admin.payment-request.index') }}"></datagrid-plus>
        </div>
    </div>
</form>
@stop

@push('script')
<script>
    function validate(evt) {
        var theEvent = evt || window.event;
        if (theEvent.type === 'paste')
            key = event.clipboardData.getData('text/plain');
        else {
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>    
@endpush

