@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase">Edit Staff <span class="text-blue-600">Account</span></h1>
            <p class="text-slate-500 font-medium mt-1">Modify access privileges and account details for this employee.</p>
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
                    <i class="fas fa-user-gear text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black tracking-tight mb-4 uppercase leading-tight">Account <br><span class="text-blue-400">Settings</span></h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-6 font-medium">Updating the email will change the login identifier. Role changes take effect immediately.</p>
                
                <div class="p-6 bg-white/5 border border-white/5 rounded-2xl">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2 font-black italic">Security Alert</p>
                    <p class="text-[11px] text-slate-400 leading-normal font-medium italic">Passwords are encrypted. If left blank, the system will retain the current security key.</p>
                </div>
            </div>

            <div class="pt-10 border-t border-white/10 mt-10">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Staff ID Pointer</p>
                <p class="font-bold text-sm text-blue-400 tracking-widest font-mono">#{{ str_pad($user->id, 8, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Form Area -->
        <div class="flex-1 p-10 lg:p-14">
            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Staff Full Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <input type="text" name="name" 
                                   value="{{ $user->name }}"
                                   class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Email (Login ID)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                <i class="fas fa-at"></i>
                            </div>
                            <input type="email" name="email" 
                                   value="{{ $user->email }}"
                                   class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">New Security Key <span class="text-xs text-orange-400 ml-1 italic">(Optional)</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-300 group-focus-within:text-blue-500 transition-colors">
                                    <i class="fas fa-key"></i>
                                </div>
                                <input type="password" name="password" 
                                       class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300"
                                       placeholder="••••••••">
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
                                    <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>LABORATORY STAFF</option>
                                    <option value="lab_admin" {{ $user->role === 'lab_admin' ? 'selected' : '' }}>SYSTEM ADMINISTRATOR</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10 flex items-center justify-end gap-6 border-t border-slate-50">
                    <a href="{{ route('users.index') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel Changes</a>
                    <button type="submit" class="inline-flex items-center px-10 py-4 bg-blue-600 text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 group">
                        Commit Updates
                        <i class="fas fa-check-double ml-3 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
