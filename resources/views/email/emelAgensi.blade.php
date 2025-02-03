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
    <p>1. Adalah dimaklumkan maklumat pendaftaran sistem ePantas Kementerian Perpaduan Negara adalah seperti berikut:</p>
    {{-- <p>1. &emsp;&emsp;Adalah dimaklumkan maklumat pendaftaran ePantas Kementerian Perpaduan Negara adalah seperti berikut:</p> --}}
    <table width="80%" border="0" style="border-collapse:collapse; text-align:left; margin:0px 0px 0px 40px;" cellpadding="3" >
        <tr>
            <th width="150" style="text-align:left">Mykad </th>
            <td width="500"><strong>: {{ $content['mykad'] }}</strong></td>
        </tr>
        <tr> 
            <th style="text-align:left">Nama </th>
            <td><strong>: {{ $content['name'] }} </strong></td>
        </tr>
        <tr>
            <th style="text-align:left">Emel </th>
            <td><strong>: {{ $content['emel'] }} </strong></td>
        </tr>
        <tr>
            <th style="text-align:left">Agensi </th>
            <td><strong>: {{ $content['agensi'] }} </strong></td>
        </tr>
        <tr>
            <th style="text-align:left">Bahagian </th>
            <td><strong>: {{ $content['bahagian'] }} </strong></td>
        </tr>
        <tr>
            <th style="text-align:left">Jawatan:</th>
            <td><strong>: {{ $content['jawatan'] }} </strong></td>
        </tr>
        <tr>
            <th style="text-align:left">Gred:</th>
            <td><strong>: {{ $content['gred'] }} </strong></td>
        </tr>
    </table>
    {{-- <p> &emsp;&emsp;Mykad: {{ $content['mykad'] }} </p>
    <p> &emsp;&emsp;Nama: {{ $content['name'] }} </p>
    <p> &emsp;&emsp;Emel: {{ $content['emel'] }} </p>
    <p> &emsp;&emsp;Agensi: {{ $content['agensi'] }} </p>
    <p> &emsp;&emsp;Bahagian: {{ $content['bahagian'] }} </p>
    <p> &emsp;&emsp;Jawatan: {{ $content['jawatan'] }} </p>
    <p> &emsp;&emsp;Gred: {{ $content['gred'] }} </p> --}}
    
    {{-- <p style="color: red;">2. <strong>Untuk mengesahkan dan mengaktifkan pendaftaran anda, sila klik pautan berikut: <a href="{{ url('daftar/daftarAgensi/simpan/' . $content['mykad']) }}">ePantas</a>.</strong></p> --}}
    <p style="color: red;">2. <strong>Untuk mengesahkan dan mengaktifkan pendaftaran anda, sila klik pautan berikut:</strong></p>

    <!-- Styled button -->
    <p style="text-align: left;">
        &nbsp;&nbsp;&nbsp;
        <a href="{{ url('daftar/daftarAgensi/simpan/' . $content['mykad']) }}" 
           style="display: inline-block; background-color: #007BFF; color: #ffffff; text-decoration: none; 
                  padding: 5px 10px; font-size: 12px; border-radius: 5px; font-weight: bold;">
            Pengesahan Akaun
        </a>
    </p>

    <p>3. Sebarang pertanyaan boleh diajukan kepada Pentadbir Sistem, Pegawai Seksyen Kewangan, Bahagian Kewangan dan Pembangunan, Kementerian Perpaduan Negara.</p>
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