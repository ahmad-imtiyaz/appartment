@extends('layouts.admin')

@section('content')
    <h1>Ubah {{ $doc->title }}</h1>

    <form method="POST" action="{{ route('admin.legal-documents.update', $doc) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Judul</label>
            <input id="title" type="text" name="title" value="{{ old('title', $doc->title) }}" required>
            @error('title') <p style="color:red">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="summary">Ringkasan (tampil di halaman persetujuan)</label>
            <input id="summary" type="text" name="summary" value="{{ old('summary', $doc->summary) }}">
            @error('summary') <p style="color:red">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content">Isi Dokumen</label>
            <textarea id="content" name="content" rows="22" required>{{ old('content', $doc->content) }}</textarea>
            @error('content') <p style="color:red">{{ $message }}</p> @enderror
        </div>

        <p>Versi saat ini: {{ $doc->version }} (naik otomatis jika isi berubah).</p>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.legal-documents.index') }}">Batal</a>
    </form>
@endsection
