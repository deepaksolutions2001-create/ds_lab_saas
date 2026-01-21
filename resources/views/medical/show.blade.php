@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <!-- ACTION BAR -->
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('medical.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase leading-none">Case Analytics</h1>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1.5">Official Registry Record & Documentation</p>
            </div>
        </div>
        
        <div class="flex gap-4">
            <button onclick="window.print()" class="px-6 py-4 bg-white border border-slate-200 rounded-2xl font-black text-[10px] uppercase tracking-widest text-slate-500 hover:bg-slate-50 transition-all flex items-center gap-3">
                <i class="fas fa-print text-sm opacity-50"></i> Print View
            </button>
            @if(!$report->is_locked)
                <a href="{{ route('medical.edit', $report->id) }}" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-blue-500/30 hover:bg-blue-700 hover:-translate-y-0.5 transition-all flex items-center gap-3">
                    <i class="fas fa-pen-nib text-sm"></i> Edit Registry
                </a>
            @endif
        </div>
    </div>

    <!-- MAIN RECORD CONTAINER -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        
        <!-- HEADER: CASE IDENTITY -->
        <div class="p-10 lg:p-14 border-b border-slate-50 bg-gradient-to-br from-slate-50 to-white flex flex-wrap gap-10 items-center justify-between">
            <div class="flex items-center gap-8">
                <div class="w-24 h-24 bg-blue-600 rounded-[2rem] flex items-center justify-center text-white text-4xl shadow-2xl shadow-blue-600/40 relative">
                    <i class="fas fa-file-waveform"></i>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 border-4 border-white rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-[10px] text-white"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">{{ $report->patient_name }}</h2>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="px-4 py-1.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">REF #{{ $report->ref_no }}</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-tight flex items-center gap-2">
                             <i class="far fa-calendar-check text-blue-500"></i> {{ $report->medical_date->format('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-end gap-3">
                <div class="flex gap-2">
                    <span class="px-5 py-2 rounded-2xl font-black text-[10px] uppercase border {{ $report->test_status === 'completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                        {{ $report->test_status }}
                    </span>
                    @if($report->fitness_status)
                        <span class="px-5 py-2 rounded-2xl font-black text-[10px] uppercase {{ $report->fitness_status === 'FIT' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-rose-600 text-white shadow-lg shadow-rose-500/30' }}">
                            {{ $report->fitness_status }}
                        </span>
                    @endif
                </div>
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Clinical Diagnostic state</p>
            </div>
        </div>

        <div class="p-10 lg:p-14 grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- LEFT COLUMN: MEDICAL DATA -->
            <div class="lg:col-span-7 space-y-16">
                
                <!-- PART A: IDENTITY -->
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-id-card-clip"></i>
                        </div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Part A: Identity Registry</h4>
                    </div>

                    <div class="grid grid-cols-2 gap-x-12 gap-y-10">
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Father's / Guardian Relation</p>
                            <p class="font-black text-slate-800 uppercase tracking-tight">{{ $report->father_name ?? 'NOT RECORDED' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Passport Intelligence</p>
                            <p class="font-black text-blue-600 uppercase tracking-[0.1em] text-lg">{{ $report->passport_no ?? 'UNAVAILABLE' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Biological Gender</p>
                            <p class="font-black text-slate-800 uppercase tracking-tight flex items-center gap-2">
                                <i class="fas fa-{{ strtolower($report->gender) === 'male' ? 'mars text-blue-400' : 'venus text-purple-400' }}"></i>
                                {{ $report->gender }}
                            </p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Chronological Birth</p>
                            <p class="font-black text-slate-800 uppercase tracking-tight">
                                {{ $report->dob ? $report->dob->format('d M Y') : 'N/A' }} 
                                <span class="ml-2 text-[10px] text-slate-400">({{ $report->dob ? $report->dob->age . ' Years' : '--' }})</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- PART B: PHYSICALS -->
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                            <i class="fas fa-heart-pulse"></i>
                        </div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Part B: Physical Observations</h4>
                    </div>

                    <div class="bg-slate-50/50 p-10 rounded-[2.5rem] border border-slate-100 flex items-center justify-around text-center shadow-inner">
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Height Gauge</p>
                            <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ $report->height ?? '--' }} <span class="text-[10px] font-bold text-slate-300 ml-1">cm</span></p>
                        </div>
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Mass Weight</p>
                            <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ $report->weight ?? '--' }} <span class="text-[10px] font-bold text-slate-300 ml-1">kg</span></p>
                        </div>
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div class="space-y-1">
                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Blood Type</p>
                            <p class="text-2xl font-black text-rose-600 tracking-tighter">{{ $report->blood_group ?? '??' }} <i class="fas fa-droplet text-sm ml-1"></i></p>
                        </div>
                    </div>

                    <div class="p-8 rounded-3xl bg-blue-50/30 border border-blue-100/50 flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                <i class="fas fa-gauge-high"></i>
                            </div>
                            <div>
                                <p class="text-[9px] text-blue-400 font-black uppercase tracking-widest leading-none mb-1">Systolic/Diastolic BP</p>
                                <p class="text-xl font-black text-blue-900 tracking-tighter">{{ $report->bp ?? '000/00' }} <small class="text-[10px] text-blue-400 ml-1 uppercase">mmHg</small></p>
                            </div>
                        </div>
                        <i class="fas fa-chart-line text-4xl text-blue-200/50"></i>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: FINANCIALS & LAB -->
            <div class="lg:col-span-5 space-y-16">
                
                <!-- FINANCIAL CARD (PREMIUM DARK) -->
                <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-blue-500/10 transition-all duration-700"></div>
                    <i class="fas fa-handshake-angle absolute -right-8 -bottom-8 text-[12rem] text-white/5 rotate-12 transition-transform duration-700 group-hover:rotate-6"></i>
                    
                    <h4 class="text-[10px] font-black text-blue-300 uppercase tracking-[0.2em] mb-10 border-b border-white/10 pb-4 flex justify-between items-center">
                        Financial Audit Context
                        <i class="fas fa-shield-check text-blue-400 opacity-50"></i>
                    </h4>
                    
                    <div class="space-y-8 relative z-10">
                        <div class="space-y-1.5">
                            <p class="text-[10px] text-white/40 font-black uppercase tracking-widest">Registry Source / Referral Party</p>
                            <p class="font-black text-xl tracking-tight text-white uppercase">{{ $report->client->name ?? 'DIRECT WALKIN' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-8 items-end">
                            <div class="space-y-1.5">
                                <p class="text-[10px] text-white/40 font-black uppercase tracking-widest">Laboratory Required fee</p>
                                <p class="font-black text-2xl tracking-tighter text-blue-200">${{ number_format($report->amount_required, 2) }}</p>
                            </div>
                            <div class="text-right space-y-1.5">
                                <p class="text-[10px] text-emerald-400 font-black uppercase tracking-widest">Patient Settled</p>
                                <p class="font-black text-3xl tracking-tighter text-emerald-400">${{ number_format($report->amount_received, 2) }}</p>
                            </div>
                        </div>

                        <div class="bg-white/10 p-6 rounded-[2rem] flex items-center justify-between border border-white/5 backdrop-blur-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                    <i class="fas fa-briefcase-medical"></i>
                                </div>
                                <div>
                                    <p class="text-[9px] text-white/40 font-black uppercase tracking-widest leading-none mb-1">Agency Incentive</p>
                                    <p class="font-black text-xl tracking-tight text-emerald-300">+${{ number_format($report->amount_received - $report->amount_required, 2) }}</p>
                                </div>
                            </div>
                            <i class="fas fa-arrow-trend-up text-3xl text-emerald-500/50"></i>
                        </div>
                    </div>
                </div>

                <!-- TEST RESULTS PANEL -->
                <div class="space-y-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                                <i class="fas fa-vials"></i>
                            </div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Part D: Diagnostic Inventory</h4>
                        </div>
                        @if($report->testResults->count() > 0)
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $report->testResults->count() }} Tests</span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @forelse($report->testResults as $result)
                            <div class="p-8 bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all border-l-4 border-l-purple-500">
                                <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-50">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                                            <i class="fas fa-microscope text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 text-sm tracking-tight uppercase">{{ $result->test->name }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-widest">{{ $result->test->category }}</p>
                                        </div>
                                    </div>
                                    <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-300">
                                        <i class="fas fa-flask"></i>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                                    @php $data = $result->data_json ?? []; @endphp
                                    @forelse($result->test->fields_json as $field)
                                        <div class="space-y-1">
                                            <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">{{ $field['label'] }} {{ isset($field['unit']) ? '('.$field['unit'].')' : '' }}</p>
                                            <p class="font-black text-slate-800 uppercase tracking-tight">
                                                {{ $data[$field['name']] ?? '---' }}
                                            </p>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-300 italic">No parameters defined for this test.</p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <div class="p-16 text-center bg-slate-50/50 rounded-[3rem] border border-dashed border-slate-200 flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-200 shadow-sm">
                                    <i class="fas fa-box-open text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Zero Analytical records</p>
                                    <p class="text-[10px] text-slate-300 font-medium mt-1">Laboratory tests have not been populated for this case UID.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER METADATA -->
        <div class="px-14 py-10 bg-slate-900 flex flex-col md:flex-row items-center justify-between gap-10 border-t border-white/5">
            <div class="flex items-center gap-10">
                <div>
                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-[0.2em] mb-1">Registry Created</p>
                    <p class="text-xs font-black text-slate-300 uppercase leading-none">{{ $report->created_at->format('d/m/Y H:i') }} <span class="text-blue-500 ml-1">UTC</span></p>
                </div>
                <div class="w-px h-8 bg-white/10"></div>
                <div>
                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-[0.2em] mb-1">Last Protocol Update</p>
                    <p class="text-xs font-black text-slate-300 uppercase leading-none">{{ $report->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-5">
                <div class="text-right">
                    <p class="text-[9px] text-slate-600 font-black uppercase tracking-widest">Compliance Protocol</p>
                    <p class="text-[10px] font-bold text-slate-400 italic">This document is digitally locked & non-fungible.</p>
                </div>
                <i class="fas fa-lock text-slate-700 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .max-w-5xl { max-width: 100% !important; padding: 0 !important; }
        .bg-white { box-shadow: none !important; border: none !important; }
        .bg-slate-900 { background: #fff !important; color: #000 !important; border-top: 1px solid #eee !important; }
        .text-white { color: #000 !important; }
        .bg-gradient-to-br { background: #fff !important; }
        .shadow-2xl, .shadow-xl, .shadow-lg { box-shadow: none !important; }
        .rounded-[3rem], .rounded-[2rem], .rounded-3xl, .rounded-2xl { border-radius: 0 !important; }
        button, a[href*="edit"] { display: none !important; }
        .px-14, .p-14, .p-10 { padding: 20px !important; }
    }
</style>
@endsection
