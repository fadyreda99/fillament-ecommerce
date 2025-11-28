<x-filament-panels::page>
    @php
        $product = $this->record;
        $featured = $product->featured_image ? asset('storage/' . $product->featured_image) : null;
    @endphp

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-start gap-6">
            <div class="w-48 h-48 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                @if($featured)
                    <img src="{{ $featured }}" alt="{{ $product->name }}" class="object-cover w-full h-full">
                @else
                    <span class="text-sm text-gray-500">No image</span>
                @endif
            </div>

            <div class="flex-1">
                <h1 class="text-2xl font-bold">{{ $product->name }}</h1>

                <div class="mt-2 flex items-center gap-3">
                    <div class="text-lg font-semibold">
                        @if($product->price)
                            {{ number_format($product->price, 2) }}
                        @endif
                    </div>

                    @if($product->compare_price)
                        <div class="text-sm line-through text-gray-500">
                            {{ number_format($product->compare_price, 2) }}
                        </div>
                        <div class="text-sm text-red-600 font-medium ml-2">
                            -{{ $product->compare_price ? round((($product->compare_price - $product->price) / $product->compare_price) * 100) : 0 }}%
                        </div>
                    @endif

                    <div class="ml-4">
                        @if($product->status)
                            <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-800 text-xs">Active</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded bg-red-100 text-red-800 text-xs">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="mt-3 text-sm text-gray-600">
                    Category:
                    @if($product->category)
                        <span class="font-medium">{{ $product->category->name }}</span>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </div>
            </div>

            <div class="w-48">
                {{-- <a href="{{ route('filament.resources.products.edit', ['record' => $product->getKey()]) }}" class="filament-button inline-flex items-center justify-center w-full"> --}}
                    {{-- Edit --}}
                {{-- </a> --}}
                {{-- <a href="{{ route('filament.resources.products.index') }}" class="filament-button filament-button-secondary inline-flex items-center justify-center w-full mt-2"> --}}
                    {{-- Back to list --}}
                {{-- </a> --}}
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Info -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                <h3 class="font-semibold mb-2">Product Info</h3>
                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <div><strong>SKU:</strong> {{ $product->sku ?? '—' }}</div>
                    <div><strong>Slug:</strong> {{ $product->slug ?? '—' }}</div>
                    <div><strong>Short description:</strong> {{ $product->short_description ?? '—' }}</div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                <h3 class="font-semibold mb-2">Pricing</h3>
                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <div><strong>Price:</strong> {{ $product->price ?? '—' }}</div>
                    <div><strong>Compare price:</strong> {{ $product->compare_price ?? '—' }}</div>
                    <div><strong>Cost price:</strong> {{ $product->cost_price ?? '—' }}</div>
                </div>
            </div>

            <!-- Inventory -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                <h3 class="font-semibold mb-2">Inventory</h3>
                <div class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
                    <div><strong>Track stock:</strong> {{ $product->track_stock ? 'Yes' : 'No' }}</div>
                    <div><strong>Stock qty:</strong> {{ $product->stock_qty ?? 0 }}</div>
                    <div><strong>Low threshold:</strong> {{ $product->low_stock_threshold ?? '—' }}</div>
                </div>
            </div>
        </div>

        <!-- Description full -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
            <h3 class="font-semibold mb-2">Description</h3>
            <div class="prose dark:prose-invert max-w-none">
                {!! $product->description ?? '<span class="text-gray-500">No description.</span>' !!}
            </div>
        </div>

        <!-- Tabs: Variations / Images -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
            <div class="flex gap-3 border-b pb-3 mb-4">
                <button data-tab="variations" class="tab-btn px-3 py-2 rounded bg-gray-100">Variations</button>
                <button data-tab="images" class="tab-btn px-3 py-2 rounded bg-white dark:bg-gray-700">Images</button>
            </div>

            <div id="tab-variations" class="tab-pane">
                <h4 class="font-medium mb-3">Variations</h4>

                @if($product->variations && $product->variations->count())
                    <div class="space-y-3">
                        @foreach($product->variations as $pv)
                            <div class="flex items-center gap-4 p-3 rounded border">
                                <div class="flex-1">
                                    <div class="text-sm text-gray-600">{{ $pv->variation?->name ?? '—' }}</div>
                                    <div class="font-medium">{{ $pv->variationValue?->value ?? $pv->value }}</div>
                                </div>

                                @if($pv->image)
                                    <div class="w-16 h-16 overflow-hidden rounded">
                                        <img src="{{ asset('storage/' . $pv->image) }}" class="object-cover w-full h-full" alt="">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500">No variations.</div>
                @endif
            </div>

            <div id="tab-images" class="tab-pane hidden">
                <h4 class="font-medium mb-3">Gallery</h4>

                @if($product->media && $product->media->count())
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($product->media as $m)
                            <div class="rounded overflow-hidden border">
                                <img src="{{ asset('storage/' . $m->file_path) }}" class="object-cover w-full h-40" alt="">
                                <div class="p-2 text-xs text-gray-600">{{ $m->file_name ?? basename($m->file_path) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500">No images.</div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function () {
            const btns = document.querySelectorAll('.tab-btn');
            const panes = {
                variations: document.getElementById('tab-variations'),
                images: document.getElementById('tab-images')
            };

            function setActive(key) {
                btns.forEach(b => b.classList.remove('bg-gray-100'));
                document.querySelector(`[data-tab="${key}"]`).classList.add('bg-gray-100');

                Object.keys(panes).forEach(k => {
                    if (k === key) panes[k].classList.remove('hidden');
                    else panes[k].classList.add('hidden');
                });
            }

            btns.forEach(b => {
                b.addEventListener('click', (e) => {
                    setActive(b.getAttribute('data-tab'));
                });
            });

            // default
            setActive('variations');
        })();
    </script>
    @endpush
</x-filament-panels::page>
