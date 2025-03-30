document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
  
    // Fungsi untuk menampilkan popup dengan pesan error dan menandai input yang error
    function showPopup(message, inputElement) {
      // Tambahkan kelas error pada input jika ada
      if (inputElement) {
        inputElement.classList.add("error");
      }
  
      // Buat elemen overlay
      const overlay = document.createElement("div");
      overlay.className = "popup-overlay";
  
      // Buat elemen popup container
      const popup = document.createElement("div");
      popup.className = "popup";
  
      // Tambahkan konten ke dalam popup
      popup.innerHTML = `
        <span class="close">&times;</span>
        <p>${message}</p>
      `;
  
      // Tambahkan popup ke overlay
      overlay.appendChild(popup);
      document.body.appendChild(overlay);
  
      // Fungsi untuk menutup popup dan menghapus efek error pada input
      function closePopup() {
        document.body.removeChild(overlay);
        if (inputElement) {
          inputElement.classList.remove("error");
        }
      }
  
      // Tutup popup saat tombol close diklik
      const closeBtn = popup.querySelector(".close");
      closeBtn.addEventListener("click", closePopup);
  
      // Tutup popup saat klik di luar area popup
      overlay.addEventListener("click", function (e) {
        if (e.target === overlay) {
          closePopup();
        }
      });
    }
  
    form.addEventListener("submit", function (e) {
      // Ambil elemen input dan nilainya
      const emailInput = document.querySelector('input[name="email"]');
      const passwordInput = document.querySelector('input[name="password"]');
      const email = emailInput.value;
      const password = passwordInput.value;
  
      // Hilangkan efek error sebelumnya (jika ada)
      emailInput.classList.remove("error");
      passwordInput.classList.remove("error");
  
      // Validasi email harus mengandung '@'
      if (!email.includes("@")) {
        showPopup("Email harus mengandung karakter '@'.", emailInput);
        e.preventDefault();
        return;
      }
  
      // Validasi password minimal 8 karakter
      if (password.length < 8) {
        showPopup("Password harus memiliki panjang minimal 8 karakter.", passwordInput);
        e.preventDefault();
        return;
      }
  
      // Jika validasi lolos, form akan dikirimkan
    });
  });
  