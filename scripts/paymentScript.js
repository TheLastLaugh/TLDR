document.addEventListener("DOMContentLoaded", function() {
    const paymentForm = document.getElementById('paymentForm');

    // change the display of the payment form
    document.getElementById('togglePaymentForm').addEventListener('click', function() {
        paymentForm.style.display = 'block';
        document.getElementById('togglePaymentForm').style.display = 'none';
    });

    // Add listener for the payment method selection
    const paymentMethodsDropdown = document.getElementById('paymentMethodsDropdown');
    // Store the CVV box div
    const cvvBox = document.getElementById('cvvBox');
    if (paymentMethodsDropdown) {

        paymentMethodsDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const method_name = selectedOption.getAttribute('data-method_name');
            const address = selectedOption.getAttribute('data-address');
            const card_type = selectedOption.getAttribute('data-card_type');
            const card_number = selectedOption.getAttribute('data-card_number');
            
            // Set the values of the form inputs
            document.querySelector('input[name=method_name]').value = method_name;
            document.querySelector('input[name=address]').value = address;
            document.querySelector('select[name=card_type]').value = card_type;
            document.querySelector('input[name=card_number]').value = card_number;

            cvvBox.style.display = 'block';
        });
    }
});