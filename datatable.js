
$('#dataTable').ready( function () {
        $('#record_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                        {
                        extend: 'csv',
                        text: 'Export Data to CSV',
                        className: 'btn btn-primary',
                        exportOptions: {
                                columns: 'th:not(:last-child,:first-child)'
                        }
                },
                {
                        extend: 'excel',
                        text: 'Export Data to Excel',
                        className: 'btn btn-warning',
                        exportOptions: {
                                columns: 'th:not(:last-child,:first-child)'
                        }
                },
                {
                        extend: 'print',
                        text: 'Export Data to Print',
                        className: 'btn btn-success',
                        exportOptions: {
                                columns: 'th:not(:last-child,:first-child)'
                        }
                }
                ]
        });
} );


// 'copy', 'csv', 'excel', 'pdf', 'print'