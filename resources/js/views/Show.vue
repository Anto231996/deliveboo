<template>
    <div v-if="restaurant">
        <div id="hero" class="position-relative bg-dark">
            <img class="position-absolute" :src="restaurant.immagine" alt="" />
            <div
                id="text-hero"
                class="text-center my-py-13 text-white position-absolute"
            >
                <h1>{{ restaurant.nome }}</h1>
                <p>{{ restaurant.indirizzo }}</p>
            </div>
        </div>

        <div class="container py-5" id="menu">
            <div class="row">
                <!-- Menu -->
                <div class="col-12 col-md-8 mb-5">
                    <h2>Menu</h2>
                    <p class="mb-4">
                        Clicca sui singoli piatti per aggiungerli al carrello.
                    </p>
                    <div class="items">
                        <div
                            class="item p-4"
                            v-for="(dish, index) in restaurant.dishes"
                            :key="index"
                            :class="
                                dish.visibilita == 0 ? 'my-not-visible' : ''
                            "
                            @click="dish.visibilita == 1 ? addToCart(dish) : ''"
                        >
                            <h3>{{ dish.nome }}</h3>
                            <p>Descrizione: {{ dish.descrizione }}</p>
                            <p>Ingredienti: {{ dish.ingredienti }}</p>
                            <p>{{ dish.prezzo }} €</p>
                        </div>
                    </div>
                </div>
                <!-- Checkout -->
                <div class="col-12 col-md-4">
                    <div class="container">
                        <h2 class="mb-4">Carrello</h2>
                        <table class="table" v-if="cart.length > 0">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Prezzo</th>
                                    <th scope="col">Rimuovi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(dish, index) in cart" :key="index">
                                    <td>{{ dish.nome }}</td>
                                    <td>{{ dish.prezzo }} €</td>
                                    <td>
                                        <button
                                            class="btn btn-sm btn-danger"
                                            @click="removeFromCart(dish)"
                                        >
                                            Rimuovi
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Totale</th>
                                    <td>{{ totalTwoDecimals }} €</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "App",
    components: {},
    data() {
        return {
            restaurant: null,
            cart: [],
            total: 0,
        };
    },
    methods: {
        addToCart(dish) {
            this.cart.push(dish);
            this.total += parseFloat(dish.prezzo);
            this.save();
        },
        removeFromCart(dish) {
            this.cart.splice(this.cart.indexOf(dish), 1);
            this.total -= parseFloat(dish.prezzo);
            this.save();
        },
        save() {
            localStorage.setItem("cart", JSON.stringify(this.cart));
            localStorage.setItem("total", this.total);
        },
    },
    mounted() {
        const url = window.location.href;
        const id = url.substring(url.lastIndexOf("/") + 1);

        axios
            .get(`/api/users/${id}`)
            .then((response) => {
                this.restaurant = response.data;
            })
            .catch((error) => {
                console.log(error);
            });

        if (localStorage.getItem("cart")) {
            try {
                this.cart = JSON.parse(localStorage.getItem("cart"));
                this.total = parseFloat(localStorage.getItem("total"));
            } catch (e) {
                localStorage.removeItem("cart");
                localStorage.removeItem("total");
            }
        }
    },
    computed: {
        // this.total with only two numbers after the decimal point
        totalTwoDecimals() {
            return this.total.toFixed(2);
        },
    },
};
</script>

<style scoped></style>
