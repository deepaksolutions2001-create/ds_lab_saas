@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-24">
    <!-- Header: Referral Network -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-200">External Network</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Parties & Agents</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Referral <span class="text-emerald-600">Registry</span></h1>
            <p class="text-slate-500 font-medium mt-3 max-w-xl">Manage commercial partners, referral agencies, and B2B clients associated with diagnostic services.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('clients.create') }}" class="px-8 py-4 rounded-2xl bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-emerald-500/30 hover:bg-emerald-700 hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-handshake text-sm"></i> Onboard New Agency
            </a>
        </div>
    </div>

    <!-- MAIN RECORD CONTAINER -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                        <th class="px-10 py-8">Agency Identity</th>
                        <th class="px-10 py-8">Contact Information</th>
                        <th class="px-10 py-8">Financial Standing</th>
                        <th class="px-10 py-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($clients as $client)
                        <tr class="group hover:bg-emerald-50/10 transition-all">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-building text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase tracking-tight text-sm">{{ $client->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-widest">UID: #AGY-{{ str_pad($client->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                        <i class="fas fa-phone text-slate-300 text-[10px]"></i> {{ $client->mobile ?? 'N/A' }}
                                    </p>
                                    <p class="text-[10px] font-medium text-slate-400 uppercase tracking-wide">
                                        {{ $client->address ? Str::limit($client->address, 30) : 'NO ADDRESS' }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Opening Balance</span>
                                    <span class="font-black text-slate-800 tracking-tighter text-sm">
                                        {{ $client->opening_balance < 0 ? '-' : '' }} ${{ number_format(abs($client->opening_balance), 2) }}
                                        <span class="text-[9px] text-slate-400 ml-1">{{ $client->opening_balance < 0 ? 'DR' : 'CR' }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="p-3 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm">
                                        <i class="fas fa-pen-nib text-xs"></i>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('TERMINATE AGENCY CONTRACT?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-3 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-10 py-40 text-center bg-slate-50/20">
                                <div class="flex flex-col items-center gap-8 opacity-20">
                                    <i class="fas fa-handshake-slash text-7xl text-slate-300"></i>
                                    <div>
                                        <p class="text-xs font-black text-slate-500 uppercase tracking-[0.4em]">Zero Active Partners</p>
                                        <p class="text-[10px] text-slate-400 font-bold mt-2">Onboard agencies to start processing referral cases.</p>
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
