$(document).ready(function() {
    $("#vehicleId").select2({
        placeholder: "Select Vehicle",
        allowClear: true,
        width: '100%',
        theme: 'bootstrap-5',
        minimumInputLength: 1, // Only show options when typing
        ajax: {
            url: baseUrl + '/vehicle/search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(vehicle) {
                        return {
                            id: vehicle.id,
                            text: vehicle.driver_name ?
                                vehicle.driver_name + ' (' + vehicle.vehicle_name + ')' :
                                vehicle.owner_name + ' (' + vehicle.vehicle_name + ')'
                        };
                    })
                };
            },
            cache: true
        }
    });
});
