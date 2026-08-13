@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="edit-user-page">

    <div class="edit-user-header">
        <h1>Edit Pengguna</h1>
        <p>Perbarui informasi dan hak akses pengguna.</p>
    </div>

    <div class="edit-user-card">

        <form>

            <div class="form-group">
                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="admin"
                    placeholder="Masukkan username">
            </div>


            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="admin@example.com"
                    placeholder="Masukkan email">
            </div>


            <div class="form-group">
                <label for="role">Role</label>

                <select id="role" name="role">

                    <option value="admin" selected>
                        Admin
                    </option>

                    <option value="kasir">
                        Kasir
                    </option>

                    <option value="user">
                        User
                    </option>

                </select>
            </div>


            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status">

                    <option value="aktif" selected>
                        Aktif
                    </option>

                    <option value="nonaktif">
                        Nonaktif
                    </option>

                </select>
            </div>


            <div class="form-actions">

                <a
                    href="{{ route('admin.pengguna') }}"
                    class="btn-cancel-user">
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-save-user">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection