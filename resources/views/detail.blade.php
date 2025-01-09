<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Detail User</h4>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('update.user') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Nama User</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="username" value="{{ $user->username }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email User</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="email" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">NoHp User</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="no_hp" value="{{ $user->no_hp }}">
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select class="form-control" id="level" name="level" required>
                    <option value="{{ $user->level }}">{{ $user->level }}</option>
                    <option value="Kepsek">Kepsek</option>
                    <option value="Wakil">Wakil</option>
                    <option value="Guru">Guru</option>
                </select>
            </div>
            <input type="hidden" name="id" value="{{ $user->id_user }}">

            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="submit" class="btn btn-danger">cancel</button>
        </form>
    </div>
</div>