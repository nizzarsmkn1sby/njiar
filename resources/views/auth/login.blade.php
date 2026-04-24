<x-guest-layout>
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="text-center">
            <h2 class="text-3xl font-black tracking-tighter uppercase text-white">Welcome Back</h2>
            <p class="text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mt-2">Enter your credentials to access NIJAR POS</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Email Address</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="name@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center px-4">
                    <label for="password" class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-[10px] font-bold text-white/20 hover:text-white uppercase tracking-widest transition-colors" href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center px-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded-lg bg-white/5 border-white/10 text-white focus:ring-0 w-5 h-5 transition-all group-hover:bg-white/10" name="remember">
                    <span class="ms-3 text-[10px] font-bold text-white/40 uppercase tracking-widest group-hover:text-white/60 transition-colors">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-white text-black font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-sm shadow-xl">
                    Sign In
                </button>
            </div>

            <div class="text-center pt-4">
                <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-white hover:underline decoration-2 underline-offset-4">Create Account</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
