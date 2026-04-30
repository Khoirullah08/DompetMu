@extends('layouts.layout')

@section('header', 'Profil Mu')
@section('subheader', 'Kelola profil mu.')

@section('styles')
<style>
  .profile-wrapper {
    display: flex;
    gap: 24px;
    align-items: flex-start;
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

  .account-nav-item:hover {
    color: #374151;
    background: #f9fafb;
  }

  .account-nav-item.active {
    color: #0D7F6A;
    font-weight: 500;
    background: #eff6ff;
    border-right-color: #0D7F6A;
  }

  .account-nav-item.danger {
    color: #ef4444;
    margin-top: 8px;
  }

  .account-nav-item.danger:hover {
    background: #fef2f2;
  }

  .profile-main {
    flex: 1;
    min-width: 0;
  }

  .profile-section-title {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 16px;
  }

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

  .profile-card-title {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
  }

  .btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #0D7F6A;
    font-weight: 500;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 6px;
    font-family: inherit;
    text-decoration: none;
    transition: background 0.15s;
  }

  .btn-edit:hover { background: #eff6ff; color: #0D7F6A; }
  .btn-edit svg { width: 13px; height: 13px; }

  .avatar-row {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .avatar-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #34d399 0%, #0D7F6A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
    letter-spacing: -0.5px;
  }

  .avatar-name {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
  }

  .avatar-role {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 3px;
  }

  .avatar-location {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: #9ca3af;
  }

  .avatar-location svg { width: 12px; height: 12px; }

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
    margin-bottom: 4px;
  }

  .field-value {
    font-size: 13.5px;
    color: #374151;
  }

  .alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13.5px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .edit-form {
    display: none;
  }

  .edit-form.active {
    display: block;
  }

  .view-mode.hidden {
    display: none;
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
    border-color: #3B9788;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    background: #fff;
  }

  textarea.form-input {
    resize: vertical;
    min-height: 72px;
  }

  .form-actions {
    display: flex;
    gap: 8px;
    margin-top: 16px;
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

  .btn-save:hover { background: #227264; }

  .btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
    background: none;
    border: 1px solid #A7B3C4;
    cursor: pointer;
    padding: 7px 16px;
    border-radius: 7px;
    font-family: inherit;
    transition: all 0.15s;
  }

  .btn-cancel:hover { background: #f9fafb; color: #374151; }
</style>
@endsection

@section('content')

@if(session('success'))
  <div class="alert-success">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="20 6 9 17 4 12"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

<div class="profile-wrapper">

  <aside class="account-sidebar">
    <div class="account-sidebar-title">Account Settings</div>

    <a href="{{ route('profile') }}"
       class="account-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
      My Profile
    </a>
  </aside>

  <div class="profile-main">
    <div class="profile-card">
      <div class="profile-card-header">
        <span class="profile-card-title">My Profile</span>
      </div>
      <div class="avatar-row">

        <div class="avatar-circle">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name, ' '), 1, 1)) }}
        </div>
        <div>
          <div class="avatar-name">{{ auth()->user()->name }}</div>
          <div class="avatar-role">{{ auth()->user()->role ?? 'User' }}</div>
          <div class="avatar-location">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            {{ auth()->user()->city ?? '-' }}, {{ auth()->user()->country ?? '-' }}
          </div>
        </div>
      </div>
    </div>

    <div class="profile-card">
      <div class="profile-card-header">
        <span class="profile-card-title">Personal Information</span>
        <button type="button" class="btn-edit" onclick="toggleEdit('personal')">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Edit
        </button>
      </div>

      <div id="personal-view" class="view-mode">
        <div class="fields-grid">
          <div>
            <div class="field-label">Nama</div>
            <div class="field-value" id="display-firstname">{{ explode(' ', auth()->user()->name)[0] }}</div>
          </div>
          <div>
            <div class="field-label">Alamat</div>
            <div class="field-value" id="display-lastname">{{ explode(' ', auth()->user()->name)[1] ?? '-' }}</div>
          </div>
          <div>
            <div class="field-label">Email</div>
            <div class="field-value" id="display-email">{{ auth()->user()->email }}</div>
          </div>
          <div>
            <div class="field-label">No Telpon</div>
            <div class="field-value" id="display-phone">{{ auth()->user()->phone ?? '-' }}</div>
          </div>
          <div class="field-full">
            <div class="field-label">Bio</div>
            <div class="field-value" id="display-bio">{{ auth()->user()->bio ?? '-' }}</div>
          </div>
        </div>
      </div>

      <div id="personal-edit" class="edit-form">
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="section" value="personal">
          <div class="fields-grid">
            <div>
              <div class="field-label">Nama</div>
              <input type="text" name="first_name" class="form-input"
                value="{{ explode(' ', auth()->user()->name)[0] }}" placeholder="Nama">
            </div>
            <div>
              <div class="field-label">Alamat</div>
              <input type="text" name="last_name" class="form-input"
                value="{{ explode(' ', auth()->user()->alamat)[1] ?? '' }}" placeholder="Alamat">
            </div>
            <div>
              <div class="field-label">Email</div>
              <input type="email" name="email" class="form-input"
                value="{{ auth()->user()->email }}" placeholder="Email">
            </div>
            <div>
              <div class="field-label">No Telpon</div>
              <input type="text" name="phone" class="form-input"
                value="{{ auth()->user()->phone ?? '' }}" placeholder="No Telpon">
            </div>
            <div class="field-full">
              <div class="field-label">Bio</div>
              <textarea name="bio" class="form-input" placeholder="Tell us about yourself">{{ auth()->user()->bio ?? '' }}</textarea>
            </div>
          </div>
          <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="cancelEdit('personal')">Cancel</button>
            <button type="submit" class="btn-save">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  function toggleEdit(section) {
    const view = document.getElementById(section + '-view');
    const edit = document.getElementById(section + '-edit');
    view.classList.add('hidden');
    edit.classList.add('active');
  }

  function cancelEdit(section) {
    const view = document.getElementById(section + '-view');
    const edit = document.getElementById(section + '-edit');
    view.classList.remove('hidden');
    edit.classList.remove('active');
  }
</script>
@endsection