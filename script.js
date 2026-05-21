
// Animasi naik turun gambar pesawat
document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen gambar
    const pesawat = document.querySelector('.pesawat-float');
    
    // Jika gambar tidak ditemukan, hentikan
    if (!pesawat) return;
    
    let posisi = 0;
    let naik = true;
    
    // Jalankan animasi setiap 30ms
    setInterval(() => {
        if (naik) {
            posisi -= 1;
            if (posisi <= -10) naik = false;
        } else {
            posisi += 1;
            if (posisi >= 0) naik = true;
        }
        pesawat.style.transform = `translateY(${posisi}px)`;
    }, 50);
});