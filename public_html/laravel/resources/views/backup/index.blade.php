@extends('admin.inc.master')

@section('css')
    <style>
        .backup-form-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .backup-form-container h2 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .backup-form-container label {
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
            color: #4a5568;
        }

        .backup-form-container select {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: all 0.3s ease-in-out;
        }

        .backup-form-container select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
        }

        .backup-form-container .btn-backup {
            background-color: #16a34a;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .backup-form-container .btn-backup:hover {
            background-color: #15803d;
        }

        .backup-form-container .error-text {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="backup-form-container">
            <h2>📦 Yedekleme Sistemi</h2>
            <form action="{{ route('admin.backup.run') }}" method="POST">
                @csrf

                <label for="type">Yedekleme Türü</label>
                <select id="type" name="type" required>
                    <option value="all">{{ __('Hepsi (DB + Dosyalar)') }}</option>
                    <option value="db">{{ __('Sadece Veritabanı') }}</option>
                    <option value="uploads">{{ __('Sadece public/uploads') }}</option>
                    <option value="app">{{ __('Sadece app klasörü') }}</option>
                    <option value="views">{{ __('Sadece resources/views') }}</option>
                    <option value="routes">{{ __('Sadece routes') }}</option>
                </select>
                @error('type')
                <p class="error-text">{{ $message }}</p>
                @enderror

                <div class="mt-4">
                    <button type="submit" class="btn-backup">
                        🚀 Yedekle
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
