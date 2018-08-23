@extends('layouts.index')

@section('content')
    <div class="row">
        <br>
        <div class="col-md-6" id="import-json-to-orders">
            <h5>Add JSON from supplier</h5>
            <form action="{{ url('/upload_supplier_database') }}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                    <select name="new_supplier_name" id="new_supplier_mame" class="form-control" required>
                        <option value="" selected disabled>Select Supplier</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_supplier_url">Add JSON content:</label><br>
                    <textarea name="supplier_json" id="supplier_json" placeholder="JSON" required></textarea>
                </div>
                <h5>Feature Under Construction!</h5>
                <button class="btn btn-success" type="submit" disabled>
                    <i class="fa fa-cloud-upload"></i>
                    Update order table
                </button>
            </form>
        </div>
    </div><br><br>
    @endsection

<script src="{{secure_asset('js/app.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#link_import').attr('class', 'active');
        $('#page_header_title').html('<i class="fa fa-circle-o-notch fa-spin"></i> Import to Orders ');
    });
</script>
