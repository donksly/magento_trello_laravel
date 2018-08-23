<div class="modal-header">
    <h4 class="modal-title">Ask Return</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <h6>Order Number: #{{ $request_values[0] }}</h6><br>

    <form action="{{ url('/modal_request_return') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" name="modal_send_return_chkbox" type="checkbox" required> Check to ask return
                </label>
            </div>
            <br>
            <input type="text" name="order_id" value="{{ $request_values[0] }}" hidden>
            <input type="text" name="supplier_id" value="{{ $request_values[2] }}" hidden>
            <button class="btn btn-success" type="submit">
                <i class="fa fa-send"></i>
                Request return
            </button>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>