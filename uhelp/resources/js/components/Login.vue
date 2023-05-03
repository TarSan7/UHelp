<template>
    <div class="container">
        <div class="back-url">
            <div class="text" onclick="window.location.replace('/')">Go back</div>
            <img src="../../img/arrow-forward.svg" onclick="window.location.replace('/')">
        </div>

        <form class="login-form" method="POST" @submit.prevent="login" @keydown="errors.clear($event.target.name)">
            <div class="title">Login</div>
            <div class="fields">
                <label for="email" class="input-label">Email</label>
                <input
                    v-model="email"
                    type="email"
                    name="email"
                    class="input-field"
                >
                <span class="help is-danger" v-text="errors.get('email')"></span>

                <label for="password" class="input-label">Password</label>
                <input
                    v-model="password"
                    type="password"
                    name="password"
                    class="input-field"
                >
                <span class="help is-danger" v-text="errors.get('password')"></span>
                <a href="/" class="small-text">Forgot password?</a>


                <button type="submit" class="main-button">Log In</button>
                <div class="small-text">
                    Don`t have an account?
                    <a href="/register" class="">Register</a>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import {Errors} from "../app";

export default {
    name: "Login",

    data() {
        return {
            email: '',
            password: '',
            errors: new Errors()
        }
    },

    methods: {
        login(event) {
            axios.post('/login', {
                'email': this.email,
                'password': this.password
            }).catch(error => this.errors.record(error.response.data));
        }
    }
}
</script>
