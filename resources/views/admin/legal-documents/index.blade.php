@extends('layouts.admin')

@section('content')
    <h1>Syarat dan Ketentuan &amp; Kebijakan Privasi</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Dokumen</th>
                <th>Versi</th>
                <th>Terakhir Diperbarui</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $doc)
                <tr>
                    <td>{{ $doc->title }}</td>
                    <td>{{ $doc->version }}</td>
                    <td>{{ $doc->updated_at->translatedFormat('d F Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.legal-documents.edit', $doc) }}">Ubah</a>
                        &middot;
                        <a href="{{ $doc->type === 'terms' ? route('legal.terms') : route('legal.privacy') }}" target="_blank">Lihat</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
