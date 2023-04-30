<template>
    <div class="container">
        <div class="screen-wraper">
            <img class="img1" src="../../img/landing-first-screen.png">

            <div class="screen">

                <div id="sidemenu">
                    <button class="sidemenu__btn" v-on:click="navOpen=!navOpen" v-bind:class="{active:navOpen}">
                        <span class="top"></span>
                        <span class="mid"></span>
                        <span class="bottom"></span>
                    </button>
                    <transition name="translateX">
                        <nav v-show="navOpen">
                            <div class="sidemenu__wrapper">
                                <ul class="sidemenu__list">
                                    <li class="sidemenu__item"><a href="">Login</a></li>
                                    <li class="sidemenu__item"><a href="">Donations</a></li>
                                    <li class="sidemenu__item"><a href="">Volunteer map</a></li>
                                    <li class="sidemenu__item"><a href="">Helping the needy</a></li>
                                </ul>
                            </div>
                        </nav>
                    </transition>
                </div>

                <div class="first-screen-block">
                    <div class="large-text text-right">Help yourself and people <br>who need it</div>
                    <div class="small-text text-right">If you need help or want to be useful to other<br>people or the Armed Forces,<br>
                        the volunteer platform UHelp will provide this <br>opportunity.
                    </div>
                    <button class="second-button button right-align">Go help!</button>
                </div>
            </div>
        </div>
        <div class="screen yellow-background">
            <div class="second-screen-block">
                <div class="large-text text-left">Make a donation to<br>cover the most<br>pressing needs</div>
                <div class="small-text text-left small-margin-top">
                    Now, during the war, volunteer projects are being opened <br>with
                    the aim of helping both military personnel on the <br>front lines and civilian Ukrainians
                    who are in a difficult <br>situation during the war.
                </div>
                <button class="main-button button right-align">Go to projects</button>
            </div>
            <div class="img2">
                <img class="img-height" src="../../img/landing-second-screen.png">
            </div>
        </div>
        <div class="service-screen">
            <div class="left-groups">
                <div class="group group1-img small-text">
                    Collections of funds <br>for the needs of the<br> army
                </div>
                <div class="group group2-img small-text">
                    Fees for heavy<br> weapons
                </div>
            </div>
            <div class="all-services">
                <div class="group all-services-img large-text">
                    Our services
                </div>
            </div>
            <div class="right-groups">
                <div class="group group3-img small-text">
                    Assistance to<br> homeless people
                </div>
                <div class="group group4-img small-text">
                    View and get <br>information about<br> help points
                </div>
            </div>
        </div>
        <div class="screen">
            <div class="flows">
                <div class="small-title">Platform flows</div>
                <div class="very-small-text">You can work with the platform under different accounts.
                    <br><br>
                    If you are a volunteer, you have the opportunity to register and use your account to post
                    fundraisers and track them, accept applications from people who need help, and place volunteering
                    places on the map.
                    <br><br>
                    If you are a person who is in a difficult situation due to enemy attacks, then you have the
                    opportunity to create a request for assistance, which will be processed by volunteers.
                    <br><br>
                    If you are a caring person who wants to help, you can do it without creating an account,
                    or create and track all transactions.
                </div>
            </div>
        </div>
        <div class="screen light-yellow-background">
            <div class="fundraising-block">
                <div class="small-title dark-text">Active fundraisings</div>
                <slider />
            </div>
        </div>
        <div class="footer">
            <div class="footer-row">
                <div class="footer-title">UHelp</div>
                <div class="footer-links">
                    <div class="very-small-text link-padding">Volunteer map</div>
                    <div class="very-small-text link-padding">Donations</div>
                    <div class="very-small-text link-padding">Helping the needy</div>
                </div>
                <div class="socials-footer">
                    <img class="social" src="../../img/insta-logo.svg">
                    <img class="social" src="../../img/facebook-logo.svg">
                    <img class="social" src="../../img/telegram-logo.svg">
                </div>
            </div>
            <div class="rights">All rights are served@ 2023</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                navOpen: false,
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
