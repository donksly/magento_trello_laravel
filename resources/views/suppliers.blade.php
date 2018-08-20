@extends('layouts.index')

@section('content')
    <div class="row">
        <br>
        <div class="col-md-6">
            <h5>Add New</h5>
            <form action="{{ url('/create_new_supplier') }}" method="post">
            {{ csrf_field() }}
                <div class="form-group">
                    <select name="new_supplier_name" id="new_supplier_mame" class="form-control" required>
                        <option value="" selected disabled>Select Supplier Name</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_supplier_url">URL address:</label>
                    <input type="url" class="form-control" name="new_supplier_url" id="new_supplier_url" maxlength="50" value="{{ old('new_supplier_url') }}" required>
                </div>
                <div class="form-group">
                    <label for="new_supplier_email">Email address:</label>
                    <input type="email" class="form-control" name="new_supplier_email" id="new_supplier_email" maxlength="50" {{ old('new_supplier_email') }} required>
                </div>
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-send"></i>
                    Save supplier
                </button>
            </form>
        </div>
    </div><br><br>
    <div class="all-suppliers-table-div">
        <h5>All Suppliers</h5>
        <table id="all_orders_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>URL</th>
                <th>Email</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>URL</th>
                <th>Email</th>
            </tr>
            </tfoot>
            <tbody>
            <tr>
                <td>1</td>
                <td>A</td>
                <td>https:trello.com/kepha/a</td>
                <td>{{ 'supplier_a@trello.com' }}</td>
            </tr>
            </tbody>
        </table>
    </div><br>
    @endsection

<script src="{{asset('js/app.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#link_all_suppliers').attr('class', 'active');
        $('#page_header_title').html('<i class="fa fa-cogs"></i> Suppliers - back office');
    });
</script>
