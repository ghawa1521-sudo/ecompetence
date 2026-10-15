

$('.list').DataTable({
    colReorder: false,
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
    },
    dom: 'Bfrtip',
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
    ]
});


var tablechk = $('.records_chk').DataTable({
    "ordering": true,
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
    },
    dom: 'lBfrtip',
    colReorder: false,
    buttons: [
        'copyHtml5',
        'excelHtml5',
        {
            extend: "pdfHtml5",
            orientation: "landscape"
        }


    ],
    'columnDefs': [
        {
            'targets': 0,
            'checkboxes': {
                'selectRow': true,
                'selectCallback': function (nodes, selected) {
                    $('input[type="checkbox"]', nodes).iCheck('update');
                },
                'selectAllCallback': function (nodes, selected, indeterminate) {
                    $('input[type="checkbox"]', nodes).iCheck('update');
                }
            }
        }
    ],
    'order': [[1, 'asc']],
    'drawCallback': function () {
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-orange'
        });
    },
});
$('.records_chk').on('ifChanged', '.dt-checkboxes-select-all input[type="checkbox"]', function (event) {
    var col = tablechk.column($(this).closest('th'));
    col.checkboxes.select(this.checked);
});

// Handle iCheck change event for checkboxes in table body
$('.records_chk').on('ifChanged', '.dt-checkboxes', function (event) {
    var cell = tablechk.cell($(this).closest('td'));
    cell.checkboxes.select(this.checked);
});


$('.records_list').DataTable({
    "ordering": true,
    "order": [],
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
    },
    dom: 'lBfrtip',
    colReorder: false,
    buttons: [
        {
            extend: "copyHtml5",
            exportOptions: {
                    columns: ':visible'
                }
        },
        {
            extend: "excelHtml5",
            exportOptions: {
                    columns: ':visible'
                }
        },
        {
            extend: "pdfHtml5",
            orientation: "landscape",
            exportOptions: {
                    columns: ':visible'
                }
        },
        {
            extend: "print",
            text:"Imprimer",
            orientation: "landscape",
            exportOptions: {
                    columns: ':visible'
                }
        },
         {
            extend: "colvis",
            text:"Afficher / Cacher colonnes"
        }


    ]
});

$('#records_list1').DataTable({
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.11/i18n/French.json"
    },
    dom: 'Bfrtip',
    colVis: {
        "buttonText": "Change columns"
    },
    colReorder: true,
    buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        {
            extend: "pdfHtml5",
            orientation: "landscape"
        },
        'print'


    ]
});

$('#form_chk').on('submit', function (e) {
    var form = this;

    var rows_selected = tablechk.column(0).checkboxes.selected();

    // Iterate over all selected checkboxes
    $.each(rows_selected, function (index, rowId) {
        //alert(rowId);
        // Create a hidden element
        $(form).append(
                $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id[]')
                .val(rowId)
                );
    });
});

$('.form_valider').on('submit', function (e) {
    var form = this;

    var rows_selected = tablechk.column(0).checkboxes.selected();

    // Iterate over all selected checkboxes
    $.each(rows_selected, function (index, rowId) {
        //alert(rowId);
        // Create a hidden element
        $(form).append(
                $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id[]')
                .val(rowId)
                );
    });
});
