<div class="mb-4">
    <label class="block font-medium">Plant Name</label>
    <input type="text" name="name" class="w-full border rounded p-2"
           value="{{ old('name', $plant->name ?? '') }}">
    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Category</label>
    <select name="category" class="w-full border rounded p-2">
        <option value="">-- Select --</option>
        @foreach (App\Models\Plant::CATEGORIES as $cat)
            <option value="{{ $cat }}" @selected(old('category', $plant->category ?? '') === $cat)>
                {{ ucfirst($cat) }}
            </option>
        @endforeach
    </select>
    @error('category') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Unit Price</label>
    <input type="text" name="unit_price" class="w-full border rounded p-2"
           value="{{ old('unit_price', $plant->unit_price ?? '') }}">
    @error('unit_price') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Description</label>
    <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $plant->description ?? '') }}</textarea>
    @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block font-medium">Stock Status</label>
    <select name="stock_status" class="w-full border rounded p-2">
        <option value="">-- Select --</option>
        @foreach (App\Models\Plant::STATUSES as $value => $label)
            <option value="{{ $value }}" @selected(old('stock_status', $plant->stock_status ?? '') === $value)>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('stock_status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>