<!DOCTYPE html>
<html>
<head>
    <title>Pengumuman</title>
</head>
<body>
    <h1>{{ $data['judul'] }}</h1>
    <p>{{ $data['isi'] }}</p>

    @if(isset($data['file']))
        <p>File Pengumuman: <a href="{{ $data['file'] }}">Download</a></p>
    @endif
</body>
</html>