<div class="modal-header">
    <h4 class="modal-title">Add or Change Supplier</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <h6>Order Number: {{ $request_values[0] }}</h6><br>

    <form action="{{ url('/modal_save_update_supplier') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="modal_new_supplier">
                @if($request_values[2]=='')
                    Add new supplier:
                @else
                    Update supplier:
                @endif
            </label>
            <select name="modal_new_supplier" id="modal_new_supplier" class="form-control" required>
                <option value="" selected disabled>Select</option>
                <option value="1">A</option>
                <option value="2">B</option>
            </select><br>
            <input type="text" name="order_id" value="{{ $request_values[1] }}" hidden>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-send"></i>
                Save supplier
            </button>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>