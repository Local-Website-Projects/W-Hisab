<section>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Update Profile Information</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" class="form-control input-default" name="name" value="{{ old('name', $user->name) }}" required>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </form>
            </div>
        </div>

    </div>
</section>
