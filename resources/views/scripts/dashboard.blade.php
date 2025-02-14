<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('customer_search');
        const searchButton = document.getElementById('customer_search_btn');
        const customersList = document.getElementById('customers_list');
        const transactionFormContainer = document.getElementById('transaction_form_container');
        const fetchCustomersUrl = @json(route('customers.fetch'));
        const fetchOptionsUrl = @json(route('transactions.fetch_options'));
        const userRole = @json(auth()->user()->role);
        const todayTransactionsContainer = document.getElementById('today_transactions_container');
        const fetchTodayTransactionsUrl = @json(route('transactions.today'));
        const transactionShowUrl = @json(route('transactions.show', ''));

        fetchCustomers('');

        fetchTodayTransactions();

        searchButton.addEventListener('click', function() {
            fetchCustomers(searchInput.value);
        });

        function applyRoleRestrictions() {
            if (userRole !== 'admin') {
                document.querySelector('input[name="transaction_date"]').disabled = true;
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
            transactionFormContainer.innerHTML = `
                <h5>Creating Transaction for ${customerName}</h5>
                <form id="transaction_form" method="POST" enctype="multipart/form-data" action="{{ route('transactions.create') }}">
                    @csrf
                    <input type="hidden" name="customer_id" value="${customerId}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                        <label for="transaction_date">Transaction Date *</label>
                        <input type="datetime-local" name="transaction_date" class="form-control" value="" id="datetime" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pistol_source">Pistol Source *</label>
                                <select name="pistol_source" class="form-control" required>
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

                    <input type="hidden" name="closed" value="0">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-success mt-1" id="closeTransaction">Pay/Close Transaction</button>
                        <button type="submit" class="btn btn-info mt-1">Save Transaction</button>
                    </div>
                </form>
            `;

            applyRoleRestrictions();

            document.getElementById('add_item_btn').addEventListener('click', addTransactionItem);
            addTransactionItem();

            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 16);
            document.getElementById('datetime').value = formattedDate;
        }

        function addTransactionItem() {
            const itemContainer = document.createElement('div');
            itemContainer.classList.add('transaction-item', 'd-flex', 'mb-1', 'align-items-center');
            itemContainer.innerHTML = `
                <div class="form-group col-3 mr-2">
                    <label>Type</label>
                    <select name="item_type[]" class="form-control item-type-select" required>
                        <option value="">Select Type</option>
                        <option value="lane">Rent a Lane</option>
                        <option value="pistol">Rent a Pistol</option>
                        <option value="caliber">Buy Calibers</option>
                    </select>
                </div>
                <div class="form-group col-3 mr-2">
                    <label>Item</label>
                    <select name="specific_item[]" class="form-control specific-item-select" required>
                        <option value="">Select Item</option>
                    </select>
                </div>
                <div class="form-group col-2 mr-2">
                    <label>Quantity</label>
                    <input type="number" name="quantity[]" class="form-control quantity-input" min="0.5" value="1" step="0.5" required>
                </div>
                <div class="form-group col-2 mr-2">
                    <label>Unit Price</label>
                    <input type="number" name="unit_price[]" class="form-control unit-price-input" step="any" min="1" required>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-item-btn"><i class="la la-trash"></i></button>
            `;

            document.getElementById('transaction_items_container').appendChild(itemContainer);

            itemContainer.querySelector('.item-type-select').addEventListener('change', function() {
                loadItemOptions(this);
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
                const quantityInput = itemContainer.querySelector('.quantity-input');
                const unitPriceInput = itemContainer.querySelector('.unit-price-input');

                const quantity = quantityInput ? parseFloat(quantityInput.value) || 0 : 0;
                const unitPrice = unitPriceInput ? parseFloat(unitPriceInput.value) || 0 : 0;

                total += quantity * unitPrice;
            });
            document.getElementById('total_price').textContent = total.toFixed(2);
        }

        function fetchTodayTransactions() {
            fetch(fetchTodayTransactionsUrl)
                .then(response => response.json())
                .then(data => {
                    todayTransactionsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(transaction => {
                            const transactionDiv = document.createElement('div');
                            transactionDiv.classList.add('transaction-item', 'clickable-transaction');
                            transactionDiv.innerHTML = `
                                <div>Transaction: #${transaction.id}</div>
                                <div>User: ${transaction.user.name}</div>
                                <div>Customer: ${transaction.customer.name}</div>
                                <div>Date: ${new Date(transaction.transaction_date).toLocaleString()}</div>
                                <div>Total: $${transaction.total.toFixed(2)}</div>
                            `;
                            transactionDiv.addEventListener('click', () => {
                                window.location.href = `${transactionShowUrl}/${transaction.id}`;
                            });
                            todayTransactionsContainer.appendChild(transactionDiv);
                        });
                    } else {
                        todayTransactionsContainer.innerHTML = '<p>No Transactions Found For Today...</p>';
                    }
                })
                .catch(error => console.error('Error fetching today\'s Transactions:', error));
        }

        const closeTransactionButton = document.querySelector('#closeTransaction');
        const transactionForm = document.getElementById('transaction_form');
        const closedInput = transactionForm.querySelector('input[name="closed"]');

        closeTransactionButton.addEventListener('click', function () {
            closedInput.value = 1;
            transactionForm.submit();
        });
    });
</script>