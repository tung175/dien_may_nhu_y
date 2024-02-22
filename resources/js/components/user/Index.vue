<template>
    <div style="background-color:white">
        <Header />
        <router-view></router-view>
        <Footer />
    </div>
</template>
<script>
import Header from './Header.vue';
import Footer from './Footer.vue';
export default {
    components: {
        Header,
        Footer
    }
}
</script>
<style>
    
</style>