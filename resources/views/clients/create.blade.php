@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-24">
    <!-- Header: Onboarding Protocol -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-200">Agency Onboarding</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ isset($client) ? 'Contract Modification' : 'New Partnership' }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Referral <span class="text-emerald-600">Source</span></h1>
            <p class="text-slate-500 font-medium mt-3">Register a commercial partner, hospital, or agent for diagnostic referral tracking.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('clients.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
        </div>
    </div>

    <!-- MAIN FORM CONTAINER -->
    <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" method="POST">
        @csrf
        @if(isset($client)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- LEFT: Agency Details --}}
            <div class="lg:col-span-12 space-y-10">
                <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-12 lg:p-16 space-y-12">
                    
                    {{-- Agency Name --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Agency / Full Party Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 group-focus-within:text-emerald-500 transition-all pointer-events-none">
                                <i class="fas fa-building text-xl"></i>
                            </div>
                            <input type="text" name="name" value="{{ $client->name ?? old('name') }}"
                                   class="w-full pl-18 pr-8 py-7 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:ring-8 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all font-black text-slate-800 text-2xl placeholder-slate-300 uppercase tracking-tight"
                                   placeholder="ENTER AGENCY NAME" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Field: Mobile --}}
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Primary Contact</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-emerald-500 transition-all pointer-events-none">
                                    <i class="fas fa-phone text-sm"></i>
                                </div>
                                <input type="text" name="mobile" value="{{ $client->mobile ?? old('mobile') }}"
                                       class="w-full pl-14 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-emerald-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300 uppercase tracking-widest"
                                       placeholder="PHONE NUMBER">
                            </div>
                        </div>

                         {{-- Field: Email --}}
                         <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Electronic Mail</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-emerald-500 transition-all pointer-events-none">
                                    <i class="fas fa-envelope text-sm"></i>
                                </div>
                                <input type="email" name="email" value="{{ $client->email ?? old('email') }}"
                                       class="w-full pl-14 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-emerald-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300 uppercase tracking-widest"
                                       placeholder="EMAIL ADDRESS">
                            </div>
                        </div>
                    </div>

                    {{-- Field: Opening Balance --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Initial Ledger Position (Opening Balance)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 pointer-events-none">
                                <span class="font-black text-lg">$</span>
                            </div>
                            <input type="number" step="0.01" name="opening_balance" value="{{ $client->opening_balance ?? old('opening_balance', 0) }}"
                                   class="w-full pl-16 pr-8 py-7 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:border-emerald-500 outline-none transition-all font-black text-slate-800 text-xl font-mono"
                                   placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-8 flex items-center text-emerald-500/50 pointer-events-none font-bold text-[10px] uppercase">
                                Previous FY Carryover
                            </div>
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold ml-2">Positive value = Receivable (Dr) | Negative value = Payable (Cr)</p>
                    </div>

                    {{-- Field: Address --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Registered Office Address</label>
                        <textarea name="address" rows="3"
                                  class="w-full p-8 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:border-emerald-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300 uppercase text-sm resize-none"
                                  placeholder="ENTER COMPLETE BILLING ADDRESS"></textarea>
                    </div>

                </div>

                {{-- Footer Action --}}
                <div class="flex justify-center">
                    <button type="submit" class="px-16 py-6 bg-emerald-600 text-white rounded-full font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-emerald-600/40 hover:bg-emerald-500 hover:-translate-y-2 transition-all active:scale-95 group relative overflow-hidden">
                        <span class="relative z-10 flex items-center gap-4">
                            {{ isset($client) ? 'Update Agreement' : 'Finalize Contract' }}
                            <i class="fas fa-file-signature group-hover:scale-110 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
    .pl-18 { padding-left: 4.5rem; }
    textarea { field-sizing: content; min-height: 120px; }
</style>
@endsection
