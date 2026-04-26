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

  /* ACCOUNT SETTINGS SIDEBAR */
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
    color: #2563eb;
    font-weight: 500;
    background: #eff6ff;
    border-right-color: #2563eb;
  }

  .account-nav-item.danger {
    color: #ef4444;
    margin-top: 8px;
  }

  .account-nav-item.danger:hover {
    background: #fef2f2;
  }

  /* MAIN PROFILE CONTENT */
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
    color: #2563eb;
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

  .btn-edit:hover { background: #eff6ff; color: #2563eb; }
  .btn-edit svg { width: 13px; height: 13px; }

  /* AVATAR ROW */
  .avatar-row {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .avatar-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #60a5fa 0%, #818cf8 100%);
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

  /* FIELDS GRID */
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

  /* SUCCESS ALERT */
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

  {{-- ACCOUNT SETTINGS SIDEBAR --}}
  <aside class="account-sidebar">
    <div class="account-sidebar-title">Account Settings</div>

    <a href="{{ route('profile') }}"
       class="account-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
      My Profile
    </a>

    <a href="{{ route('profile.security') }}"
       class="account-nav-item {{ request()->routeIs('profile.security') ? 'active' : '' }}">
      Security
    </a>

    <a href="{{ route('profile.teams') }}"
       class="account-nav-item {{ request()->routeIs('profile.teams') ? 'active' : '' }}">
      Teams
    </a>

    <a href="{{ route('profile.team-member') }}"
       class="account-nav-item {{ request()->routeIs('profile.team-member') ? 'active' : '' }}">
      Team Member
    </a>

    <a href="{{ route('profile.notifications') }}"
       class="account-nav-item {{ request()->routeIs('profile.notifications') ? 'active' : '' }}">
      Notifications
    </a>

    <a href="{{ route('profile.billing') }}"
       class="account-nav-item {{ request()->routeIs('profile.billing') ? 'active' : '' }}">
      Billing
    </a>

    <a href="{{ route('profile.data-export') }}"
       class="account-nav-item {{ request()->routeIs('profile.data-export') ? 'active' : '' }}">
      Data Export
    </a>

    <a href="{{ route('profile.delete') }}"
       class="account-nav-item danger {{ request()->routeIs('profile.delete') ? 'active' : '' }}">
      Delete Account
    </a>
  </aside>

  {{-- MAIN CONTENT --}}
  <div class="profile-main">
    <h2 class="profile-section-title">My Profile</h2>

    {{-- Profile Card --}}
    <div class="profile-card">
      <div class="profile-card-header">
        <span class="profile-card-title">My Profile</span>
        <a href="{{ route('profile.edit') }}" class="btn-edit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Edit
        </a>
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

    {{-- Personal Information Card --}}
    <div class="profile-card">
      <div class="profile-card-header">
        <span class="profile-card-title">Personal Information</span>
        <a href="{{ route('profile.edit') }}" class="btn-edit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Edit
        </a>
      </div>
      <div class="fields-grid">
        <div>
          <div class="field-label">First Name</div>
          <div class="field-value">{{ explode(' ', auth()->user()->name)[0] }}</div>
        </div>
        <div>
          <div class="field-label">Last Name</div>
          <div class="field-value">{{ explode(' ', auth()->user()->name)[1] ?? '-' }}</div>
        </div>
        <div>
          <div class="field-label">Email Address</div>
          <div class="field-value">{{ auth()->user()->email }}</div>
        </div>
        <div>
          <div class="field-label">Phone</div>
          <div class="field-value">{{ auth()->user()->phone ?? '-' }}</div>
        </div>
        <div class="field-full">
          <div class="field-label">Bio</div>
          <div class="field-value">{{ auth()->user()->bio ?? '-' }}</div>
        </div>
      </div>
    </div>

    {{-- Address Card --}}
    <div class="profile-card">
      <div class="profile-card-header">
        <span class="profile-card-title">Address</span>
        <a href="{{ route('profile.edit') }}" class="btn-edit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Edit
        </a>
      </div>
      <div class="fields-grid">
        <div>
          <div class="field-label">Country</div>
          <div class="field-value">{{ auth()->user()->country ?? '-' }}</div>
        </div>
        <div>
          <div class="field-label">City/State</div>
          <div class="field-value">{{ auth()->user()->city ?? '-' }}</div>
        </div>
        <div>
          <div class="field-label">Postal Code</div>
          <div class="field-value">{{ auth()->user()->postal_code ?? '-' }}</div>
        </div>
        <div>
          <div class="field-label">TAX ID</div>
          <div class="field-value">{{ auth()->user()->tax_id ?? '-' }}</div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
@endsection