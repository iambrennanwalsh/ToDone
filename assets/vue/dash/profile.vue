<template>
  <form v-on:submit.prevent="validate" class="m-top-30">
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Name </label>
      </div>
      <div class="field-body">
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-user"></span>
            </a>
          </p>
          <p class="control is-expanded">
            <input
              @focus="init"
              v-bind:class="{
                'is-primary': attempted && fnameStatus,
                'is-success': success && user.firstName !== $root.user.firstName
              }"
              v-model="$root.user.firstName"
              class="input"
              name="fname"
              type="text"
              placeholder="Your first name."
            />
          </p>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-user"></span>
            </a>
          </p>
          <p class="control is-expanded">
            <input
              @focus="init"
              v-bind:class="{
                'is-primary': attempted && lnameStatus,
                'is-success': success && user.lastName !== $root.user.lastName
              }"
              v-model="$root.user.lastName"
              class="input"
              name="lname"
              type="text"
              placeholder="Your last name."
            />
          </p>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Contact</label>
      </div>
      <div class="field-body">
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-phone"></span>
            </a>
          </p>
          <p class="control is-expanded">
            <input
              @focus="init"
              v-bind:class="{
                'is-primary': attempted && phoneStatus,
                'is-success': success && user.phone !== $root.user.phone
              }"
              v-model="$root.user.phone"
              class="input"
              name="phone"
              type="text"
              placeholder="Your phone #."
            />
          </p>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-envelope"></span>
            </a>
          </p>
          <p class="control is-expanded">
            <input
              @focus="init"
              v-bind:class="{
                'is-primary': attempted && emailStatus,
                'is-success': success && user.email !== $root.user.email
              }"
              v-model="$root.user.email"
              class="input"
              name="email"
              type="email"
              placeholder="Your email address."
            />
          </p>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">Password</label>
      </div>
      <div class="field-body">
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-lock"></span>
            </a>
          </p>
          <p class="control is-expanded">
            <input
              @focus="init"
              v-bind:class="{
                'is-primary': attempted && npassStatus,
                'is-success': success && user.password !== $root.user.password
              }"
              v-model="npass"
              class="input"
              name="npass"
              type="password"
              placeholder="New password"
            />
          </p>
        </div>
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-lock"></span>
            </a>
          </p>
          <p class="control is-expanded">
            <input
              @focus="init"
              v-model="cpass"
              v-on:blur="attempt"
              v-bind:class="{
                'is-primary':
                  (cpassStatus && attemptedcpass) || (cpassStatus && attempted),
                'is-success': success && user.password !== $root.user.password
              }"
              class="input"
              name="cpass"
              type="password"
              placeholder="Confirm new password"
            />
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal">
      <div class="field-label">
        <label class="label">Details</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control has-icons-left">
            <div class="select is-rounded w-100">
              <select
                v-model="$root.user.country"
                name="country"
                class="select w-100"
              >
                <option
                  v-for="country in countryList"
                  v-text="country.name"
                  :value="country.alpha2Code"
                ></option>
              </select>
            </div>
            <span class="icon is-small is-left">
              <i class="fa fa-globe"></i>
            </span>
          </div>
        </div>
        <div class="field">
          <div class="control has-icons-left">
            <div class="select is-rounded w-100">
              <select name="gender" class="w-100" v-model="$root.user.gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="robot">Robot</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="icon is-small is-left">
              <i class="fa fa-venus"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label"></label>
      </div>
      <div class="field-body">
        <div class="field has-addons">
          <p class="control">
            <a class="button is-static">
              <span class="fa fa-key"></span>
            </a>
          </p>
          <div class="control is-expanded">
            <input
              @focus="init"
              v-bind:class="{
                'is-primary': (attempted && passStatus) || incorrect
              }"
              v-model="password"
              class="input"
              type="password"
              placeholder="Your current password"
              name="password"
            />
          </div>
        </div>
        <div class="field" style="height: 37px">
          <div class="control is-pulled-right">
            <button
              @focus="init"
              type="submit"
              v-on:submit.prevent="validate"
              :class="{ 'is-loading': loader, checker: checker }"
              class="button is-primary updateinfo"
            >
              <span>Update Info</span><i class="fa fa-check"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { EventBus } from "./../eventbus.vue";

export default {
  data: function() {
    return {
      user: "",
      password: "",
      npass: "",
      cpass: "",
      countryList: "",
      attempted: false,
      attemptedcpass: false,
      incorrect: false,
      success: false,
      loader: false,
      checker: false
    };
  },

  computed: {
    fnameStatus() {
      return (
        this.$root.user.firstName === "" ||
        this.$root.user.firstName.length > 30
      );
    },
    lnameStatus() {
      return (
        this.$root.user.lastName === "" || this.$root.user.lastName.length > 30
      );
    },
    phoneStatus() {
      return this.$root.user.phone === "" || this.$root.user.phone.length > 30;
    },
    emailStatus() {
      return this.$root.user.email === "" || this.$root.user.email.length > 30;
    },
    passStatus() {
      return this.password.length < 5 || this.password.length > 30;
    },
    npassStatus() {
      return (
        (this.npass.length >= 1 && this.npass.length <= 5) ||
        this.npass.length > 30
      );
    },
    cpassStatus() {
      return this.cpass !== this.npass;
    },
    status() {
      return (
        this.phoneStatus ||
        this.emailStatus ||
        this.fnameStatus ||
        this.lnameStatus ||
        this.passStatus ||
        this.countryStatus ||
        this.genderStatus ||
        this.npassStatus ||
        this.cpassStatus
      );
    }
  },

  methods: {
    init() {
      if (this.user == "") {
        this.user = Object.assign({}, this.$root.user);
      } else if (this.success) {
        this.user = Object.assign({}, this.$root.user);
        this.success = false;
      }
    },

    validate() {
      this.incorrect = false;
      this.attempted = true;
      if (this.status) return false;
      this.loader = true;
      this.checkPassword();
    },

    checkPassword() {
      axios
        .post("/api/users/" + this.$root.user.id + "/check", {
          password: this.password
        })
        .then(response => {
          if (response.data.status) {
            this.$root.user.password = this.npass;
            this.submit();
          } else {
            this.incorrect = true;
            this.password = "";
            this.npass = "";
            this.cpass = "";
            this.loader = false;
            EventBus.$emit(
              "openMessage",
              "is-danger",
              "Sorry that password was incorrect. Please try again."
            );
          }
        });
    },

    submit() {
      axios
        .put("/api/users/" + this.$root.user.id, {
          phone: this.$root.user.phone,
          email: this.$root.user.email,
          firstName: this.$root.user.firstName,
          lastName: this.$root.user.lastName,
          gender: this.$root.user.gender,
          country: this.$root.user.country,
          password: this.$root.user.password
        })
        .then(response => {
          this.checker = true;
          this.attempted = false;
          this.success = true;
          this.loader = false;
          this.password = "";
          EventBus.$emit(
            "openMessage",
            "is-success",
            "Your information has been updated."
          );
          setTimeout(() => {
            this.checker = false;
          }, 2000);
        });
    },

    attempt() {
      this.attemptedcpass = true;
    }
  },

  mounted() {
    axios.get("https://restcountries.eu/rest/v2/all").then(response => {
      this.countryList = response.data;
    });
  }
};
</script>
