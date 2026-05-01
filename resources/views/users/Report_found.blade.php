<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Found Item') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ __('Report Found Item') }}
                </h1>
                <p class="mt-2 text-gray-500">{{ __('Log an item that was found and handed to you') }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8 shadow-sm">
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Found Item Details') }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Provide accurate information to help the owner claim it') }}</p>
                </div>

                <form action="{{ route('user.report-found.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Item Title') }} <span class="text-gray-900">*</span>
                        </label>
                        <input type="text" id="title" name="title" placeholder="e.g., Red JanSport Backpack" required
                            class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-900">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Description') }} <span class="text-gray-900">*</span>
                        </label>
                        <textarea id="description" name="description" rows="3" placeholder="Provide detailed description of the item..." required
                            class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-900"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Item Image') }} <span class="text-gray-900">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image-upload" class="relative cursor-pointer rounded-md font-medium text-gray-600 hover:text-gray-900 focus-within:outline-none">
                                        <span>Click to upload image</span>
                                        <input id="image-upload" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 5MB</p>
                            </div>
                        </div>
                        <div id="image-preview-wrap" class="mt-4 hidden">
                            <p class="mb-2 text-xs font-medium uppercase tracking-wide text-gray-500">Image Preview</p>
                            <img id="image-preview" src="#" alt="Selected image preview" class="h-56 w-full rounded-xl border border-gray-200 object-contain bg-gray-50" />
                        </div>
                        <p class="mt-2 text-xs text-gray-400">{{ __('An image helps the owner recognize their item') }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Category') }} <span class="text-gray-900">*</span>
                            </label>
                            <select id="category" name="category" required
                                class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-600">
                                <option value="" disabled @selected(old('category') === null)>Select category</option>
                                <option value="electronics" @selected(old('category') === 'electronics')>Electronics</option>
                                <option value="mobile-phone" @selected(old('category') === 'mobile-phone')>Mobile Phone</option>
                                <option value="laptop-tablet" @selected(old('category') === 'laptop-tablet')>Laptop / Tablet</option>
                                <option value="bags-backpacks" @selected(old('category') === 'bags-backpacks')>Bags / Backpacks</option>
                                <option value="wallets-purses" @selected(old('category') === 'wallets-purses')>Wallets / Purses</option>
                                <option value="ids-cards" @selected(old('category') === 'ids-cards')>IDs / Cards</option>
                                <option value="keys" @selected(old('category') === 'keys')>Keys</option>
                                <option value="jewelry-watch" @selected(old('category') === 'jewelry-watch')>Jewelry / Watch</option>
                                <option value="books-notebooks" @selected(old('category') === 'books-notebooks')>Books / Notebooks</option>
                                <option value="school-supplies" @selected(old('category') === 'school-supplies')>School Supplies</option>
                                <option value="clothing" @selected(old('category') === 'clothing')>Clothing</option>
                                <option value="water-bottles" @selected(old('category') === 'water-bottles')>Water Bottles</option>
                                <option value="umbrellas" @selected(old('category') === 'umbrellas')>Umbrellas</option>
                                <option value="gadgets-accessories" @selected(old('category') === 'gadgets-accessories')>Gadgets / Accessories</option>
                                <option value="documents" @selected(old('category') === 'documents')>Documents</option>
                                <option value="sports-equipment" @selected(old('category') === 'sports-equipment')>Sports Equipment</option>
                                <option value="cash" @selected(old('category') === 'cash')>Cash</option>
                                <option value="other" @selected(old('category') === 'other')>Other</option>
                            </select>

                            <div id="other-category-wrap" class="mt-3 hidden">
                                <label for="other-category" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Specify Other Category') }} <span class="text-gray-900">*</span>
                                </label>
                                <input type="text" id="other-category" name="custom_category" value="{{ old('custom_category') }}" placeholder="e.g., Medical Device"
                                    class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-900">
                            </div>
                        </div>
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Color') }}
                            </label>
                            <input type="text" id="color" name="color" placeholder="e.g., Red, Blue"
                                class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-900">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Location Found') }} <span class="text-gray-900">*</span>
                            </label>
                            <input type="text" id="location" name="location" placeholder="e.g., Cafeteria - Table 5" required
                                class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-900">
                        </div>
                        <div>
                            <label for="date_found" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Date Found') }}
                            </label>
                            <input type="date" id="date_found" name="date_found"
                                class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-600">
                        </div>
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Tags (comma-separated)') }}
                        </label>
                        <input type="text" id="tags" name="tags" placeholder="e.g., backpack, red, jansport"
                            class="w-full rounded-xl bg-gray-50 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 px-4 py-3 text-sm text-gray-900">
                        <p class="mt-2 text-xs text-gray-400">{{ __('Add keywords to make the item easier to find') }}</p>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row sm:justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto flex justify-center py-2.5 px-6 border border-gray-300 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition text-center">
                            {{ __('Cancel') }}
                        </a>

                        <button type="submit" class="w-full sm:w-auto flex justify-center py-2.5 px-6 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-[#4a6b41] hover:bg-[#3a5433] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4a6b41] transition">
                            {{ __('Submit Report') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('image-upload');
                const previewWrap = document.getElementById('image-preview-wrap');
                const preview = document.getElementById('image-preview');
                const categorySelect = document.getElementById('category');
                const otherCategoryWrap = document.getElementById('other-category-wrap');
                const otherCategoryInput = document.getElementById('other-category');

                if (!input || !previewWrap || !preview) {
                    return;
                }

                const toggleOtherCategory = function () {
                    if (!categorySelect || !otherCategoryWrap || !otherCategoryInput) {
                        return;
                    }

                    const shouldShow = categorySelect.value === 'other';
                    otherCategoryWrap.classList.toggle('hidden', !shouldShow);
                    otherCategoryInput.required = shouldShow;
                    if (!shouldShow) {
                        otherCategoryInput.value = '';
                    }
                };

                if (categorySelect) {
                    categorySelect.addEventListener('change', toggleOtherCategory);
                    toggleOtherCategory();
                }

                let activePreviewUrl = null;

                input.addEventListener('change', function () {
                    const file = this.files && this.files[0];

                    if (activePreviewUrl) {
                        URL.revokeObjectURL(activePreviewUrl);
                        activePreviewUrl = null;
                    }

                    if (!file || !file.type.startsWith('image/')) {
                        previewWrap.classList.add('hidden');
                        preview.src = '#';
                        return;
                    }

                    activePreviewUrl = URL.createObjectURL(file);
                    preview.src = activePreviewUrl;
                    previewWrap.classList.remove('hidden');
                });
            });
        </script>
    @endpush
</x-app-layout>