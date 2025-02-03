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
    <title>Emel kepada Pendaftar</title>
</head>
<body>
    <p>Assalamualaikum dan Salam Perpaduan.<p>

    <p>YBhg. Datuk/Dato'/ YBrs. Dr/Tuan/Puan,</p>

    <h3>Pendaftaran Akaun ePantas</h3>

    <justify>
    <p>1. Adalah dimaklumkan maklumat pendaftaran Sistem ePantas Kementerian Perpaduan Negara adalah seperti berikut:</p>
    {{-- <p> &emsp;&emsp;Mykad: {{ $content['id_pengguna'] }} </p>
    <p> &emsp;&emsp;Nama: {{ $content['nama'] }} </p>
    <p> &emsp;&emsp;Emel: {{ $content['email'] }} </p>
    <p> &emsp;&emsp;Agensi: {{ $content['agensi'] }} </p>
    <p> &emsp;&emsp;Bahagian: {{ $content['bahagian'] }} </p>
    <p> &emsp;&emsp;Jawatan: {{ $content['jawatan'] }} </p>
    <p> &emsp;&emsp;Gred: {{ $content['gred'] }} </p> --}}

    <table width="80%" border="0" style="border-collapse:collapse; text-align:left; margin:0px 0px 0px 40px;" cellpadding="3" >
        {{-- <tr>
            <th width="150" style="text-align:left">Mykad </th>
            <td width="500"><strong>: {{ $content['name'] }}</strong></td>
        </tr> --}}
        <tr>
            <th style="text-align:left">ID Pengguna </th>
            <td><strong>: {{ $content['id_pengguna'] }} </strong></td>
        </tr>
        <tr>
            <th style="text-align:left">Kata Laluan </th>
            <td><strong>: {{ $content['kata_laluan'] }} </strong></td>
        </tr>
    </table>
    
    <p style="color: red;">2. <strong>Sila pastikan anda menukar kata laluan di profil sistem sebagai langkah keselamatan. Ini penting untuk memastikan keselamatan akaun dan maklumat Kementerian Perpaduan Negara.</strong> </p>

    <p>3. Sila klik pautan berikut untuk log masuk: <a href="{{ url('/') }}">ePantas</a>.</p>

    <p>4. Sebarang pertanyaan boleh diajukan kepada Pentadbir Sistem, Bahagian Kewangan dan Pembangunan, Kementerian Perpaduan Negara.</p>
    {{-- <p>2. &emsp;&emsp;Sebarang pertanyaan boleh dikemukakan kepada Pegawai Seksyen Pembangunan Dan Penyelenggaraan Sistem seperti berikut:</p> --}}
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