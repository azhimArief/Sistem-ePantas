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
    <title>Emel kepada Pemohon</title>
</head>
<body>
    <p>Assalamualaikum dan Salam Perpaduan.<p>

    <p>YBhg. Datuk/Dato'/ YBrs. Dr/Tuan/Puan,</p>

    <h3>Set Semula Kata Laluan Akaun ePantas</h3>

    <justify>
    {{-- <p>1. Untuk menetapkan semula kata laluan anda, sila klik pautan berikut: <a href="{{ url('/reset/password/' . $content) }}">ePantas</a>.</p> --}}

    <p>1. Untuk menetapkan semula kata laluan anda, sila klik pautan berikut:</p>

    <!-- Styled button -->
    <p style="text-align: left;">
        &nbsp;&nbsp;&nbsp;
        <a href="{{ url('/reset/password/' . $content) }}" 
           style="display: inline-block; background-color: #007BFF; color: #ffffff; text-decoration: none; 
                  padding: 5px 10px; font-size: 12px; border-radius: 5px; font-weight: bold;">
            Reset Kata Laluan
        </a>
    </p>
    
    <p>2. Sebarang pertanyaan boleh diajukan kepada Pentadbir Sistem, Pegawai Seksyen Kewangan, Bahagian Kewangan dan Pembangunan, Kementerian Perpaduan Negara.</p>
    {{-- <p>2. &emsp;&emsp;Sebarang pertanyaan boleh dikemukakan kepada Pegawai Seksyen Pembangunan Dan Penyelenggaraan Sistem, Bahagian Pengurusan Maklumat.</p> --}}
    </justify>
     {{-- <p>&emsp;&emsp;&emsp; Nama : Test --}}
    {{-- <br>&emsp;&emsp;&emsp; Tel : 03-000000000 --}}
    {{-- <br>&emsp;&emsp;&emsp; E-mel : test@perpaduan.gov.my </p> --}}

    <p>Sekian, terima kasih.</p><br>
    <p><b> "MALAYSIA MADANI" </b></p>
    <p><b> "BERKHIDMAT UNTUK NEGARA" </b></p>
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