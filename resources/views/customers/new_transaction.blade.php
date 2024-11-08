@extends('layouts.app')

@section('title', 'New Transaction')

@section('content')
<div class="container">
    <h5>Creating Transaction for {{ ucwords($customer->name) }}</h5>
    <form id="transaction_form" method="POST" enctype="multipart/form-data" action="{{ route('transactions.create') }}">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <div class="form-group">
            <label for="transaction_date">Transaction Date *</label>
            <input type="datetime-local" name="transaction_date" class="form-control" value="{{now()}}" required>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userRole = @json(auth()->user()->role);
        const fetchOptionsUrl = @json(route('transactions.fetch_options'));

        function applyRoleRestrictions() {
            if (userRole !== 'admin') {
                document.querySelector('input[name="transaction_date"]').disabled = true;
                document.querySelectorAll('.unit-price-input').forEach(input => input.disabled = true);
            }
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

            applyRoleRestrictions();
        }

        document.getElementById('add_item_btn').addEventListener('click', addTransactionItem);
        addTransactionItem();

        applyRoleRestrictions();
    });

</script>
@endsection
