(function($) {
    if(typeof $.fn.dataTable !== 'undefined') {
        $.extend( true, $.fn.dataTable.defaults, {
            "language": {
                "loadingRecords": Translator.trans('Loading ...'),
                "processing": Translator.trans('Processing ...'),
                "zeroRecords": Translator.trans('No matching records found')
            }
        });
    }
}(jQuery));