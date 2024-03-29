@extends('layout.master') @push('css')
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sb-1.3.3/sl-1.4.0/datatables.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush @section('content')
<div class="card">
    @if ($errors->any())
    <div class="card-header">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="card-body">
        <a class="btn btn-success" href="{{ route('course.create') }}">
            Create
        </a>
        <div class="form-group">
            <select id="select-name"></select>
        </div>
        <table class="table table-striped table-centered mb-0" id="table-index">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Number Students</th>
                    <th>Created At</th>
                    <th>Edit</th>
                    @if(checkSuperAdmin())
                    <th>Delete</th>
                    @endif
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection @push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fc-4.1.0/fh-3.2.3/r-2.3.0/rg-1.2.0/sc-2.0.6/sb-1.3.3/sl-1.4.0/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function () {
        $("#select-name").select2({
            ajax: {
                url: "{{ route('course.api.name')}}",
                dataType: 'json',
                // delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, params) {
                    console.log(data);
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        })
                    };
                }
            },
            placeholder: 'Search for a name',
        });

        var buttonCommon = {
            exportOptions: {
                columns: ':visible :not(.not-export)',
            }
        };
        let table = $('#table-index').DataTable({
            dom: 'Blrtip',
            select: true,
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copyHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excelHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdfHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'csvHtml5'
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'print'
                }),
                'colvis'
            ],
            // lengthMenu: [1, 25, 50, 75, 100],
            processing: true,
            serverSide: true,
            ajax: '{!! route('course.api') !!}',
            columnDefs: [
                { className: "not-export", "targets": [3] }
            ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'students_count', name: 'number_students' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: 'edit',
                    targets: 3,
                    orderable: false,
                    searchable: false,
                    "render": function (data, type, row, meta) {
                        return `<a
                        class="btn btn-primary"
                        href="${data}">
                        Edit
                    </a>`;
                    }
                },
                    @if (checkSuperAdmin()) {
            data: 'destroy',
                targets: 4,
                    orderable: false,
                        searchable: false,
                            "render": function (data, type, row, meta) {
                                return `<form
                        action="${data}"
                        method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete btn btn-danger">Delete</button>
                    </form>`;
                            }
        },
        @endif
            ]
    });

    $('#select-name').change(function () {
        table.columns(0).search(this.value).draw();
    });

    $(document).on('click', '.btn-delete', function () {
        // let row = $(this).parents('tr');
        let form = $(this).parents('form');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            success: function () {
                console.log("Success");
                // row.remove();
                table.draw();
            },
            error: function () {
                console.log("error");
            }
        });
    });
    });
</script>
@endpush