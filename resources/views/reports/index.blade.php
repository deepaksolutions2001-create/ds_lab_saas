@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-24">
    <!-- Header: Reports Hub -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-200">Financial Intelligence</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Reporting Module</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Analytics <span class="text-indigo-600">Hub</span></h1>
            <p class="text-slate-500 font-medium mt-3 max-w-xl">Generate financial statements, audit logs, and operational summaries.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- REPORT CARD: Party Ledger -->
        <a href="{{ route('reports.ledger') }}" class="group bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden transition-all hover:bg-indigo-600 hover:shadow-indigo-500/30 hover:-translate-y-2">
            <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-50 rounded-bl-[100%] transition-colors group-hover:bg-white/10"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl mb-8 group-hover:bg-white/20 group-hover:text-white transition-colors">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-3 group-hover:text-white transition-colors">Party Ledger</h3>
                <p class="text-sm font-medium text-slate-400 leading-relaxed group-hover:text-indigo-100 transition-colors">
                    Detailed statement of accounts for referral agencies. Includes opening balances, billings, and payment history.
                </p>
                
                <div class="mt-8 flex items-center text-[10px] font-black uppercase tracking-widest text-indigo-600 group-hover:text-white transition-colors">
                    <span>Generate Statement</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>
        </a>

        <!-- REPORT CARD: Balance Summary Hub -->
        <a href="{{ route('reports.balances') }}" class="group bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden transition-all hover:bg-emerald-600 hover:shadow-emerald-500/30 hover:-translate-y-2">
            <div class="absolute top-0 right-0 w-40 h-40 bg-emerald-50 rounded-bl-[100%] transition-colors group-hover:bg-white/10"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl mb-8 group-hover:bg-white/20 group-hover:text-white transition-colors">
                    <i class="fas fa-wallet"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight mb-3 group-hover:text-white transition-colors">Live Balances</h3>
                <p class="text-sm font-medium text-slate-400 leading-relaxed group-hover:text-emerald-100 transition-colors">
                    Real-time monitoring of all outstanding receivables from partner agencies.
                </p>
                
                <div class="mt-8 flex items-center text-[10px] font-black uppercase tracking-widest text-emerald-600 group-hover:text-white transition-colors">
                    <span>View Hub</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </div>
            </div>
        </a>

        <!-- REPORT CARD: Inventory Audit (Placeholder) -->
        <div class="group bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden opacity-60">
            <div class="absolute top-0 right-0 w-40 h-40 bg-slate-50 rounded-bl-[100%]"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 text-2xl mb-8">
                    <i class="fas fa-dolly"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-400 uppercase tracking-tight mb-3">Stock Audit</h3>
                <p class="text-sm font-medium text-slate-400 leading-relaxed">
                    Inventory movement logs showing consumption vs. procurement trends over time.
                </p>
                
                <div class="mt-8 flex items-center text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <span>Coming Soon</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
