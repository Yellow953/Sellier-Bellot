<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('customer_search');
        const searchButton = document.getElementById('customer_search_btn');
        const customersList = document.getElementById('customers_list');
        const transactionFormContainer = document.getElementById('transaction_form_container');
        const fetchCustomersUrl = @json(route('customers.fetch'));
        const fetchOptionsUrl = @json(route('transactions.fetch_options'));
        const userRole = @json(auth()->user()->role);

        fetchCustomers('');

        searchButton.addEventListener('click', function() {
            fetchCustomers(searchInput.value);
        });

        function applyRoleRestrictions() {
            if (userRole !== 'admin') {
                document.querySelector('input[name="transaction_date"]').disabled = true;
                document.querySelectorAll('.unit-price-input').forEach(input => input.disabled = true);
            }
        }

        function fetchCustomers(search) {
            fetch(`${fetchCustomersUrl}?search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    customersList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(customer => {
                            const customerDiv = document.createElement('div');
                            customerDiv.classList.add('customer-item', 'd-flex', 'justify-content-between', 'align-items-center', 'mb-1');
                            customerDiv.innerHTML = `
                                <span>${customer.name} | ${customer.phone}</span>
                                <button class="btn btn-sm btn-info select-customer-btn" data-id="${customer.id}" data-name="${customer.name}">+</button>
                            `;
                            customersList.appendChild(customerDiv);
                        });

                        document.querySelectorAll('.select-customer-btn').forEach(button => {
                            button.addEventListener('click', function() {
                                const customerId = this.getAttribute('data-id');
                                const customerName = this.getAttribute('data-name');
                                displayTransactionForm(customerId, customerName);
                            });
                        });
                    } else {
                        customersList.innerHTML = '<p>No customers found.</p>';
                    }
                })
                .catch(error => console.error('Error fetching customers:', error));
        }

        function displayTransactionForm(customerId, customerName) {
            const currentDate = new Date().toISOString().slice(0, 16);
            transactionFormContainer.innerHTML = `
                <h5>Creating Transaction for ${customerName}</h5>
                <form id="transaction_form" method="POST" enctype="multipart/form-data" action="{{ route('transactions.create') }}">
                    @csrf
                    <input type="hidden" name="customer_id" value="${customerId}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                        <label for="transaction_date">Transaction Date *</label>
                        <input type="datetime-local" name="transaction_date" class="form-control" value="${currentDate}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gun_source">Gun Source *</label>
                                <select name="gun_source" class="form-control" required>
                                    <option value="club">Club</option>
                                    <option value="self">Self</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ammo_source">Ammo Source *</label>
                                <select name="ammo_source" class="form-control" required>
                                    <option value="club">Club</option>
                                    <option value="self">Self</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h6>Transaction Items</h6>
                    <div id="transaction_items_container"></div>

                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <button type="button" class="btn btn-sm btn-info mb-1" id="add_item_btn">Add Item</button>
                        <div class="form-group">
                            <label>Total Price: </label>
                            <span id="total_price">0.00</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-info mt-1">Submit Transaction</button>
                    </div>
                </form>
            `;

            applyRoleRestrictions();

            document.getElementById('add_item_btn').addEventListener('click', addTransactionItem);
            addTransactionItem();
        }

        function addTransactionItem() {
            const itemContainer = document.createElement('div');
            itemContainer.classList.add('transaction-item', 'd-flex', 'mb-1', 'align-items-center');
            itemContainer.innerHTML = `
                <div class="form-group mr-2">
                    <label>Type</label>
                    <select name="item_type[]" class="form-control item-type-select" required>
                        <option value="">Select Type</option>
                        <option value="corridor">Rent a Corridor</option>
                        <option value="gun">Rent a Gun</option>
                        <option value="caliber">Buy Calibers</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label>Item</label>
                    <select name="specific_item[]" class="form-control specific-item-select" required>
                        <option value="">Select Item</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label>Quantity</label>
                    <input type="number" name="quantity[]" class="form-control quantity-input" min="1" value="1" required>
                </div>
                <div class="form-group mr-2">
                    <label>Unit Price</label>
                    <input type="number" name="unit_price[]" class="form-control unit-price-input" step="any" min="1" required>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-item-btn"><i class="la la-trash"></i></button>
            `;

            document.getElementById('transaction_items_container').appendChild(itemContainer);

            itemContainer.querySelector('.item-type-select').addEventListener('change', function() {
                loadItemOptions(this);
                const quantityInput = itemContainer.querySelector('.quantity-input');

                if (this.value === 'corridor') {
                    quantityInput.addEventListener('change', () => {
                        quantityInput.value = 1;
                        calculateTotal();
                    })
                }
            });

            itemContainer.querySelector('.specific-item-select').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                const unitPriceInput = itemContainer.querySelector('.unit-price-input');
                unitPriceInput.value = price || '';
                calculateTotal();
            });

            itemContainer.querySelector('.quantity-input').addEventListener('input', calculateTotal);
            itemContainer.querySelector('.unit-price-input').addEventListener('input', calculateTotal);

            itemContainer.querySelector('.remove-item-btn').addEventListener('click', function() {
                itemContainer.remove();
                calculateTotal();
            });

            if (userRole !== 'admin') {
                itemContainer.querySelector('.unit-price-input').disabled = true;
            }
        }

        function loadItemOptions(itemTypeSelect) {
            const specificItemSelect = itemTypeSelect.closest('.transaction-item').querySelector('.specific-item-select');
            const selectedType = itemTypeSelect.value;

            if (!selectedType) {
                specificItemSelect.innerHTML = '<option value="">Select Item</option>';
                return;
            }

            fetch(`${fetchOptionsUrl}?type=${selectedType}`)
                .then(response => response.json())
                .then(data => {
                    specificItemSelect.innerHTML = '<option value="">Select Item</option>';
                    data.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option.id;
                        opt.textContent = option.name;
                        opt.setAttribute('data-price', option.price);
                        specificItemSelect.appendChild(opt);
                    });
                })
                .catch(error => console.error('Error fetching item options:', error));
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.transaction-item').forEach(itemContainer => {
                const quantity = parseFloat(itemContainer.querySelector('.quantity-input').value) || 0;
                const unitPrice = parseFloat(itemContainer.querySelector('.unit-price-input').value) || 0;
                total += quantity * unitPrice;
            });
            document.getElementById('total_price').textContent = total.toFixed(2);
        }
    });
</script>
