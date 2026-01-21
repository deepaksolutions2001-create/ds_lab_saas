<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statement of Account - {{ $client->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; }
            .print-break { page-break-before: always; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 p-8 md:p-12 print:p-0 print:bg-white">

    <div class="max-w-4xl mx-auto bg-white shadow-2xl shadow-slate-200 rounded-[2rem] overflow-hidden print:shadow-none print:rounded-none">
        
        <!-- Toolbar -->
        <div class="bg-slate-900 text-white p-4 flex justify-between items-center no-print">
            <a href="{{ route('reports.ledger') }}" class="text-sm font-bold text-slate-400 hover:text-white flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="px-6 py-2 bg-indigo-600 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-indigo-500 shadow-lg shadow-indigo-500/50 transition-all">
                <i class="fas fa-print mr-2"></i> Print Statement
            </button>
        </div>

        <!-- Statement Header -->
        <div class="p-10 border-b-2 border-slate-100">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight mb-1">Statement of Account</h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ session('lab_name', 'Laboratory ERP') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Statement Period</p>
                    <p class="text-lg font-bold text-slate-800">{{ $date_range['start'] }} <span class="text-slate-300 mx-2">TO</span> {{ $date_range['end'] }}</p>
                </div>
            </div>

            <div class="mt-10 p-6 bg-slate-50 rounded-2xl border border-slate-100 flex flex-col md:flex-row justify-between gap-6 print:bg-slate-50 print:border-slate-200">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Billed To</p>
                    <h3 class="text-xl font-black text-slate-900 uppercase">{{ $client->name }}</h3>
                    <p class="text-sm font-medium text-slate-500 mt-1 max-w-xs">{{ $client->address ?? 'No formatted address on file' }}</p>
                    <p class="text-xs font-bold text-slate-400 mt-2"><i class="fas fa-phone mr-2"></i> {{ $client->mobile ?? 'N/A' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Account Summary</p>
                    <div class="space-y-1">
                        <div class="flex justify-end gap-8 text-sm">
                            <span class="text-slate-500 font-medium">Opening Balance:</span>
                            <span class="font-bold font-mono">{{ number_format($opening_balance, 2) }}</span>
                        </div>
                        <div class="flex justify-end gap-8 text-sm">
                            <span class="text-slate-500 font-medium">Total Debits:</span>
                            <span class="font-bold font-mono text-indigo-600">+{{ number_format($period_debits, 2) }}</span>
                        </div>
                        <div class="flex justify-end gap-8 text-sm border-b border-slate-200 pb-1 mb-1">
                            <span class="text-slate-500 font-medium">Total Credits:</span>
                            <span class="font-bold font-mono text-emerald-600">-{{ number_format($period_credits, 2) }}</span>
                        </div>
                        <div class="flex justify-end gap-8 text-lg">
                            <span class="font-black text-slate-800">Net Balance:</span>
                            <span class="font-black font-mono {{ $closing_balance > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                {{ number_format($closing_balance, 2) }} {{ $closing_balance > 0 ? 'Dr' : 'Cr' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Table -->
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-indigo-50/50 text-indigo-900 uppercase text-[10px] font-black tracking-widest border-b border-indigo-100">
                    <th class="px-8 py-4">Date</th>
                    <th class="px-4 py-4">Ref #</th>
                    <th class="px-4 py-4 w-1/3">Description</th>
                    <th class="px-4 py-4 text-right">Debit</th>
                    <th class="px-4 py-4 text-right">Credit</th>
                    <th class="px-8 py-4 text-right">Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-600">
                <!-- Opening Row -->
                <tr class="bg-slate-50/30">
                    <td class="px-8 py-4 text-slate-400 italic" colspan="3">Opening Balance Brought Forward</td>
                    <td class="px-4 py-4 text-right font-mono text-slate-400">-</td>
                    <td class="px-4 py-4 text-right font-mono text-slate-400">-</td>
                    <td class="px-8 py-4 text-right font-bold font-mono text-slate-800">{{ number_format($opening_balance, 2) }}</td>
                </tr>

                @foreach($transactions as $entry)
                <tr class="hover:bg-slate-50 print:bg-white transition-colors">
                    <td class="px-8 py-4 whitespace-nowrap">{{ $entry->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-4 text-xs font-bold text-slate-400">
                        {{ $entry->medicalReport->ref_no ?? ($entry->medical_report_id ? 'REP-'.$entry->medical_report_id : 'MANUAL') }}
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-slate-800 font-bold text-xs uppercase">{{ Str::limit($entry->description, 50) }}</p>
                    </td>
                    <td class="px-4 py-4 text-right font-mono text-indigo-600 font-bold">
                        {{ $entry->type === 'DR' ? number_format($entry->amount, 2) : '-' }}
                    </td>
                    <td class="px-4 py-4 text-right font-mono text-emerald-600 font-bold">
                        {{ $entry->type === 'CR' ? number_format($entry->amount, 2) : '-' }}
                    </td>
                    <td class="px-8 py-4 text-right font-bold font-mono text-slate-900">
                        {{ number_format($entry->running_balance, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-900 text-white border-t border-slate-800">
                    <td class="px-8 py-4 font-black uppercase tracking-widest text-[10px]" colspan="3">Ending Totals</td>
                    <td class="px-4 py-4 text-right font-mono font-bold">{{ number_format($period_debits, 2) }}</td>
                    <td class="px-4 py-4 text-right font-mono font-bold">{{ number_format($period_credits, 2) }}</td>
                    <td class="px-8 py-4 text-right font-mono font-black text-indigo-300">{{ number_format($closing_balance, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="p-10 mt-8 border-t border-slate-100 text-center">
            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-4">Official Financial Statement</p>
            <p class="text-xs text-slate-500 max-w-2xl mx-auto leading-relaxed">
                This is a computer-generated statement of accounts. Balances are subject to realignment pending final audit. 
                Please contact the accounts department for any discrepancies within 7 days.
            </p>
        </div>

    </div>

</body>
</html>
