<div class="modal-header">
    <h4 class="modal-title">View Order {{ $request_values[0] }}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <h6>Purchase point: {{ $request_values[0] }}</h6>
    <h6>Purchase date: {{ $request_values[0] }}</h6>
    <h6>Bill to: {{ $request_values[0] }}</h6>
    <h6>Ship to: {{ $request_values[0] }}</h6>
    <h6>Grand total: {{ $request_values[0] }}</h6>
    <h6>Current state: {{ $request_values[0] }}</h6>
    <br>


    @if($request_values[2]=='')
        Order tracking has no errors.
        @else
        Errors found:
        <p>
            <code>sdjfhsggashdvasdfjhsdngfjsdgajhmfgadsjfgdsnvsdfashfgds</code>
        </p>
        <form action="{{ url('/modal_fix_errors_form') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="order_id" value="{{ $request_values[1] }}" hidden>
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