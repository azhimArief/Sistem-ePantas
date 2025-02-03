<!DOCTYPE html>
<html>
<style>
    body {
        font-family: "Arial", sans-serif;
        color: black;
        font-size:14px;
        text-align: justify;
    }
</style>
<head>
    <title>NOTIFIKASI PERMOHONAN BARU EPANTAS</title>
</head>
<body>
    <p>Assalamualaikum dan Salam Perpaduan.<p>

    <p>YBhg. Datuk/Dato'/ YBrs. Dr/Tuan/Puan,</p>

    <h3 style="text-transform: uppercase">NOTIFIKASI PERMOHONAN BARU</h3>

    <p>Dengan segala hormatnya, perkara di atas adalah dirujuk.</p>

    <justify>
    
        <p>
            2. &emsp;Dimaklumkan bahawa terdapat permohonan baru yang memerlukan tindakan daripada pihak YBhg. Dato’/ Datuk/ Datin/ Tuan/ Puan . Butiran permohonan adalah seperti berikut:
        </p>

        <p> 
            {{-- &emsp;&emsp;&emsp; Kod Permohonan: {{ $contentEmel->kod_permohonan }}
            <br>&emsp;&emsp;&emsp; Nama Permohonan: {{ $contentEmel->namaProgram }}
            <br>&emsp;&emsp;&emsp; Jumlah Anggaran Kos : RM{{ number_format($contentEmel->kosMohon, 2) }}
            <br>&emsp;&emsp;&emsp; Status Permohonan : <b>{{ ($contentEmel->id_status) ? optional(\App\LkpStatus::find($contentEmel->id_status))->status : '' }}</b> --}}
            <table width="80%" border="0" style="border-collapse:collapse; text-align:left; margin:0px 0px 0px 40px;" cellpadding="3" >
                <tr>
                    <th width="150" style="text-align:left">Kod Permohonan</th>
                    <td width="500"><strong>: {{ $contentEmel->kod_permohonan }}</strong></td>
                </tr>
                <tr>
                    <th style="text-align:left">Nama Permohonan</th>
                    <td><strong>: {{ $contentEmel->namaProgram }} </strong></td>
                </tr>
                <tr>
                    <th style="text-align:left">Jumlah Kos Mohon</th>
                    <td><strong>: RM{{ number_format($contentEmel->kosMohon, 2) }} </strong></td>
                </tr>
                <tr>
                    <th style="text-align:left">Status Permohonan</th>
                    <td><strong>: {{ ($contentEmel->id_status) ? optional(\App\LkpStatus::find($contentEmel->id_status))->status : '' }} </strong></td>
                </tr>
            </table>
        </p>

        <p>
            3. &emsp;Butiran permohonan boleh didapati di 
            <a href="{{ url('/peruntukan/butiran/' . $contentEmel->idMaklumatPermohonan) }}">ePantas</a>.
        </p>

        <p>4. &emsp;Kerjasama pihak YBhg. Dato’/ Datuk/ Datin/ Tuan/ Puan amatlah dihargai.</p>

    </justify>

    <p>Sekian, terima kasih.</p><br>
    <p><b> "MALAYSIA MADANI" </b></p>
    <p><b> "BERKHIDMAT UNTUK NEGARA" </b></p>

    <p>
        <h7>{{ $contentEmel->namaPemohon }}
        <br> {{ $contentEmel->jawatanPemohon }}
        <br> {{ $contentEmel->namaBahagian }}
        <br> {{ $contentEmel->agensi }}
        {{-- <br> Kementerian Perpaduan Negara --}}
        <br>
        {{-- <br>Tel: +603-8091 8000 --}}
        {{-- <br>E-mel:  -@perpaduan.gov.my --}}
        </h7>
    </p>
    {{-- <p>
        <h7>Cawangan Keurusetiaan
        <br> Seksyen Pentadbiran dan Aset
        <br> Bahagian Khidmat Pengurusan
        <br> Kementerian Perpaduan Negara
        <br>
        <br>Tel: 03-809 18119 / 18141
        <br>E-mel: norainiyasin@perpaduan.gov.my / idham@perpaduan.gov.my
        </h7>
    </p> --}}
    <p></p>
    <p><i>** E-mel ini dijana oleh sistem ePantas dan tidak perlu dibalas. **</i></p>
</body>
</html>