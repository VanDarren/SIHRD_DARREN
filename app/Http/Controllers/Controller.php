<?php

namespace App\Http\Controllers;

use App\Models\HRD;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard()
    {
        $model = new HRD();

        $id_level = session()->get('id_level');
        if (!$id_level) {
            return redirect()->route('login');
        }
        $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
 
        echo view('header', $data);
        echo view('menu', $data);
        echo view('dashboard', $data);
        echo view('footer');
    }

    public function login()
    {
        $model = new HRD();
        $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
        echo view('header', $data);
        echo view('login', $data);
        echo view('footer');
    }

    public function aksi_login(Request $request)
    {
        // Mengakses input dari request
        $name = $request->input('username');
        $pw = $request->input('password');
        $captchaResponse = $request->input('g-recaptcha-response');
        $backupCaptcha = $request->input('backup_captcha');
        
        // Secret key untuk Google reCAPTCHA
        $secretKey = '6LdFhCAqAAAAAM1ktawzN-e2ebDnMnUQgne7cy53'; 
        $recaptchaSuccess = false;
        
        // Membuat instance model
        $model = new HRD(); 
        
        // Cek koneksi internet dari sisi server
        if ($this->isInternetAvailable()) {
            // Server terhubung ke internet, gunakan Google reCAPTCHA
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
            $responseKeys = json_decode($response, true);
            $recaptchaSuccess = $responseKeys["success"];
        }
        
        // Jika reCAPTCHA Google berhasil diverifikasi
        if ($recaptchaSuccess) {
            // Dapatkan pengguna berdasarkan username
            $user = $model->getWhere('user', ['username' => $name]);
            
            if ($user && $user->password === $pw) { // Verifikasi password tanpa hash
                // Set session
                session()->put('username', $user->username);
                session()->put('id_user', $user->id_user);
                session()->put('id_level', $user->id_level);
    
                return redirect()->to('dashboard');
            } else {
                return redirect()->to('login')->with('error', 'Invalid username or password.');
            }
        } else {
            $storedCaptcha = session()->get('captcha_code'); 
            
            if ($storedCaptcha !== null) {
                // Verifikasi backup CAPTCHA (offline)
                if ($storedCaptcha === $backupCaptcha) {
                    // CAPTCHA valid, lanjutkan login
                    $user = $model->getWhere('user', ['username' => $name]);
    
                    if ($user && $user->password === $pw) { // Verifikasi password tanpa hash
                        // Set session
                        session()->put('username', $user->username);
                        session()->put('id_user', $user->id_user);
                        session()->put('id_level', $user->id_level);
    
                        return redirect()->to('dashboard');
                    } else {
                        return redirect()->to('login')->with('error', 'Invalid username or password.');
                    }
                } else {
                    // CAPTCHA tidak valid
                    return redirect()->to('login')->with('error', 'Invalid CAPTCHA.');
                }
            } else {
                return redirect()->to('login')->with('error', 'CAPTCHA session is not set.');
            }
        }
    }
    
    private function isInternetAvailable()
    {

        $connected = @fsockopen("www.google.com", 80); 
        if ($connected){
            fclose($connected);
            return true;
        }
        return false;
    }
    

    public function generateCaptcha()
    {
        $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        session()->put('captcha_code', $code);
    
        $image = imagecreatetruecolor(120, 40);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
    
        imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);
        imagestring($image, 5, 10, 10, $code, $textColor);
    
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();
    
        imagedestroy($image);
    
        return response($imageData)
                    ->header('Content-Type', 'image/png'); 
    }

    public function logout()
    {
        $model = new HRD();
        $id_user = session()->get('id_user');
    

        session()->flush();
        return redirect()->route('login'); 
    }

    public function register()
    {
        $model = new HRD();
        $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
        echo view('header', $data);
        echo view('register', $data);
        echo view('footer');
    }

    public function aksiregister(Request $request)
    {
        $model = new HRD();
    
        $username = $request->input('username');
        $email = $request->input('email');
        $nohp = $request->input('nohp');
        $password = $request->input('password');
        $confirmPassword = $request->input('confirm_password');
    
        // Validasi konfirmasi password
        if ($password !== $confirmPassword) {
            return redirect()->back()->withErrors(['confirm_password' => 'Password dan konfirmasi password harus sama']);
        }
    
        $data = [
            'username' => $username,
            'email' => $email,
            'nohp' => $nohp,
            'password' => $password,
            'id_level' => 3 // Default level untuk user baru
        ];
    
        // Simpan data ke database
        $model->tambah('user', $data);
        return redirect('login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function lowongan()
    {
        $model = new HRD();

        $id_level = session()->get('id_level');
        if (!$id_level) {
            return redirect()->route('login');
        }

        $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
        $data['lowongans'] = $model->tampil('lowongan');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('lowongan', $data);
        echo view('footer');
    }

    public function addlowongan(Request $request)
    {
        $id_user = session()->get('id_user');
        $lowongan_id = $request->input('lowongan_id');
        $tgl_lahir = $request->input('tanggal_lahir');
        $alamat = $request->input('alamat');
    
        // Simpan file CV ke folder public/lamaran/
        $cv = $request->file('cv');
        $cvName = time() . '_' . $cv->getClientOriginalName();
        $cvPath = public_path('lamaran');
        $cv->move($cvPath, $cvName);
    
        // Simpan file Surat Lamaran ke folder public/lamaran/
        $surat = $request->file('surat');
        $suratName = time() . '_' . $surat->getClientOriginalName();
        $surat->move($cvPath, $suratName);
    
        $data = [
            'id_user' => $id_user,
            'id_lowongan' => $lowongan_id,
            'tgl_lahir' => $tgl_lahir,
            'alamat' => $alamat,
            'cv' => $cvName,
            'surat' =>  $suratName,
            'status' => 'Pending',
        ];
    
        $model = new HRD();
        $model->tambah('pelamar', $data);
        session()->flash('success', 'Lamaran berhasil ditambahkan!');
        return redirect('lowongan')->with('success', 'Lamaran berhasil dikirim');
    }
    
    
}
