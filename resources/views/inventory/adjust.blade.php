@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-24">
    <!-- Header: Stock Control -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-cyan-200">Stock Adjustment</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ $product->name }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Logistics <span class="text-cyan-600">Update</span></h1>
            <p class="text-slate-500 font-medium mt-3">Manually calibrate stock levels, record new procurements, or log consumption events.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('inventory.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- LEFT: Product Context -->
        <div class="lg:col-span-12 xl:col-span-5 space-y-8">
            <div class="bg-gradient-to-br from-cyan-900 via-slate-900 to-slate-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-500/10 blur-[80px] rounded-full pointer-events-none"></div>
                
                <div class="flex items-center gap-5 mb-10 pb-8 border-b border-white/10">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-cyan-300 shadow-inner border border-white/5">
                        <i class="fas fa-prescription-bottle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-1">Asset Designation</p>
                        <h3 class="text-2xl font-black uppercase tracking-tight">{{ $product->name }}</h3>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-1">Current Stock Level</p>
                        <p class="text-5xl font-black tracking-tighter font-mono text-cyan-300">
                            {{ $product->stock }} <span class="text-lg text-white/30">{{ strtoupper($product->unit) }}</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-5 bg-white/5 rounded-2xl border border-white/5">
                            <p class="text-[9px] font-black text-white/40 uppercase tracking-widest mb-1">Category</p>
                            <p class="font-bold text-white uppercase text-sm">{{ $product->category->name ?? 'GENERAL' }}</p>
                        </div>
                        <div class="p-5 bg-white/5 rounded-2xl border border-white/5">
                            <p class="text-[9px] font-black text-white/40 uppercase tracking-widest mb-1">Alert Threshold</p>
                            <p class="font-bold text-white uppercase text-sm flex items-center gap-2">
                                <i class="fas fa-bell text-xs text-white/50"></i> {{ $product->alert_level }} Units
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Adjustment Form -->
        <div class="lg:col-span-12 xl:col-span-7">
            <form action="{{ route('inventory.updateStock', $product->id) }}" method="POST" class="bg-white rounded-[3rem] shadow-xl border border-slate-100 p-12 space-y-10">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h4 class="text-lg font-black text-slate-800 uppercase tracking-tight flex items-center gap-3">
                        <i class="fas fa-sliders text-cyan-600"></i> Operation Type
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="add" class="peer sr-only" checked>
                            <div class="p-6 bg-slate-50 border-2 border-slate-100 rounded-3xl peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 hover:bg-white hover:shadow-lg transition-all text-center">
                                <div class="w-10 h-10 mx-auto mb-3 bg-white rounded-full flex items-center justify-center shadow-sm text-slate-300 peer-checked:text-emerald-500">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest">Procurement (IN)</span>
                            </div>
                        </label>
                        
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="remove" class="peer sr-only">
                            <div class="p-6 bg-slate-50 border-2 border-slate-100 rounded-3xl peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 hover:bg-white hover:shadow-lg transition-all text-center">
                                <div class="w-10 h-10 mx-auto mb-3 bg-white rounded-full flex items-center justify-center shadow-sm text-slate-300 peer-checked:text-rose-500">
                                    <i class="fas fa-minus"></i>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest">Consumption (OUT)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Adjustment Quantity</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 pointer-events-none">
                            <i class="fas fa-calculator text-lg"></i>
                        </div>
                        <input type="number" name="quantity" min="1" 
                               class="w-full pl-16 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-[2rem] focus:border-cyan-500 outline-none transition-all font-black text-slate-800 text-3xl font-mono"
                               placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-8 flex items-center text-slate-400 font-black text-xs uppercase">{{ strtoupper($product->unit) }}</div>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Reference / Remarks</label>
                    <input type="text" name="reason" 
                           class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-cyan-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300 uppercase tracking-widest text-sm"
                           placeholder="E.G. BATCH #4023 OR DAILY CONSUMPTION">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-6 bg-slate-900 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/30 hover:bg-cyan-600 hover:-translate-y-1 transition-all active:scale-95">
                        Confirm Adjustment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
