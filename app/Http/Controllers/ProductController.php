<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
 /**
 * mo-display a listing of the resource.
 */
 public function index() : View
 {
 return view('products.index', [
 'products' => Product::latest()->paginate(4)
 ]);
 }
 /**
 * mo-show sa form for creating a new resource.
 */
 public function create() : View
 {
 return view('products.create');
 }
 /**
 * mo-store sa newly created resource in storage.
 */
 public function store(StoreProductRequest $request) : 
RedirectResponse
 {
 $data = $request->validated();
 
 if ($request->hasFile('image')) {
 $image = $request->file('image');
 $imageName = time() . '.' . $image->getClientOriginalExtension();
 $image->move(public_path('images/products'), $imageName);
 $data['image'] = asset('images/products/' . $imageName);
 }

 Product::create($data);
 return redirect()->route('products.index')
 ->withSuccess('New product is added successfully.');
 }
 /**
 * mo-display sa specified resource.
 */
 public function show(Product $product) : View
 {
 return view('products.show', compact('product'));
 }
 /**
 * mo- show sa form for editing the specified resource.
 */
 public function edit(Product $product) : View
 {
 return view('products.edit', compact('product'));
 }
 /**
 * mo- Update sa specified resource in storage.
 */
 public function update(UpdateProductRequest $request, Product
$product) : RedirectResponse
 {
 $data = $request->validated();

 if ($request->hasFile('image')) {
 // mo-Delete old image
 if ($product->image && file_exists(public_path(parse_url($product->image, PHP_URL_PATH)))) {
 unlink(public_path(parse_url($product->image, PHP_URL_PATH)));
 }
 
 // mo-Store new image
 $image = $request->file('image');
 $imageName = time() . '.' . $image->getClientOriginalExtension();
 $image->move(public_path('images/products'), $imageName);
 $data['image'] = asset('images/products/' . $imageName);
 }

 $product->update($data);
 return redirect()->back()
 ->withSuccess('Product is updated successfully.');
 }
 /**
 * mo-Remove sa specified resource from storage.
 */
 public function destroy(Product $product) : RedirectResponse
 {
 if ($product->image && file_exists(public_path(parse_url($product->image, PHP_URL_PATH)))) {
 unlink(public_path(parse_url($product->image, PHP_URL_PATH)));
 }
 
 $product->delete();
 return redirect()->route('products.index')
 ->withSuccess('Product is deleted successfully.');
 }
}