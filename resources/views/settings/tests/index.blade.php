@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-[var(--text-main)]">Lab Form Builder</h1>
        <p class="text-[var(--text-muted)] text-sm">Define medical tests and the specific fields your lab needs to collect.</p>
    </div>
    <a href="{{ route('medical-tests.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i>
        <span>Define New Test</span>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($tests as $test)
        <div class="card p-6 flex flex-col h-full border-t-4 border-t-[var(--primary-500)]">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="px-2 py-0.5 bg-[var(--bg-subtle)] text-[var(--text-muted)] rounded text-[10px] font-bold uppercase tracking-widest border border-[var(--border-color)]">{{ $test->category }}</span>
                    <h3 class="text-lg font-bold text-[var(--text-main)] mt-1">{{ $test->name }}</h3>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('medical-tests.edit', $test->id) }}" class="text-[var(--text-light)] hover:text-[var(--primary-500)] transition-colors">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('medical-tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('Delete this test definition?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[var(--text-light)] hover:text-[var(--theme-danger)] transition-colors">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="flex-grow">
                <p class="text-xs text-[var(--text-muted)] font-bold uppercase tracking-tight mb-2">Defined Fields</p>
                <div class="flex flex-wrap gap-2 text-[10px]">
                    @php 
                        $fields = $test->fields_json;
                        // Handle potential double-encoding or string storage
                        if (is_string($fields)) $fields = json_decode($fields, true);
                        $fields = $fields ?? [];
                    @endphp
                    @foreach($fields as $field)
                        @if(is_array($field) && isset($field['label']))
                            <span class="px-2 py-1 bg-[var(--primary-50)] text-[var(--primary-700)] rounded-md font-bold">{{ $field['label'] }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-[var(--border-color)] flex items-center justify-between">
                <span class="text-xs font-bold {{ $test->is_active ? 'text-[var(--success-text)]' : 'text-[var(--text-light)]' }}">
                    {{ $test->is_active ? 'Active' : 'Inactive' }}
                </span>
                <span class="text-[10px] text-[var(--text-muted)] lowercase font-medium">Updated {{ $test->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    @empty
        <div class="md:col-span-2 lg:col-span-3 card p-12 text-center text-[var(--text-muted)]">
            <i class="fas fa-vial text-5xl mb-4 opacity-20"></i>
            <p class="text-lg font-bold">No tests defined yet.</p>
            <p class="text-sm">Start by creating your first laboratory test definition.</p>
        </div>
    @endforelse
</div>
@endsection
