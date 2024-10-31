@extends('layouts.app')

@section('title', 'Customers')

@section('content')

<script type="text/javascript" src="https://cdn.asprise.com/scannerjs/scanner.js"></script>

<div class="container">
    <div class="d-flex align-items-center justify-content-between my-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm d-flex align-items-center"><i
                class="la la-angle-left"></i> BACK</a>
        <h2>New Customer</h2>
    </div>

    <form action="{{ route('customers.create') }}" method="POST" enctype="multipart/form-data" id="customerForm">
        @csrf

        <div class="form-group">
            <label for="name">Name *</label>
            <fieldset class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}"
                    required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <fieldset class="form-group">
                <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number"
                    value="{{ old('phone') }}" required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="address">Address *</label>
            <fieldset class="form-group">
                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                    value="{{ old('address') }}" required>
            </fieldset>
        </div>

        <div class="mb-2">
            <label for="verification">Verification Documents *</label>
            <div class="form-group">
                <button type="button" onclick="scanToJpg();" class="btn btn-info btn-sm">Scan</button>
                <div id="images" class="d-flex flex-wrap"></div>
            </div>
        </div>

        <div id="scannedImagesInputs"></div>

        <button type="submit" class="btn btn-info btn-block">
            Create
        </button>
    </form>
</div>

<script>
    function scanToJpg() {
        scanner.scan(displayImagesOnPage, {
            "output_settings": [
                {
                    "type": "return-base64",
                    "format": "jpg"
                }
            ]
        });
    }

    function displayImagesOnPage(successful, mesg, response) {
        if (!successful) {
            console.error('Failed: ' + mesg);
            return;
        }

        if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) {
            console.info('User canceled');
            return;
        }

        const scannedImages = scanner.getScannedImages(response, true, false);
        if (scannedImages instanceof Array) {
            scannedImages.forEach((scannedImage, index) => {
                processScannedImage(scannedImage, index);
            });
        } else {
            console.warn('No scanned images were returned.');
        }
    }

    function processScannedImage(scannedImage, index) {
        const imgElement = document.createElement('img');
        imgElement.className = 'scanned img-thumbnail m-1';
        imgElement.src = scannedImage.src;
        imgElement.style.maxWidth = '150px';
        document.getElementById('images').appendChild(imgElement);

        const inputElement = document.createElement('input');
        inputElement.type = 'hidden';
        inputElement.name = 'scanned_images[]';
        inputElement.value = scannedImage.src;
        document.getElementById('scannedImagesInputs').appendChild(inputElement);
    }
</script>
@endsection