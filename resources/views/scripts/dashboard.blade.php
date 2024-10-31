<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('customer_search');
        const searchButton = document.getElementById('customer_search_btn');
        const customersList = document.getElementById('customers_list');

        const fetchCustomersUrl = @json(route('customers.fetch'));

        searchButton.addEventListener('click', function() {
            fetchCustomers(searchInput.value);
        });

        function fetchCustomers(search) {
            fetch(`${fetchCustomersUrl}?search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    customersList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(customer => {
                            const customerDiv = document.createElement('div');
                            customerDiv.classList.add('customer-item');
                            customerDiv.innerHTML = `
                                <h5>${customer.name}</h5>
                                <p>Phone: ${customer.phone}</p>
                            `;
                            customersList.appendChild(customerDiv);
                        });
                    } else {
                        customersList.innerHTML = '<p>No customers found.</p>';
                    }
                })
                .catch(error => console.error('Error fetching customers:', error));
        }
    });
</script>