@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-24">
    <!-- Header: Medical Staff Registry -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-rose-200">Clinical Personnel</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Medical Board</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Physician <span class="text-rose-600">Registry</span></h1>
            <p class="text-slate-500 font-medium mt-3 max-w-xl">Manage certified medical professionals and authorized signatories for laboratory diagnostics.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('doctors.create') }}" class="px-8 py-4 rounded-2xl bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-slate-900/30 hover:bg-rose-600 hover:-translate-y-1 transition-all flex items-center gap-3">
                <i class="fas fa-user-md text-sm"></i> Register New Physician
            </a>
        </div>
    </div>

    <!-- MAIN RECORD CONTAINER -->
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                        <th class="px-10 py-8">Physician Identity</th>
                        <th class="px-10 py-8">Specialization</th>
                        <th class="px-10 py-8">Registration Fee</th>
                        <th class="px-10 py-8">Protocol Status</th>
                        <th class="px-10 py-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($doctors as $doctor)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-rose-600 group-hover:text-white transition-all shadow-sm">
                                        @if($doctor->signature)
                                            <img src="{{ asset('storage/'.$doctor->signature) }}" class="w-full h-full object-contain p-1 rounded-xl">
                                        @else
                                            <i class="fas fa-user-doctor text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase tracking-tight text-sm">{{ $doctor->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-widest">Digital ID: #DOC-{{ $doctor->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-1.5 bg-slate-50 text-slate-500 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-100">
                                    {{ $doctor->category ?? 'GENERAL CLINICIAN' }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <p class="font-black text-slate-700 tracking-tighter text-sm">${{ number_format($doctor->doctor_fee, 2) }}</p>
                            </td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest {{ $doctor->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                    {{ $doctor->is_active ? 'ACTIVE PROTOCOL' : 'REVOKED' }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all">
                                    <a href="{{ route('doctors.edit', $doctor->id) }}" class="p-3 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                                        <i class="fas fa-pen-nib text-xs"></i>
                                    </a>
                                    <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="inline" onsubmit="return confirm('REVOKE PHYSICIAN REGISTRY?')">
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
                            <td colspan="5" class="px-10 py-40 text-center bg-slate-50/20">
                                <div class="flex flex-col items-center gap-8 opacity-20">
                                    <i class="fas fa-microscope text-7xl text-slate-300"></i>
                                    <div>
                                        <p class="text-xs font-black text-slate-500 uppercase tracking-[0.4em]">Zero Medical Personnel Data</p>
                                        <p class="text-[10px] text-slate-400 font-bold mt-2">Initialize physician records to enable diagnostic signatures.</p>
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
