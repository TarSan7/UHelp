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
                    <input v-model="name" type="text" name="name" id="name" class="small-input-field">

                    <label for="email" class="input-label">Email</label>
                    <input v-model="email" type="email" name="email" id="email" class="small-input-field">

                    <label for="password" class="input-label">Password</label>
                    <input v-model="password" type="password" name="password" id="password" class="small-input-field">
                </div>
                <div class="small-fields">
                    <label for="account" class="input-label">Account type</label>
                    <select name="account" id="account" class="small-input-field">
                        <option
                            v-for="(type, index) in accountTypes"
                            :key="index"
                            :value="type"
                        ></option>
                    </select>

                    <label for="phone" class="input-label">Phone number</label>
                    <input v-model="phone" type="text" name="phone" id="phone" class="small-input-field">

                    <label for="password" class="input-label">Confirm password</label>
                    <input v-model="rePassword" type="password" name="password" id="password" class="small-input-field">
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

    data() {
        return {
            name: String,
            email: String,
            password: String,
            rePassword: String,
            phone: String,
            accountType: Number
        }
    },

    props: {
        accountTypes: {
            type: Array,
            default: []
        }
    }
}
</script>
