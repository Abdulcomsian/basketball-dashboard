<script>
// Configuration of DataTable for default behavior
$(function () {
    let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json',
        'hu': '{{ asset("lang/hu/datatable.json") }}', // Set the path to your Hungarian language file
    };

    let dataTableConfig = {
        language: {
            url: languages['{{ app()->getLocale() }}']
        },
        columnDefs: [
            { orderable: false, className: 'select-checkbox', targets: 0 },
            { orderable: false, searchable: false, targets: -1 }
        ],
        select: { style: 'multi+shift', selector: 'td:first-child' },
        order: [],
        scrollX: true,
        pageLength: 100,
        dom: 'lBfrtip<"actions">',
        buttons: [
            { extend: 'selectAll', className: 'btn-primary', text: '{{ trans('global.select_all') }}',
                exportOptions: { columns: ':visible' },
                action: function (e, dt) {
                    e.preventDefault();
                    dt.rows().deselect();
                    dt.rows({ search: 'applied' }).select();
                }
            },
            { extend: 'selectNone', className: 'btn-primary', text: '{{ trans('global.deselect_all') }}',
                exportOptions: { columns: ':visible' }
            },
            { extend: 'copy', className: 'btn-default', text: '{{ trans('global.datatables.copy') }}',
                exportOptions: { columns: ':visible' }
            },
            { extend: 'csv', className: 'btn-default', text: '{{ trans('global.datatables.csv') }}',
                exportOptions: { columns: ':visible' }
            },
            { extend: 'excel', className: 'btn-default', text: '{{ trans('global.datatables.excel') }}',
                exportOptions: { columns: ':visible' }
            },
            { extend: 'pdf', className: 'btn-default', text: '{{ trans('global.datatables.pdf') }}',
                exportOptions: { columns: ':visible' }
            },
            { extend: 'print', className: 'btn-default', text: '{{ trans('global.datatables.print') }}',
                exportOptions: { columns: ':visible' }
            },
            { extend: 'colvis', className: 'btn-default', text: '{{ trans('global.datatables.colvis') }}',
                exportOptions: { columns: ':visible' }
            }
        ]
    };

    $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' });
    $.extend(true, $.fn.dataTable.defaults, dataTableConfig);

    $.fn.dataTable.ext.classes.sPageButton = '';
});

</script>
