@extends('layouts.template')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar level</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-sm table-striped table-hover" id="table_level">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode level</th>
                        <th>Nama level</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var tableLevel;
        $(document).ready(function() {
            tableLevel = $('#table_level').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/level/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.filter_kategori = $('.filter_kategori').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },{
                    data: "level_kode",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "level_nama",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true,
                }]
            });
            $('#table_level_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableLevel.search(this.value).draw();
                }
            });
            $('.filter_kategori').change(function() {
                tableLevel.draw();
            });
        });
    </script>
@endpush