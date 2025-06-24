<x-layout>
  <h1 class="text-4xl text-center mb-2">Buat Reservasi di <span class="font-allura text-5xl">Beautyworks by Fifi</span>
  </h1>

  <div class="grid grid-cols-2 grid-rows-2 gap-4">
    <div class="flex place-items-end justify-end flex-col gap-2">
      <calendar-date class="cally bg-base-100 border border-base-300 shadow-lg rounded-box" id="reservationCalendar">
        <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24">
          <path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path>
        </svg>
        <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24">
          <path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
        </svg>
        <calendar-month></calendar-month>
      </calendar-date>
      <button type="button" class="btn btn-primary w-[18rem]" id="checkAvailabilityBtn">Cek Ketersediaan</button>
    </div>

    {{-- Form ini akan kita modifikasi agar tombolnya memicu pembayaran Midtrans --}}
    <form id="reservationForm" action="{{ route('reservation.store') }}" method="post"
      class="flex items-center justify-center w-72">
      {{-- CSRF Token --}}
      @csrf
      <div class="bg-base-300 p-4 rounded-lg w-xl mx-auto">
        {{-- Display Validation Errors --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {{-- Display Success Message --}}
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        {{-- Display Midtrans Error --}}
        @if (session('midtrans_error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <span class="block sm:inline">{{ session('midtrans_error') }}</span>
        </div>
        @endif

        <input type="text" value="{{ Auth::user()->nama }}" name="nama" hidden>
        <input type="text" value="{{ Auth::user()->no_telp }}" name="kontak" hidden>
        <input type="email" value="{{ Auth::user()->email }}" name="email" hidden> {{-- Tambahkan email --}}

        <div class="flex flex-col gap-4 mb-4">
          <div class="flex-[50%]">
            <legend for="" class="text-xl mb-1">Tanggal :</legend>
            <input type="date" class="input w-full mb-2" name="tanggal_reservation"
              value="{{ old('tanggal_reservation') }}" />
          </div>

          <div class="flex-[50%]">
            <legend for="" class="text-xl mb-1">Jam :</legend>
            <input type="time" class="input w-full" name="waktu_reservation" value="{{ old('waktu_reservation') }}" />
            <span class="text-sm">(tersedia dari 07.00 - 17.00 WIB)</span>
          </div>
        </div>

        <legend for="" class="text-lg mb-1">Jenis Layanan :</legend>
        <select name="jenis_layanan" class="w-full select select-bordered mb-3">
          <option value="Make-up Class" selected>Make-up Class</option>
        </select>

        {{-- Tampilkan harga --}}
        <p class="text-xl font-bold mb-4">Harga: Rp 450.000</p>


        <button type="submit" class="btn btn-primary w-full" id="payButton">Bayar Sekarang</button>
      </div>
    </form>

    <div class="col-span-2">
      <h2 class="text-2xl text-center">List Booking</h2>
      <div class="border-2 rounded-box p-4" id="bookingList">
        {{-- Booking list will be loaded here via AJAX --}}
        <p class="text-center text-gray-500">Pilih tanggal untuk melihat daftar booking.</p>
      </div>
    </div>
  </div>

  <script type="module" src="https://unpkg.com/cally"></script>
  {{-- Load Midtrans Snap JS --}}
  @if(session('snapToken'))
  <script type="text/javascript" src="{{ session('midtransSnapUrl') }}"
    data-client-key="{{ session('midtransClientKey') }}"></script>
  @endif

  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('reservationCalendar');
    const checkAvailabilityBtn = document.getElementById('checkAvailabilityBtn');
    const bookingListDiv = document.getElementById('bookingList');
    const reservationForm = document.getElementById('reservationForm');
    const payButton = document.getElementById('payButton');

    checkAvailabilityBtn.addEventListener('click', function() {
      const selectedDate = calendar.value;

      if (!selectedDate) {
        alert('Silakan pilih tanggal terlebih dahulu.');
        return;
      }

      fetch(`/get-reservations?date=${selectedDate}`, {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          let html = '<h3 class="text-xl font-semibold mb-3">Booking untuk Tanggal: ' + new Date(selectedDate)
            .toLocaleDateString('id-ID', {
              weekday: 'long',
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            }) + '</h3>';
          if (data.reservations.length > 0) {
            html += '<div class="overflow-x-auto"><table class="table w-full">';
            html +=
              '<thead><tr><th>No</th><th>Nama</th><th>Jenis Layanan</th><th>Waktu</th><th>Status</th></tr></thead><tbody>'; // Tambahkan kolom status
            data.reservations.forEach((res, index) => {
              html += `<tr>
                                    <td>${index + 1}</td>
                                    <td>${res.nama}</td>
                                    <td>${res.jenis_layanan}</td>
                                    <td>${res.waktu_reservation.substring(0, 5)}</td>
                                    <td>${res.status}</td> {{-- Tampilkan status --}}
                                </tr>`;
            });
            html += '</tbody></table></div>';
          } else {
            html += '<p class="text-center text-gray-500">Tidak ada booking untuk tanggal ini.</p>';
          }
          bookingListDiv.innerHTML = html;
        })
        .catch(error => {
          console.error('There has been a problem with your fetch operation:', error);
          bookingListDiv.innerHTML =
            '<p class="text-red-500 text-center">Gagal memuat daftar booking. Silakan coba lagi.</p>';
        });
    });

    // Cek apakah ada snapToken dari session setelah redirect
    const snapToken = "{{ session('snapToken') }}";
    if (snapToken) {
      console.log('Snap Token received:', snapToken);
      // Panggil Midtrans Snap Pop-up
      window.snap.pay(snapToken, {
        onSuccess: function(result) {
          /* You may add your own implementation here */
          alert("Pembayaran berhasil!");
          // Redirect user ke halaman sukses atau update UI
          window.location.href = "{{ route('reservation') }}?payment_status=success";
        },
        onPending: function(result) {
          /* You may add your own implementation here */
          alert("Pembayaran Anda tertunda!");
          window.location.href = "{{ route('reservation') }}?payment_status=pending";
        },
        onError: function(result) {
          /* You may add your own implementation here */
          alert("Pembayaran gagal!");
          window.location.href = "{{ route('reservation') }}?payment_status=error";
        },
        onClose: function() {
          /* You may add your own implementation here */
          alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
          // Mungkin tidak perlu redirect di sini, karena status akan dihandle oleh webhook jika sudah terlanjur pending/settlement
        }
      });
    }

    // Handle status pembayaran dari URL jika ada
    const urlParams = new URLSearchParams(window.location.search);
    const paymentStatus = urlParams.get('payment_status');
    if (paymentStatus) {
      let message = '';
      let alertClass = '';
      if (paymentStatus === 'success') {
        message = 'Pembayaran berhasil! Reservasi Anda akan segera dikonfirmasi.';
        alertClass = 'bg-green-100 border-green-400 text-green-700';
      } else if (paymentStatus === 'pending') {
        message = 'Pembayaran Anda tertunda. Silakan selesaikan pembayaran atau cek status reservasi Anda.';
        alertClass = 'bg-yellow-100 border-yellow-400 text-yellow-700';
      } else if (paymentStatus === 'error') {
        message = 'Pembayaran gagal. Silakan coba lagi.';
        alertClass = 'bg-red-100 border-red-400 text-red-700';
      }

      if (message) {
        const alertDiv = `
                <div class="${alertClass} px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">${message}</span>
                </div>
            `;
        // Masukkan alert di bagian atas form
        reservationForm.insertAdjacentHTML('beforebegin', alertDiv);

        // Hapus parameter payment_status dari URL agar tidak muncul lagi saat refresh
        history.replaceState({}, document.title, window.location.pathname);
      }
    }

  });
  </script>
</x-layout>
