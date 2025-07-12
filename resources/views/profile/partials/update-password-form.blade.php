<section>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Update Password</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Current Password*</label>
                        <input type="password" class="form-control input-default" name="current_password" required>
                        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                    </div>
                    <div class="form-group">
                        <label>New Password*</label>
                        <input type="password" class="form-control input-default" name="password" required>
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password*</label>
                        <input type="password" class="form-control input-default" name="password_confirmation" required>
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>


                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </form>
            </div>
        </div>

    </div>
</section>

