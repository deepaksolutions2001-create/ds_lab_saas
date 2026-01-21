@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-24">
    <!-- Header: Diagnostic Context -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-amber-200">Record Modification</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">REF #{{ $report->ref_no }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Modify <span class="text-amber-600">Medical Case</span></h1>
            <p class="text-slate-500 font-medium mt-3 max-w-xl">Adjust patient demographics, diagnostic observations, or clinical outcomes for this established registry record.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('medical.show', $report->id) }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
            <button type="button" onclick="document.getElementById('medicalReportForm').submit()" class="px-8 py-3 rounded-2xl bg-amber-600 text-white font-black text-sm uppercase tracking-widest shadow-xl shadow-amber-500/30 hover:bg-amber-700 transition-all">
                Update Protocol
            </button>
        </div>
    </div>

    <form action="{{ route('medical.update', $report->id) }}" method="POST" id="medicalReportForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- LEFT COLUMN: Patient & Vitals -->
            <div class="lg:col-span-12 xl:col-span-12 space-y-10">
                
                <!-- SECTION 1: IDENTITY (PART A) -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-amber-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-500/20">
                                <i class="fas fa-edit text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase leading-none text-sm">Part A: Identity Registry</h3>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1.5">Established demographics and travel credentials</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                            <div class="md:col-span-8 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Legal Name (As per Passport)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-amber-500 transition-colors pointer-events-none">
                                        <i class="fas fa-user-tag text-sm"></i>
                                    </div>
                                    <input type="text" name="patient_name" value="{{ $report->patient_name }}"
                                           class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all font-black text-slate-800 text-lg placeholder-slate-300 uppercase tracking-tight"
                                           placeholder="ENTER PATIENT NAME" required>
                                </div>
                            </div>

                            <div class="md:col-span-4 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Passport Number</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-amber-500 transition-colors pointer-events-none">
                                        <i class="fas fa-passport text-sm"></i>
                                    </div>
                                    <input type="text" name="passport_no" value="{{ $report->passport_no }}"
                                           class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none transition-all font-black text-blue-600 tracking-widest placeholder-slate-300 uppercase"
                                           placeholder="PASSPORT NO">
                                </div>
                            </div>

                            <div class="md:col-span-4 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Patient Occupation</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-amber-500 transition-colors pointer-events-none">
                                        <i class="fas fa-briefcase text-sm"></i>
                                    </div>
                                    <select name="occupation_id" 
                                            class="w-full pl-14 pr-10 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-amber-500 outline-none transition-all font-black text-slate-700 appearance-none cursor-pointer">
                                        <option value="">-- SELECT OCCUPATION --</option>
                                        @foreach($occupations as $occ)
                                            <option value="{{ $occ->id }}" {{ $report->occupation_id == $occ->id ? 'selected' : '' }}>{{ $occ->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-300 pointer-events-none">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-4 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Father / Guardian</label>
                                <input type="text" name="father_name" value="{{ $report->father_name }}"
                                       class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-amber-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300 uppercase"
                                       placeholder="RELATION NAME">
                            </div>

                            <div class="md:col-span-3 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Date of Birth</label>
                                <input type="date" name="dob" value="{{ $report->dob ? $report->dob->format('Y-m-d') : '' }}"
                                       class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-amber-500 outline-none transition-all font-bold text-slate-700">
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Gender</label>
                                <select name="gender" class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-amber-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="Male" {{ $report->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $report->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $report->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="md:col-span-3 space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Registry Date</label>
                                <input type="date" name="medical_date" value="{{ $report->medical_date->format('Y-m-d') }}"
                                       class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-amber-500 outline-none transition-all font-bold text-slate-700">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: PHYSICALS (PART B - VITALS) -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex items-center gap-5 bg-slate-50/30">
                        <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-500/20">
                            <i class="fas fa-heart-pulse text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase leading-none text-sm">Part B: Clinical Observations</h3>
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1.5">Adjusted physical examination & vitals data</p>
                        </div>
                    </div>

                    <div class="p-10">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Height (cm)</label>
                                <div class="relative">
                                    <input type="text" name="height" value="{{ $report->height }}" class="w-full pl-6 pr-12 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-orange-500 outline-none transition-all font-black text-slate-700" placeholder="0">
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-400 uppercase">CM</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Weight (kg)</label>
                                <div class="relative">
                                    <input type="text" name="weight" value="{{ $report->weight }}" class="w-full pl-6 pr-12 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-orange-500 outline-none transition-all font-black text-slate-700" placeholder="0">
                                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-400 uppercase">KG</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">B.P. Gauge</label>
                                <div class="relative">
                                    <input type="text" name="bp" value="{{ $report->bp }}" class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-orange-500 outline-none transition-all font-black text-slate-700" placeholder="120/80">
                                    <i class="fas fa-gauge absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Blood Type</label>
                                <select name="blood_group" class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-orange-500 outline-none transition-all font-black text-slate-700 appearance-none cursor-pointer">
                                    <option value="">N/A</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                        <option value="{{ $bg }}" {{ $report->blood_group === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-4 lg:col-span-1">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Fitness Verdict</label>
                                <select name="fitness_status" class="w-full px-6 py-5 bg-slate-900 border-none text-white rounded-2xl focus:ring-4 focus:ring-blue-500/20 outline-none transition-all font-black text-xs uppercase tracking-widest appearance-none cursor-pointer">
                                    @foreach(['TENTATIVE', 'FIT', 'UNFIT', 'HELD'] as $status)
                                        <option value="{{ $status }}" {{ $report->fitness_status === $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: DIAGNOSTIC INVENTORY (DYNAMIC) -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-purple-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-500/20">
                                <i class="fas fa-microscope text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase leading-none text-sm">Diagnostic Inventory</h3>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1.5">Establish medical evaluations and clinical outcomes</p>
                            </div>
                        </div>
                        <div class="relative w-64 group">
                            <select id="test_selector" class="w-full pl-6 pr-10 py-3 bg-white border-2 border-slate-100 rounded-xl focus:border-purple-500 shadow-sm font-black text-slate-700 outline-none appearance-none cursor-pointer transition-all text-[10px] uppercase tracking-widest">
                                <option value="">+ ADD DIAGNOSTIC</option>
                                @foreach($tests as $test)
                                    <option value="{{ $test->id }}" data-fields='@json($test->fields_json)' data-name="{{ $test->name }}">{{ $test->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-300 pointer-events-none">
                                <i class="fas fa-flask text-[10px]"></i>
                            </div>
                        </div>
                    </div>

                    <div id="diagnostics_container" class="p-10 space-y-6">
                        <!-- Existing Test results will be injected here via JS on page load -->
                        <div id="no_test_empty" class="py-12 flex flex-col items-center justify-center text-center opacity-40">
                            <div class="w-20 h-20 rounded-full border-4 border-dashed border-slate-200 flex items-center justify-center mb-4">
                                <i class="fas fa-plus text-slate-300 text-xl"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-loose">No diagnostics added.<br>Select a laboratory test from the dropdown above.</p>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: FINANCIAL AUDIT -->
                <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-slate-500/20 p-10 lg:p-14 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 blur-[100px] rounded-full pointer-events-none"></div>
                    
                    <div class="flex items-center gap-5 mb-14 border-b border-white/5 pb-10">
                        <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-500/20">
                            <i class="fas fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black tracking-tight uppercase leading-none">Financial Audit Context</h3>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.2em] mt-2">Referral settlement update</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                        <div class="md:col-span-6 space-y-3">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Referral Source / Agency</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-emerald-500 pointer-events-none">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <select name="client_id" required
                                        class="w-full pl-14 pr-10 py-5 bg-white/5 border border-white/10 rounded-2xl focus:border-emerald-500 shadow-sm font-black text-white outline-none appearance-none cursor-pointer transition-all">
                                    <option value="">-- UNKNOWN / DIRECT WALK-IN --</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ $report->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="md:col-span-3 space-y-3">
                            <label class="block text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] ml-1">Lab Required Fee</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-blue-500/50">
                                    <span class="font-black text-xs text-blue-400 tracking-tighter">$</span>
                                </div>
                                <input type="number" step="0.01" name="amount_required" id="amount_required" value="{{ $report->amount_required }}"
                                       class="w-full pl-12 pr-6 py-5 bg-white/5 border border-white/10 rounded-2xl focus:border-blue-500 outline-none font-black text-white transition-all font-mono text-xl" 
                                       placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="md:col-span-3 space-y-3">
                            <label class="block text-[10px] font-black text-orange-400 uppercase tracking-[0.2em] ml-1">Patient Settled</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-orange-500/50">
                                    <span class="font-black text-xs text-orange-400 tracking-tighter">$</span>
                                </div>
                                <input type="number" step="0.01" name="amount_received" id="amount_received" value="{{ $report->amount_received }}"
                                       class="w-full pl-12 pr-6 py-5 bg-white/5 border border-white/10 rounded-2xl focus:border-orange-500 outline-none font-black text-white transition-all font-mono text-xl" 
                                       placeholder="0.00" required>
                            </div>
                        </div>
                    </div>

                    <div id="balance_indicator" class="mt-12 p-8 rounded-[2rem] bg-white/5 border border-white/5 flex items-center justify-between transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-500">
                                <i class="fas fa-coins text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Coordinated Incentive</p>
                                <p class="text-xs font-bold text-slate-400">Calculated Agent Surplus</p>
                            </div>
                        </div>
                        <span id="agent_share_value" class="text-4xl font-black font-mono tracking-tighter">0.00</span>
                    </div>
                </div>

                <!-- FORM ACTIONS -->
                <div class="flex items-center justify-center gap-8 py-10">
                    <button type="submit" class="px-20 py-7 bg-amber-600 text-white rounded-[2.5rem] font-black text-lg uppercase tracking-[0.3em] shadow-3xl shadow-amber-600/50 hover:bg-amber-500 hover:-translate-y-2 transition-all active:scale-95 group relative overflow-hidden">
                        <span class="relative z-10 flex items-center gap-6">
                            UPDATE CLINICAL REPORT
                            <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-400/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- DIAGNOSTIC MODULE TEMPLATE -->
<template id="test_module_template">
    <div class="test-module bg-slate-50/50 rounded-3xl border border-slate-100 p-8 pt-6 group animate-in slide-in-from-top-4 duration-500">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200/50">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-black text-[10px] border border-purple-200">#</span>
                <h4 class="test-title text-sm font-black text-slate-900 uppercase tracking-tighter">Test Name</h4>
            </div>
            <button type="button" class="remove-test text-slate-300 hover:text-red-500 transition-colors p-2">
                <i class="fas fa-times-circle text-lg"></i>
            </button>
        </div>
        <div class="fields-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-8">
            <!-- Dynamic fields go here -->
        </div>
    </div>
</template>

<script>
    const testSelector = document.getElementById('test_selector');
    const container = document.getElementById('diagnostics_container');
    const emptyState = document.getElementById('no_test_empty');
    const template = document.getElementById('test_module_template');

    const selectedTests = new Set();

    function addTestModule(testId, name, fields, existingValues = {}) {
        if (!testId || selectedTests.has(testId)) return;

        // Create Module UI
        const clone = template.content.cloneNode(true);
        const module = clone.querySelector('.test-module');
        module.dataset.id = testId;
        module.querySelector('.test-title').innerText = name;

        const grid = module.querySelector('.fields-grid');

        fields.forEach(f => {
            const fieldWrapper = document.createElement('div');
            fieldWrapper.className = 'space-y-2';
            
            const label = document.createElement('label');
            label.className = 'block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1';
            label.innerText = f.label + (f.unit ? ` (${f.unit})` : '');

            const inputWrapper = document.createElement('div');
            inputWrapper.className = 'relative group';

            let input;
            if (f.type === 'textarea') {
                input = document.createElement('textarea');
                input.rows = 2;
                input.className = 'w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:border-purple-400 outline-none transition-all font-bold text-slate-700 text-sm shadow-sm';
            } else {
                input = document.createElement('input');
                input.type = f.type || 'text';
                input.className = 'w-full px-6 py-5 bg-white border border-slate-200 rounded-2xl focus:border-purple-400 outline-none transition-all font-black text-slate-700 text-sm shadow-sm';
            }
            
            input.name = `test_results[${testId}][${f.name}]`;
            input.placeholder = `ENTER ${f.label.toUpperCase()}`;
            input.value = existingValues[f.name] || '';

            inputWrapper.appendChild(input);
            fieldWrapper.appendChild(label);
            fieldWrapper.appendChild(inputWrapper);
            grid.appendChild(fieldWrapper);
        });

        module.querySelector('.remove-test').addEventListener('click', () => {
            module.remove();
            selectedTests.delete(testId);
            if (selectedTests.size === 0) emptyState.classList.remove('hidden');
        });

        // Append and track
        container.appendChild(clone);
        selectedTests.add(testId);
        emptyState.classList.add('hidden');
    }

    testSelector.addEventListener('change', function() {
        const testId = this.value;
        if (!testId) return;
        const option = this.options[this.selectedIndex];
        const fields = JSON.parse(option.dataset.fields || '[]');
        const name = option.dataset.name;
        
        addTestModule(testId, name, fields);
        this.value = '';
    });

    // Financial Audit Real-time
    const reqInput = document.getElementById('amount_required');
    const recvInput = document.getElementById('amount_received');
    const indicator = document.getElementById('balance_indicator');
    const shareVal = document.getElementById('agent_share_value');

    function updateShare() {
        const req = parseFloat(reqInput.value) || 0;
        const recv = parseFloat(recvInput.value) || 0;
        const share = recv - req;

        shareVal.innerText = share.toFixed(2);
        if(share >= 0) {
            shareVal.className = 'text-4xl font-black font-mono tracking-tighter text-emerald-400';
        } else {
            shareVal.className = 'text-4xl font-black font-mono tracking-tighter text-red-500';
        }
    }

    reqInput.addEventListener('input', updateShare);
    recvInput.addEventListener('input', updateShare);

    // Bootstrap existing results
    window.addEventListener('DOMContentLoaded', () => {
        const existingResults = @json($report->testResults->mapWithKeys(fn($tr) => [$tr->medical_test_id => ['name' => $tr->test->name, 'fields' => $tr->test->fields_json, 'data' => $tr->data_json]]));
        
        Object.entries(existingResults).forEach(([testId, payload]) => {
            addTestModule(testId, payload.name, payload.fields, payload.data);
        });
        
        updateShare();
    });
</script>

<style>
    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection
