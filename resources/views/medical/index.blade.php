@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
    <div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase">Medical <span class="text-blue-600">Records</span></h1>
        <p class="text-slate-500 font-medium mt-1">Laboratory Information System — Comprehensive Patient Diagnostics</p>
    </div>
    <a href="{{ route('medical.create') }}" class="inline-flex items-center px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:bg-blue-600 hover:-translate-y-1 transition-all active:scale-95 group">
        <i class="fas fa-microscope mr-3 group-hover:rotate-12 transition-transform"></i>
        New Medical Case
    </a>
</div>

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
    <!-- Filter Bar (Optional for future) -->
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Case Identity</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Patient Intelligence</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Registry Source</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Diagnostic Status</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Financials</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Ops</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($reports as $report)
                    <tr class="group hover:bg-blue-50/30 transition-all cursor-default">
                        <td class="px-10 py-7">
                            <div class="space-y-1">
                                <p class="font-mono text-blue-600 font-black text-sm tracking-tight">#{{ $report->ref_no }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $report->medical_date->format('d M, Y') }}</p>
                                <p class="text-[9px] text-slate-300 font-medium">{{ $report->medical_date->format('h:i A') }}</p>
                            </div>
                        </td>
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:text-blue-500 transition-colors shadow-inner">
                                    <i class="fas fa-user-injured text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-900 text-base tracking-tight uppercase group-hover:text-blue-700 transition-colors">{{ $report->patient_name }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $report->gender }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                        <span class="text-[10px] text-slate-400 font-medium italic"><i class="fas fa-passport text-slate-300 mr-1"></i> {{ $report->passport_no ?? 'No Passport' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-7">
                            <div class="space-y-1">
                                <p class="text-xs font-black text-slate-700 uppercase tracking-tight">{{ $report->client->name ?? 'DIRECT CASE' }}</p>
                                <p class="text-[10px] text-blue-400 font-black uppercase tracking-widest">Linked Agency</p>
                            </div>
                        </td>
                        <td class="px-10 py-7 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-{{ $report->test_status === 'completed' ? 'emerald' : 'orange' }}-50 text-{{ $report->test_status === 'completed' ? 'emerald' : 'orange' }}-600 border border-{{ $report->test_status === 'completed' ? 'emerald' : 'orange' }}-100 font-black text-[9px] uppercase tracking-widest leading-none">
                                    {{ $report->test_status }}
                                </span>
                                @if($report->fitness_status)
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-{{ $report->fitness_status === 'FIT' ? 'blue' : 'red' }}-600 text-white font-black text-[10px] uppercase tracking-widest shadow-md">
                                        <i class="fas fa-{{ $report->fitness_status === 'FIT' ? 'check-circle' : 'circle-xmark' }} mr-2"></i>
                                        {{ $report->fitness_status }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-7 text-right">
                            <div class="inline-block text-right">
                                <div class="flex items-center justify-end gap-2 text-slate-400 font-bold text-[10px] uppercase tracking-widest mb-1">
                                    Total Fee: <span class="text-slate-900 font-mono text-sm leading-none">{{ number_format($report->amount_required, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-end gap-2 text-emerald-500 font-black text-[10px] uppercase tracking-widest">
                                    Received: <span class="bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100 font-mono text-sm leading-none">{{ number_format($report->amount_received, 2) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-7 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('medical.show', $report->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                @if(!$report->is_locked)
                                    <a href="{{ route('medical.edit', $report->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-pen-to-square text-sm"></i>
                                    </a>
                                @endif
                                <a href="{{ route('medical.print', $report->id) }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-print text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-10 py-32 text-center">
                            <div class="max-w-xs mx-auto space-y-6">
                                <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mx-auto shadow-inner">
                                    <i class="fas fa-notes-medical text-slate-200 text-4xl"></i>
                                </div>
                                <div>
                                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs italic">No Registry Found</p>
                                    <p class="text-slate-300 text-[10px] mt-2 font-medium">Start by registering a new medical diagnostic case.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($reports->hasPages())
    <div class="mt-10 px-10">
        {{ $reports->links() }}
    </div>
@endif
@endsection
