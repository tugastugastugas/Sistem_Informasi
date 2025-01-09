<div class="container-fluid py-4" style="margin-top: 60px;">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4" style="padding: 20px;">

                <div class="container">
                    <h1>Set Menu Permissions for {{ $userLevel }}</h1>
                    <form action="{{ route('save.permissions') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_level" value="{{ $userLevel }}">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="menus[]" value="Dashboard"
                                    {{ isset($permissions['Dashboard']) && $permissions['Dashboard'] ? 'checked' : '' }}>
                                Dashboard
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="menus[]" value="Setting"
                                    {{ isset($permissions['Setting']) && $permissions['Setting'] ? 'checked' : '' }}>
                                Setting
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="menus[]" value="pengumuman_umum"
                                    {{ isset($permissions['pengumuman_umum']) && $permissions['pengumuman_umum'] ? 'checked' : '' }}>
                                Pengumuman Umum
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="menus[]" value="pengumuman_terpilih"
                                    {{ isset($permissions['pengumuman_terpilih']) && $permissions['pengumuman_terpilih'] ? 'checked' : '' }}>
                                Pengumuman Terpilih
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="menus[]" value="Pengaturan"
                                    {{ isset($permissions['Pengaturan']) && $permissions['Pengaturan'] ? 'checked' : '' }}>
                                Pengaturan
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>