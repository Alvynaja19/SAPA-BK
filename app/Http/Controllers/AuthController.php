<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerificationMail;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'Akun dengan email ini belum terdaftar atau belum diaktivasi. Silakan lakukan aktivasi atau registrasi akun terlebih dahulu.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors(['email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi admin sekolah.']);
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Kata sandi yang Anda masukkan salah. Silakan periksa kembali kata sandi Anda.',
        ])->onlyInput('email');
    }

    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nisn' => ['required', 'string', 'max:20'],
            'kelas' => ['required', 'string', 'max:50'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa', // Registrasi publik khusus role siswa
            'nisn' => $validated['nisn'],
            'kelas' => $validated['kelas'],
            'no_hp' => $validated['no_hp'] ?? null,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('siswa.dashboard')->with('success', 'Selamat datang di SAPA BK! Akun siswa Anda berhasil didaftarkan.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil logout.');
    }

    public function profile(): View
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nis' => ['nullable', 'string', 'max:30'],
            'nisn' => ['nullable', 'string', 'max:20'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'captured_avatar' => ['nullable', 'string'],
            'remove_avatar' => ['nullable', 'boolean'],
        ], [
            'avatar.image' => 'Berkas foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto profil yang didukung adalah JPEG, PNG, JPG, atau WEBP.',
            'avatar.max' => 'Ukuran foto profil maksimal adalah 2MB.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->name = $validated['name'];
        if (array_key_exists('nis', $validated)) {
            $user->nis = $validated['nis'];
        }
        if (array_key_exists('nisn', $validated)) {
            $user->nisn = $validated['nisn'];
        }
        if (array_key_exists('kelas', $validated)) {
            $user->kelas = $validated['kelas'];
        }
        if (array_key_exists('no_hp', $validated)) {
            $user->no_hp = $validated['no_hp'];
        }

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Tangani unggah foto profil (berkas atau jepretan kamera)
        if ($request->hasFile('avatar')) {
            if ($user->avatar && ! str_starts_with($user->avatar, 'http://') && ! str_starts_with($user->avatar, 'https://')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        } elseif ($request->filled('captured_avatar')) {
            $capturedData = $request->input('captured_avatar');
            if (preg_match('/^data:image\/(\w+);base64,/', $capturedData, $matches)) {
                $imageType = strtolower($matches[1]);
                if (in_array($imageType, ['jpeg', 'jpg', 'png', 'webp'])) {
                    $imageData = substr($capturedData, strpos($capturedData, ',') + 1);
                    $decodedImage = base64_decode($imageData);
                    if ($decodedImage !== false) {
                        if ($user->avatar && ! str_starts_with($user->avatar, 'http://') && ! str_starts_with($user->avatar, 'https://')) {
                            Storage::disk('public')->delete($user->avatar);
                        }
                        $filename = 'avatars/'.Str::uuid().'.'.$imageType;
                        Storage::disk('public')->put($filename, $decodedImage);
                        $user->avatar = $filename;
                    }
                }
            }
        } elseif ($request->boolean('remove_avatar')) {
            if ($user->avatar && ! str_starts_with($user->avatar, 'http://') && ! str_starts_with($user->avatar, 'https://')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
        }

        $user->save();

        // Sinkronisasi data ke data induk Student jika ada
        if ($user->isSiswa()) {
            Student::where('user_id', $user->id)->update([
                'nama' => $user->name,
                'nis' => $user->nis,
                'nisn' => $user->nisn,
                'kelas' => $user->kelas,
                'no_hp' => $user->no_hp,
            ]);
        }

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman aktivasi akun siswa (Klaim Akun).
     */
    public function showAktivasiForm(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        $foundStudent = $request->session()->get('aktivasi_student');
        $otpSent = $request->session()->get('aktivasi_otp_sent', false);
        $otpEmail = $request->session()->get('aktivasi_otp_email');

        return view('auth.aktivasi', compact('foundStudent', 'otpSent', 'otpEmail'));
    }

    /**
     * Pencarian data siswa berdasarkan NIS atau NISN.
     */
    public function aktivasiLookup(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis_nisn' => 'required|string|max:30',
        ], [
            'nis_nisn.required' => 'Silakan masukkan NIS atau NISN Anda.',
        ]);

        $rawQuery = trim($validated['nis_nisn']);
        $cleanQuery = preg_replace('/\.0+$/', '', $rawQuery);
        $paddedNisn = (! empty($cleanQuery) && ctype_digit($cleanQuery) && strlen($cleanQuery) < 10)
            ? str_pad($cleanQuery, 10, '0', STR_PAD_LEFT)
            : $cleanQuery;
        $unpaddedNisn = ltrim($cleanQuery, '0');

        $searchVariants = array_values(array_unique(array_filter([
            $rawQuery,
            $cleanQuery,
            $cleanQuery.'.0',
            $paddedNisn,
            $unpaddedNisn,
        ])));

        // Cari siswa yang belum diaktivasi (user_id IS NULL)
        $student = Student::where(function ($q) use ($searchVariants) {
            $q->whereIn('nis', $searchVariants)
                ->orWhereIn('nisn', $searchVariants);
        })->whereNull('user_id')->first();

        if (! $student) {
            // Periksa apakah siswa sudah pernah diaktivasi
            $alreadyActivated = Student::where(function ($q) use ($searchVariants) {
                $q->whereIn('nis', $searchVariants)
                    ->orWhereIn('nisn', $searchVariants);
            })->whereNotNull('user_id')->exists();

            if ($alreadyActivated) {
                return back()->withErrors([
                    'nis_nisn' => 'Akun dengan NIS/NISN tersebut sudah pernah diaktivasi. Silakan langsung masuk (login) menggunakan email Anda.',
                ])->withInput();
            }

            return back()->withErrors([
                'nis_nisn' => 'Data siswa dengan NIS/NISN tersebut tidak ditemukan dalam prapendaftaran sekolah. Harap periksa kembali atau hubungi admin sekolah.',
            ])->withInput();
        }

        $request->session()->put('aktivasi_student', [
            'id' => $student->id,
            'nama' => $student->nama,
            'nis' => preg_replace('/\.0+$/', '', (string) $student->nis),
            'nisn' => $student->nisn,
            'kelas' => $student->kelas,
        ]);

        return redirect()->route('aktivasi')->with('success', "Data ditemukan atas nama {$student->nama} ({$student->kelas}). Silakan lengkapi email dan kata sandi Anda.");
    }

    /**
     * Mengirim kode OTP verifikasi ke email siswa.
     */
    public function aktivasiSendOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'student_id.required' => 'Identitas siswa tidak valid.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email tersebut sudah terdaftar pada akun lain. Silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $student = Student::where('id', $validated['student_id'])
            ->whereNull('user_id')
            ->firstOrFail();

        $otp = (string) random_int(100000, 999999);
        $cacheKey = 'sapa_aktivasi_otp_'.$student->id;

        Cache::put($cacheKey, [
            'student_id' => $student->id,
            'email' => strtolower($validated['email']),
            'password_hash' => Hash::make($validated['password']),
            'otp_hash' => Hash::make($otp),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(10)->toDateTimeString(),
        ], now()->addMinutes(10));

        try {
            Mail::to($validated['email'])->send(new AccountVerificationMail($otp, $student->nama, 'activate'));
        } catch (\Throwable $e) {
            Cache::forget($cacheKey);

            return back()->withErrors([
                'email' => 'Gagal mengirimkan email verifikasi. Pastikan alamat email benar atau coba beberapa saat lagi.',
            ])->withInput();
        }

        $request->session()->put('aktivasi_otp_sent', true);
        $request->session()->put('aktivasi_otp_email', strtolower($validated['email']));

        return redirect()->route('aktivasi')->with('success', "Kode verifikasi OTP 6 digit telah dikirim ke {$validated['email']}. Silakan periksa kotak masuk atau spam email Anda.");
    }

    /**
     * Memverifikasi kode OTP dan mengaktifkan akun siswa.
     */
    public function aktivasiVerifyOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $cacheKey = 'sapa_aktivasi_otp_'.$validated['student_id'];
        $otpData = Cache::get($cacheKey);

        if (! $otpData) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluwarsa atau belum diminta. Silakan minta kode baru.']);
        }

        if (now()->greaterThan($otpData['expires_at'])) {
            Cache::forget($cacheKey);

            return back()->withErrors(['otp' => 'Kode OTP telah kadaluwarsa. Silakan minta kode verifikasi baru.']);
        }

        if (($otpData['attempts'] ?? 0) >= 5) {
            Cache::forget($cacheKey);

            return back()->withErrors(['otp' => 'Terlalu banyak percobaan kode OTP yang salah. Silakan minta kode baru.']);
        }

        if (! Hash::check($validated['otp'], $otpData['otp_hash'])) {
            $otpData['attempts'] = ($otpData['attempts'] ?? 0) + 1;
            Cache::put($cacheKey, $otpData, now()->addMinutes(10));

            $sisa = 5 - $otpData['attempts'];

            return back()->withErrors(['otp' => "Kode OTP tidak sesuai. Sisa kesempatan mencoba: {$sisa} kali."]);
        }

        $student = Student::where('id', $validated['student_id'])
            ->whereNull('user_id')
            ->firstOrFail();

        if (User::where('email', $otpData['email'])->exists()) {
            Cache::forget($cacheKey);

            return back()->withErrors(['otp' => 'Email ini sudah terdaftar pada akun lain.']);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $student->nama,
                'email' => $otpData['email'],
                'email_verified_at' => now(),
                'password' => $otpData['password_hash'],
                'role' => 'siswa',
                'nis' => $student->nis,
                'nisn' => $student->nisn,
                'kelas' => $student->kelas,
                'no_hp' => $student->no_hp,
                'is_active' => true,
            ]);

            $student->update([
                'user_id' => $user->id,
                'status' => 'aktif',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors(['otp' => 'Terjadi kesalahan sistem saat mengaktivasi akun. Silakan coba kembali.']);
        }

        Cache::forget($cacheKey);
        $request->session()->forget(['aktivasi_student', 'aktivasi_otp_sent', 'aktivasi_otp_email']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('siswa.dashboard')->with('success', "Selamat datang di SAPA BK, {$student->nama}! Akun siswa Anda berhasil diaktivasi.");
    }

    /**
     * Mereset form aktivasi akun siswa.
     */
    public function aktivasiReset(Request $request): RedirectResponse
    {
        $request->session()->forget(['aktivasi_student', 'aktivasi_otp_sent', 'aktivasi_otp_email']);

        return redirect()->route('aktivasi');
    }

    protected function redirectBasedOnRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'guru_bk' => redirect()->intended(route('bk.dashboard')),
            default => redirect()->intended(route('siswa.dashboard')),
        };
    }
}
