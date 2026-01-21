<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Lab ERP Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
        body { 
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #1e3a8a, #0f172a);
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .input-dark {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        .input-dark:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #3b82f6;
            ring: 1px #3b82f6;
        }
        .btn-premium {
            background: linear-gradient(to right, #2563eb, #3b82f6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-premium:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            transform: translateY(-1px);
        }
        .interface-tab {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .interface-tab.active {
            background: #3b82f6;
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full glass rounded-[2.5rem] shadow-2xl overflow-hidden p-10">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600/20 rounded-3xl mb-6 border border-blue-500/30">
                <i class="fas fa-microscope text-blue-400 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">System Login</h1>
            <p class="text-gray-400 mt-2">Access your laboratory management portal</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 p-4 mb-6 rounded-2xl">
                <div class="flex">
                    <i class="fas fa-circle-exclamation text-red-400 mt-1"></i>
                    <div class="ml-3">
                        @foreach($errors->all() as $error)
                            <p class="text-sm text-red-300">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Interface Selection -->
            <div class="bg-white/5 p-1.5 rounded-2xl flex">
                <label class="flex-1 text-center py-2.5 rounded-xl text-sm font-semibold text-gray-400 interface-tab active" data-interface="admin">
                    <input type="radio" name="interface" value="admin" class="hidden" checked>
                    Admin
                </label>
                <label class="flex-1 text-center py-2.5 rounded-xl text-sm font-semibold text-gray-400 interface-tab" data-interface="staff">
                    <input type="radio" name="interface" value="staff" class="hidden">
                    Staff
                </label>
                <label class="flex-1 text-center py-2.5 rounded-xl text-sm font-semibold text-gray-400 interface-tab" data-interface="client">
                    <input type="radio" name="interface" value="client" class="hidden">
                    Client
                </label>
            </div>

            <!-- Lab Code (Only for Staff/Client) -->
            <div id="labCodeWrapper" class="hidden">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Lab Code</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                        <i class="fas fa-hashtag"></i>
                    </span>
                    <input type="text" name="lab_code" id="lab_code"
                           class="block w-full pl-11 pr-4 py-3.5 input-dark rounded-2xl focus:outline-none placeholder-gray-600 transition duration-200" 
                           placeholder="Enter Lab Code">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Email / Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                        <i class="far fa-user text-lg"></i>
                    </span>
                    <input type="text" name="email" value="{{ old('email') }}" required
                           class="block w-full pl-11 pr-4 py-3.5 input-dark rounded-2xl focus:outline-none placeholder-gray-600 transition duration-200" 
                           placeholder="yourname@lab.com">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                        <i class="fas fa-shield-alt text-lg"></i>
                    </span>
                    <input type="password" name="password" required
                           class="block w-full pl-11 pr-4 py-3.5 input-dark rounded-2xl focus:outline-none placeholder-gray-600 transition duration-200" 
                           placeholder="••••••••">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full flex justify-center py-4 px-4 rounded-2xl shadow-xl text-base font-bold text-white btn-premium transform active:scale-[0.98]">
                    Secure Sign In
                </button>
            </div>
        </form>

        <div class="mt-10 pt-8 border-t border-white/5 text-center">
            <p class="text-[0.65rem] text-gray-600 uppercase font-black tracking-[0.2em]">&copy; 2026 Laboratory ERP Pro • Advanced Analytics System</p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.interface-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Update active state
                document.querySelectorAll('.interface-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Toggle Lab Code visibility
                const interfaceVal = this.getAttribute('data-interface');
                const labCodeWrapper = document.getElementById('labCodeWrapper');
                const labCodeInput = document.getElementById('lab_code');

                if (interfaceVal === 'admin') {
                    labCodeWrapper.classList.add('hidden');
                    labCodeInput.removeAttribute('required');
                } else {
                    labCodeWrapper.classList.remove('hidden');
                    labCodeInput.setAttribute('required', 'required');
                }
            });
        });
    </script>
</body>
</html>
