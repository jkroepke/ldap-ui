(function ($) {
    $(document).ready(function () {
        $(".panel-left").resizable({
            handleSelector: ".splitter",
            resizeHeight: false
        });

        $('#jstree').jstree({
            "core" : {
                // so that create works
                "check_callback" : true,
                'strings' : {
                    'Loading ...' : Translator.trans('Loading ...')
                },
                'data' : {
                    'url' : '/browser/jstree',
                    'data' : function (node) {
                        return { 'id' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder"
                },
                "root" : {
                    "icon" : "fa fa-users"
                }
            },
            "massload" : {
                "url" : "/browser/jstree/lazy",
                "data" : function (nodes) {
                    return { "ids" : nodes.join(",") };
                }
            },
            "plugins" : [ "contextmenu", "massload", "search", "sort", "types", "wholerow" ]
        }).on("changed.jstree", function (e, data) {
            $('#browser-table').DataTable().ajax.reload();
        });

        $('#browser-table').DataTable({
            "ajax": {
                "url": "/datatable",
                "type": "POST",
                "data": function ( d ) {
                    return $.extend( {}, d, {
                        'baseDn': $('#jstree').jstree('get_selected')[0]
                    });
                }
            },
            "columnDefs": [
                { "width": "60px", "searchable": false, "orderable": false, "targets": 3 }
            ],
            "columns": [
                { "data": "cn" },
                { "data": "objectClass" },
                { "data": "description" },
                { "data": "actions" }
            ],
            "deferRender": true,
            "processing": false,
            "serverSide": true,
            "paging": false,
            "searching": false,
            "bInfo" : false
        }).on( 'processing.dt', function ( e, settings, processing ) {
            if(processing) {
                $('.panel-right').addClass('loading');
            } else {
                $('.panel-right').removeClass('loading');
            }
        });

        var table = $('#browser-table').DataTable();

        $('#browser-table tbody').on('dblclick', 'tr', function () {
            var data = table.row( this ).data();
            alert( 'You clicked on '+data[0]+'\'s row' );
        });
    })
})(jQuery);