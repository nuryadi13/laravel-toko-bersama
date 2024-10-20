<x-app-layout>
    @if (session()->has('success'))
        <x-alert message="{{ session('success') }}"/>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mx-2">
                <h2 class="font-semibold text-xl mt-5">List Product</h2>
                <a href="{{ route('product.create') }}">
                    <h2 class="bg-blue-500 px-10 py-2 text-white rounded font-semibold">Add Product</h2>
                </a>
            </div>

            <div data-aos="fade-up"
     data-aos-duration="2000">
                <div class="container grid md:grid-cols-3 grid-cols-1 mt-4 gap-10 px-20">
                @foreach ($products as $product)
                <div class="bg-gray-200 rounded-lg shadow-lg p-4"> <!-- Card Container -->
                    <div class="text-center">
                        <img src="{{ url('images/' . $product->foto) }}" alt="list product" class="mx-auto mb-2 rounded-md w-32 h-32 object-cover"> <!-- Gambar produk -->
                        <p class="text-xl font-light">{{ $product->nama }}</p>
                        <p class="font-semibold text-gray-400">{{ number_format($product->harga) }}</p>
                        <p class="font-semibold text-green-300 text-sm">{{ $product->deskripsi }}</p>
                    </div>
                    <a href="{{ route ('product.edit', $product)  }}">
                    <button class="bg-yellow-200 px-10 py-2 rounded-md font-semibold w-full mt-2">Edit</button>
                    </a>
                </div>
                @endforeach
            </div>
            </div>
            
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

