<x-guest-layout>
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="text-center">
            <h2 class="text-2xl font-black tracking-tighter uppercase text-white">Reset Password</h2>
            <p class="text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mt-2 leading-relaxed px-6">
                {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Email Address</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="name@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-white text-black font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs shadow-xl">
                    {{ __('Send Reset Link') }}
                </button>
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('login') }}" class="text-[10px] font-bold text-white/20 uppercase tracking-widest hover:text-white transition-colors">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
