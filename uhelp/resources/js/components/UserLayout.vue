<template>
    <div class="container">
        <div class="sidenav">
            <ul class="navlinks">
                <a class="logo-a" href="/">
                    <img class="logo" src="../../img/ukraine.png">
                </a>
                <li :class="active === 'fundraising' ? 'active-li' : ''">
                    <a href="/fundraising">
                        <img src="../../img/donations.svg">
                    </a>
                </li>
                <li :class="active === 'announcements' ? 'active-li' : ''">
                    <a href="/announcements">
                        <img src="../../img/victims.svg">
                    </a>
                </li>
                <li :class="active === 'map' ? 'active-li' : ''">
                    <a href="/map">
                        <img src="../../img/map.svg">
                    </a>
                </li>
                <li :class="active === 'archive' ? 'active-li' : ''">
                    <a href="/archive">
                        <img src="../../img/archive.svg">
                    </a>
                </li>
            </ul>
        </div>
        <div class="topnav">
            <div v-if="user" class="cabinet">
                <img src="../../img/user.svg">
                <div class="text">{{ user['name'] }}</div>
                <div class="dropdown-menu" @click="hide = !hide">
                    <img src="../../img/dropdown.svg">
                    <div v-if="!hide" class="dropdown-content">
                        <a v-if="user['account_type_id'] === 1" class="text" href="/members">Members</a>
                        <a v-if="user['account_type_id'] === 2" class="text" href="/my-fundraising">My fundraising</a>
                        <a v-if="user['account_type_id'] === 3" class="text" href="/my-announcements">My announcements</a>
                        <a class="text" href="/logout">Log out</a>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="back-url padding-small">
                    <div class="text" onclick="window.location.replace('/')">Go back</div>
                    <img src="../../img/arrow-forward.svg" onclick="window.location.replace('/')">
                </div>
            </div>
        </div>

        <slot>hghgv</slot>
    </div>
</template>

<script>
export default {
    /**
     * Name
     */
    name: 'UserLayout',

    data() {
        return {
            hide: true
        }
    },


    props: {
        user:  [Object, null],
        active: '',
    },
  };
</script>
