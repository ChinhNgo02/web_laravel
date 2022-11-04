<form method="post" action="{{ route('process_login') }}">
    @csrf
    Email
    <input type="email" name="email" placeholder="">
    <br>
    Password
    <input type="password" name="password" placeholder="">
    <br>
    <button>Login</button>
</form>