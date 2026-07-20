<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Daftar Publikasi Konten') }}
        </h2>
    </x-slot>


            <div class="bg-white/95 border border-primary/10 shadow-xl rounded-[1.5rem] overflow-hidden">
                <div class="p-5 border-b">
                    <form method="GET" action="{{ route('postingan.index') }}" data-role="posting-filter" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                        <div class="md:col-span-2">
                            <label class="text-xs text-primary/70">Sumber</label>
                            <select name="sumber_konten_id" class="w-full rounded-2xl border border-primary/20 px-3 py-2">
                                <option value="">-- Semua Sumber --</option>
                                @foreach($sumberKonten as $sumber)
                                    <option value="{{ $sumber->id }}" {{ request('sumber_konten_id') == $sumber->id ? 'selected' : '' }}>{{ $sumber->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-xs text-primary/70">Jenis</label>
                            <select name="jenis_konten_id" class="w-full rounded-2xl border border-primary/20 px-3 py-2">
                                <option value="">-- Semua Jenis --</option>
                                @foreach($jenisKonten as $jenis)
                                    <option value="{{ $jenis->id }}" {{ request('jenis_konten_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-xs text-primary/70">Mode Waktu</label>
                            <select name="date_mode" class="w-full rounded-2xl border border-primary/20 px-3 py-2">
                                <option value="hari" {{ request('date_mode','hari') == 'hari' ? 'selected' : '' }}>Hari</option>
                                <option value="bulan" {{ request('date_mode') == 'bulan' ? 'selected' : '' }}>Bulan</option>
                                <option value="tahun" {{ request('date_mode') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                                <option value="rentang" {{ request('date_mode') == 'rentang' ? 'selected' : '' }}>Rentang</option>
                            </select>
                        </div>

                        @php $dm = request('date_mode','hari'); @endphp
                        <div class="md:col-span-2">
                            @if($dm === 'hari')
                                @php
                                    $dateVal = request('date');
                                    if($dateVal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateVal)) {
                                        $dateVal = \Carbon\Carbon::parse($dateVal)->format('d/m/Y');
                                    }
                                @endphp
        
                            @elseif($dm === 'bulan')
                                @php
                                    $monthVal = request('month');
                                    if($monthVal && preg_match('/^\d{4}-\d{2}$/', $monthVal)) {
                                        $monthVal = \Carbon\Carbon::createFromFormat('Y-m', $monthVal)->format('m/Y');
                                    }
                                @endphp
                                <label class="text-xs text-primary/70">Bulan (mm/YYYY)</label>
                                <div class="relative">
                                    <input type="text" name="month" value="{{ $monthVal }}" placeholder="mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                    <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open monthpicker">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </button>
                                </div>
                            @elseif($dm === 'rentang')
                                @php
                                    $startVal = request('start_date');
                                    if($startVal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $startVal)) {
                                        $startVal = \Carbon\Carbon::parse($startVal)->format('d/m/Y');
                                    }
                                    $endVal = request('end_date');
                                    if($endVal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $endVal)) {
                                        $endVal = \Carbon\Carbon::parse($endVal)->format('d/m/Y');
                                    }
                                @endphp
                                <label class="text-xs text-primary/70">Rentang (dd/mm/YYYY)</label>
                                <div class="flex gap-2">
                                    <div class="relative w-1/2">
                                        <input type="text" name="start_date" value="{{ $startVal }}" placeholder="dd/mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open start date picker">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </button>
                                    </div>
                                    <div class="relative w-1/2">
                                        <input type="text" name="end_date" value="{{ $endVal }}" placeholder="dd/mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open end date picker">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <label class="text-xs text-primary/70">Tahun</label>
                                <input type="number" name="year" value="{{ request('year') ?? now()->format('Y') }}" min="2000" max="2100" class="w-full rounded-2xl border border-primary/20 px-3 py-2" />
                            @endif
                        </div>

                        <div class="md:col-span-2 flex items-center space-x-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-full">Terapkan</button>
                            <a href="{{ route('postingan.index') }}" class="inline-flex items-center px-3 py-2 border rounded-full">Reset</a>
                            <div class="ml-auto relative">
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-full" onclick="toggleExportDropdown(this)">Export Excel ▾</button>
                                <div role="export-menu" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded shadow-lg z-50">
                                    <a href="{{ route('postingan.export', request()->query()) }}" class="block px-4 py-2 hover:bg-gray-100">Export Filtered (Excel)</a>
                                    <a href="{{ route('postingan.export') }}" class="block px-4 py-2 hover:bg-gray-100">Export All (Excel)</a>
                                    <a href="{{ route('postingan.export.aggregate', request()->query()) }}" class="block px-4 py-2 hover:bg-gray-100">Export Aggregate (Excel)</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="postingan-filter-data" class="hidden"
                         data-date-mode="{{ request('date_mode','hari') }}"
                         data-date="{{ request('date') }}"
                         data-month="{{ request('month') }}"
                         data-year="{{ request('year') ?? now()->format('Y') }}"
                         data-start-date="{{ request('start_date') }}"
                         data-end-date="{{ request('end_date') }}">
                    </div>
                    @push('scripts')
                    <!-- Flatpickr CSS & JS -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
                    <script>
                    (function(){
                        function qs(q){return document.querySelector(q)}
                        function qsa(q){return document.querySelectorAll(q)}

                        const form = qs('form[data-role="posting-filter"]');
                        if(!form) return;
                        const modeSelect = form.querySelector('select[name="date_mode"]');
                        const container = form.querySelector('div.md\\:col-span-2:nth-last-child(2)') || null;
                        // fallback: create container after mode select
                        let dateContainer = form.querySelector('#date-inputs');
                        if(!dateContainer){
                            dateContainer = document.createElement('div');
                            dateContainer.id = 'date-inputs';
                            // keep the date inputs in their own column, left-aligned and symmetric
                            dateContainer.className = 'md:col-span-2 flex flex-col lg:flex-row gap-2 items-start';
                            // insert before the submit button container
                            const submitWrap = form.querySelector('div.md\\:col-span-2.flex.items-center') || form.querySelector('button[type="submit"]');
                            if(submitWrap) submitWrap.parentNode.insertBefore(dateContainer, submitWrap);
                        }

                        // read current query values from URL
                        const params = new URLSearchParams(window.location.search);
                        const dataEl = document.getElementById('postingan-filter-data');
                        const current = {
                            date_mode: params.get('date_mode') || (dataEl ? dataEl.dataset.dateMode : 'hari'),
                            date: params.get('date') || (dataEl ? dataEl.dataset.date : ''),
                            month: params.get('month') || (dataEl ? dataEl.dataset.month : ''),
                            year: params.get('year') || (dataEl ? dataEl.dataset.year : ''),
                            start_date: params.get('start_date') || (dataEl ? dataEl.dataset.startDate : ''),
                            end_date: params.get('end_date') || (dataEl ? dataEl.dataset.endDate : ''),
                        };

                        function escapeHtml(s){ return (s||'').toString().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

                        let fpInstances = [];

                        function destroyAll(){
                            if(!window.flatpickr) return;
                            fpInstances.forEach(inst => {
                                try{ inst.destroy(); }catch(e){}
                            });
                            fpInstances = [];
                        }

                        function render(mode){
                            let html = '';
                            if(mode === 'hari'){
                                const v = current.date && /\d{4}-\d{2}-\d{2}/.test(current.date) ? (new Date(current.date)).toLocaleDateString('en-GB').split('/').join('/') : current.date || '';
                                html = `
                                    <label class="text-xs text-primary/70">Tanggal (dd/mm/YYYY)</label>
                                    <div class="relative">
                                        <input type="text" name="date" value="${escapeHtml(v)}" placeholder="dd/mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open datepicker">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-red-600 hidden" data-error></p>
                                `;
                            } else if(mode === 'bulan'){
                                const v = current.month && /\d{4}-\d{2}/.test(current.month) ? (function(){const parts=current.month.split('-'); return parts[1]+'/'+parts[0];})() : current.month || '';
                                html = `
                                    <label class="text-xs text-primary/70">Bulan (mm/YYYY)</label>
                                    <div class="relative">
                                        <input type="text" name="month" value="${escapeHtml(v)}" placeholder="mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                        <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open monthpicker">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-red-600 hidden" data-error></p>
                                `;
                            } else if(mode === 'rentang'){
                                const s = current.start_date && /\d{4}-\d{2}-\d{2}/.test(current.start_date) ? (new Date(current.start_date)).toLocaleDateString('en-GB') : current.start_date || '';
                                const e = current.end_date && /\d{4}-\d{2}-\d{2}/.test(current.end_date) ? (new Date(current.end_date)).toLocaleDateString('en-GB') : current.end_date || '';
                                html = `
                                    <label class="text-xs text-primary/70">Rentang (dd/mm/YYYY)</label>
                                        <div class="flex gap-2">
                                            <div class="relative w-1/2">
                                                <input type="text" name="start_date" value="${escapeHtml(s)}" placeholder="dd/mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open start date picker">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                                </button>
                                            </div>
                                            <div class="relative w-1/2">
                                                <input type="text" name="end_date" value="${escapeHtml(e)}" placeholder="dd/mm/YYYY" class="w-full rounded-2xl border border-primary/20 px-3 py-2 pr-10" />
                                                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary/70" onclick="this.parentNode.querySelector('input').focus()" aria-label="Open end date picker">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-red-600 hidden" data-error></p>
                                `;
                            } else {
                                html = `
                                    <label class="text-xs text-primary/70">Tahun</label>
                                    <input type="number" name="year" value="${escapeHtml(current.year)}" min="2000" max="2100" class="w-full rounded-2xl border border-primary/20 px-3 py-2" />
                                    <p class="mt-1 text-xs text-red-600 hidden" data-error></p>
                                `;
                            }
                            dateContainer.innerHTML = html;

                            // destroy previous pickers and initialize new ones
                            destroyAll();
                            initPickers();
                            attachValidation();
                        }

                        function initPickers(){
                            if(typeof flatpickr === 'undefined') return;

                            // date
                            const dateInput = dateContainer.querySelector('input[name="date"]');
                            if(dateInput){
                                const fp = flatpickr(dateInput, {dateFormat: 'd/m/Y', allowInput: true});
                                fpInstances.push(fp);
                            }

                            // month
                            const monthInput = dateContainer.querySelector('input[name="month"]');
                            if(monthInput){
                                try{
                                    if(typeof monthSelectPlugin !== 'undefined'){
                                        const fp = flatpickr(monthInput, {plugins: [new monthSelectPlugin({shorthand: false, dateFormat: 'm/Y', altFormat: 'm/Y'})], allowInput: true});
                                        fpInstances.push(fp);
                                    } else {
                                        const fp = flatpickr(monthInput, {dateFormat: 'm/Y', allowInput: true});
                                        fpInstances.push(fp);
                                    }
                                }catch(e){
                                    const fp = flatpickr(monthInput, {dateFormat: 'm/Y', allowInput: true});
                                    fpInstances.push(fp);
                                }
                            }

                            // range: link start/end
                            const startInput = dateContainer.querySelector('input[name="start_date"]');
                            const endInput = dateContainer.querySelector('input[name="end_date"]');
                            if(startInput && endInput){
                                const startFp = flatpickr(startInput, {
                                    dateFormat: 'd/m/Y',
                                    allowInput: true,
                                    onChange: function(selectedDates){
                                        if(selectedDates.length){
                                            endFp.set('minDate', selectedDates[0]);
                                        }
                                    }
                                });
                                const endFp = flatpickr(endInput, {
                                    dateFormat: 'd/m/Y',
                                    allowInput: true,
                                    onChange: function(selectedDates){
                                        if(selectedDates.length){
                                            startFp.set('maxDate', selectedDates[0]);
                                        }
                                    }
                                });
                                fpInstances.push(startFp, endFp);
                            }
                        }

                        function attachValidation(){
                            const errEl = dateContainer.querySelector('[data-error]');
                            const submitBtn = form.querySelector('button[type="submit"]');
                            const inputs = dateContainer.querySelectorAll('input');

                            function validate(){
                                let ok = true; errEl.textContent = ''; errEl.classList.add('hidden');
                                const mode = (modeSelect && modeSelect.value) || current.date_mode;
                                if(mode === 'hari'){
                                    const v = form.querySelector('input[name="date"]').value.trim();
                                    if(!/^\d{2}\/\d{2}\/\d{4}$/.test(v)) { ok = false; errEl.textContent = 'Format tanggal harus dd/mm/YYYY'; }
                                } else if(mode === 'bulan'){
                                    const v = form.querySelector('input[name="month"]').value.trim();
                                    if(!/^\d{2}\/\d{4}$/.test(v)) { ok = false; errEl.textContent = 'Format bulan harus mm/YYYY'; }
                                } else if(mode === 'rentang'){
                                    const s = form.querySelector('input[name="start_date"]').value.trim();
                                    const e = form.querySelector('input[name="end_date"]').value.trim();
                                    if(!/^\d{2}\/\d{2}\/\d{4}$/.test(s) || !/^\d{2}\/\d{2}\/\d{4}$/.test(e)) { ok = false; errEl.textContent = 'Format rentang harus dd/mm/YYYY'; }
                                    else {
                                        // compare dates
                                        const sd = s.split('/').reverse().join('-');
                                        const ed = e.split('/').reverse().join('-');
                                        if(new Date(sd) > new Date(ed)) { ok = false; errEl.textContent = 'Start harus <= End'; }
                                    }
                                } else if(mode === 'tahun'){
                                    const v = form.querySelector('input[name="year"]').value.trim();
                                    if(!/^\d{4}$/.test(v)) { ok = false; errEl.textContent = 'Format tahun harus YYYY'; }
                                }
                                if(!ok){ errEl.classList.remove('hidden'); } else { errEl.classList.add('hidden'); errEl.textContent=''; }
                                if(submitBtn) submitBtn.disabled = !ok;
                            }

                            inputs.forEach(i => i.addEventListener('input', validate));
                            inputs.forEach(i => i.addEventListener('blur', validate));
                            if(submitBtn) submitBtn.addEventListener('click', validate);
                            validate();
                        }

                        // initial render
                        render(current.date_mode || 'hari');

                        // listen for changes
                        if(modeSelect) modeSelect.addEventListener('change', function(e){
                            current.date_mode = e.target.value;
                            render(current.date_mode);
                        });

                    })();

                    // simple export dropdown toggle
                    window.toggleExportDropdown = function(btn){
                        const menu = btn.parentNode.querySelector('[role="export-menu"]');
                        if(!menu) return;
                        menu.classList.toggle('hidden');
                        // close on outside click
                        const onDoc = function(e){ if(!btn.parentNode.contains(e.target)){ menu.classList.add('hidden'); document.removeEventListener('click', onDoc); } };
                        // delay adding listener so the click that opened doesn't immediately close it
                        setTimeout(()=>document.addEventListener('click', onDoc));
                    };

                    </script>
                    @endpush
                </div>
                <div class="p-5 border-b">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="text-sm text-primary/80">
                            <div><span class="font-semibold text-primary">Total hasil:</span> {{ $totalCount ?? $postingan->total() }}</div>
                            <div class="mt-1 text-xs text-primary/70">
                                @if(!empty($countsBySumber) && $countsBySumber->count())
                                    <div>Distribusi per sumber:
                                        @foreach($countsBySumber as $name => $cnt)
                                            <span class="inline-block ml-2">{{ $name }}: <span class="font-medium">{{ $cnt }}</span></span>
                                        @endforeach
                                    </div>
                                @endif

                                @if(!empty($countsByJenis) && $countsByJenis->count())
                                    <div class="mt-1">Distribusi per jenis:
                                        @foreach($countsByJenis as $name => $cnt)
                                            <span class="inline-block ml-2">{{ $name }}: <span class="font-medium">{{ $cnt }}</span></span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-surface text-primary/90">
                                <th class="px-4 py-4 text-xs font-semibold uppercase tracking-[0.18em]">Judul/Keterangan</th>
                                <th class="px-4 py-4 text-xs font-semibold uppercase tracking-[0.18em]">Jenis</th>
                                <th class="px-4 py-4 text-xs font-semibold uppercase tracking-[0.18em]">Sumber</th>
                                <th class="px-4 py-4 text-xs font-semibold uppercase tracking-[0.18em]">Tagar</th>
                                <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-[0.18em]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($postingan as $item)
                            <tr class="border-b border-primary/10 hover:bg-mist transition-colors duration-200">
                                <td class="px-4 py-4">
                                    <a href="{{ $item->link }}" target="_blank" class="text-primary font-medium hover:underline">{{ $item->judul }}</a>
                                </td>
                                <td class="px-4 py-4 text-sm text-primary/80">{{ $item->jenisKonten->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-4 text-sm text-primary/80">{{ $item->sumberKonten->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-4 text-sm text-primary/80">{{ $item->tagar }}</td>
                                <td class="px-4 py-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-3">
                                        <a href="{{ route('postingan.edit', $item->id) }}" class="text-primary font-semibold hover:text-primary/80">Edit</a>
                                        <form action="{{ route('postingan.destroy', $item->id) }}" method="POST" class="delete-form" data-title="Konfirmasi: Yakin ingin menghapus postingan ini? Aksi ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-primary/70">Belum ada konten yang tersedia. Tambahkan data baru untuk mulai melacak publikasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation modal for deletes -->
    <div id="confirm-delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4 py-6">
        <div class="fixed inset-0 bg-black/50"></div>
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-auto p-6 relative">
            <h3 id="confirm-delete-title" class="text-lg font-semibold text-primary mb-4">Konfirmasi</h3>
            <p id="confirm-delete-message" class="text-sm text-primary/80 mb-6">Apakah Anda yakin ingin menghapus item ini? Aksi ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end gap-3">
                <button type="button" id="confirm-delete-cancel" class="px-4 py-2 rounded-full border">Batal</button>
                <button type="button" id="confirm-delete-do" class="px-4 py-2 rounded-full bg-red-600 text-white">Hapus</button>
            </div>
        </div>
    </div>

    <!-- Flash toast -->
    <div id="flash-toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-green-600 text-white px-4 py-3 rounded-lg shadow">&nbsp;</div>
    </div>

    @push('scripts')
    <script>
        (function(){
            // Intercept delete forms and show confirmation modal
            let currentForm = null;
            document.addEventListener('click', function(e){
                const btn = e.target.closest('form.delete-form button[type="submit"], form.delete-form .delete-button');
                if(btn){
                    const form = btn.closest('form.delete-form');
                    if(!form) return;
                    e.preventDefault();
                    currentForm = form;
                    const msg = form.dataset.title || 'Yakin ingin menghapus item ini?';
                    document.getElementById('confirm-delete-message').textContent = msg;
                    document.getElementById('confirm-delete-modal').classList.remove('hidden');
                    document.getElementById('confirm-delete-modal').classList.add('flex');
                }
            }, true);

            document.getElementById('confirm-delete-cancel').addEventListener('click', function(){
                document.getElementById('confirm-delete-modal').classList.add('hidden');
                document.getElementById('confirm-delete-modal').classList.remove('flex');
                currentForm = null;
            });

            document.getElementById('confirm-delete-do').addEventListener('click', function(){
                if(!currentForm) return;
                // submit the form
                currentForm.submit();
            });

            // Show flash toast if session contains success message
            document.addEventListener('DOMContentLoaded', function(){
                var flash = null;
                try{ flash = @json(session('success') ?? null); }catch(e){ flash = null; }
                if(flash){
                    const toast = document.getElementById('flash-toast');
                    toast.firstElementChild.textContent = flash;
                    toast.classList.remove('hidden');
                    setTimeout(()=>{ toast.classList.add('hidden'); }, 4000);
                }
            });
        })();
    </script>
    @endpush

</x-app-layout>
