document.addEventListener("DOMContentLoaded", function() {
    const paymentForm = document.getElementById('paymentForm');
    // Store the CVV box div
    const cvvBox = document.getElementById('cvvBox');
    
    // change the display of the payment form
    document.getElementById('togglePaymentForm').addEventListener('click', function() {
        paymentForm.style.display = 'block';
        cvvBox.style.display = 'block';
;        document.getElementById('togglePaymentForm').style.display = 'none';
    });

    // Add listener for the payment method selection
    const paymentMethodsDropdown = document.getElementById('paymentMethodsDropdown');
    
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

    const creditCardInput = document.getElementById('creditCardInput');

    if (creditCardInput) {
        creditCardInput.addEventListener('change', function() {
            if(!checkCardValidity(creditCardInput.value)) {
                creditCardInput.setCustomValidity('This is not a valid card number');
            } else {
                creditCardInput.setCustomValidity('');
            }
        })
    }
     
    // Checks the validity of a credit card number based on Luhns (mod10) algorithm
    function checkCardValidity(cardNumber) {
        let numDigits = cardNumber.length;
 
        let sum = 0;
        let isSecond = false;
        for (let i = numDigits - 1; i >= 0; i--) {
 
            let digit = cardNumber[i].charCodeAt() - '0'.charCodeAt();
 
            if (isSecond) {
                digit = digit * 2;
            }
                
            sum += parseInt(digit / 10, 10);
            sum += digit % 10;
 
            isSecond = !isSecond;
        }
        return (sum % 10 == 0);
    }
});