<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('destroy');
    }

    public function index()
    {
        $customers = Customer::select('id', 'name', 'phone', 'document_type', 'address')->filter()->latest()->paginate(25);
        return view('customers.index', compact('customers'));
    }

    public function new()
    {
        return view('customers.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'document_type' => 'required'
        ]);

        if ($request->upload) {
            $index = 0;
            $uploadImages = [];

            foreach ($request->file('upload') as $image) {
                $ext = $image->getClientOriginalExtension();
                $filename = time() . $index . '.' . $ext;
                $image->move('uploads/customers/', $filename);
                $path = '/uploads/customers/' . $filename;
                $uploadImages[] = $path;
                $index++;
            }

            $document1 = $uploadImages[0];
            $document2 = $uploadImages[1] ?? null;
        } else if ($request->scanned_images) {
            $scannedImagesPaths = [];

            foreach ($request->scanned_images as $index => $base64Image) {
                $imageData = explode(',', $base64Image);
                $decodedImage = base64_decode($imageData[1]);

                $imageName = 'document_' . time() . '_' . $index . '.jpg';
                $path = public_path('uploads/customers/' . $imageName);
                file_put_contents($path, $decodedImage);

                $scannedImagesPaths[] = 'uploads/customers/' . $imageName;
            }

            $document1 = $scannedImagesPaths[0];
            $document2 = $scannedImagesPaths[1] ?? null;
        }

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'document_type' => $request->document_type,
            'document1' => $document1,
            'document2' => $document2,
        ]);

        $text = ucwords(auth()->user()->name) . " created Customer: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('customers.new_transaction', $customer->id)->with('success', 'Customer was successfully created.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'document_type' => 'required'
        ]);

        if ($request->upload) {
            $index = 0;
            $uploadImages = [];

            foreach ($request->file('upload') as $image) {
                $ext = $image->getClientOriginalExtension();
                $filename = time() . $index . '.' . $ext;
                $image->move('uploads/customers/', $filename);
                $path = '/uploads/customers/' . $filename;
                $uploadImages[] = $path;
                $index++;
            }

            $document1 = $uploadImages[0];
            $document2 = $uploadImages[1] ?? null;
        } else if ($request->scanned_images) {
            $scannedImagesPaths = [];

            foreach ($request->scanned_images as $index => $base64Image) {
                $imageData = explode(',', $base64Image);
                $decodedImage = base64_decode($imageData[1]);

                $imageName = 'document_' . time() . '_' . $index . '.jpg';
                $path = public_path('uploads/customers/' . $imageName);
                file_put_contents($path, $decodedImage);

                $scannedImagesPaths[] = 'uploads/customers/' . $imageName;
            }

            $document1 = $scannedImagesPaths[0];
            $document2 = $scannedImagesPaths[1] ?? null;
        }

        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'document_type' => $request->document_type,
            'document1' => $document1,
            'document2' => $document2,
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Customer: " . $customer->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('customers')->with('success', 'Customer was successfully updated.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Customer: " . $customer->name . ", datetime: " . now();
            $customer->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Customer was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }

    public function fetch(Request $request)
    {
        $search = $request->query('search');

        $customers = Customer::where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")->limit(25)->get();

        return response()->json($customers);
    }

    public function download1(Customer $customer)
    {
        $filePath = public_path($customer->document1);

        if (File::exists($filePath)) {
            return response()->download($filePath, "Document_{$customer->name}.jpg");
        }

        return redirect()->back()->with('error', 'Document not found.');
    }

    public function download2(Customer $customer)
    {
        $filePath = public_path($customer->document2);

        if (File::exists($filePath)) {
            return response()->download($filePath, "Document_{$customer->name}.jpg");
        }

        return redirect()->back()->with('error', 'Document not found.');
    }

    public function new_transaction(Customer $customer)
    {
        return view('customers.new_transaction', compact('customer'));
    }
}
