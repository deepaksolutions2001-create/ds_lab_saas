@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-24">
    <!-- Header: Asset Protocol -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-cyan-200">Asset Procurement</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">New Entry</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Inventory <span class="text-cyan-600">Definition</span></h1>
            <p class="text-slate-500 font-medium mt-3">Register a new laboratory asset, consumable, or medical equipment for supply chain tracking.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('inventory.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
        </div>
    </div>

    <!-- MAIN FORM CONTAINER -->
    <form action="{{ route('inventory.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- LEFT: Asset Details --}}
            <div class="lg:col-span-12 space-y-10">
                <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-12 lg:p-16 space-y-12">
                    
                    {{-- Asset Name --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Official Asset Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 group-focus-within:text-cyan-500 transition-all pointer-events-none">
                                <i class="fas fa-box text-xl"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full pl-18 pr-8 py-7 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:ring-8 focus:ring-cyan-500/5 focus:border-cyan-500 outline-none transition-all font-black text-slate-800 text-2xl placeholder-slate-300 uppercase tracking-tight"
                                   placeholder="ENTER ASSET DESIGNATION" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        {{-- Field: Category --}}
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Asset Category</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-cyan-500 transition-all pointer-events-none">
                                    <i class="fas fa-tags text-sm"></i>
                                </div>
                                <select name="category_id" class="w-full pl-14 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">-- GENERAL SUPPLY --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-300 pointer-events-none">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                         {{-- Field: Unit --}}
                         <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tracking Unit</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 group-focus-within:text-cyan-500 transition-all pointer-events-none">
                                    <i class="fas fa-scale-balanced text-sm"></i>
                                </div>
                                <select name="unit" class="w-full pl-14 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="pcs">PIECES (PCS)</option>
                                    <option value="box">BOXES</option>
                                    <option value="kg">KILOGRAMS (KG)</option>
                                    <option value="ltr">LITERS (LTR)</option>
                                    <option value="kit">TEST KITS</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-6 flex items-center text-slate-300 pointer-events-none">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Field: Alert Level --}}
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Low Stock Threshold</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 pointer-events-none">
                                    <i class="fas fa-bell text-sm"></i>
                                </div>
                                <input type="number" name="alert_level" value="{{ old('alert_level', 10) }}"
                                       class="w-full pl-16 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition-all font-black text-slate-800"
                                       placeholder="0">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Action --}}
                <div class="flex justify-center">
                    <button type="submit" class="px-16 py-6 bg-cyan-600 text-white rounded-full font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-cyan-600/40 hover:bg-cyan-500 hover:-translate-y-2 transition-all active:scale-95 group relative overflow-hidden">
                        <span class="relative z-10 flex items-center gap-4">
                            Initiate Asset Tracking
                            <i class="fas fa-dolly group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
    .pl-18 { padding-left: 4.5rem; }
</style>
@endsection
