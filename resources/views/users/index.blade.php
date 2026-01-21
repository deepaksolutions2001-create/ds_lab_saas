@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
    <div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase">Staff <span class="text-blue-600">Accounts</span></h1>
        <p class="text-slate-500 font-medium mt-1">Manage laboratory employees and administrative access control.</p>
    </div>
    <a href="{{ route('users.create') }}" class="inline-flex items-center px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:bg-blue-600 hover:-translate-y-1 transition-all active:scale-95 group">
        <i class="fas fa-plus mr-3 group-hover:rotate-90 transition-transform"></i>
        New Staff Registration
    </a>
</div>

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Staff Member</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">Access Identity</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-center">Authorization Level</th>
                    <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100 text-right">Operations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="group hover:bg-blue-50/30 transition-all cursor-default">
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-black text-xl group-hover:from-blue-500 group-hover:to-indigo-600 group-hover:text-white transition-all shadow-inner">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-900 text-lg tracking-tight uppercase">{{ $user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-7">
                            <p class="text-sm font-semibold text-slate-600 tracking-tight">{{ $user->email }}</p>
                            <p class="text-[10px] text-emerald-500 font-black uppercase mt-1 tracking-widest">Active Login Verified</p>
                        </td>
                        <td class="px-10 py-7 text-center">
                            @php
                                $badgeColor = $user->role === 'lab_admin' ? 'blue' : ($user->role === 'super_admin' ? 'indigo' : 'slate');
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-{{ $badgeColor }}-50 text-{{ $badgeColor }}-700 border border-{{ $badgeColor }}-100 font-black text-[10px] uppercase tracking-widest shadow-sm">
                                <div class="w-1.5 h-1.5 rounded-full bg-{{ $badgeColor }}-500 mr-2.5"></div>
                                {{ str_replace('_', ' ', $user->role) }}
                            </span>
                        </td>
                        <td class="px-10 py-7 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('users.edit', $user->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-pen-to-square text-sm"></i>
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm" onclick="return confirm('Archive this staff record?')">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-10 py-20 text-center">
                            <div class="max-w-xs mx-auto space-y-4">
                                <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center mx-auto">
                                    <i class="fas fa-user-slash text-slate-200 text-3xl"></i>
                                </div>
                                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs italic">No Registry Found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
