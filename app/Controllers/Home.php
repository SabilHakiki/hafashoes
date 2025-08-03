<?php

namespace App\Controllers;

use App\Models\Akun;
use App\Models\dataproduk;
use App\Models\kategori;
use App\Models\keranjang;
use App\Models\orderdetail;
use App\Models\order;
use Dompdf\Dompdf;


use Midtrans\Snap;
use Midtrans\Config;

use Login;
use phpDocumentor\Reflection\Types\This;
use Welcome;

class Home extends BaseController
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = 'SB-Mid-server-sQIOvET0PN0icODCdQadnjfn';
        Config::$isProduction = false; // Ganti true jika di produksi
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }



    public function index()
    {
        return redirect()->to(base_url('/mainmenu'));
    }

    public function contact()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $data = [
            'user' => $user,
        ];

        return view('contact', $data);
    }

    public function mainmenu()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first(); // bisa jadi null

        $model = new dataproduk();
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $produk = $model
                ->like('nama', $keyword)
                ->orLike('nkategori', $keyword)
                ->fullkategori();
        } else {
            $produk = $model->fullkategori();
        }

        $data = [
            'user' => $user, // ini bisa null jika belum login
            'produk' => $produk,
            'keyword' => $keyword,
        ];
        return view('mainmenu', $data);
    }

    public function registrasi(): string
    {
        helper(['form']);
        $valid = [];
        if (session()->has('validation')) {
            $valid = session('validation');
        }
        $data = [
            'valid' => $valid,
        ];
        return view('registrasi', $data);
    }

    public function add() // TAMBAH USER
    {
        // validasi
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => 'required',
            'email' => 'required|is_unique[users.email]',
            'nohp' => 'required',
            'pass1' => 'required|min_length[5]',
            'pass2' => 'required|matches[pass1]'
        ]);

        $errors = [
            'nama' => [
                'required' => 'Nama Harus di isi.',
            ],
            'email' => [
                'required' => 'Email Harus di isi.',
                'is_unique' => 'Email Sudah di Gunakan.',
            ],
            'nohp' => [
                'required' => 'Nomor HP Harus di isi.',
            ],
            'pass1' => [
                'required' => 'Password Harus di isi.',
                'min_length' => 'Password Minimal 5 character.',
            ],
            'pass2' => [
                'required' => 'Password Harus di isi.',
                'matches' => 'Password Tidak Cocok.',
            ]
        ];
        // Validasi input
        if (! $this->validate($validation->getRules(), $errors)) {
            // Redirect ke form registrasi dengan pesan kesalahan
            return redirect()->to(base_url('registrasi'))->withInput()->with('validation', $validation->getErrors());
        }

        $model = new Akun();
        $model->save([
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nohp' => $this->request->getVar('nohp'),
            'password' => $this->request->getVar('pass1'),
        ]);
        return redirect()->to(base_url())->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function edit()
    {
        $akun = new Akun();
        $email = session()->get('email');

        $user = $akun->where('email', $email)->first();

        $oldPassword = $this->request->getPost('oldpassword');
        $newPassword = $this->request->getPost('newpassword');

        if (!empty($newPassword)) {
            if (password_verify($oldPassword, $user['password'])) {
                $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            } else {
                return redirect()->back()->with('error', 'Password lama salah.');
            }
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'destination_id' => $this->request->getPost('destination_id'),
            'destination_label' => $this->request->getPost('destination_label'),
            'email' => $this->request->getPost('email'),
            'nohp' => $this->request->getPost('nohp'),
        ];

        // Proses upload foto jika ada
        $croppedImage = $this->request->getPost('croppedImage'); // Ambil data Base64
        if ($croppedImage) {
            // Decode data Base64
            $imageParts = explode(";base64,", $croppedImage);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1]; // Tipe gambar (jpg, png, dll)
            $imageBase64 = base64_decode($imageParts[1]);

            // Nama file baru
            $fotoName = 'profil_' . uniqid() . '.' . $imageType;
            $path = 'gmbrprofil/' . $fotoName;
            // Hapus foto lama jika ada
            if (!empty($user['foto']) && file_exists('gmbrprofil/' . $user['foto'])) {
                unlink('gmbrprofil/' . $user['foto']);
            }
            file_put_contents($path, $imageBase64);
            $data['foto'] = $fotoName;
        }


        // dd($data);
        $akun->update($user['id'], $data);

        return redirect()->to(base_url('profile'))->with('success', 'Profil berhasil diperbarui'); // Redirect dengan pesan sukses
    }

    public function login_view()
    {
        // Menampilkan halaman login
        helper('form');

        $data = [
            'valid' => session()->getFlashdata('error'),
        ];

        return view('login', $data);
    }

    public function login()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'user' => 'required|valid_email',
            'pass' => 'required|min_length[5]'
        ]);

        $nama = $this->request->getVar('user');
        $pass = $this->request->getVar('pass');

        $model = new Akun();
        $akun = $model->where('email', $nama)->first();


        if ($akun) {
            if ($pass == $akun['password']) {
                $session = session();
                $session->set([
                    'id' => $akun['id'],
                    'nama' => $akun['nama'],
                    'email' => $akun['email'],
                    'role' => $akun['role'],
                    'logged_in' => true,
                ]);
            } else {
                session()->setFlashdata('error1', 'Password salah');
                return redirect()->to(base_url('login'))->withInput()->with('validation', $validation);
            }
        } else {
            session()->setFlashdata('error', 'Email tidak ditemukan');
            return redirect()->to(base_url('login'));
        }


        if ($akun['role'] === 'kurir') {
            return redirect()->to(base_url() . 'kurir');
        } else {
            return redirect()->to(base_url() . 'mainmenu');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }

    public function profile()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $kurir = $akun->where('role', 'kurir')->findAll();
        $customers = $akun->where('role', 'Customer')->findAll();

        $data = [
            'user' => $user,
            'kurir' => $kurir,
            'customers' => $customers
        ];
        return view('profile', $data);
    }

    public function updateRole()
    {
        $akun = new Akun();
        $idUser = $this->request->getPost('id_user');
        $role = $this->request->getPost('role');
        $email = session()->get('email');


        if ($akun->where('id', $idUser)->set('role', $role)->update()) {
            return redirect()->to(base_url('profile'))->with('success', 'Role berhasil diperbarui!');
        } else {
            return redirect()->to(base_url('profile'))->with('error', 'Gagal memperbarui role.');
        }
    }

    // ______________________________________________________

    public function produk()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $model = new dataproduk();

        $data = [
            'user' => $user,
            'produk' => $model->fullkategori(),
        ];
        return view('produk', $data);
    }

    public function updateproduk($id)
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $kategori = new kategori();
        $model = new dataproduk();

        $produk = $model->where('id', $id)->first();

        helper(['form']);
        $valid = [];
        if (session()->has('validation')) {
            $valid = session('validation');
        }
        $data = [
            'user' => $user,
            'valid' => $valid,
            'kategori' => $kategori->findAll(),
            'produk' => $produk,
        ];
        return view('updateproduk', $data);
    }

    public function addproduk()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $model = new kategori();
        $dataproduk = new dataproduk();

        helper(['form']);
        $valid = [];
        if (session()->has('validation')) {
            $valid = session('validation');
        }
        $data = [
            'user' => $user,
            'valid' => $valid,
            'nama' => $dataproduk,
            'kategori' => $model->findAll(),
        ];

        return view('addproduk', $data);
    }

    public function newproduk()
    {
        $email = session()->get('email');
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nbarang' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ]);

        $errors = [
            'nbarang' => [
                'required' => 'Nama Barang Harus di isi.',
            ],
            'kategori' => [
                'required' => 'Kategori Harus dipilih.',
            ],
            'harga' => [
                'required' => 'Harga Harus di isi.',
                'numeric' => 'Harga harus angka'
            ],
            'stok' => [
                'required' => 'Stok Harus di isi.',
                'numeric' => 'Stok harus angka.',
            ],
            'gambar' => [
                'uploaded' => 'Tambahkan File Gambar.',
                'is_image' => 'File Bukan Gambar',
                'mime_in' => 'File Bukan Gambar',
            ]
        ];
        if (! $this->validate($validation->getRules(), $errors)) {
            return redirect()->to(base_url('addproduk'))->withInput()->with('validation', $validation->getErrors());
        }


        $files = $this->request->getFiles();
        $savedFiles = [];

        if ($files && isset($files['gambar'])) {
            foreach ($files['gambar'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $fileName = 'produk_' . uniqid() . '.' . $file->getExtension();
                    $file->move('gmbrproduk/', $fileName);
                    $savedFiles[] = $fileName;
                }
            }
        }


        $a = $this->request->getVar('nbarang');
        $deskripsi = $this->request->getPost('deskripsi');
        $model = new dataproduk();

        $model->save([
            'gmbr' => json_encode($savedFiles), // Simpan gambar sebagai JSON
            'nama' => $this->request->getVar('nbarang'),
            'kategori' => $this->request->getVar('kategori'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'deskripsi' => $deskripsi,
        ]);

        return redirect()->to(base_url('produk'))->with('success', "Produk $a berhasil ditambahkan.");
    }

    public function editproduk()
    {
        $email = session()->get('email');
        $id = $this->request->getPost('idbarang');
        $a = $this->request->getPost('nbarang');
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nbarang' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'permit_empty|is_image[gambar.*]|mime_in[gambar.*,image/jpg,image/jpeg,image/png]',
        ]);

        $errors = [
            'nbarang' => [
                'required' => 'Nama Barang Harus di isi.',
            ],
            'kategori' => [
                'required' => 'Kategori Harus dipilih.',
            ],
            'harga' => [
                'required' => 'Harga Harus di isi.',
                'numeric' => 'Harga harus angka'
            ],
            'stok' => [
                'required' => 'Stok Harus di isi.',
                'numeric' => 'Stok harus angka.',
            ],
            'gambar' => [
                'uploaded' => 'Tambahkan File Gambar.',
                'is_image' => 'File Bukan Gambar',
                'mime_in' => 'Format gambar yang diizinkan adalah jpg, jpeg, atau png.',
            ]
        ];

        if (! $this->validate($validation->getRules(), $errors)) {
            return redirect()->to(base_url('updateproduk/' . $id))->withInput()->with('validation', $validation->getErrors());
        }

        $gambarLama = json_decode($this->request->getVar('gambar_lama'), true) ?? [];
        $files = $this->request->getFileMultiple('gambar');
        $uploadedImages = [];
        // dd($gambarLama);

        if ($files) {
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $namafoto = 'produk_' . $file->getRandomName();
                    if ($file->move('gmbrproduk/', $namafoto)) {
                        $uploadedImages[] = $namafoto;
                    } else {
                        return redirect()->to(base_url('updateproduk/' . $id))->withInput()->with('error', 'Gagal mengunggah gambar.');
                    }
                }
            }
        }

        if (empty($uploadedImages)) {
            $uploadedImages = $gambarLama;
        }

        $allImages = array_unique(array_merge($gambarLama, $uploadedImages));
        $allImagesJson = json_encode($allImages); // Konversi ke JSON

        // Update produk
        $model = new dataproduk();
        $model->update($id, [
            'nama' => $this->request->getVar('nbarang'),
            'kategori' => $this->request->getVar('kategori'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gmbr' => $allImagesJson,
        ]);

        return redirect()->to(base_url('produk'))->with('success', "Produk $a berhasil diupdate.");
    }

    public function deleteimage()
    {

        $model = new dataproduk();
        $id = $this->request->getPost('idbarang');
        $produk = $model->find($id);

        //cek gambar lama
        $gambarLama = json_decode($produk['gmbr'], true) ?? [];
        if (empty($gambarLama)) {
            return redirect()->back()->with('error', 'Tidak ada gambar untuk dihapus.');
        }

        // Hapus  gambar  direktori
        $success = true;
        foreach ($gambarLama as $gambar) {
            $path = FCPATH . 'gmbrproduk/' . $gambar;

            if (file_exists($path)) {
                if (!unlink($path)) {
                    $success = false;
                    log_message('error', "Gagal menghapus gambar: $path");
                    return redirect()->back()->with('error', "Gagal menghapus gambar: $path");
                }
            } else {
                log_message('error', "File tidak ditemukan: $path");
                return redirect()->back()->with('error', "File tidak ditemukan: $path");
            }
        }

        if ($success) {
            // Hapus gambar database 
            $model->update($id, ['gmbr' => json_encode([])]);
            return redirect()->back()->with('success', 'Semua gambar berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus beberapa gambar.');
        }
    }

    public function hapusproduk()
    {
        $model = new dataproduk();

        // Ambil ID produk dari request POST
        $id_produk = $this->request->getPost('idproduk');

        // Cek apakah data dengan ID tersebut ada
        $produk = $model->where('id', $id_produk)->first();

        if ($produk) {
            // Hapus data jika ditemukan dengan klausa WHERE
            $model->where('id', $id_produk)->delete();
            // Redirect dengan pesan sukses
            return redirect()->to(base_url('produk'))->with('success', 'produk berhasil dihapus.');
        } else {
            // Redirect dengan pesan error jika data tidak ditemukan
            return redirect()->to(base_url('produk'))->with('error', 'produk tidak ditemukan.');
        }
    }

    // ______________________________________________________

    public function kategori()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $model = new kategori();

        $data = [
            'user' => $user,
            'kategori' => $model->findAll(),
        ];
        return view('kategori', $data);
    }

    public function newkategori()
    {
        $model = new kategori();
        $model->save([
            'nkategori' => $this->request->getVar('nkategori'),
        ]);

        return redirect()->to(base_url('kategori'));
    }

    public function editkategori()
    {

        $model = new kategori();

        $id_kategori = $this->request->getPost('idkategori');
        $nama_kategori = $this->request->getPost('ekategori');
        // dd($id_kategori, $nama_kategori);


        $model->where('id_kategori', $id_kategori)->set(['nkategori' => $nama_kategori])->update();

        return redirect()->to(base_url('kategori'));
    }

    public function hapuskategori()
    {
        $model = new Kategori();

        // Ambil ID kategori dari request POST
        $id_kategori = $this->request->getPost('idkategori2');

        // Cek apakah data dengan ID tersebut ada
        $kategori = $model->where('id_kategori', $id_kategori)->first();

        if ($kategori) {
            // Hapus data jika ditemukan dengan klausa WHERE
            $model->where('id_kategori', $id_kategori)->delete();
            // Redirect dengan pesan sukses
            return redirect()->to(base_url('kategori'))->with('success', 'Kategori berhasil dihapus.');
        } else {
            // Redirect dengan pesan error jika data tidak ditemukan
            return redirect()->to(base_url('kategori'))->with('error', 'Kategori tidak ditemukan.');
        }
    }

    // ______________________________________________________

    public function detail_produk($id)
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $model = new dataproduk();
        $produk = $model->select('produk.*, kategori.nkategori')->join('kategori', 'produk.kategori = kategori.id_kategori')->where('produk.id', $id)->first();
        $gambarproduk = json_decode($produk['gmbr'], true) ?? [];
        $data = [
            'user' => $user,
            'produk' => $produk,
            'gambarproduk' => $gambarproduk,
        ];
        return view('detail_produk', $data);
    }

    public function keranjang()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $userId = $user['id'];
        $model = new keranjang();
        $keranjang = $model->getproduk($userId);
        $data = [
            'user' => $user,
            'keranjang' => $keranjang,
        ];
        // dd($data);
        return view('keranjang', $data);
    }


    public function tambah()
    {
        $session = session();
        $idbarang = $this->request->getPost('idbarang');
        $nama = $this->request->getPost('nama');
        $jumlah = $this->request->getPost('jumlah');
        $id_user = $session->get('id');

        $model = new dataproduk();
        $keranjang = new keranjang();

        // Cek apakah produk ada di database
        $produk = $model->find($idbarang);

        if ($produk) {
            // Cek stok
            if ($jumlah > $produk['stok']) {
                return redirect()->to('/keranjang')->with('error', 'Jumlah melebihi stok yang tersedia.');
            }

            // Hitung subtotal berdasarkan harga produk dan jumlah yang dibeli
            $subtotal = $produk['harga'] * $jumlah;

            // Cek apakah produk sudah ada di keranjang untuk user ini
            $itemKeranjang = $keranjang->where('id_user', $id_user)
                ->where('id_produk', $idbarang)
                ->first();

            if ($itemKeranjang) {
                // Jika produk sudah ada di keranjang, update jumlah dan subtotal
                $keranjang->update($itemKeranjang['id'], [
                    'jumlah' => $itemKeranjang['jumlah'] + $jumlah,
                    'subtotal' => ($itemKeranjang['jumlah'] + $jumlah) * $produk['harga']
                ]);
            } else {
                // Insert baru
                $result = $keranjang->insert([
                    'id_user' => $id_user,
                    'id_produk' => $idbarang,
                    'gmbr' => $produk['gmbr'],
                    'nama' => $nama,
                    'harga' => $produk['harga'],
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal
                ]);
                if (!$result) {
                    // Menangkap kesalahan jika insert gagal
                    return redirect()->to(base_url('/keranjang'))->with('error', 'Gagal menambahkan produk ke keranjang.');
                }
            }

            // Redirect ke halaman keranjang dengan pesan sukses
            return redirect()->to(base_url('/keranjang'))->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } else {
            // Redirect ke halaman keranjang dengan pesan error jika produk tidak ditemukan
            return redirect()->to(base_url('/keranjang'))->with('error', 'Produk tidak ditemukan.');
        }
    }

    public function update()
    {
        $session = session();
        $idKeranjang = $this->request->getPost('id_keranjang');
        $jumlah = $this->request->getPost('jumlah');

        $keranjang = new keranjang();
        $produkModel = new dataproduk();

        $itemKeranjang = $keranjang->find($idKeranjang);

        if (!$itemKeranjang) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang tidak ditemukan.');
        }

        // Ambil data produk berdasarkan id_produk
        $produk = $produkModel->find($itemKeranjang['id_produk']);

        if (!$produk) {
            return redirect()->to('/keranjang')->with('error', 'Produk tidak ditemukan.');
        }

        // Validasi jumlah ≤ stok
        if ($jumlah > $produk['stok']) {
            return redirect()->to('/keranjang')->with('error', 'Jumlah melebihi stok tersedia.');
        }

        // Hitung subtotal baru
        $subtotal = $jumlah * $produk['harga'];

        // Update keranjang
        $keranjang->update($idKeranjang, [
            'jumlah'   => $jumlah,
            'subtotal' => $subtotal,
        ]);

        return redirect()->to('/keranjang')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function hapus()
    {
        $model = new keranjang();
        $idKeranjang = $this->request->getPost('idkeranjang');

        // Cek apakah data dengan ID tersebut ada
        $produk = $model->where('id', $idKeranjang)->first();

        if ($produk) {
            // Hapus data jika ditemukan dengan klausa WHERE
            $model->where('id', $idKeranjang)->delete();
            // Redirect dengan pesan sukses
            return redirect()->to(base_url('/keranjang'))->with('success', 'produk berhasil dihapus dari keranjang.');
        } else {
            // Redirect dengan pesan error jika data tidak ditemukan
            return redirect()->to(base_url('/keranjang'))->with('error', 'produk tidak ditemukan.');
        }
    }

    public function hapusall()
    {
        $model = new keranjang();
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }


        $model->where('id_user', $userId)->delete();

        return redirect()->to(base_url('/keranjang'))->with('success', 'Semua produk berhasil dihapus dari keranjang.');
    }

    // ______________________________________________________

    public function checkout()
    {
        $akun = new akun();
        $keranjangModel = new keranjang();

        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $userId = session()->get('id');
        $keranjang = $keranjangModel->where('id_user', $userId)->findAll();

        if (empty($keranjang)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalItem = 0;
        foreach ($keranjang as $item) {
            $totalItem += $item['jumlah']; // jumlah barang per produk
        }


        $data = [
            'user' => $user,
            'keranjang' => $keranjang,
            'totalItem' => $totalItem,
            'origin' => '65364'
        ];

        return view('checkout', $data);
    }

    public function getKota()
    {
        $keyword = $this->request->getPost('search');
        $client = \Config\Services::curlrequest();

        if (!$keyword) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Parameter search kosong'
            ]);
        }


        try {
            $response = $client->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
                'headers' => [
                    // 'key' => 'uMBA4JYdabf4b05b1be3d0c5hEpXVtRU'
                    'key' => '47aWQlvQ00e81856a8f1ca6dgLfpXLcu'

                ],
                'query' => [
                    'search' => $keyword,
                    'limit' => 10
                ]
            ]);

            return $this->response->setJSON(json_decode($response->getBody(), true));

            if (!$result || !isset($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                    'raw' => $result
                ]);
            }

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getAlamatAutocomplete()
    {
        $search = $this->request->getPost('search');
        if (!$search) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Parameter search wajib diisi.'
            ]);
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
                'headers' => [
                    'key' => '47aWQlvQ00e81856a8f1ca6dgLfpXLcu' // GANTI dengan API Key kamu
                ],
                'query' => [
                    'search' => $search,
                    'limit' => 20
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (!isset($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan dari API.',
                    'raw' => $result
                ]);
            }

            // Format label agar lebih enak dibaca
            $formatted = array_map(function ($item) {
                return [
                    'id' => $item['id'],
                    'label' => $item['subdistrict_name'] . ', ' .
                        $item['district_name'] . ', ' .
                        $item['city_name'] . ', ' .
                        $item['province_name'] . ' (' . $item['zip_code'] . ')'
                ];
            }, $result['data']);

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $formatted
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getOngkir()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight');
        $courier = $this->request->getPost('courier');
        $price = 'lowest'; // Bisa diganti 'all' jika ingin semua layanan kurir

        // Validasi input
        if (!$origin || !$destination || !$weight || !$courier) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Semua parameter wajib diisi.'
            ]);
        }

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'headers' => [
                    'key' => '47aWQlvQ00e81856a8f1ca6dgLfpXLcu', // 🔴 Ganti dengan API KEY Anda
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier,
                    'price' => $price
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['data'])) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $result['data']
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data ongkir tidak tersedia.',
                    'raw' => $result
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function processPayment()
    {
        // dd($this->request->getPost());

        $keranjangModel = new keranjang();
        $orderModel = new order();
        $detailOrderModel = new orderdetail();
        $produkModel = new dataproduk();

        // Ambil data checkout dari form
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email');
        $telepon = $this->request->getPost('telepon');
        $alamat = $this->request->getPost('alamat');
        $destinationId = $this->request->getPost('destination_id');
        $destinationLabel = $this->request->getPost('destination_label');
        $kurir = $this->request->getPost('kurir');
        $ongkir = $this->request->getPost('ongkir');
        $ongkirService = $this->request->getPost('ongkir_service');
        $metodePembayaran = $this->request->getPost('metode_pembayaran');

        $keranjang = $keranjangModel->where('id_user', session()->get('id'))->findAll();

        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        if (empty($ongkir)) {
            $ongkir = 0;
        }

        // Hitung total
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }
        $grandTotal = $total + $ongkir;
        $orderNumber = 'ORD-' . time();

        // Jika metode pembayaran COD
        if ($metodePembayaran === 'COD') {
            // Simpan data order langsung tanpa Midtrans

            $alamatPengiriman = $alamat . ' - ' . $destinationLabel;
            $orderData = [
                'id_user' => session()->get('id'),
                'order_number' => $orderNumber,
                'nama_pembeli' => $nama,
                'total_harga' => $total,
                'ongkir' => $ongkir,
                'grand_total' => $grandTotal,
                'status' => 'Menunggu Konfirmasi',
                'tanggal_pesanan' => date('Y-m-d H:i:s'),
                'alamat_pengiriman' => $alamatPengiriman,
                'kurir' => $kurir,
                'layanan' => $ongkirService,
                'metode_pembayaran' => $metodePembayaran,
            ];
            $orderId = $orderModel->insert($orderData);

            // Simpan detail order
            foreach ($keranjang as $item) {
                $produk = $produkModel->find($item['id_produk']);
                if ($produk) {
                    // Update stok
                    $produkModel->update($item['id_produk'], [
                        'stok' => $produk['stok'] - $item['jumlah']
                    ]);

                    // Insert detail
                    $detailOrderModel->insert([
                        'id_order' => $orderId,
                        'id_produk' => $item['id_produk'],
                        'jumlah' => $item['jumlah'],
                        'harga' => $produk['harga'],
                        'subtotal' => $item['jumlah'] * $produk['harga'],
                    ]);
                }
            }

            // Hapus keranjang
            $keranjangModel->where('id_user', session()->get('id'))->delete();

            return redirect()->to('/transaksi')->with('success', 'Pesanan COD berhasil dibuat.');
        }
        // Jika metode pembayaran Midtrans
        else {
            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = 'SB-Mid-server-sQIOvET0PN0icODCdQadnjfn';
            \Midtrans\Config::$clientKey = 'SB-Mid-client-hCVwpeiZXPpOwiJh';
            \Midtrans\Config::$isProduction = false;

            $orderNumber = 'ORD-' . time();

            // Simpan order ke DB langsung meskipun belum bayar
            $orderData = [
                'id_user' => session()->get('id'),
                'order_number' => $orderNumber,
                'nama_pembeli' => $nama,
                'total_harga' => $total,
                'ongkir' => $ongkir,
                'grand_total' => $grandTotal,
                'status' => 'Belum Dibayar',
                'tanggal_pesanan' => date('Y-m-d H:i:s'),
                'alamat_pengiriman' => $alamat . ' - ' . $destinationLabel,
                'kurir' => $kurir,
                'layanan' => $ongkirService,
                'metode_pembayaran' => $metodePembayaran,
                'snap_token' => '',
            ];
            $orderId = $orderModel->insert($orderData);
            // Simpan detail order
            foreach ($keranjang as $item) {
                $produk = $produkModel->find($item['id_produk']);
                if ($produk) {
                    // Update stok
                    $produkModel->update($item['id_produk'], [
                        'stok' => $produk['stok'] - $item['jumlah']
                    ]);

                    // Insert detail
                    $detailOrderModel->insert([
                        'id_order' => $orderId,
                        'id_produk' => $item['id_produk'],
                        'jumlah' => $item['jumlah'],
                        'harga' => $produk['harga'],
                        'subtotal' => $item['jumlah'] * $produk['harga'],
                    ]);
                }
            }
            $keranjangModel->where('id_user', session()->get('id'))->delete();

            // Setup transaksi Snap
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $nama,
                    'email' => $email,
                    'phone' => $telepon,
                ],
                'item_details' => array_merge(
                    array_map(function ($item) {
                        return [
                            'id' => $item['id'],
                            'price' => $item['harga'],
                            'quantity' => $item['jumlah'],
                            'name' => $item['nama'],
                        ];
                    }, $keranjang),
                    ($ongkir > 0) ? [[
                        'id' => 'ongkir',
                        'price' => (int)$ongkir,
                        'quantity' => 1,
                        'name' => 'Ongkos Kirim'
                    ]] : []
                ),
            ];
            $params['finish_redirect_url'] = base_url('transaksi');

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $orderModel->update($orderId, ['snap_token' => $snapToken]);

                // Simpan data checkout ke session untuk digunakan setelah pembayaran sukses
                session()->set([
                    'order_number' => $orderNumber,
                    'checkout_data' => [
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'email' => $email,
                        'telepon' => $telepon,
                        'destination_id' => $destinationId,
                        'destination_label' => $destinationLabel,
                        'kurir' => $kurir,
                        'ongkir' => $ongkir,
                        'layanan' => $ongkirService,
                        'grand_total' => $grandTotal,
                        'metode_pembayaran' => $metodePembayaran,
                        'order_number' => $orderNumber,
                    ]
                ]);

                return redirect()->to(site_url('midtrans?snaptoken=' . $snapToken));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan Midtrans: ' . $e->getMessage());
            }
        }
    }


    public function clear()
    {
        log_message('info', 'clear() dipanggil oleh JavaScript');

        try {
            $json = $this->request->getJSON();

            $userId = session()->get('id');
            $orderNumber = session()->get('order_number');

            if (!$userId || !$orderNumber) {
                log_message('error', 'User ID atau Order Number tidak ditemukan di sesi.');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Sesi tidak valid. Silakan login ulang.'
                ]);
            }

            $orderModel = new order();
            $order = $orderModel->where('order_number', $orderNumber)->first();

            // Ambil order berdasarkan order_number
            if (!$order) {
                log_message('error', 'Order dengan order_number ' . $orderNumber . ' tidak ditemukan.');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan.'
                ]);
            }

            // Update status jadi "Menunggu Konfirmasi"
            $orderModel->where('order_number', $orderNumber)
                ->set(['status' => 'Menunggu Konfirmasi'])
                ->update();

            // Hapus sesi
            session()->remove('checkout_data');
            session()->remove('checkout_order_id');
            session()->remove('midtrans_snap_token');
            session()->remove('order_number');

            log_message('info', 'Transaksi berhasil diselesaikan oleh user ID: ' . $userId);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            log_message('error', 'clear() error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyelesaikan transaksi.'
            ]);
        }
    }


    public function midtrans()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        if (!$email) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        if (!$user) {
            return redirect()->to(base_url('login'))->with('error', 'Akun tidak ditemukan.');
        }

        $snaptoken = $this->request->getVar('snaptoken');
        $checkoutData = session()->get('checkout_data'); // Ambil data checkout dari session
        $orderId = $this->request->getGet('order_id');

        if ($snaptoken && $checkoutData) {
            return view('midtrans', [
                'user' => $user,
                'snaptoken' => $snaptoken,
                'checkout_data' => $checkoutData
            ]);
        }

        return redirect()->to(base_url('checkout'))->with('error', 'Data pembayaran tidak lengkap.');
    }


    public function notification() //Midtrans
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            log_message('error', 'Notifikasi gagal: data kosong');
            return;
        }

        log_message('info', 'Midtrans notif: ' . print_r($data, true));

        $order_id = $data['order_id'];
        $status = $data['transaction_status'];

        $orderModel = new Order();
        $order = $orderModel->where('order_number', $order_id)->first();

        if (!$order) {
            log_message('error', 'Order tidak ditemukan: ' . $order_id);
            return $this->response->setStatusCode(404)->setBody('Order Not Found');
        }

        if ($status == 'settlement' || $status == 'capture') {
            // Pembayaran berhasil
            $orderModel->where('order_number', $order_id)
                ->set(['status' => 'Menunggu Konfirmasi'])
                ->update();
            log_message('info', 'Transaksi berhasil, status diubah ke Menunggu Konfirmasi: ' . $order_id);
        } elseif ($status == 'pending') {
            // Menunggu pembayaran (opsional)
            $orderModel->where('order_number', $order_id)
                ->set(['status' => 'Belum Dibayar'])
                ->update();
            log_message('info', 'Transaksi pending: ' . $order_id);
        } elseif ($status == 'expire' || $status == 'cancel' || $status == 'deny') {
            // Gagal bayar
            $orderModel->where('order_number', $order_id)
                ->set(['status' => 'Gagal'])
                ->update();
            log_message('info', 'Transaksi gagal/expired: ' . $order_id);
        }

        return $this->response->setStatusCode(200)->setBody('OK');
    }

    // ______________________________________________________

    public function transaksi()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();



        $order = new order();
        $userId = $user['id'];
        $role = $user['role'];

        $allOrders = $role === 'admin'
            ? $order->orderBy('id', 'DESC')->findAll()
            : $order->where('id_user', $userId)->orderBy('id', 'DESC')->findAll();

        $belum_dibayar = [];
        $menunggu_konfirmasi = [];
        $dalam_proses = [];
        $sedang_dikirim = [];
        $selesai = [];
        $gagal = [];

        foreach ($allOrders as $o) {
            switch ($o['status']) {
                case 'Belum Dibayar':
                    $belum_dibayar[] = $o;
                    break;
                case 'Menunggu Konfirmasi':
                    $menunggu_konfirmasi[] = $o;
                    break;
                case 'Dalam Proses':
                    $dalam_proses[] = $o;
                    break;
                case 'Sedang Dikirim':
                    $sedang_dikirim[] = $o;
                    break;
                case 'Selesai':
                    $selesai[] = $o;
                    break;
                case 'Gagal':
                    $gagal[] = $o;
                    break;
            }
        }
        $data = [
            'user' => $user,
            'role' => $role,
            'belum_dibayar' => $belum_dibayar,
            'menunggu_konfirmasi' => $menunggu_konfirmasi,
            'dalam_proses' => $dalam_proses,
            'sedang_dikirim' => $sedang_dikirim,
            'selesai' => $selesai,
            'gagal' => $gagal,
        ];
        return view('transaksi', $data);
    }

    public function transaksi_detail($id)
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $ordermodel = new order();
        $order = $ordermodel->find($id);
        $customer = $akun->find($order['id_user']);

        $orderdetail = new orderdetail();
        $orderDetails = $orderdetail->getOrderDetailsWithProduk($id);

        return view('transaksi_detail', [
            'user' => $user,
            'order' => $order,
            'orderDetails' => $orderDetails,
            'customer' => $customer,
        ]);
    }

    public function invoice($id)
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $ordermodel = new order();
        $order = $ordermodel->getOrderWithPelanggan();
        $order = array_filter($order, fn($item) => $item['id'] == $id);
        $order = reset($order);

        $orderdetail = new orderdetail();
        $orderDetails = $orderdetail->getOrderDetailsWithProduk($id);
        $data = [
            'user' => $user,
            'order' => $order,
            'orderDetails' => $orderDetails,
        ];

        return view('invoice', $data);
    }

    public function cetakPdf($id)
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();
        $ordermodel = new order();
        $order = $ordermodel->getOrderWithPelanggan();
        $order = array_filter($order, fn($item) => $item['id'] == $id);
        $order = reset($order);

        $orderdetail = new orderdetail();
        $orderDetails = $orderdetail->getOrderDetailsWithProduk($id);
        $data = [
            'user' => $user,
            'order' => $order,
            'orderDetails' => $orderDetails,
        ];

        $html =  view('invoice_print', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('invoice_' . $id . '.pdf', ["Attachment" => 1]);
    }

    // ______________________________________________________

    public function laporan()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $orderModel = new order();
        $orderDetailModel = new orderdetail();

        // Ambil bulan dan tahun dari request
        $filterMonth = $this->request->getGet('filter-month');
        $filterYear = $this->request->getGet('filter-year');

        // Jika tidak ada bulan atau tahun yang dipilih, gunakan bulan dan tahun saat ini
        if (!$filterMonth) {
            $filterMonth = date('m');
        }
        if (!$filterYear) {
            $filterYear = date('Y');
        }

        $totalPenjualan = 0;
        $jumlahProdukTerjual = 0;
        $jumlahTransaksi = 0;

        // Variabel untuk grafik
        $labels = [];
        $data = [];

        // Ambil data penjualan berdasarkan bulan dan tahun yang dipilih
        $query = $orderModel->query(
            "
        SELECT 
            DATE(tanggal_pesanan) AS tanggal, 
            SUM(total_harga) AS total_harga 
        FROM `order` 
        WHERE MONTH(tanggal_pesanan) = ? AND YEAR(tanggal_pesanan) = ?
        GROUP BY DATE(tanggal_pesanan)
    ",
            [$filterMonth, $filterYear]
        );

        $results = $query->getResultArray();
        foreach ($results as $row) {
            $labels[] = date('Y-m-d', strtotime($row['tanggal'])); // Tanggal
            $data[] = $row['total_harga']; // Total penjualan per hari
            $totalPenjualan += $row['total_harga']; // Menjumlahkan total penjualan
        }

        // Mengambil data transaksi
        $transaksi = $this->getTransaksiFiltered($filterMonth, $filterYear);

        // Hitung jumlah produk terjual dan jumlah transaksi
        foreach ($transaksi as $trx) {
            $jumlahProdukTerjual += $trx['jumlah'];
            $jumlahTransaksi++;
        }

        return view('laporan', [
            'user' => $user,
            'filterMonth' => $filterMonth,
            'filterYear' => $filterYear,
            'bulan' => json_encode($labels),
            'datagrafik' => json_encode($data),
            'totalPenjualan' => $totalPenjualan,
            'jumlahProdukTerjual' => $jumlahProdukTerjual,
            'jumlahTransaksi' => $jumlahTransaksi,
            'transaksi' => $transaksi
        ]);
    }

    private function getTransaksiFiltered($filterMonth, $filterYear)
    {
        $orderModel = new order();
        $orderDetailModel = new orderdetail();

        $orderModel->where('MONTH(tanggal_pesanan)', $filterMonth);
        $orderModel->where('YEAR(tanggal_pesanan)', $filterYear);

        return $orderModel
            ->select('order.id AS id, order.order_number, order.tanggal_pesanan, order.total_harga, order.status, order.id_user, order_detail.jumlah, order_detail.subtotal, produk.nama AS nama_produk, users.nama AS nama_pembeli')
            ->join('order_detail', 'order.id = order_detail.id_order')
            ->join('produk', 'order_detail.id_produk = produk.id')
            ->join('users', 'users.id = order.id_user')
            ->findAll();
    }

    // ______________________________________________________

    public function kurir()
    {
        $akun = new Akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $userRole = $user['role'];
        $userId = $user['id'];
        $orderModel = new Order();
        $orderDetailModel = new OrderDetail();

        if ($userRole === 'kurir') {
            $pesanan = $orderModel
                ->where('kurir_id', $userId)
                ->whereIn('status', ['Sedang Dikirim', 'Dalam Proses'])
                ->getOrderWithPelanggan();
        } elseif ($userRole === 'admin') {
            $pesanan = $orderModel
                ->whereIn('status', ['Sedang Dikirim', 'Dalam Proses'])
                ->getOrderWithPelanggan();
        } else {
            return redirect()->to('/login')->with('error', 'Akses tidak diizinkan.');
        }


        $ambil = $orderModel
            ->where('kurir_id', null)
            ->whereIn('status', ['Menunggu Konfirmasi', 'Dalam Proses'])
            ->getOrderWithPelanggan();

        // Riwayat pengiriman
        $orders = $orderModel
            ->where('status', 'Selesai')
            ->getOrderWithPelanggan();

        // Data yang dikirim ke view
        $data = [
            'user' => $user,
            'pesanan' => $pesanan,
            'ambil' => $ambil,
            'orders' => $orders,
            'orderDetailModel' => $orderDetailModel
        ];

        return view('kurir', $data);
    }

    public function ambilPesanan()
    {
        $akun = new akun();
        $email = session()->get('email');
        $user = $akun->where('email', $email)->first();

        $orderId = $this->request->getPost('order_id');
        $kurirId = session()->get('id');

        $orderModel = new order();


        $pesanan = $orderModel->find($orderId);

        if ($pesanan['kurir_id']) {
            return redirect()->to(base_url('/kurir'))->with('error', 'Pesanan ini sudah diambil oleh kurir lain.');
        }


        $orderModel->update($orderId, [
            'kurir_id' => $kurirId,
            'status' => 'Dalam Proses',
        ]);

        return redirect()->to(base_url('/kurir'))->with('success', 'Pesanan berhasil diambil.');
    }

    public function updateStatus()
    {

        $orderModel = new order();
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        $orderModel->update($orderId, [
            'status' => $status,
            'tanggal_pengiriman' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('/kurir'))->with('success1', 'Status berhasil diperbarui.');
    }

    public function inputResi($id)
    {
        $orderModel = new Order();
        $noResi = $this->request->getPost('no_resi');
        $orderModel->update($id, [
            'no_resi' => $noResi,
            'status' => 'Sedang Dikirim',
            'tanggal_pengiriman' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('/kurir'))->with('success1', 'Nomor resi berhasil disimpan.');
    }

    public function detailPesanan($id)
    {
        $orderModel = new order();
        $orderDetailModel = new orderdetail();
        $order = $orderModel->find($id);
        $details = $orderDetailModel->where('id_order', $id)->findAll();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        $data = [
            'order' => $order,
            'details' => $details,
        ];

        return view('kurir/detail_pesanan', $data);
    }
}
