$(document).ready(function() {
    $("#vendorId").select2({
        placeholder: "Select Vendor",
        allowClear: true,
        width: '100%',
        theme: 'bootstrap-5',
        minimumInputLength: 1, // Only show options when typing
        ajax: {
            url: baseUrl + '/vendor/search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(vendor) {
                        return {
                            id: vendor.id,
                            text: vendor.name
                        };
                    })
                };
            },
            cache: true
        }
    });
});
