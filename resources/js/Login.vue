<template>
    <div class="d-flex justify-center align-center" style="height: 70vh">
    <v-card min-width="400">
            <v-card-text>
                <v-form
                    @submit.prevent="login"
                >
                    <v-text-field
                    v-model="form.email"
                    class="mb-2"
                    clearable
                    label="Email or username"
                    ></v-text-field>

                    <v-text-field
                    v-model="form.password"
                    clearable
                    label="Password"
                    ></v-text-field>

                    <br>

                    <v-btn
                    block
                    color="blue"
                    size="large"
                    type="submit"
                    variant="elevated"
                    >
                    Sign In
                    </v-btn>
                    <div class="d-flex justify-center mt-5">
                        <a href="">Forgot passowrd?</a>
                    </div>
                </v-form>
                <v-divider class="my-5"></v-divider>
                    <v-btn
                    block
                    color="success"
                    size="large"
                    type="submit"
                    variant="elevated"
                    @click="showDialog"
                    >
                    Register
                </v-btn>
            </v-card-text>
        </v-card>
    </div>
    <modal ref="modal"></modal>
</template>

<script>
import Modal from './Dialog.vue'

  export default {
    name: 'Login',

    components: {
        Modal,
    },

    data: () =>
        ({
            form : {
                email: "",
                password: ""
            }
        }),

    created() {
        var fruits = [3, 5, 4, 2, 3, 2, 3, 5, 1];


var position = 1;

for (var x = 0; x < fruits.length; x++) {
  var end = fruits[x] + position;
  var start = (position - fruits[x]) - 1;
  if (start < 0) {
    start = 0;
  }
console.log("position: "+position);
console.log("value: "+fruits[x]);
  console.log("start: "+start);
  console.log("end: "+end);
  console.log(fruits.slice(start, end));
  var views = (fruits.slice(start, end));
  var total = views.reduce((sum, num) => {
    return sum + num;
  });
  console.log("sum: "+total);
  position++;
}
    },

    methods: {
        showDialog () {
            this.$refs.modal.showDialog();
        },

        login () {
            let payload = this.form;

            this.$http.post("/login", payload)
            .then(response => {
                if (response.status == 200) {
                    this.$router.push({ path: '/profile' });
                }
            });
        }
    }
  }
</script>
