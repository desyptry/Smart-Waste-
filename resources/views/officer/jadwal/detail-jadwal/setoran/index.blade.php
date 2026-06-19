@extends('officer.layout.app')

@section('content')
    {{-- Include Navigasi Atas --}}
    @include('officer.jadwal.detail-jadwal.sidebar')

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 md:p-8 space-y-8">
        <div>
            <h2 class="text-lg font-black text-slate-800 uppercase tracking-wider">Timbang & Catat Setoran Nasabah</h2>
            <p class="text-xs font-semibold text-gray-400 mt-0.5">Buat sesi setoran baru dan masukkan kuantitas timbangan beberapa komoditas sekaligus</p>
        </div>

        {{-- Notifikasi Error/Sukses Flash --}}
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl font-semibold text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form id="deposit-multiform" action="{{ route('officer.jadwal.detail.setoran.store', $schedule->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('POST')
            {{-- SECTION 1: DATA INDUK SETORAN (waste_deposits) --}}
            <div class="bg-[#F4F9FC] p-6 rounded-3xl border border-gray-50 space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-gray-200/60">
                    <span class="w-2 h-5 bg-[#69C3C1] rounded-full"></span>
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Data Utama Transaksi</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Pilih Nasabah (Masyarakat)</label>
                        <select name="user_id" required class="w-full px-5 py-4 bg-white rounded-2xl font-bold text-slate-700 border-2 border-transparent outline-none focus:border-[#69C3C1] @error('user_id') border-red-400 @enderror">
                            <option value="" disabled selected>Cari nama nasabah...</option>
                            @foreach($nasabahList as $nasabah)
                                <option value="{{ $nasabah->id }}" {{ old('user_id') == $nasabah->id ? 'selected' : '' }}>
                                    {{ $nasabah->name }} ({{ $nasabah->phone_number ?? 'No Telp' }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-slate-800 font-black ml-1 uppercase text-[10px] tracking-[0.2em]">Tanggal Setoran</label>
                        <input type="text" disabled value="Hari ini (Otomatis)" class="w-full px-5 py-4 bg-gray-100/70 rounded-2xl font-bold text-gray-500 border-2 border-transparent outline-none">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: DINAMIS BARIS SAMPAH (deposit_details) --}}
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-5 bg-[#2D333D] rounded-full"></span>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Item Komoditas Timbangan</h3>
                    </div>
                    
                    <button type="button" id="add-row-btn" class="px-4 py-2 bg-[#69C3C1] hover:bg-[#58A8A6] text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Sampah
                    </button>
                </div>

                <div id="items-container" class="space-y-3">
                    {{-- Row Utama Pertama (Index 0) --}}
                    <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-white p-4 rounded-2xl border-2 border-gray-100 transition-all">
                        <div class="md:col-span-5 space-y-1">
                            <label class="text-[9px] font-black uppercase text-gray-400 tracking-wider">Komoditas & Harga Berjalan</label>
                            <select name="items[0][waste_price_id]" required class="waste-select w-full px-4 py-3 bg-[#F8FAFC] rounded-xl font-bold text-slate-700 outline-none border-2 border-transparent focus:bg-white focus:border-[#69C3C1]">
                                <option value="" disabled selected>Pilih komoditas...</option>
                                @foreach($availablePrices as $price)
                                    <option value="{{ $price->id }}" data-price="{{ $price->price }}">
                                        {{ $price->wasteCategory->name }} — (Rp {{ number_format($price->price, 0, ',', '.') }}/Kg)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-3 space-y-1">
                            <label class="text-[9px] font-black uppercase text-gray-400 tracking-wider">Berat (Kg)</label>
                            <input type="number" step="0.01" min="0.01" name="items[0][weight_kg]" required placeholder="0.00" class="weight-input w-full px-4 py-3 bg-[#F8FAFC] rounded-xl font-bold text-slate-700 outline-none border-2 border-transparent focus:bg-white focus:border-[#69C3C1]">
                        </div>

                        <div class="md:col-span-3 space-y-1">
                            <label class="text-[9px] font-black uppercase text-gray-400 tracking-wider">Subtotal Rupiah</label>
                            <input type="text" readonly value="Rp 0" class="subtotal-display w-full px-4 py-3 bg-gray-50 rounded-xl font-black text-slate-800 outline-none border-2 border-transparent">
                            <input type="hidden" name="items[0][total_price]" class="subtotal-raw">
                        </div>

                        <div class="md:col-span-1 pt-4 text-center">
                            <button type="button" class="remove-row-btn text-gray-400 hover:text-red-500 transition-colors p-1" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER KALKULASI --}}
            <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-center sm:text-left">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Akumulasi Seluruh Item</p>
                    <h3 id="grand-total-display" class="text-3xl font-black text-[#69C3C1] tracking-tight mt-0.5">Rp 0</h3>
                </div>
                
                <div class="flex gap-3 w-full sm:w-auto">
                    <button type="button" id="reset-form-btn" class="w-full sm:w-auto px-6 py-4 bg-gray-100 hover:bg-gray-200 text-slate-600 font-black text-sm rounded-2xl transition-all">
                        Reset Form
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-[#2D333D] hover:bg-slate-800 text-white font-black text-sm uppercase tracking-wider rounded-2xl shadow-xl transition-all active:scale-95">
                        Simpan Semua Setoran
                    </button>
                </div>
            </div>

        </form>
    </div>

    {{-- LOGIKA INTERAKTIF JQUERY --}}
    <script type="module">
        $(document).ready(function() {
            let rowIndex = 1;

            // Masukkan data komoditas dari Blade ke variabel JavaScript sebagai master opsi dropdown
            const dropdownOptions = `
                <option value="" disabled selected>Pilih komoditas...</option>
                @foreach($availablePrices as $price)
                    <option value="{{ $price->id }}" data-price="{{ $price->price }}">
                        {{ $price->wasteCategory->name }} — (Rp {{ number_format($price->price, 0, ',', '.') }}/Kg)
                    </option>
                @endforeach
            `;

            // Pembuat template baris HTML baru
            function createRowHtml(index) {
                return `
                <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 items-center bg-white p-4 rounded-2xl border-2 border-gray-100 transition-all opacity-0 scale-95 duration-200">
                    <div class="md:col-span-5 space-y-1">
                        <label class="text-[9px] font-black uppercase text-gray-400 tracking-wider">Komoditas & Harga Berjalan</label>
                        <select name="items[${index}][waste_price_id]" required class="waste-select w-full px-4 py-3 bg-[#F8FAFC] rounded-xl font-bold text-slate-700 outline-none border-2 border-transparent focus:bg-white focus:border-[#69C3C1]">
                            ${dropdownOptions}
                        </select>
                    </div>
                    <div class="md:col-span-3 space-y-1">
                        <label class="text-[9px] font-black uppercase text-gray-400 tracking-wider">Berat (Kg)</label>
                        <input type="number" step="0.01" min="0.01" name="items[${index}][weight_kg]" required placeholder="0.00" class="weight-input w-full px-4 py-3 bg-[#F8FAFC] rounded-xl font-bold text-slate-700 outline-none border-2 border-transparent focus:bg-white focus:border-[#69C3C1]">
                    </div>
                    <div class="md:col-span-3 space-y-1">
                        <label class="text-[9px] font-black uppercase text-gray-400 tracking-wider">Subtotal Rupiah</label>
                        <input type="text" readonly value="Rp 0" class="subtotal-display w-full px-4 py-3 bg-gray-50 rounded-xl font-black text-slate-800 outline-none border-2 border-transparent">
                        <input type="hidden" name="items[${index}][total_price]" class="subtotal-raw">
                    </div>
                    <div class="md:col-span-1 pt-4 text-center">
                        <button type="button" class="remove-row-btn text-gray-400 hover:text-red-500 transition-colors p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>`;
            }

            // Hitung Subtotal per baris & Kalkulasi Grand Total Keseluruhan
            function calculateInvoice() {
                let grandTotal = 0;

                $('.item-row').each(function() {
                    const row = $(this);
                    const pricePerKg = parseFloat(row.find('.waste-select').find(':selected').data('price')) || 0;
                    const weight = parseFloat(row.find('.weight-input').val()) || 0;
                    
                    const subtotal = Math.round(pricePerKg * weight);
                    
                    row.find('.subtotal-raw').val(subtotal);
                    row.find('.subtotal-display').val('Rp ' + subtotal.toLocaleString('id-ID'));
                    
                    grandTotal += subtotal;
                });

                $('#grand-total-display').text('Rp ' + grandTotal.toLocaleString('id-ID'));
            }

            // Tambah baris baru
            $('#add-row-btn').on('click', function() {
                const newRow = $(createRowHtml(rowIndex));
                $('#items-container').append(newRow);
                
                setTimeout(() => {
                    newRow.removeClass('opacity-0 scale-95');
                }, 50);

                rowIndex++;
                toggleRemoveButtons();
            });

            // Hapus baris timbangan
            $(document).on('click', '.remove-row-btn', function() {
                const row = $(this).closest('.item-row');
                row.addClass('opacity-0 scale-95');
                setTimeout(() => {
                    row.remove();
                    calculateInvoice();
                    toggleRemoveButtons();
                }, 200);
            });

            // Hitung otomatis saat kolom input diubah
            $(document).on('input change', '.weight-input, .waste-select', function() {
                calculateInvoice();
            });

            function toggleRemoveButtons() {
                const rowsCount = $('.item-row').length;
                $('.remove-row-btn').prop('disabled', rowsCount <= 1);
            }

            // Reset seluruh form ke kondisi awal
            $('#reset-form-btn').on('click', function() {
                if(confirm('Apakah Anda yakin ingin mengosongkan form timbangan ini?')) {
                    $('#deposit-multiform')[0].reset();
                    $('#items-container').html(createRowHtml(0)); 
                    rowIndex = 1;
                    calculateInvoice();
                    toggleRemoveButtons();
                }
            });
        });
    </script>
@endsection
