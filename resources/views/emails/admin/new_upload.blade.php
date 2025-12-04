<!DOCTYPE html>
<html>
<head>
    <title>Neuer Upload</title>
</head>
<body>
    <h1>Neuer Datei-Upload</h1>
    <p>Der Benutzer <strong>{{ $upload->user->name }}</strong> ({{ $upload->user->email }}) hat eine neue Datei hochgeladen.</p>
    
    <ul>
        <li><strong>Dateiname:</strong> {{ $upload->original_name }}</li>
        <li><strong>Größe:</strong> {{ \Illuminate\Support\Number::fileSize(Storage::disk('public')->size($upload->file_path)) }}</li>
        <li><strong>Zeitpunkt:</strong> {{ $upload->created_at->format('d.m.Y H:i') }}</li>
    </ul>

    <p>
        <a href="{{ Storage::url($upload->file_path) }}">Datei herunterladen</a>
    </p>
</body>
</html>

