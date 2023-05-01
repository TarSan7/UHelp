<template>
    <div class="container">
        <div class="back-url">
            <div class="text" onclick="window.location.replace('/')">Go back</div>
            <img src="../../img/arrow-forward.svg" onclick="window.location.replace('/')">
        </div>

        <div class="login-form">
            <div class="title">Login</div>
            <div class="fields">
                <label for="email" class="input-label">Email</label>
                <input type="email" name="email" id="email" class="input-field">

                <label for="password" class="input-label">Password</label>
                <input type="password" name="password" id="password" class="input-field">
                <a href="/" class="small-text">Forgot password?</a>

                <button type="submit" class="main-button">Log In</button>
                <div class="small-text">
                    Don`t have an account?
                    <a href="/register" class="">Register</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
}
</script>
