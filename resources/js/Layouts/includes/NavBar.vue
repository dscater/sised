<script setup>
// Composables
import { usePage, Link, router } from "@inertiajs/vue3";
import { onMounted, onBeforeUnmount, ref } from "vue";
import { useConfiguracion } from "@/composables/configuracion/useConfiguracion";
import { useAppOptionStore } from "@/stores/app-option";
import { useMenu } from "@/composables/useMenu";
import { useUser } from "@/composables/useUser";
const { props } = usePage();
const { oUser } = useUser();
var url_assets = "";
var url_principal = "";
const { drawer, width, rail, mobile, toggleDrawer, cambiarUrl } = useMenu();

const user = {
    initials: "JD",
    fullName: "John Doe",
    email: "john.doe@doe.com",
};

const listNotificacions = ref([]);
const sin_ver = ref(0);
const ultimo = ref(0);

const { oConfiguracion } = useConfiguracion();
const appOption = useAppOptionStore();

const logout = () => {
    router.post(route("logout"));
};

const open_perfil = ref(false);
const open_menu_usuario = () => {
    open_perfil.value = !open_perfil.value;
};

const open_menu_mobile = () => {
    appOption.appSidebarMobileToggled = !appOption.appSidebarMobileToggled;
};

const getNotificacions = () => {
    axios.get(route("notificacions.listadoPorUsuario")).then((response) => {
        listNotificacions.value = response.data.notificacion_users;
        sin_ver.value = response.data.sin_ver;
    });
};

const muestra_notificacions = ref(false);
const mostrarNotificaciones = () => {
    muestra_notificacions.value = !muestra_notificacions.value;
};
const intervalNotificaciones = ref(null);

onMounted(() => {
    intervalNotificaciones.value = setInterval(() => {
        getNotificacions();
    }, 1500);

    url_assets = props.url_assets;
    url_principal = props.url_principal;
});

onBeforeUnmount(() => {
    if (intervalNotificaciones.value) {
        clearInterval(intervalNotificaciones.value);
    }
});
</script>
<template>
    <!-- BEGIN #header -->
    <div id="header" class="app-header bg-principal">
        <!-- BEGIN navbar-header -->
        <div class="navbar-header">
            <a href="" class="navbar-brand"
                ><img :src="oConfiguracion.url_logo" alt=""
            /></a>
            <button
                type="button"
                class="navbar-mobile-toggler"
                @click="open_menu_mobile()"
            >
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- END navbar-header -->
        <!-- BEGIN header-nav -->
        <div class="navbar-nav text-white">
            <div class="navbar-item dropdown">
                <a
                    href="#"
                    data-bs-toggle="dropdown"
                    class="navbar-link dropdown-toggle icon"
                    :class="{
                        show: muestra_notificacions,
                    }"
                    @click="mostrarNotificaciones()"
                >
                    <i class="fa fa-bell text-white"></i>
                    <span class="badge" v-show="sin_ver > 0">{{
                        sin_ver
                    }}</span>
                </a>

                <div
                    class="dropdown-menu media-list dropdown-menu-end notificacions"
                    :class="{
                        show: muestra_notificacions,
                    }"
                >
                    <div class="dropdown-header">
                        NOTIFICACIONES ({{ sin_ver }})
                    </div>
                    <Link
                        class="dropdown-item media"
                        v-for="item in listNotificacions"
                        :href="item.url_notificacion ?? ''"
                    >
                        <div class="media-left">
                            <i
                                class="fa fa-info-circle media-object bg-gray-400"
                            ></i>
                        </div>
                        <div class="media-body">
                            <p class="media-heading">
                                <span v-html="item.descripcion"></span>
                            </p>
                            <div class="text-muted fs-10px">
                                {{ item.hace }}
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
            <div class="navbar-item navbar-user dropdown">
                <a
                    href="#"
                    class="navbar-link dropdown-toggle d-flex align-items-center"
                    :class="[open_perfil ? 'show' : '']"
                    data-bs-toggle="dropdown"
                    @click="open_menu_usuario()"
                >
                    <img :src="oUser.url_foto" alt="" />
                    <span class="d-none d-md-inline text-white">{{
                        oUser.usuario
                    }}</span>
                    <b class="caret ms-6px"></b>
                </a>
                <div
                    class="dropdown-menu dropdown-menu-end me-1"
                    :class="[open_perfil ? 'show' : '']"
                >
                    <Link :href="route('profile.edit')" class="dropdown-item"
                        >Perfil</Link
                    >
                    <div class="dropdown-divider"></div>
                    <a href="#" @click.prevent="logout()" class="dropdown-item"
                        >Cerrar sesión</a
                    >
                </div>
            </div>
        </div>
        <!-- END header-nav -->
    </div>
    <!-- END #header -->
</template>

<style scoped>
.dropdown-menu.show {
    position: absolute;
    inset: 0px 0px auto auto;
    margin: 0px;
    transform: translate(0px, 52px);
}

.dropdown-item .media-body h6 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.dropdown-menu.notificacions {
    max-height: 67vh;
    overflow-y: scroll;
}
</style>
