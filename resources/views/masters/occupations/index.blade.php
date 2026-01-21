@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-24">
    <!-- Header: Registry Hub -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-blue-200">Master Data Control</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Global Protocol</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Occupation <span class="text-blue-600">Registry</span></h1>
            <p class="text-slate-500 font-medium mt-3 max-w-xl">Manage standardized patient occupations used across clinical documentation and analytics.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('occupations.create') }}" class="px-8 py-4 rounded-2xl bg-blue-600 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-blue-500/30 hover:bg-blue-700 hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-plus text-sm"></i> Add New Protocol
            </a>
        </div>
    </div>

    <!-- MAIN RECORD CONTAINER -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Clinical UID</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Occupation Designation</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Registry Status</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Protocol Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($occupations as $occupation)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="px-10 py-8">
                                <span class="text-xs font-black text-slate-300 uppercase italic">#{{ str_pad($occupation->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <p class="font-black text-slate-800 uppercase tracking-tight">{{ $occupation->name }}</p>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $occupation->is_active ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-50 text-slate-400 border-slate-200' }}">
                                    {{ $occupation->is_active ? 'PROTOCOL ACTIVE' : 'LOCKED' }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 translate-x-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                                    <a href="{{ route('occupations.edit', $occupation->id) }}" class="p-3 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                                        <i class="fas fa-pen-nib text-xs"></i>
                                    </a>
                                    <form action="{{ route('occupations.destroy', $occupation->id) }}" method="POST" class="inline" onsubmit="return confirm('DECOMMISSION RECORD?')">
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
                            <td colspan="4" class="px-10 py-32 text-center bg-slate-50/30">
                                <div class="flex flex-col items-center gap-6 opacity-30">
                                    <i class="fas fa-folder-open text-6xl text-slate-300"></i>
                                    <div>
                                        <p class="text-xs font-black text-slate-500 uppercase tracking-[0.3em]">Zero Occupations Mapped</p>
                                        <p class="text-[10px] text-slate-400 font-bold mt-2">No clinical occupation designations have been protocolled.</p>
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
