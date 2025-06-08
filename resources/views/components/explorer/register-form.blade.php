       <!-- Fixed Registration Form (Right Side) -->
            <div class="col-lg-5 position-fixed end-0 top-0 vh-100 overflow-y-auto bg-light border-start" style="width: 41.666667%; padding: 2rem;">
                <div class="px-lg-4">
                    <h2 class="mb-4">Join Our Community</h2>
                    <form action="{{ route('register') }}" method="POST" id="registration-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="username-register" class="text-muted mb-1"><small>Username</small></label>
                            <input name="username" value="{{ old('username') }}" id="username-register" class="form-control" type="text" placeholder="Pick a username" autocomplete="off" />
                            @error('username')
                                <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
                            <input name="email" value="{{ old('email') }}" id="email-register" class="form-control" type="text" placeholder="you@example.com" autocomplete="off" />
                            @error('email')
                                <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
                            <input name="password" id="password-register" class="form-control" type="password" placeholder="Create a password" />
                            @error('password')
                                <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password-register-confirm" class="text-muted mb-1"><small>Confirm Password</small></label>
                            <input name="password_confirmation" id="password-register-confirm" class="form-control" type="password" placeholder="Confirm password" />
                            @error('password_confirmation')
                                <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="py-3 btn btn-lg btn-success btn-block">Sign up for OurApp</button>
                    </form>
                </div>
            </div>