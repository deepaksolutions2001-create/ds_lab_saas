@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-24">
    <!-- Header: Command Center -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-indigo-200">System Overview</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ now()->format('d M Y') }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Clinical <span class="text-indigo-600">Command</span></h1>
            <p class="text-slate-500 font-medium mt-3">Real-time laboratory diagnostics monitoring and operational metrics.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('medical.create') }}" class="px-8 py-4 rounded-2xl bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/30 hover:bg-indigo-600 hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-microscope text-sm"></i> New Diagnostic Entry
            </a>
        </div>
    </div>

    <!-- HUD Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        
        <!-- CARD: Today's Volume -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[2.5rem] -mr-8 -mt-8 flex items-end justify-start p-6 text-indigo-200 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                <i class="fas fa-vial text-3xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Today's Volume</p>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['today_reports'] }}</h3>
            <p class="text-xs font-bold text-indigo-500 mt-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500 blink-animation"></span> Live Cases
            </p>
        </div>

        <!-- CARD: Pending Processing -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-[2.5rem] -mr-8 -mt-8 flex items-end justify-start p-6 text-amber-200 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500">
                <i class="fas fa-hourglass-half text-3xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pending Results</p>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $stats['pending_reports'] }}</h3>
            <p class="text-xs font-bold text-amber-500 mt-2">Awaiting Analysis</p>
        </div>

        <!-- CARD: Daily Revenue -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-[2.5rem] -mr-8 -mt-8 flex items-end justify-start p-6 text-emerald-200 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                <i class="fas fa-coins text-3xl"></i>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Daily Revenue</p>
            <h3 class="text-4xl font-black text-slate-900 tracking-tighter">${{ number_format($stats['today_revenue']) }}</h3>
            <p class="text-xs font-bold text-emerald-500 mt-2">Cash Collected</p>
        </div>

        <!-- CARD: Registry Status -->
        <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-xl shadow-slate-900/30 border border-slate-800 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="absolute top-0 right-0 w-48 h-48 bg-indigo-500/10 blur-[40px] rounded-full"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">System Health</p>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm font-bold text-slate-300">
                        <span><i class="fas fa-user-md text-slate-500 w-6"></i> Doctors</span>
                        <span class="text-white">{{ $active_doctors }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold text-slate-300">
                        <span><i class="fas fa-handshake text-slate-500 w-6"></i> Partners</span>
                        <span class="text-white">{{ $active_clients }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold text-slate-300">
                        <span><i class="fas fa-bell text-slate-500 w-6"></i> Low Stock</span>
                        <span class="{{ $low_stock > 0 ? 'text-rose-500 blink-animation' : 'text-emerald-500' }}">{{ $low_stock }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- RECENT ACTIVITY -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden min-h-[500px]">
                <div class="p-10 pb-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Recent Protocol Activity</h3>
                    <a href="{{ route('medical.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800">View Registry <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recent_reports as $report)
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-black {{ $report->test_status == 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                                {{ substr($report->patient_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-800 uppercase tracking-tight">{{ $report->patient_name }}</p>
                                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">{{ $report->ref_no }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-slate-700 uppercase">{{ $report->client->name ?? 'WALK-IN' }}</span>
                                            <span class="text-[9px] font-medium text-slate-400 uppercase">Referral</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $report->test_status == 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                            {{ $report->test_status }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <a href="{{ route('medical.edit', $report->id) }}" class="text-slate-300 hover:text-indigo-600 transition-colors"><i class="fas fa-pen"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-24 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">No recent protocols found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS / SIDEBAR -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Action 1 -->
            <a href="{{ route('inventory.index') }}" class="block bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-[2.5rem] p-8 text-white shadow-xl shadow-cyan-900/20 group hover:shadow-2xl hover:-translate-y-1 transition-all relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-[30px] -mr-10 -mt-10 group-hover:bg-white/20 transition-all"></div>
                <div class="flex justify-between items-start mb-12">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-white backdrop-blur-sm">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-black uppercase tracking-tight mb-2">Inventory</h3>
                <p class="text-cyan-100 text-xs font-medium">Manage stock levels and procurement.</p>
            </a>

            <!-- Action 2 -->
            <a href="{{ route('occupations.index') }}" class="block bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 group hover:border-indigo-200 hover:shadow-indigo-500/10 transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Master Data</h3>
                </div>
                <p class="text-slate-400 text-xs font-medium pl-14">Configure Doctors, Occupations, and Tests.</p>
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
    .blink-animation { animation: blink 2s infinite ease-in-out; }
</style>
@endsection
