$(document).ready(function() {
    let itemCount = 1;

    // Handle product selection change
    $('#productSelect').change(function() {
        let selectedOption = $(this).find('option:selected');
        let price = selectedOption.data('price');
        let taxId = selectedOption.data('tax-id');
        let taxRate = selectedOption.data('tax');
        let taxName = selectedOption.data('tax-name');

        // Set purchase price
        $('#purchasePrice').val(price);

        // Set tax
        $('#taxSelect').val(taxId);

        calculateTotals();
    });

    // Handle tax selection change
    $('#taxSelect').change(function() {
        calculateTotals();
    });
});

function calculateTotals() {
    let kantaWeight = parseFloat($('#kantaWeight').val()) || 0;
    let purchasePrice = parseFloat($('#purchasePrice').val()) || 0;
    let salePrice = parseFloat($('#salePrice').val()) || 0;
    let vehicleRate = parseFloat($('#vehicleRate').val()) || 0;
    let taxRate = parseFloat($('#taxSelect option:selected').data('tax-rate')) || 0;

    // Calculate subtotals without tax
    let purchaseSubtotal = kantaWeight * purchasePrice;
    let saleSubtotal = kantaWeight * salePrice;
    let vehicleSubtotal = kantaWeight * vehicleRate;

    // Calculate tax amounts
    let purchaseTax = (purchaseSubtotal * taxRate) / 100;
    let saleTax = (saleSubtotal * taxRate) / 100;
    let vehicleTax = (vehicleSubtotal * taxRate) / 100;

    // Calculate final totals including tax
    let purchaseTotal = purchaseSubtotal + purchaseTax;
    let saleTotal = saleSubtotal + saleTax;
    let vehicleTotal = vehicleSubtotal + vehicleTax;

    // Update the total fields
    $('#purchaseTotal').val(purchaseTotal.toFixed(2));
    $('#saleTotal').val(saleTotal.toFixed(2));
    $('#vehicleTotal').val(vehicleTotal.toFixed(2));
}
