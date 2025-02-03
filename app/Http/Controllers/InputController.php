<?php

namespace App\Http\Controllers;

use App\DasarSemasa;
use App\JustifikasiPermohonan;
use App\LatarBelakang;
use App\Tujuan;
use App\UlasanBahagian;
use Illuminate\Http\Request;

class InputController extends Controller
{

    // TUJUAN
        public function tujuan_index($idMaklumatPermohonan) // Accept idMaklumatPermohonan as a parameter
        {
            // Retrieve only the tujuan records that match the idMaklumatPermohonan
            $tujuans = Tujuan::where('idMaklumatPermohonan', $idMaklumatPermohonan)->get();
            return response()->json($tujuans);
        }

        public function tujuan_store(Request $request)
        {
            $request->validate([
                'tujuan' => 'required|string',
                'idMaklumatPermohonan' => 'required|integer', // Validate idMaklumatPermohonan
            ]);

            // Create the new Tujuan record and associate it with idMaklumatPermohonan
            $tujuan = Tujuan::create([
                'tujuan' => $request->tujuan,
                'idMaklumatPermohonan' => $request->idMaklumatPermohonan, // Save idMaklumatPermohonan
            ]);

            return response()->json($tujuan);
        }

        public function tujuan_update(Request $request, $id)
        {
            $request->validate([
                'tujuan' => 'required|string',
            ]);

            // Check if the record exists before trying to update
            $tujuan = Tujuan::find($id);
            if (!$tujuan) {
                return response()->json(['message' => 'Tujuan not found'], 404);
            }

            $tujuan->update($request->only('tujuan'));
            return response()->json($tujuan);
        }

        public function tujuan_destroy($id)
        {
            $tujuan = Tujuan::findOrFail($id);
            $tujuan->delete();

            return response()->json(['message' => 'Tujuan deleted successfully']);
        }

        public function tujuan_show($id)
        {
            // Find the tujuan by ID
            $tujuan = Tujuan::find($id);
            
            if (!$tujuan) {
                return response()->json(['message' => 'Tujuan not found'], 404); // Handle not found
            }

            return response()->json($tujuan); // Return the found tujuan
        }
    // TUJUAN

    // LATAR BELAKANG
        public function latar_index($idMaklumatPermohonan) // Accept idMaklumatPermohonan as a parameter
        {
            // Retrieve only the tujuan records that match the idMaklumatPermohonan
            $latarBelakang = LatarBelakang::where('idMaklumatPermohonan', $idMaklumatPermohonan)->get();
            return response()->json($latarBelakang);
        }

        public function latar_store(Request $request)
        {
            $request->validate([
                'latarBelakang' => 'required|string',
                'idMaklumatPermohonan' => 'required|integer', // Validate idMaklumatPermohonan
            ]);

            // Create the new Tujuan record and associate it with idMaklumatPermohonan
            $latarBelakang = LatarBelakang::create([
                'latarBelakang' => $request->latarBelakang,
                'idMaklumatPermohonan' => $request->idMaklumatPermohonan, // Save idMaklumatPermohonan
            ]);

            return response()->json($latarBelakang);
        }

        public function latar_update(Request $request, $id)
        {
            $request->validate([
                'latarBelakang' => 'required|string',
            ]);

            // Check if the record exists before trying to update
            $latarBelakang = LatarBelakang::find($id);
            if (!$latarBelakang) {
                return response()->json(['message' => 'Latar Belakang not found'], 404);
            }

            $latarBelakang->update($request->only('latarBelakang'));
            return response()->json($latarBelakang);
        }

        public function latar_destroy($id)
        {
            $latarBelakang = LatarBelakang::findOrFail($id);
            $latarBelakang->delete();

            return response()->json(['message' => 'Latar Belakang deleted successfully']);
        }

        public function latar_show($id)
        {
            // Find the latarBelakang by ID
            $latarBelakang = LatarBelakang::find($id);
            
            if (!$latarBelakang) {
                return response()->json(['message' => 'Latar Belakang not found'], 404); // Handle not found
            }

            return response()->json($latarBelakang); // Return the found latarBelakang
        }
    // LATAR BELAKANG

    // DASAR SEMASA
        public function dasar_index($idMaklumatPermohonan) // Accept idMaklumatPermohonan as a parameter
        {
            // Retrieve only the tujuan records that match the idMaklumatPermohonan
            $dasarSemasas = DasarSemasa::where('idMaklumatPermohonan', $idMaklumatPermohonan)->get();
            return response()->json($dasarSemasas);
        }

        public function dasar_store(Request $request)
        {
            $request->validate([
                'dasarSemasa' => 'required|string',
                'idMaklumatPermohonan' => 'required|integer', // Validate idMaklumatPermohonan
            ]);

            // Create the new dasarSemasa record and associate it with idMaklumatPermohonan
            $dasarSemasa = DasarSemasa::create([
                'dasarSemasa' => $request->dasarSemasa,
                'idMaklumatPermohonan' => $request->idMaklumatPermohonan, // Save idMaklumatPermohonan
            ]);

            return response()->json($dasarSemasa);
        }

        public function dasar_update(Request $request, $id)
        {
            $request->validate([
                'dasarSemasa' => 'required|string',
            ]);

            // Check if the record exists before trying to update
            $dasarSemasa = DasarSemasa::find($id);
            if (!$dasarSemasa) {
                return response()->json(['message' => 'dasarSemasa not found'], 404);
            }

            $dasarSemasa->update($request->only('dasarSemasa'));
            return response()->json($dasarSemasa);
        }

        public function dasar_destroy($id)
        {
            $dasarSemasa = DasarSemasa::findOrFail($id);
            $dasarSemasa->delete();

            return response()->json(['message' => 'dasarSemasa deleted successfully']);
        }

        public function dasar_show($id)
        {
            // Find the dasarSemasa by ID
            $dasarSemasa = DasarSemasa::find($id);
            
            if (!$dasarSemasa) {
                return response()->json(['message' => 'dasarSemasa not found'], 404); // Handle not found
            }

            return response()->json($dasarSemasa); // Return the found dasarSemasa
        }
    // DASAR SEMASA

    // JUSTIFIKASI
        public function justifikasi_index($idMaklumatPermohonan) // Accept idMaklumatPermohonan as a parameter
        {
            // Retrieve only the justifikasi records that match the idMaklumatPermohonan
            $justifikasis = JustifikasiPermohonan::where('idMaklumatPermohonan', $idMaklumatPermohonan)->get();
            return response()->json($justifikasis);
        }

        public function justifikasi_store(Request $request)
        {
            $request->validate([
                'justifikasiPermohonan' => 'required|string',
                'idMaklumatPermohonan' => 'required|integer', // Validate idMaklumatPermohonan
            ]);

            // Create the new Tujuan record and associate it with idMaklumatPermohonan
            $justifikasiPermohonan = JustifikasiPermohonan::create([
                'justifikasiPermohonan' => $request->justifikasiPermohonan,
                'idMaklumatPermohonan' => $request->idMaklumatPermohonan, // Save idMaklumatPermohonan
            ]);

            return response()->json($justifikasiPermohonan);
        }

        public function justifikasi_update(Request $request, $id)
        {
            $request->validate([
                'justifikasiPermohonan' => 'required|string',
            ]);

            // Check if the record exists before trying to update
            $justifikasiPermohonan = JustifikasiPermohonan::find($id);
            if (!$justifikasiPermohonan) {
                return response()->json(['message' => 'justifikasiPermohonan not found'], 404);
            }

            $justifikasiPermohonan->update($request->only('justifikasiPermohonan'));
            return response()->json($justifikasiPermohonan);
        }

        public function justifikasi_destroy($id)
        {
            $justifikasiPermohonan = JustifikasiPermohonan::findOrFail($id);
            $justifikasiPermohonan->delete();

            return response()->json(['message' => 'justifikasiPermohonan deleted successfully']);
        }

        public function justifikasi_show($id)
        {
            // Find the tujuan by ID
            $justifikasiPermohonan = JustifikasiPermohonan::find($id);
            
            if (!$justifikasiPermohonan) {
                return response()->json(['message' => 'Tujuan not found'], 404); // Handle not found
            }

            return response()->json($justifikasiPermohonan); // Return the found tujuan
        }
    // JUSTIFIKASI

    // ULASAN
        public function ulasan_index($idMaklumatPermohonan) // Accept idMaklumatPermohonan as a parameter
        {
            // Retrieve only the tujuan records that match the idMaklumatPermohonan
            $ulasanBahagians = UlasanBahagian::where('idMaklumatPermohonan', $idMaklumatPermohonan)->get();
            return response()->json($ulasanBahagians);
        }

        public function ulasan_store(Request $request)
        {
            $request->validate([
                'ulasanBahagian' => 'required|string',
                'idMaklumatPermohonan' => 'required|integer', // Validate idMaklumatPermohonan
            ]);

            // Create the new Tujuan record and associate it with idMaklumatPermohonan
            $ulasanBahagian = UlasanBahagian::create([
                'ulasanBahagian' => $request->ulasanBahagian,
                'idMaklumatPermohonan' => $request->idMaklumatPermohonan, // Save idMaklumatPermohonan
            ]);

            return response()->json($ulasanBahagian);
        }

        public function ulasan_update(Request $request, $id)
        {
            $request->validate([
                'ulasanBahagian' => 'required|string',
            ]);

            // Check if the record exists before trying to update
            $ulasanBahagian = UlasanBahagian::find($id);
            if (!$ulasanBahagian) {
                return response()->json(['message' => 'ulasanBahagian not found'], 404);
            }

            $ulasanBahagian->update($request->only('ulasanBahagian'));
            return response()->json($ulasanBahagian);
        }

        public function ulasan_destroy($id)
        {
            $ulasanBahagian = UlasanBahagian::findOrFail($id);
            $ulasanBahagian->delete();

            return response()->json(['message' => 'ulasanBahagian deleted successfully']);
        }

        public function ulasan_show($id)
        {
            // Find the tujuan by ID
            $ulasanBahagian = UlasanBahagian::find($id);
            
            if (!$ulasanBahagian) {
                return response()->json(['message' => 'ulasanBahagian not found'], 404); // Handle not found
            }

            return response()->json($ulasanBahagian); // Return the found tujuan
        }
    // ULASAN
    
}

