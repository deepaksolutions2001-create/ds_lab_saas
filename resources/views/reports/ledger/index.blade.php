@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    <!-- Header: Ledger Query -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-200">Financial Reports</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Statement Generation</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Party <span class="text-indigo-600">Ledger</span></h1>
            <p class="text-slate-500 font-medium mt-3">Configure parameters to generate a detailed Statement of Accounts.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('reports.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Back to Hub
            </a>
        </div>
    </div>

    <!-- MAIN FORM CONTAINER -->
    <form action="{{ route('reports.ledger.generate') }}" method="POST" target="_blank">
        @csrf

        <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-12 lg:p-16 space-y-12">
            
            {{-- Field: Agency/Client Select --}}
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Referral Agency</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-all pointer-events-none">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                    <select name="client_id" class="w-full pl-18 pr-8 py-7 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:ring-8 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none transition-all font-black text-slate-800 text-xl uppercase tracking-tight appearance-none cursor-pointer" required>
                        <option value="">-- SELECT PARTNER AGENCY --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->mobile ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-8 flex items-center text-slate-300 pointer-events-none">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                {{-- Field: Start Date --}}
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Example Period Start</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-all pointer-events-none">
                            <i class="fas fa-calendar-alt text-sm"></i>
                        </div>
                        <input type="date" name="start_date" value="{{ now()->startOfMonth()->format('Y-m-d') }}"
                               class="w-full pl-14 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 outline-none transition-all font-black text-slate-700 uppercase tracking-widest text-sm" required>
                    </div>
                </div>

                {{-- Field: End Date --}}
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Period Ending</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-indigo-500 transition-all pointer-events-none">
                            <i class="fas fa-calendar-check text-sm"></i>
                        </div>
                        <input type="date" name="end_date" value="{{ now()->format('Y-m-d') }}"
                               class="w-full pl-14 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 outline-none transition-all font-black text-slate-700 uppercase tracking-widest text-sm" required>
                    </div>
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="flex justify-center pt-6">
                <button type="submit" class="px-16 py-6 bg-indigo-600 text-white rounded-full font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-indigo-600/40 hover:bg-indigo-500 hover:-translate-y-2 transition-all active:scale-95 group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-4">
                        Generate Statement
                        <i class="fas fa-print group-hover:scale-110 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </button>
            </div>

        </div>
    </form>
</div>

<style>
    .pl-18 { padding-left: 4.5rem; }
</style>
@endsection
