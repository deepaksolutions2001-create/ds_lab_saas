@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto pb-24">
    <!-- Header: Registration Protocol -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-rose-200">Clinical Personnel</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ isset($doctor) ? 'Protocol Modification' : 'New Registration' }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">Physician <span class="text-rose-600">Definition</span></h1>
            <p class="text-slate-500 font-medium mt-3">Establish medical licensing, specialization, and authorized diagnostic signatures.</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('doctors.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all">
                Cancel
            </a>
        </div>
    </div>

    <!-- MAIN FORM CONTAINER -->
    <form action="{{ isset($doctor) ? route('doctors.update', $doctor->id) : route('doctors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($doctor)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- LEFT: Identity & Fee --}}
            <div class="lg:col-span-8 space-y-10">
                <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-12 lg:p-16 space-y-12">
                    
                    {{-- Physician Name --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Medical Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-8 flex items-center text-slate-300 group-focus-within:text-rose-500 transition-all pointer-events-none">
                                <i class="fas fa-user-md text-xl"></i>
                            </div>
                            <input type="text" name="name" value="{{ $doctor->name ?? old('name') }}"
                                   class="w-full pl-18 pr-8 py-7 bg-slate-50 border border-slate-100 rounded-[2.5rem] focus:ring-8 focus:ring-rose-500/5 focus:border-rose-500 outline-none transition-all font-black text-slate-800 text-2xl placeholder-slate-300 uppercase tracking-tight"
                                   placeholder="DR. ENTER NAME" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Field: Specialization --}}
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Medical Specialization</label>
                            <input type="text" name="category" value="{{ $doctor->category ?? old('category') }}"
                                   class="w-full px-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-rose-500 outline-none transition-all font-bold text-slate-700 placeholder-slate-300 uppercase"
                                   placeholder="E.G. PATHOLOGIST">
                        </div>

                        {{-- Field: Fee --}}
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Registration/Service Fee</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center text-slate-300 pointer-events-none">
                                    <span class="font-black text-sm">$</span>
                                </div>
                                <input type="number" step="0.01" name="doctor_fee" value="{{ $doctor->doctor_fee ?? old('doctor_fee', 0) }}"
                                       class="w-full pl-12 pr-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl focus:border-rose-500 outline-none transition-all font-black text-slate-800"
                                       placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    {{-- Field: Status Toggle --}}
                    <div class="p-8 rounded-[2.5rem] bg-slate-50/50 border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-400">
                                <i class="fas fa-id-card-clip text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest leading-none mb-1">Active Status</p>
                                <p class="text-xs text-slate-400 font-medium">Allow this physician to sign reports.</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ (isset($doctor) && $doctor->is_active) || !isset($doctor) ? 'checked' : '' }}>
                                <div class="w-16 h-8 bg-slate-200 rounded-full peer peer-checked:bg-rose-600 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-7 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Signature & Actions --}}
            <div class="lg:col-span-4 space-y-10">
                <div class="bg-slate-900 rounded-[3.5rem] shadow-2xl shadow-slate-900/40 p-10 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/10 blur-[60px] rounded-full"></div>
                    
                    <h4 class="text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] mb-10 pb-4 border-b border-white/5">Authorized Signature</h4>
                    
                    <div class="space-y-8 flex flex-col items-center">
                        <div class="w-full aspect-square bg-white/5 border-4 border-dashed border-white/10 rounded-[2.5rem] flex items-center justify-center relative group overflow-hidden">
                            @if(isset($doctor) && $doctor->signature)
                                <img id="sig_preview" src="{{ asset('storage/'.$doctor->signature) }}" class="w-full h-full object-contain p-6 transform group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div id="sig_placeholder" class="text-center space-y-4">
                                    <i class="fas fa-pen-nib text-4xl text-white/20"></i>
                                    <p class="text-[10px] font-black text-white/30 uppercase tracking-widest">No Signature</p>
                                </div>
                                <img id="sig_preview" class="absolute inset-0 w-full h-full object-contain p-6 hidden">
                            @endif
                            <input type="file" name="signature" id="sig_input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                        </div>
                        
                        <p class="text-[9px] text-white/40 font-bold uppercase text-center leading-loose">Upload a transparent PNG/JPG of the clinical signature.</p>
                        
                        <button type="submit" class="w-full py-6 bg-rose-600 text-white rounded-[2rem] font-black text-sm uppercase tracking-widest shadow-xl shadow-rose-600/40 hover:bg-rose-500 hover:-translate-y-2 transition-all active:scale-95">
                            {{ isset($doctor) ? 'UPDATE REGISTRY' : 'FINALIZE PROTOCOL' }}
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 flex items-center gap-5">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400">
                        <i class="fas fa-shield-halved text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest leading-none mb-1">Compliance Check</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Authorized professionals only.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const sigInput = document.getElementById('sig_input');
    const sigPreview = document.getElementById('sig_preview');
    const sigPlaceholder = document.getElementById('sig_placeholder');

    sigInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                sigPreview.src = e.target.result;
                sigPreview.classList.remove('hidden');
                if(sigPlaceholder) sigPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

<style>
    .pl-18 { padding-left: 4.5rem; }
</style>
@endsection
