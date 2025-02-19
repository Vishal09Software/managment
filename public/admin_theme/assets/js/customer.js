$(document).ready(function() {
    $("#customerId").select2({
        placeholder: "Select Customer",
        allowClear: true,
        width: '100%',
        theme: 'bootstrap-5',
        minimumInputLength: 1, // Only show options when typing
        ajax: {
            url: baseUrl + '/customer/search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(customer) {
                        return {
                            id: customer.id,
                            text: customer.name
                        };
                    })
                };
            },
            cache: true
        }
    });
});
