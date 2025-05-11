document.addEventListener('DOMContentLoaded', () => {
    const serviceSelect = document.querySelector('#estimate_service');
    const priceInput = document.querySelector('#estimate_price');

    if (serviceSelect && priceInput) {
        serviceSelect.addEventListener('change', () => {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || '';
            priceInput.value = price;
        });

        const initialOption = serviceSelect.options[serviceSelect.selectedIndex];
        if (initialOption && initialOption.getAttribute('data-price')) {
            priceInput.value = initialOption.getAttribute('data-price');
        }
    }
});