@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-24">
    <!-- Header: Balance Hub -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-emarald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-200">Financial Intelligence</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Live Accounts</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Balance <span class="text-emerald-600">Hub</span></h1>
            <p class="text-slate-500 font-medium mt-3">Monitoring outstanding receivables and financial health of all referral partners.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('reports.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Back to Hub
            </a>
            <div class="px-6 py-3 bg-slate-900 rounded-2xl text-white font-bold text-sm shadow-xl flex items-center gap-3">
                <span class="text-[10px] text-slate-400 uppercase tracking-widest">Total Outstanding</span>
                <span class="text-emerald-400 text-lg font-mono">${{ number_format($totalReceivable, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- BALANCE GRID -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                        <th class="px-10 py-8">Referral Agency</th>
                        <th class="px-10 py-8">Contact Info</th>
                        <th class="px-10 py-8 text-right">Net Balance</th>
                        <th class="px-10 py-8 text-right">Last Activity</th>
                        <th class="px-10 py-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($balances as $client)
                        <tr class="group hover:bg-emerald-50/10 transition-all">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                                        <div class="font-black text-xl">{{ substr($client['name'], 0, 1) }}</div>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase tracking-tight text-sm">{{ $client['name'] }}</p>
                                        <p class="text-[9px] text-emerald-500 font-bold uppercase mt-1 tracking-widest">Authorized Partner</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-2 text-slate-500 font-medium">
                                    <i class="fas fa-phone text-xs text-slate-300"></i>
                                    {{ $client['mobile'] ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="text-xl font-black font-mono tracking-tighter {{ $client['balance'] > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    {{ number_format(abs($client['balance']), 2) }} <span class="text-xs text-slate-400 ml-1">{{ $client['balance'] > 0 ? 'DR' : 'CR' }}</span>
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    {{ $client['last_activity'] ? \Carbon\Carbon::parse($client['last_activity'])->format('d M, Y') : 'No History' }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all">
                                    <form action="{{ route('reports.ledger.generate') }}" method="POST" target="_blank" class="inline">
                                        @csrf
                                        <input type="hidden" name="client_id" value="{{ $client['id'] }}">
                                        <input type="hidden" name="start_date" value="{{ now()->startOfYear()->format('Y-m-d') }}">
                                        <input type="hidden" name="end_date" value="{{ now()->format('Y-m-d') }}">
                                        <button type="submit" class="px-5 py-3 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm flex items-center gap-2">
                                            <i class="fas fa-file-invoice-dollar text-xs"></i>
                                            <span class="text-[9px] font-black uppercase tracking-widest">Statement</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-40 text-center bg-slate-50/20">
                                <div class="flex flex-col items-center gap-8 opacity-20">
                                    <i class="fas fa-scale-balanced text-7xl text-slate-300"></i>
                                    <div>
                                        <p class="text-xs font-black text-slate-500 uppercase tracking-[0.4em]">No Accounts Found</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
