<div class="modal-header">
    <h4 class="modal-title">View Order #{{ $request_values[3] }}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <div class="modal-view-order-details">
        <h6>Purchase point: {{ $request_values[4] }}</h6>
        <h6>Purchase date: {{ $request_values[5] }}</h6>
        <h6>Customer name: {{ $request_values[6] }}</h6>
        <h6>Customer email: {{ $request_values[7] }}</h6>
        <h6>Grand total: {{ ucwords(strtolower($request_values[12])).' '.round($request_values[8], 2) }}</h6>
        <h6>
            Current state: <a href="javascript:;" class="btn btn-primary" id="status-color-created"
                              style="background-color: {{ $request_values[10] }}">
            </a> {{ ucwords(strtolower($request_values[9])) }}
        </h6>
    </div>
    <br>

    <hr>
    @if($request_values[2] == '')
        Order tracking has no errors.
        @else
        Errors found:
        <p>
            <code>{{ $request_values[2] }}</code>
        </p>
        <form action="{{ url('/modal_fix_errors_form') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="order_id" value="{{ $request_values[1] }}" hidden>
                <input type="text" name="modal_current_supplier" value="{{ $request_values[11] }}" hidden>
                <button class="btn btn-warning" type="submit">
                    <i class="fa fa-check-square-o"></i>
                    One click fix
                </button>
            </div>
        </form>
    @endif

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>