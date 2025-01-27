<?php

namespace App\Http\Controllers;

use App\Models\HRD;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
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

    public function tambahlowongan(Request $request)
    {
        $model = new HRD();
    
        $nama = $request->input('nama_lowongan');
        $syarat = $request->input('syarat');

        $data = [
            'nama_lowongan' => $nama,
            'syarat' => $syarat
        ];
    
        // Simpan data ke database
        $model->tambah('lowongan', $data);
        return redirect('lowongan')->with('success', 'Lowongan berhasil ditambah');
    }

    public function editlowongan(Request $request, $id_lowongan)
    {
        $model = new HRD();
    
        $nama = $request->input('nama_lowongan');
        $syarat = $request->input('syarat');

        $data = [
            'nama_lowongan' => $nama,
            'syarat' => $syarat
        ];
    
        // Simpan data ke database
        $model->edit('lowongan',['id_lowongan' => $id_lowongan] ,$data);
        return redirect('lowongan')->with('success', 'Lowongan berhasil diedit');
    }

    public function hapuslowongan(Request $request, $id_lowongan)
    {
        $model = new HRD();
    $model->hapus('lowongan', ['id_lowongan' => $id_lowongan]);
    return redirect()->route('lowongan')->with('success', 'Lowongan dihapus');
    }

    public function addlamaran(Request $request)
    {
        $id_user = session()->get('id_user');
        $lowongan_id = $request->input('lowongan_id');
        $nama = $request->input('nama');
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
            'nama_lengkap' => $nama,
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
    
    
    public function lamaran()
    {
        $model = new HRD();

        $id_level = session()->get('id_level');
        if (!$id_level) {
            return redirect()->route('login');
        }

        $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
        $data['pelamars'] = $model->join2('pelamar','lowongan','pelamar.id_lowongan','lowongan.id_lowongan');
        echo view('header', $data);
        echo view('menu', $data);
        echo view('lamaran', $data);
        echo view('footer');
    }


    public function acceptPelamar($id_pelamar)
    {
        // Ambil data pelamar berdasarkan ID dan lakukan join dengan tabel lowongan dan user
        $pelamar = DB::table('pelamar')
            ->join('lowongan', 'pelamar.id_lowongan', '=', 'lowongan.id_lowongan')
            ->join('user', 'pelamar.id_user', '=', 'user.id_user') // Join with user to get email
            ->where('pelamar.id_pelamar', $id_pelamar)
            ->select('pelamar.*', 'lowongan.nama_lowongan', 'user.email') // Include email in the selection
            ->first();
    
        if (!$pelamar) {
            return redirect()->route('lamaran')->with('error', 'Pelamar tidak ditemukan');
        }
        
        // Pastikan pelamar memiliki ID User
        if (!$pelamar->id_user) {
            return redirect()->route('lamaran')->with('error', 'Pelamar tidak memiliki ID User terkait');
        }
    
        // Update status pelamar menjadi "Diterima"
        DB::table('pelamar')->where('id_pelamar', $id_pelamar)->update(['status' => 'Diterima']);
        
        // Update id_level pada tabel user menjadi 2
        DB::table('user')->where('id_user', $pelamar->id_user)->update(['id_level' => 2]);
    
        // Tambahkan data ke tabel karyawan
        DB::table('karyawan')->insert([
            'id_user' => $pelamar->id_user,          // Ambil id_user dari pelamar
            'divisi' => $pelamar->nama_lowongan,    // Ambil nama_lowongan dari hasil join
        ]);
    
        // Kirim email kepada pelamar
        $this->sendEmail($pelamar->email, 'Penerimaan Pelamar', 'Selamat! Anda telah diterima untuk posisi: ' . $pelamar->nama_lowongan);
        
        // Redirect kembali ke halaman lamaran dengan pesan sukses
        return redirect()->route('lamaran')->with('success', 'Pelamar berhasil diterima, id_level diperbarui, dan data karyawan ditambahkan');
    }
    

    public function declinePelamar($id_pelamar)
    {
        $model = new HRD();
        $pelamar = DB::table('pelamar')
            ->join('user', 'pelamar.id_user', '=', 'user.id_user')
            ->join('lowongan', 'pelamar.id_lowongan', '=', 'lowongan.id_lowongan') // Join with lowongan to get nama_lowongan
            ->where('pelamar.id_pelamar', $id_pelamar)
            ->select('pelamar.*', 'user.email', 'lowongan.nama_lowongan') // Include email and nama_lowongan in the selection
            ->first();
    
        if (!$pelamar) {
            return redirect()->route('lamaran')->with('error', 'Pelamar tidak ditemukan');
        }
    
        // Mark pelamar as declined
        $model->edit('pelamar', ['id_pelamar' => $id_pelamar], ['status' => 'Ditolak']);
    
        // Kirim email kepada pelamar
        $this->sendEmail($pelamar->email, 'Penolakan Pelamar', 'Maaf, Anda telah ditolak untuk posisi: ' . $pelamar->nama_lowongan);
        
        return redirect()->route('lamaran')->with('success', 'Pelamar ditolak');
    }

    private function sendEmail($to, $subject, $body)
{
    $mail = new PHPMailer();

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'vandarren06@gmail.com'; // Your email
        $mail->Password = 'jlhd ebql lmot kfaw'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('vandarren06@gmail.com', 'PT. CBPQLNJIAO');
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

public function karyawan()
{
    $model = new HRD(); // Model yang digunakan
    $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
    $data['karyawan'] = $model->join('karyawan', 'user', 'karyawan.id_user', 'user.id_user');
    echo view('header', $data);
    echo view('menu', $data);
    echo view('karyawan', $data);
    echo view('footer');
}



public function editKaryawan(Request $request, $id_karyawan)
    {
        $model = new HRD();

        // Ambil data dari request
        $username = $request->input('username');
        $gaji = $request->input('gaji');
        $divisi = $request->input('divisi');

        // Siapkan data untuk diupdate
        $data = [
            'gaji' => $gaji,
            'divisi' => $divisi
        ];

        // Panggil fungsi edit dari model
        $model->edit('karyawan', ['id_karyawan' => $id_karyawan], $data);
        
        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil diedit');
    }

    public function hapusKaryawan(Request $request, $id_karyawan)
    {
        $model = new HRD();
        $model->hapus('karyawan', ['id_karyawan' => $id_karyawan]);
        
        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil dihapus');
    }

public function setting()
{
    $id_level = session()->get('id_level');	

    // Cek apakah pengguna sudah login
    if (!$id_level) {
        return redirect()->route('login'); // Redirect ke halaman login
    } elseif ($id_level != 1) {
        return redirect()->route('error404'); // Redirect ke halaman error
    } else {
        // Ambil data dari database
        $model = new HRD();
        $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);

        // Log aktivitas pengguna
        $id_user = session()->get('id_user');
     

        $data['id_level'] = $id_level; 

        echo view('header', $data);
        echo view('menu', $data);
        echo view('setting', $data);
        echo view('footer');
    }
}

public function editsetting(Request $request)
    {
        // Initialize the model
        $model = new HRD();
        $namawebsite = $request->input('namaweb');
    
        $data = ['namawebsite' => $namawebsite];
    
        // Process upload for tab icon
        if ($request->hasFile('tab') && $request->file('tab')->isValid()) {
            $tab = $request->file('tab');
            $tabName = time() . '_' . $tab->getClientOriginalName(); // Save file with unique name
            $tab->move(public_path('img'), $tabName);
            $data['icontab'] = $tabName; // Save file name to database
        }
    
        // Process upload for menu icon
        if ($request->hasFile('menu') && $request->file('menu')->isValid()) {
            $menu = $request->file('menu');
            $menuName = time() . '_' . $menu->getClientOriginalName();
            $menu->move(public_path('img'), $menuName);
            $data['iconmenu'] = $menuName;
        }
    
        // Process upload for login icon
        if ($request->hasFile('login') && $request->file('login')->isValid()) {
            $login = $request->file('login');
            $loginName = time() . '_' . $login->getClientOriginalName();
            $login->move(public_path('img'), $loginName);
            $data['iconlogin'] = $loginName;
        }
    
        $where = ['id_setting' => 1];
        $model->edit('setting',$where, $data ); 
    
       
        return redirect()->route('setting')->with('success', 'Settings updated successfully!'); // Adjust as necessary
    }

    public function user()
{
    $model = new HRD(); // Model yang digunakan
    $data['darren2'] = $model->getWhere('setting', ['id_setting' => 1]);
    $data['users'] = $model->join('user', 'level', 'user.id_level', 'level.id_level');
    echo view('header', $data);
    echo view('menu', $data);
    echo view('user', $data);
    echo view('footer');
}



}
