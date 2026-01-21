@extends('layouts.app')

@section('content')
<div class="mb-8">
    <a href="{{ route('medical-tests.index') }}" class="text-[var(--text-muted)] hover:text-[var(--primary-500)] inline-flex items-center gap-2 mb-4 transition-colors">
        <i class="fas fa-arrow-left"></i>
        <span class="font-bold text-sm uppercase tracking-widest">Back to Tests</span>
    </a>
    <h1 class="text-2xl font-bold text-[var(--text-main)]">Define Laboratory Test</h1>
    <p class="text-[var(--text-muted)] text-sm">Create a custom test definition and build its input form.</p>
</div>

<form action="{{ route('medical-tests.store') }}" method="POST" id="testForm">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Basic Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card p-6">
                <h3 class="font-bold text-[var(--text-main)] mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle text-[var(--primary-500)]"></i>
                    Test Information
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-[var(--text-main)] mb-2 uppercase tracking-tight">Test Name</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-surface)] focus:ring-2 focus:ring-[var(--primary-500)] focus:border-transparent outline-none transition-all"
                               placeholder="e.g. Biochemistry / HIV Test">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[var(--text-main)] mb-2 uppercase tracking-tight">Category</label>
                        <input type="text" name="category" required
                               class="w-full px-4 py-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-surface)] focus:ring-2 focus:ring-[var(--primary-500)] focus:border-transparent outline-none transition-all"
                               placeholder="e.g. Blood, X-Ray, etc.">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--primary-500)]"></div>
                            <span class="ml-3 text-sm font-bold text-[var(--text-main)]">Active Status</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card p-6 bg-[var(--primary-50)] border-none shadow-none">
                <h4 class="font-bold text-[var(--primary-700)] text-sm mb-2">How it works?</h4>
                <p class="text-xs text-[var(--primary-600)] leading-relaxed">
                    Define the fields you want to show when adding a medical report. For each field, specify the label and unit (e.g. Unit: mg/dL).
                </p>
                <div class="mt-4 pt-4 border-t border-[var(--primary-100)]">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <i class="fas fa-save"></i>
                        <span>Save Test Definition</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Field Builder -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-[var(--text-main)] flex items-center gap-2">
                        <i class="fas fa-layer-group text-[var(--primary-500)]"></i>
                        Form Field Designer
                    </h3>
                    <button type="button" id="addFieldBtn" class="text-xs font-bold text-[var(--primary-500)] hover:text-[var(--primary-700)] bg-[var(--primary-50)] px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus"></i> Add New Field
                    </button>
                </div>

                <div id="fieldsContainer" class="space-y-4">
                    <!-- Fields will be added here via JS -->
                </div>

                <input type="hidden" name="fields_json" id="fields_json_input">
            </div>
        </div>
    </div>
</form>

<!-- Field Template -->
<template id="fieldTemplate">
    <div class="field-row bg-[var(--bg-subtle)] p-4 rounded-2xl border border-[var(--border-color)] flex flex-wrap md:flex-nowrap gap-4 items-end animate-in fade-in slide-in-from-top-2 duration-300">
        <div class="flex-grow">
            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-widest">Field Label</label>
            <input type="text" class="field-label w-full px-3 py-2 rounded-lg border border-[var(--border-color)] bg-[var(--bg-surface)] focus:ring-1 focus:ring-[var(--primary-500)] outline-none text-sm" placeholder="e.g. Sugar Level">
        </div>
        <div class="w-full md:w-32">
            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-widest">Type</label>
            <select class="field-type w-full px-3 py-2 rounded-lg border border-[var(--border-color)] bg-[var(--bg-surface)] focus:ring-1 focus:ring-[var(--primary-500)] outline-none text-sm">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="textarea">Long Text</option>
            </select>
        </div>
        <div class="w-full md:w-32">
            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-widest">Unit</label>
            <input type="text" class="field-unit w-full px-3 py-2 rounded-lg border border-[var(--border-color)] bg-[var(--bg-surface)] focus:ring-1 focus:ring-[var(--primary-500)] outline-none text-sm" placeholder="e.g. mg/dL">
        </div>
        <div class="pb-1">
            <button type="button" class="removeFieldBtn p-2 text-[var(--text-light)] hover:text-[var(--theme-danger)] transition-all">
                <i class="fas fa-times-circle text-lg"></i>
            </button>
        </div>
    </div>
</template>

<script>
    const fieldsContainer = document.getElementById('fieldsContainer');
    const addFieldBtn = document.getElementById('addFieldBtn');
    const template = document.getElementById('fieldTemplate');
    const fieldsJsonInput = document.getElementById('fields_json_input');
    const testForm = document.getElementById('testForm');

    function addFieldRow() {
        const clone = template.content.cloneNode(true);
        const row = clone.querySelector('.field-row');
        
        row.querySelector('.removeFieldBtn').addEventListener('click', function() {
            row.remove();
        });

        fieldsContainer.appendChild(clone);
    }

    // Add initial field
    addFieldRow();

    addFieldBtn.addEventListener('click', addFieldRow);

    testForm.addEventListener('submit', function(e) {
        const rows = fieldsContainer.querySelectorAll('.field-row');
        const fields = [];

        rows.forEach(row => {
            const label = row.querySelector('.field-label').value;
            const type = row.querySelector('.field-type').value;
            const unit = row.querySelector('.field-unit').value;

            if (label) {
                // Generate a safe name for JSON key
                const name = label.toLowerCase().replace(/[^a-z0-9]/g, '_');
                fields.push({ label, name, type, unit });
            }
        });

        fieldsJsonInput.value = JSON.stringify(fields);
    });
</script>
@endsection
