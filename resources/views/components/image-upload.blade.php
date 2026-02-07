@props([
    'name' => 'image',
    'label' => 'Image',
    'id' => 'imageInput',
    'oldImage' => null, // untuk edit
])

@push('style')
<style>
#{{ $id }}Wrapper {
    width: 120px;
    height: 120px;
    border: 2px dashed #ced4da;
    border-radius: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-direction: column;
    position: relative;
    transition: border-color 0.2s, color 0.2s;
}
#{{ $id }}Wrapper:hover { border-color: #007bff; color: #007bff; }

#{{ $id }}Placeholder i { font-size: 28px; }
#{{ $id }}Placeholder small { font-size: 12px; color: #6c757d; margin-top:4px; }

#{{ $id }}Preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

#{{ $id }}Remove {
    position: absolute;
    top: -8px;
    right: -8px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    font-size: 14px;
    line-height: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
#{{ $id }}Remove:hover { background: darkred; }
</style>
@endpush

<div class="form-group">
    <label>{{ $label }}</label>

    <!-- Wrapper upload / preview -->
    <div id="{{ $id }}Wrapper">
        <span id="{{ $id }}Placeholder">
            <i class="fas fa-plus"></i>
            <small>Click to upload</small>
        </span>

        <img id="{{ $id }}Preview" src="{{ $oldImage }}" class="{{ $oldImage ? '' : 'd-none' }}" alt="Preview Image">
        <button type="button" id="{{ $id }}Remove" class="{{ $oldImage ? '' : 'd-none' }}">&times;</button>
    </div>

    <!-- Input file -->
    <input type="file" name="{{ $name }}" id="{{ $id }}" class="d-none" accept="image/*">

    <!-- Error -->
    @error($name)
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
(function() {
    const input = document.getElementById('{{ $id }}');
    const wrapper = document.getElementById('{{ $id }}Wrapper');
    const preview = document.getElementById('{{ $id }}Preview');
    const removeBtn = document.getElementById('{{ $id }}Remove');
    const placeholder = document.getElementById('{{ $id }}Placeholder');

    // Jika ada oldImage, sembunyikan placeholder
    if(preview.src) { placeholder.classList.add('d-none'); }

    // Klik wrapper → buka file dialog
    wrapper.addEventListener('click', () => input.click());

    // Saat file dipilih
    input.addEventListener('change', () => {
        if(input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                removeBtn.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    });

    // Hapus image → kembali ke state awal
    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // agar tidak trigger klik wrapper
        input.value = '';
        preview.src = '';
        preview.classList.add('d-none');
        removeBtn.classList.add('d-none');
        placeholder.classList.remove('d-none');
    });
})();
</script>
@endpush
