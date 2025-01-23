<main role="main" class="main-content text-center" style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f8f9fa;">
  <div class="container">
    <div class="welcome-message">
      <h1>Selamat Datang di <strong>SIHRD</strong></h1>
      <p>Sistem Informasi Human Resource Development</p>
    </div>
    <div class="clock" id="clock" style="font-size: 48px; font-weight: bold; color: #343a40;">
      <!-- Jam akan muncul di sini -->
    </div>
  </div>
</main>

<script>
  // Fungsi untuk memperbarui waktu
  function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
  }

  // Jalankan fungsi updateClock setiap detik
  setInterval(updateClock, 1000);

  // Panggil updateClock pertama kali agar langsung muncul
  updateClock();
</script>
