import React from "react";
import { useForm } from "@inertiajs/react";

export default function CreateSiaranPers() {
    // 1. Inisialisasi state form menggunakan helper dari Inertia
    const { data, setData, post, processing, errors } = useForm({
        judul: "",
        kategori: "",
        tanggal_publish: "",
        konten: "",
        lampiran: null,
    });

    // 2. Fungsi penanganan submit form
    const handleSubmit = (e) => {
        e.preventDefault();
        // Mengirimkan data via POST ke route Laravel '/siaran-pers'
        post("/siaran-pers");
    };

    return (
        <div
            style={{
                maxWidth: "700px",
                margin: "40px auto",
                fontFamily: "sans-serif",
            }}
        >
            <h2>Buat Siaran Pers Baru</h2>

            <form onSubmit={handleSubmit}>
                {/* Input Judul */}
                <div style={{ marginBottom: "15px" }}>
                    <label style={{ display: "block", marginBottom: "5px" }}>
                        Judul Siaran Pers
                    </label>
                    <input
                        type="text"
                        value={data.judul}
                        onChange={(e) => setData("judul", e.target.value)}
                        style={{ width: "100%", padding: "8px" }}
                        placeholder="Masukkan judul..."
                    />
                    {errors.judul && (
                        <small style={{ color: "red" }}>{errors.judul}</small>
                    )}
                </div>

                {/* Input Kategori */}
                <div style={{ marginBottom: "15px" }}>
                    <label style={{ display: "block", marginBottom: "5px" }}>
                        Kategori
                    </label>
                    <select
                        value={data.kategori}
                        onChange={(e) => setData("kategori", e.target.value)}
                        style={{ width: "100%", padding: "8px" }}
                    >
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Pengumuman">Pengumuman</option>
                        <option value="Berita Resmi">Berita Resmi</option>
                        <option value="Kegiatan">Kegiatan</option>
                    </select>
                    {errors.kategori && (
                        <small style={{ color: "red" }}>
                            {errors.kategori}
                        </small>
                    )}
                </div>

                {/* Input Tanggal Publish */}
                <div style={{ marginBottom: "15px" }}>
                    <label style={{ display: "block", marginBottom: "5px" }}>
                        Tanggal Rilis/Publish
                    </label>
                    <input
                        type="date"
                        value={data.tanggal_publish}
                        onChange={(e) =>
                            setData("tanggal_publish", e.target.value)
                        }
                        style={{ width: "100%", padding: "8px" }}
                    />
                    {errors.tanggal_publish && (
                        <small style={{ color: "red" }}>
                            {errors.tanggal_publish}
                        </small>
                    )}
                </div>

                {/* Input Konten */}
                <div style={{ marginBottom: "15px" }}>
                    <label style={{ display: "block", marginBottom: "5px" }}>
                        Isi / Konten
                    </label>
                    <textarea
                        rows="6"
                        value={data.konten}
                        onChange={(e) => setData("konten", e.target.value)}
                        style={{ width: "100%", padding: "8px" }}
                        placeholder="Tuliskan isi siaran pers..."
                    ></textarea>
                    {errors.konten && (
                        <small style={{ color: "red" }}>{errors.konten}</small>
                    )}
                </div>

                {/* Upload Lampiran / Dokumen */}
                <div style={{ marginBottom: "20px" }}>
                    <label style={{ display: "block", marginBottom: "5px" }}>
                        Lampiran (PDF/Gambar)
                    </label>
                    <input
                        type="file"
                        onChange={(e) => setData("lampiran", e.target.files[0])}
                    />
                    {errors.lampiran && (
                        <small style={{ color: "red" }}>
                            {errors.lampiran}
                        </small>
                    )}
                </div>

                {/* Tombol Simpan */}
                <button
                    type="submit"
                    disabled={processing}
                    style={{
                        padding: "10px 20px",
                        backgroundColor: "#007bff",
                        color: "#fff",
                        border: "none",
                        borderRadius: "4px",
                        cursor: "pointer",
                    }}
                >
                    {processing ? "Menyimpan..." : "Simpan Siaran Pers"}
                </button>
            </form>
        </div>
    );
}
