<template>
    <div class="container">
        <div class="back-url">
            <div class="text" onclick="window.location.replace('/')">Go back</div>
            <img src="../../img/arrow-forward.svg" onclick="window.location.replace('/')">
        </div>

        <div class="form-register">
            <div class="title">Register</div>
            <div class="field-group">
                <div class="small-fields">
                    <label for="name" class="input-label">Name</label>
                    <input type="text" name="name" id="name" class="small-input-field">

                    <label for="email" class="input-label">Email</label>
                    <input type="email" name="email" id="email" class="small-input-field">

                    <label for="password" class="input-label">Password</label>
                    <input type="password" name="password" id="password" class="small-input-field">
                </div>
                <div class="small-fields">
                    <label for="account" class="input-label">Account type</label>
                    <select name="account" id="account" class="small-input-field">
                    </select>

                    <label for="phone" class="input-label">Phone number</label>
                    <input type="text" name="phone" id="phone" class="small-input-field">

                    <label for="password" class="input-label">Confirm password</label>
                    <input type="password" name="password" id="password" class="small-input-field">
                </div>
            </div>
            <button type="submit" class="main-button button-reg">Register</button>
            <div class="small-text">
                Already have an account?
                <a href="/login" class="">Log in</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Register",
}
</script>
