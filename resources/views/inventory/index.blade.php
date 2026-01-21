@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-24">
    <!-- Header: Supply Chain -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-cyan-200">Laboratory Logistics</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Stock Control</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Inventory <span class="text-cyan-600">Command</span></h1>
            <p class="text-slate-500 font-medium mt-3 max-w-xl">Monitor laboratory assets, track consumption rates, and manage supply chain alerts.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('inventory.create') }}" class="px-8 py-4 rounded-2xl bg-cyan-600 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-cyan-500/30 hover:bg-cyan-700 hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-boxes-stacked text-sm"></i> Onboard New Asset
            </a>
        </div>
    </div>

    <!-- MAIN RECORD CONTAINER -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                        <th class="px-10 py-8">Asset Designation</th>
                        <th class="px-10 py-8">Stock Level</th>
                        <th class="px-10 py-8">Consumption Unit</th>
                        <th class="px-10 py-8">Alert Threshold</th>
                        <th class="px-10 py-8 text-right">Supply Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                        <tr class="group hover:bg-cyan-50/10 transition-all">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-prescription-bottle text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase tracking-tight text-sm">{{ $product->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-widest">
                                            {{ $product->category->name ?? 'GENERAL SUPPLY' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                @php
                                    $statusColor = $product->stock > $product->alert_level ? 'emerald' : ($product->stock > 0 ? 'amber' : 'rose');
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl font-black text-slate-900 tracking-tighter">{{ $product->stock }}</span>
                                    <span class="px-2 py-1 bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700 rounded-lg text-[9px] font-black uppercase tracking-widest">
                                        {{ $product->stock > 0 ? 'IN STOCK' : 'DEPLETED' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-1.5 bg-slate-50 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-100">
                                    PER {{ strtoupper($product->unit) }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-2 text-slate-400">
                                    <i class="fas fa-bell text-xs"></i>
                                    <span class="text-xs font-bold">{{ $product->alert_level }} Units</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all">
                                    <a href="{{ route('inventory.adjust', $product->id) }}" class="px-5 py-3 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-cyan-600 hover:border-cyan-200 transition-all shadow-sm flex items-center gap-2">
                                        <i class="fas fa-right-left text-xs"></i>
                                        <span class="text-[9px] font-black uppercase tracking-widest">Adjust</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-40 text-center bg-slate-50/20">
                                <div class="flex flex-col items-center gap-8 opacity-20">
                                    <i class="fas fa-dolly text-7xl text-slate-300"></i>
                                    <div>
                                        <p class="text-xs font-black text-slate-500 uppercase tracking-[0.4em]">Warehouse Empty</p>
                                        <p class="text-[10px] text-slate-400 font-bold mt-2">Initialize inventory assets to begin stock tracking.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-10 border-t border-slate-50 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
