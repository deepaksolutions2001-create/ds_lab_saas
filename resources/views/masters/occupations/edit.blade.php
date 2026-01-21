@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    <!-- Header: Protocol Entry -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-200">Protocol Registry</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ isset($occupation) ? 'Modification' : 'New Entry' }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Occupation <span class="text-blue-600">Definition</span></h1>
            <p class="text-slate-500 font-medium mt-3">Define standardized clinical occupation designations for the medical registry system.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('occupations.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
        </div>
    </div>

    <!-- MAIN FORM CONTAINER -->
    <form action="{{ isset($occupation) ? route('occupations.update', $occupation->id) : route('occupations.store') }}" method="POST">
        @csrf
        @if(isset($occupation)) @method('PUT') @endif

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="p-12 lg:p-16 space-y-12">
                
                {{-- Field: Designation Name --}}
                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Official Designation Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-all pointer-events-none">
                            <i class="fas fa-briefcase text-xl"></i>
                        </div>
                        <input type="text" name="name" value="{{ $occupation->name ?? old('name') }}"
                               class="w-full pl-18 pr-8 py-7 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:ring-8 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all font-black text-slate-800 text-2xl placeholder-slate-300 uppercase tracking-tight"
                               placeholder="ENTER OCCUPATION DESIGNATION" required>
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest ml-1 opacity-60">This name will appear in dropdowns and clinical reports.</p>
                </div>

                {{-- Field: Status Toggle --}}
                <div class="p-8 rounded-[2.5rem] bg-slate-50/50 border border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-400">
                            <i class="fas fa-toggle-on text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest leading-none mb-1">Protocol Availability</p>
                            <p class="text-xs text-slate-400 font-medium">Enable or disable this occupation in the registry.</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ (isset($occupation) && $occupation->is_active) || !isset($occupation) ? 'checked' : '' }}>
                            <div class="w-16 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-7 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="p-12 lg:p-16 bg-slate-50/50 border-t border-slate-100 flex justify-center">
                <button type="submit" class="px-16 py-6 bg-slate-900 text-white rounded-full font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/40 hover:bg-blue-600 hover:-translate-y-2 transition-all active:scale-95 group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-4">
                        {{ isset($occupation) ? 'Update Protocol' : 'Initialize Protocol' }}
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .pl-18 { padding-left: 4.5rem; }
</style>
@endsection
