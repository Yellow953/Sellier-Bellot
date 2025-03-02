@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
<div class="container">
    <h5>Updating Transaction for {{ ucwords($transaction->customer->name) }}</h5>
    <form id="transaction_form" method="POST" enctype="multipart/form-data"
        action="{{ route('transactions.update', $transaction->id) }}">
        @csrf

        <div class="form-group">
            <label for="transaction_date">Transaction Date *</label>
            <input type="datetime-local" name="transaction_date" class="form-control"
                value="{{ $transaction->transaction_date }}" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="pistol_source">Pistol Source *</label>
                    <select name="pistol_source" class="form-control" required>
                        <option value="club" {{ $transaction->pistol_source == 'club' ? 'selected' : '' }}>Club</option>
                        <option value="self" {{ $transaction->pistol_source == 'self' ? 'selected' : '' }}>Self</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ammo_source">Ammo Source *</label>
                    <select name="ammo_source" class="form-control" required>
                        <option value="club" {{ $transaction->ammo_source == 'club' ? 'selected' : '' }}>Club</option>
                        <option value="self" {{ $transaction->ammo_source == 'self' ? 'selected' : '' }}>Self</option>
                    </select>
                </div>
            </div>
        </div>

        <h6>Transaction Items</h6>
        <div class="existing_items">
            @foreach ($transaction->items as $item)
            <div class="d-flex mb-1 align-items-center">
                <div class="form-group mr-2">
                    <label>Type</label>
                    <input type="text" class="form-control" value="{{ $item->type }}" disabled>
                </div>
                <div class="form-group mr-2">
                    <label>Item</label>
                    @switch($item->type)
                    @case('lane')
                    <input type="text" value="{{ $item->lane->name }}" disabled class="form-control">
                    @break
                    @case('pistol')
                    <input type="text" value="{{ $item->pistol->name }}" disabled class="form-control">
                    @break
                    @case('caliber')
                    <input type="text" value="{{ $item->caliber->name }}" disabled class="form-control">
                    @break
                    @default
                    @endswitch
                </div>
                <div class="form-group mr-2">
                    <label>Quantity</label>
                    <input type="number" value="{{ $item->quantity }}" disabled class="form-control">
                </div>
                <div class="form-group mr-2">
                    <label>Unit Price</label>
                    <input type="number" value="{{ $item->unit_price }}" disabled class="form-control">
                </div>
                <a href="{{ route('transactions.items.destroy', $item->id) }}"
                    class="btn btn-danger btn-sm remove-item-btn show_confirm" data-toggle="tooltip"
                    data-original-title="Delete Caliber"><i class="la la-trash"></i></a>
            </div>
            @endforeach
        </div>

        <div id="transaction_items_container">
        </div>

        <div class="d-flex align-items-center justify-content-between mt-1">
            <button type="button" class="btn btn-sm btn-info mb-1" id="add_item_btn">Add Item</button>
            <div class="form-group">
                <label>Total Price: </label>
                <span id="total_price">0</span>
            </div>
        </div>

        <input type="hidden" name="closed" value="{{ $transaction->closed ? '1' : '0' }}">
        <div class="d-flex justify-content-between">
            @if (!$transaction->closed)
            <button type="button" class="btn btn-success mt-1" id="closeTransaction">Pay/Close Transaction</button>
            @endif

            <button type="submit" class="btn btn-info mt-1">Save Transaction</button>
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
            }
        }

        function calculateTotal() {
            let total = {{ number_format($transaction->total, 2) }};
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
                <button type="button" class="btn btn-danger btn-sm remove-item-btn my-auto"><i class="la la-trash"></i></button>
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

            applyRoleRestrictions();
        }

        document.getElementById('add_item_btn').addEventListener('click', addTransactionItem);

        applyRoleRestrictions();

        const closeTransactionButton = document.querySelector('#closeTransaction');
        const transactionForm = document.getElementById('transaction_form');
        const closedInput = transactionForm.querySelector('input[name="closed"]');

        closeTransactionButton.addEventListener('click', function () {
            closedInput.value = 1;
            transactionForm.submit();
        });
    });

</script>
@endsection