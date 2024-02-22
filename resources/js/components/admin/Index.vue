<template>
    <div>
        <div v-if="$route.name == 'admin.login'">
        </div>
        <div v-else-if="$route.name == 'change-password'">
        </div>
        <div v-else>
            <HeaderAdmin/>
        </div>
        <router-view></router-view>
        <div v-if="$route.name == 'admin.login'">
        </div>
        <div v-else-if="$route.name == 'change-password'">
        </div>
        <div v-else>
            <FooterAdmin/>
        </div>
    </div>
</template>
<script>
import HeaderAdmin from './Header.vue';
import FooterAdmin from './Footer.vue';
export default {
    components: {
        HeaderAdmin,
        FooterAdmin
    }
};
</script>
<style></style>
