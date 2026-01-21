@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase">New Staff <span class="text-blue-600">Account</span></h1>
            <p class="text-slate-500 font-medium mt-1">Register a new laboratory employee with specific system access.</p>
        </div>
        <a href="{{ route('users.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden flex flex-col md:flex-row">
        <!-- Sidebar Info -->
        <div class="md:w-1/3 bg-slate-900 p-10 text-white flex flex-col justify-between">
            <div>
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-blue-500/30">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black tracking-tight mb-4 uppercase leading-tight">Identity & <br><span class="text-blue-400">Security</span></h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 font-medium">Ensure the email address is unique and the password meets laboratory security standards.</p>
                
                <ul class="space-y-4">
                    <li class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <i class="fas fa-check-circle text-blue-500 mr-3 text-xs"></i> Lab Isolated Access
                    </li>
                    <li class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <i class="fas fa-check-circle text-blue-500 mr-3 text-xs"></i> Role-Based Permissions
                    </li>
                    <li class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-500">
                        <i class="fas fa-check-circle text-blue-500 mr-3 text-xs"></i> Audit Trail Enabled
                    </li>
                </ul>
            </div>

            <div class="pt-10 border-t border-white/10 mt-10">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Current Laboratory</p>
                <p class="font-bold text-sm text-blue-400 truncate">{{ session('lab_name') }}</p>
            </div>
        </div>

        <!-- Form Area -->
        <div class="flex-1 p-10 lg:p-14">
            <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Staff Full Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <input type="text" name="name" 
                                   class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300"
                                   placeholder="e.g. DAVID MILLER" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Email (Login ID)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                <i class="fas fa-at"></i>
                            </div>
                            <input type="email" name="email" 
                                   class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300"
                                   placeholder="staff.name@lab.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Security Key</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" name="password" 
                                       class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300"
                                       placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">System Privilege</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors pointer-events-none">
                                    <i class="fas fa-shield-halved"></i>
                                </div>
                                <select name="role" 
                                        class="w-full pl-12 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 appearance-none cursor-pointer">
                                    <option value="staff" selected>LABORATORY STAFF</option>
                                    <option value="lab_admin">SYSTEM ADMINISTRATOR</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10 flex items-center justify-end gap-6 border-t border-slate-50">
                    <a href="{{ route('users.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Discard</a>
                    <button type="submit" class="inline-flex items-center px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 group">
                        Confirm Registration
                        <i class="fas fa-check-double ml-3 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
