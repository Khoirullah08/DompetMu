@extends('layouts.layout')

@section('header', 'Edit Profil')
@section('subheader', 'Perbarui informasi profil mu.')

@section('styles')
<style>
  .profile-wrapper {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding: 32px;
  }

  .account-sidebar {
    width: 220px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px 0;
    flex-shrink: 0;
  }

  .account-sidebar-title {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    padding: 0 20px 16px;
    border-bottom: 1px solid #f0f1f5;
    margin-bottom: 8px;
  }

  .account-nav-item {
    display: block;
    width: 100%;
    padding: 9px 20px;
    font-size: 13.5px;
    color: #6b7280;
    background: none;
    border: none;
    border-right: 3px solid transparent;
    text-align: left;
    cursor: pointer;
    font-family: inherit;
    text-decoration: none;
    transition: all 0.15s ease;
  }

  .account-nav-item:hover { color: #374151; background: #f9fafb; }

  .account-nav-item.active {
    color: #0D7F6A;
    font-weight: 500;
    background: #ecfdf5;
    border-right-color: #0D7F6A;
  }

  .profile-main { flex: 1; min-width: 0; }

  .profile-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 16px;
  }

  .profile-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .profile-card-title { font-size: 14px; font-weight: 600; color: #111827; }

  .fields-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 24px;
  }

  .field-full { grid-column: 1 / -1; }

  .field-label {
    font-size: 10.5px;
    color: #9ca3af;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 6px;
  }

  .form-input {
    width: 100%;
    padding: 8px 12px;
    font-size: 13.5px;
    color: #374151;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-family: inherit;
    background: #f9fafb;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
  }

  .form-input:focus {
    outline: none;
    border-color: #0D7F6A;
    box-shadow: 0 0 0 3px rgba(13, 127, 106, 0.1);
    background: #fff;
  }

  .form-input.is-invalid { border-color: #ef4444; }

  textarea.form-input { resize: vertical; min-height: 72px; }

  .invalid-feedback {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
  }

  .form-actions {
    display: flex;
    gap: 8px;
    margin-top: 20px;
    justify-content: flex-end;
  }

  .btn-save {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 500;
    color: #fff;
    background: #0D7F6A;
    border: none;
    cursor: pointer;
    padding: 7px 16px;
    border-radius: 7px;
    font-family: inherit;
    transition: background 0.15s;
  }

  .btn-save:hover { background: #0a6357; }

  .btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
    background: none;
    border: 1px solid #d1d5db;
    cursor: pointer;
    padding: 7px 16px;
    border-radius: 7px;
    font-family: inherit;
    text-decoration: none;
    transition: all 0.15s;
  }

  .btn-cancel:hover { background: #f9fafb; color: #374151; }
</style>
@endsection

@section('content')
<div class="profile-wrapper">

  <aside class="account-sidebar">
    <div class="account-sidebar-title">Account Settings</div>
    <a href="{{ route('profile') }}"
       class="account-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
      My Profile
    </a>
  </aside>

  <div class="profile-main">
    <div class="profile-card">
      <div class="profile-card-header">
        <span class="profile-card-title">Edit Personal Information</span>
      </div>

      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="fields-grid">

          <div>
            <div class="field-label">Nama</div>
            <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
              value="{{ old('name', auth()->user()->name) }}" placeholder="Nama lengkap">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <div class="field-label">Alamat</div>
            <input type="text" name="alamat" class="form-input @error('alamat') is-invalid @enderror"
              value="{{ old('alamat', auth()->user()->alamat) }}" placeholder="Alamat">
            @error('alamat')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <div class="field-label">Email</div>
            <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
              value="{{ old('email', auth()->user()->email) }}" placeholder="Email">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <div class="field-label">No Telpon</div>
            <input type="text" name="phone" class="form-input @error('phone') is-invalid @enderror"
              value="{{ old('phone', auth()->user()->phone) }}" placeholder="No Telpon">
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="field-full">
            <div class="field-label">Bio</div>
            <textarea name="bio" class="form-input @error('bio') is-invalid @enderror"
              placeholder="Ceritakan tentang dirimu">{{ old('bio', auth()->user()->bio) }}</textarea>
            @error('bio')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

        </div>

        <div class="form-actions">
          <a href="{{ route('profile') }}" class="btn-cancel">Batal</a>
          <button type="submit" class="btn-save">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
            Simpan Perubahan
          </button>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection