<x-guest-layout>
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="text-center">
            <h2 class="text-3xl font-black tracking-tighter uppercase text-white">Join Nijar POS</h2>
            <p class="text-[10px] font-bold text-white/40 uppercase tracking-[0.2em] mt-2">Create your account to start managing</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Full Name</label>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="John Doe">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Email Address</label>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="name@example.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-[10px] font-bold text-white/40 uppercase tracking-widest ml-4">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full bg-white/5 border border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-white/20 focus:ring-0 transition-all placeholder:text-white/10"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-[10px] font-bold uppercase" />
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-white text-black font-black rounded-2xl hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-sm shadow-xl">
                    Register Now
                </button>
            </div>

            <div class="text-center pt-4">
                <p class="text-[10px] font-bold text-white/20 uppercase tracking-widest">
                    Already registered? 
                    <a href="{{ route('login') }}" class="text-white hover:underline decoration-2 underline-offset-4">Sign In</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
